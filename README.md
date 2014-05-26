# Initial based icon generator for PHP

[![Build Status](https://secure.travis-ci.org/runmybusiness/initialcon.png)](http://travis-ci.org/runmybusiness/initialcon)

![Initialcon example #1](doc/red.png)&nbsp;&nbsp;
![Initialcon example #2](doc/blue.png)&nbsp;&nbsp;
![Initialcon example #3](doc/green.png)&nbsp;&nbsp;

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

### Image Object

You can also grab the Image object to add more manipulation to the final icon (such as rounded corders, opacity, etc).
We use the [http://image.intervention.io/](Intervention) library for image creation so all of its' methods are available to you.

```php
$initialcon->getImageObject('TS', 'tom@test.com', 512);
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
