# Initial based icon generator for PHP

[![Build Status](https://secure.travis-ci.org/runmybusiness/initialcon.png)](http://travis-ci.org/runmybusiness/initialcon)

![Initialcon example #1](data:image/png;base64,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)&nbsp;&nbsp;

## Installation

The recommended way to install Initialcon is through composer.

Just create a `composer.json` file for your project:

``` json
{
    "require": {
        "runmybusiness/initialcon": "*"
    }
}
```

And run these two commands to install it:

``` bash
$ wget http://getcomposer.org/composer.phar
$ php composer.phar install
```

Now you can add the autoloader, and you will have access to the library:

``` php
<?php

require 'vendor/autoload.php';
```

If you don't use either **Composer** or a _ClassLoader_ in your application, just require the provided autoloader:

``` php
<?php

require_once 'src/autoload.php';
```

You're done.


## Usage

Images are generated in PNG format with a colored background & the initials in white text.

The string can be an email, an IP address, a username, an ID or something else that is persistant between page loads.

### Generate an initialcon

Create a new ```Initialcon``` object.

``` php
$initialcon = new Initialcon();
```

Then you can generate and display an initialcon image

``` php
$initialcon->displayImage('TS', 'tom@test.com');
```

or generate and get the image data

``` php
$imageData = $initialcon->getImageData('TS', 'tom@test.com');
```

or generate and get the base 64 image uri ready for integrate into an HTML img tag.

``` php
$imageDataUri = $initialcon->getImageDataUri('HI', 'hello@test.com');
```
``` html
<img src="<?php echo $imageDataUri; ?>" alt="bar Initialcon" />
```


### Change the size

By default the size will be 64 pixels. If you want to change the image size just add a secondary parameter. 512 x 512px in this example.

``` php
$initialcon->displayImage('TS', 'tom@test.com', 512);
```

### Color

The color is automaticaly generated according to the string hash but you can chose to specify a color by adding a third argument.

Color can be an hexadecimal with 6 characters

``` php
$initialcon->displayImage('TS', 'tom@test.com', 64, 'A87EDF');
```

That's it!

## Unit Tests

To run unit tests, you'll need and a set of dependencies you can install using Composer:

```
php composer.phar install
```

Once installed, just launch the following command:

```
phpunit
```

Everythings should be ok.


## Credits

* Originally forkeed from Benjamin Laugueux's great Identicon library at (https://github.com/yzalis/Initialcon)


## License

Initialcon is released under the MIT License. See the bundled LICENSE file for details.
