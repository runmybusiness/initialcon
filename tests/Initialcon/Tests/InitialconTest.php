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
            array('HI', 'hello@test.com', 'data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAIAAAACACAYAAADDPmHLAAABi0lEQVR4nO3cwQkCMRBA0SgWpB1oB1qpJViCJWkBgguCZuW/d93LLHwGckg25/3xMcjazh6AuQQQJ4A4AcQJIE4AcQKIE0CcAOIEECeAOAHECSBOAHECiBNAnADiBBAngDgBxAkgTgBxAogTQJwA4gQQJ4A4AcQJIE4AcbvZA4wxxvV+e/v9cjj9aJJX35xtDf9tA8QJIE4AcQKIE0CcAOIEECeAOAHECSBOAHECiBNAnADiBBAngDgBxAkgTgBxAogTQJwA4gQQJ4C4VVwMWbJ0gYLP2QBxAogTQJwA4gQQJ4C4vzgGrvl9gH9nA8QJIE4AcQKIE0CcAOIEECeAOAHECSBOAHECiBNAnADiBBAngDgBxAkgTgBxAogTQJwA4gQQJ4A4AcQJIE4AcQKI25z3x8fsIZjHBogTQJwA4gQQJ4A4AcQJIE4AcQKIE0CcAOIEECeAOAHECSBOAHECiBNAnADiBBAngDgBxAkgTgBxAogTQJwA4gQQJ4A4AcQJIE4AcQKIE0CcAOKeDX4SwOb8tgYAAAAASUVORK5CYII='),
        );
    }
}
