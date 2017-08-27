# Dakzilla/Strongpass
A strong password generator package for Laravel 5

## Installation
`composer require dakzilla/strongpass`

Then, add the following line to the `providers` element of your `config/app.php` file:

`Dakzilla\Strongpass\StrongpassServiceProvider::class`

## Usage
Use dependency injection to receive an instance of `Dakzilla\Strongpass\Strongpass` in your class, as such:

```
use Dakzilla\Strongpass\Strongpass;

class MyClass {

    public function __construct(
        Strongpass $strongpass
    ) {
        $this->strongpass = $strongpass;
    }

}
```

Then, in your controller, model, or view, call the `generate` method, as such:

```
echo $strongpass->generate();

Sample result: K]2Fyg5:x'1yV([Q 
```

## Customization

The following options can be customized:

* The length of the password (minimum 6 characters)
* Using letters (a-z and A-Z)
* Using numbers (0-9)
* Using symbols ({,},[,],(,),/,\,',",`,~,,,;,:,.,<,>)

### Customize the options using a config file

If you're installing this package for the first time, you need to publish the config file to your project using this command:

`php artisan vendor:publish`

In the console output, you should see this line:

`Copied File [/vendor/dakzilla/strongpass/config/package.php] To [/config/strongpass.php]`

You can now edit the following configurations in the `config/strongpass.php` file and override the defaults globally:

```
'length' => 16, //integer
'use_letters' => true, //boolean
'use_numbers' => true, //boolean
'use_symbols' => true //boolean
```

### Customize the options programatically
Once you have instantiated the Strongpass class, you can call the following public methods to set your options:

```
$strongpass->setLength(int $length)
$strongpass->setUseLetters(bool $useLetters)
$strongpass->setUseNumbers(bool $useNumbers)
$strongpass->setUseSymbols(bool $useSymbols)
```

## Retrieving the last generated password

The class is instantiated as a singleton. Thus, no matter how many times it is instantiated or where you choose to use it, you will be able to retrieve the last generated password from anywhere in your application using this method:

`$strongpass->getLastpass()`

This goes without saying, but if you call the `generate` method again from anywhere in your application, the last password will be overwritten. If you need to save the last generated password, call the `getLastPass` method before calling `generate` again.

## Requirements
* Laravel 5.4
* PHP 7.0 and above

## License

This module is licensed under the MIT License

Copyright 2017 Simon Dakin

Made with ♥ in Montreal