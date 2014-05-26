<?php

namespace RunMyBusiness\Initialcon;

use Intervention\Image\ImageManagerStatic as Image;

class Initialcon
{
    /**
     * @var string
     */
    private $hash;

    /**
     * @var string
     */
    private $initials;

    /**
     * @var integer
     */
    private $color;

    /**
     * @var integer
     */
    private $size;

    /**
     * @var integer
     */
    private $fontPath;

    /**
     * @var integer
     */
    private $pixelRatio;

    /**
     * @var array
     */
    private $arrayOfSquare = array();

    /**
     * Set the image size
     *
     * @param integer $size
     *
     * @return Initialcon
     */
    public function setSize($size)
    {
        $this->size = $size;
        $this->pixelRatio = round($size / 5);

        return $this;
    }

    /**
     * Get the image size
     *
     * @return integer
     */
    public function getSize()
    {
        return $this->size;
    }

    /**
     * Get the text size
     *
     * @return integer
     */
    public function getTextSize()
    {
        return (strlen($this->initials) == 2) ? round($this->size / 1.5) : $this->size;
    }

    /**
     * Generate a hash fron the identifier
     *
     * @param string $string
     *
     * @return Initialcon
     */
    public function setInitials($initials)
    {
        if (null === $initials) {
            throw new \Exception('The initials cannot be null.');
        }

        $this->initials = substr($initials, 0, 2);

        return $this;
    }

    /**
     * Generate a hash fron the identifier
     *
     * @param string $string
     *
     * @return Initialcon
     */
    public function setIdentifier($identifier)
    {
        if (null === $identifier) {
            throw new \Exception('The identifier cannot be null.');
        }

        $this->hash = md5($identifier);

        $this->convertHashToArrayOfBoolean();

        return $this;
    }

    /**
     * Get the Initialcon string hash
     *
     * @return string
     */
    public function getHash()
    {
        return $this->hash;
    }

    /**
     * Convert the hash into an multidimensionnal array of boolean
     *
     * @return Initialcon
     */
    private function convertHashToArrayOfBoolean()
    {
        preg_match_all('/(\w)(\w)/', $this->hash, $chars);
        // foreach ($chars[1] as $i => $char) {
        //     if ($i % 3 == 0) {
        //         $this->arrayOfSquare[$i/3][0] = $this->convertHexaToBoolean($char);
        //         $this->arrayOfSquare[$i/3][4] = $this->convertHexaToBoolean($char);
        //     } elseif ($i % 3 == 1) {
        //         $this->arrayOfSquare[$i/3][1] = $this->convertHexaToBoolean($char);
        //         $this->arrayOfSquare[$i/3][3] = $this->convertHexaToBoolean($char);
        //     } else {
        //         $this->arrayOfSquare[$i/3][2] = $this->convertHexaToBoolean($char);
        //     }
        //     ksort($this->arrayOfSquare[$i/3]);
        // }

        $this->color[0] = hexdec(array_pop($chars[1]))*16;
        $this->color[1] = hexdec(array_pop($chars[1]))*16;
        $this->color[2] = hexdec(array_pop($chars[1]))*16;

        return $this;
    }

    /**
     * Convert an heaxecimal number into a boolean
     *
     * @param string $hexa
     *
     * @return boolean
     */
    private function convertHexaToBoolean($hexa)
    {
        return (bool) intval(round(hexdec($hexa)/10));
    }

    /**
     *
     *
     * @return array
     */
    public function getArrayOfSquare()
    {
        return $this->arrayOfSquare;
    }

    /**
     * Generate the Initialcon image
     *
     * @param string  $string
     * @param integer $size
     * @param string $hexaColor
     */
    private function generateImage($initials, $identifier, $size, $color)
    {
        $this->setInitials($initials);
        $this->setIdentifier($identifier);
        $this->setSize($size);
        $textSize = $this->getTextSize();

        if($this->fontPath == null)
        {
            $this->setFontPath(__DIR__ . '/arial.ttf');
        }

        $fontFilePath = $this->getFontPath();

        // prepage the color
        if (null !== $color) {
            $this->setColor($color);
        }

        $image = Image::canvas($size, $size, $this->getColor());

        $image->text($this->initials, ($size / 2.1), ($size / 2.1), function($font) use ($textSize, $fontFilePath){
            $font->size($textSize);
            $font->color('#ffffff');
            $font->align('center');
            $font->valign('middle');
            $font->file($fontFilePath);
        });

        return $image;
    }

    /**
     * Set the image color
     *
     * @param string $color The color in hexa (6 chars)
     *
     * @return Initialcon
     */
    public function setColor($color)
    {
        if (false !== strpos($color, '#')) {
            $color = substr($color, 1);
        }
        $this->color = hexdec(substr($color, 0, 2));
        $this->color .= hexdec(substr($color, 2, 2));
        $this->color .= hexdec(substr($color, 4, 2));

        return $this;
    }

    /**
     * Get the color
     *
     * @return string
     */
    public function getColor()
    {
        return $this->color;
    }

    /**
     * Get the font path
     *
     * @return string
     */
    public function getFontPath()
    {
        return realpath($this->fontPath);
    }

    /**
     * Set the font path
     *
     * @param string $path
     */
    public function setFontPath($path)
    {
        $this->fontPath = $path;
    }

    /**
     * Display an Initialcon image
     *
     * @param string  $initials
     * @param string  $identifier
     * @param integer $size
     * @param string $hexaColor
     */
    public function displayImage($initials, $identifier, $size = 64, $hexaColor = null)
    {
        header("Content-Type: image/png");
        $img = $this->generateImage($initials, $identifier, $size, $hexaColor);
        echo $img->encode('png');
    }

    /**
     * Get an Initialcon PNG image data
     *
     * @param string  $initials
     * @param string  $identifier
     * @param integer $size
     * @param string $hexaColor
     *
     * @return string
     */
    public function getImageData($initials, $identifier, $size = 64, $hexaColor = null)
    {
        $img = $this->generateImage($initials, $identifier, $size, $hexaColor);
        return $img->encode('png');
    }

    /**
     * Get an Initialcon PNG image data
     *
     * @param string  $initials
     * @param string  $identifier
     * @param integer $size
     * @param string $hexaColor
     *
     * @return string
     */
    public function getImageDataUri($initials, $identifier, $size = 64, $hexaColor = null)
    {
        return sprintf('data:image/png;base64,%s', base64_encode($this->getImageData($initials, $identifier, $size, $hexaColor)));
    }
}
