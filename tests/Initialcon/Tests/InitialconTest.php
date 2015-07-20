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
        return [
            ['#ffffff', [255, 255, 255]],
            ['ffffff', [255, 255, 255]],
            ['000000', [0, 0, 0]],
        ];
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
        return [
            ['TS', 'tom@test.com', 'data:image/png;base64,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'],
            ['HI', 'hello@test.com', 'data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAIAAAACACAYAAADDPmHLAAAB/0lEQVR4nO3bIWuWURiA4TMxq//EgcE6WBqGfZg0rc2y8KXB1xYEm6wJK4JFGBYxqMEgigjiLxCDv2RGQT4sU4/zvq564H2ecHNe3vBuLDa3zgZZl2YvwFwCiBNAnADiBBAngDgBxAkgTgBxAogTQJwA4gQQJ4A4AcQJIE4AcQKIE0CcAOIEECeAOAHECSBOAHECiBNAnADiBBAngDgBxAkgTgBxAoi7PHuBdQ6ODsf27s7as5MHx+Pl6fO/vNEP27s74+DocO3Zu1dvxsPV/XM9f295byz27qw9e/ro8Tg9eXKu5//MDRAngDgBxAkgTgBxAogTQJwA4gQQJ4A4AcQJIE4AcQKIE0CcAOIEECeAOAHECSBOAHECiBNAnADiBBD3T/4Z9Cv7q+XYXy1nr/HfcAPECSBOAHECiBNA3IX7Cnj97MX4/P7jtPnXb94Yt+7enjb/d7twAXz78nV8evth2vwr165Om/0neAXECSBOAHECiBNAnADiBBAngDgBxAkgTgBxAogTQJwA4gQQJ4A4AcQJIE4AcQKIE0CcAOIEECeAOAHECSBOAHEbi82ts9lLMI8bIE4AcQKIE0CcAOIEECeAOAHECSBOAHECiBNAnADiBBAngDgBxAkgTgBxAogTQJwA4gQQJ4A4AcQJIE4AcQKIE0CcAOIEECeAuO9RciQ7x6j8GQAAAABJRU5ErkJggg=='],
        ];
    }
}
