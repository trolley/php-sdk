# Trolley PHP SDK

[![Latest Stable Version](http://poser.pugx.org/trolley/core/v)](https://packagist.org/packages/trolley/core) 
[![PHP Version Require](http://poser.pugx.org/trolley/core/require/php)](https://packagist.org/packages/trolley/core)

The Trolley PHP SDK provides integration access to the Trolley API.

## Requirements

PHP version >= 5.4.0 is required.

The following PHP extensions are required:

curl
json
mbstring
openssl

## Installation & Usage

### SDK

```bash
git clone https://github.com/PaymentRails/php-sdk.git
```


### Composer

[Install PHP Composer](https://getcomposer.org/doc/00-intro.md)

To install the bindings via [Composer](http://getcomposer.org/), add the following to `composer.json`:

```bash
composer require trolley/core
```

Then run `composer install`


## Getting Started

Please follow the [installation procedure](#installation--usage) and then run the following:

```php
<?php

// This line is for the Composer autoloader
require_once 'vendor/autoload.php';

// Or use this if installed via git clone
// require_once 'php-sdk/lib/autoload.php';

use Trolley;

Trolley\Configuration::publicKey(YOUR_ACCESS_KEY);
Trolley\Configuration::privateKey(YOUR_SECRET_KEY);

try {
    $recipients = Trolley\Recipient::all();

    foreach ($recipients as $rcpt) {
      print_r($rcpt->id . "\n");
    }
} catch (Exception $e) {
    echo 'Exception when calling Trolley\\Recipient::all ', $e->getMessage(), PHP_EOL;
}
```

## Documentation for API Endpoints

All URIs are available at https://docs.trolley.com/

## Running SDK from Source  
  1. Clone this repo.
  2. Install dependencies by running `composer install` from the project root.
  3. Access the SDK source code from your code by using `Trolley` namespace as per the path you put the SDK source code on.

### Environment Variables
While running from source locally, you can use a `.env` file to supply a custom server URL.

The tests use the `.env` file anyway to load the API keys.  
If you're running tests, make sure the `.env` file exists in the project root.

For your ease, a sample `.env.example` file is provided, which can be copied to create the `.env` file:

```
$ cp .env.example .env
```

Once copied, edit the `.env` file to supply the values needed.

### Running the tests from SDK  
To run the tests in the terminal, you'll need to setup the `.env` file to supply API Keys, and then use the PHPUnit test suite from within the `tests` directory, like the following:  
```
$ cp .env.example .env
 // Edit the .env file to supply API Keys

$ cd tests
$ ../vendor/bin/phpunit integration/RecipientTest.php
```

If you want to provide a custom server URL, provide the server URL in the `.env` file , and set the sdk configuration to use the `development` server:

```
Configuration::environment('development');
```

Refer to the inline documentation about this in the test setup file: [/tests/Setup.php:38](https://github.com/PaymentRails/php-sdk/blob/master/tests/Setup.php#L38)