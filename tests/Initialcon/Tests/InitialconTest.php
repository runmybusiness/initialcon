<?php

namespace RunMyBusiness\Initialcon\Tests;

use RunMyBusiness\Initialcon\Initialcon;

class InitialconTest extends \PHPUnit_Framework_TestCase
{
    protected $faker;
    protected $initialcon;

    protected function setUp()
    {
        $this->faker = \Faker\Factory::create();
        $this->initialcon = new Initialcon();
    }

    public function testHash()
    {
        for ($i = 0; $i < 10; $i++) {
            // Get the previous hash
            $previousHash = $this->initialcon->getHash();

            // Set a new string
            $this->initialcon->setIdentifier($this->faker->email);
            $this->initialcon->setInitials($this->faker->firstname);

            // Test the hash length
            $this->assertEquals(32, strlen($this->initialcon->getHash()));

            // Test the hash generation result
            $this->assertThat(
                $this->initialcon->getHash(),
                $this->logicalNot(
                    $this->equalTo($previousHash)
                )
            );
        }
    }

    /**
     * @dataProvider testColorDataProvider
     */
    public function testColor($color, $expected)
    {
        $expected = $expected[0].$expected[1].$expected[2];
        $this->assertEquals($expected, $this->initialcon->setColor($color)->getColor());
    }

    public function testColorDataProvider()
    {
        return array(
            array('#ffffff', array(255, 255, 255)),
            array('ffffff', array(255, 255, 255)),
            array('000000', array(0, 0, 0)),
        );
    }

    /**
     * @dataProvider resultDataProvider
     */
    public function testResult($initials, $identifier, $imageData)
    {
        $this->assertEquals($imageData, $this->initialcon->getImageDataUri($initials, $identifier, 128));
    }

    public function resultDataProvider()
    {
        return array(
            array('TS', 'tom@test.com', 'data:image/png;base64,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'),
            array('HI', 'hello@test.com', 'data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAIAAAACACAYAAADDPmHLAAACAElEQVR4nO3bIWuVYRiA4XdiVv+JA4N1sDQMO5g0rc2ycNLgtAXBJjZhRbAIwyIGNRhEEUH8BWLwl8xoOWgY7j14X1d94XuecPN+fOHbWmzvnA+yrsxegLkEECeAOAHECSBOAHECiBNAnADiBBAngDgBxAkgTgBxAogTQJwA4gQQJ4A4AcQJIE4AcQKIE0CcAOIEECeAOAHECSBOAHFXZy8wxhhHJ8djd39v7dnpoyfjzdmrS97ot939vXF0crz27OPb9+Px6uGFnn+wfDAWB/fWnr14+mycnT6/0PP/xg0QJ4A4AcQJIE4AcQKIE0CcAOIEECeAOAHECSBOAHECiBNAnADiBBAngDgBxAkgTgBxAogTQJwA4gQQtxF/Bv3J4Wo5DlfL2Wv8t9wAcQKIE0CcAOIEELfxXwHvXr4e3z59mTb/5u1b4879u9Pm/2sbH8DP7z/G1w+fp82/duP6tNmXwSsgTgBxAogTQJwA4gQQJ4A4AcQJIE4AcQKIE0CcAOIEECeAOAHECSBOAHECiBNAnADiBBAngDgBxAkgTgBxAojbWmzvnM9egnncAHECiBNAnADiBBAngDgBxAkgTgBxAogTQJwA4gQQJ4A4AcQJIE4AcQKIE0CcAOIEECeAOAHECSBOAHECiBNAnADiBBAngDgBxAkgTgBxAogTQNwvwpQkOxI55a8AAAAASUVORK5CYII='),
        );
    }
}
