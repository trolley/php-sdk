# Payment Rails PHP Library

[![Latest Stable Version](https://poser.pugx.org/paymentrails/php-sdk/v/stable.png)](https://packagist.org/packages/paymentrails/php-sdk)

The Payment Rails PHP library provides integration access to the Payment Rails API.


## Requirements

PHP version >= 5.4.0 is required.

The following PHP extensions are required:

curl
json
mbstring
openssl

## Installation & Usage

### Library

```bash
git clone https://github.com/PaymentRails/php-sdk.git
```


### Composer

[Install PHP Composer](https://getcomposer.org/doc/00-intro.md)

To install the bindings via [Composer](http://getcomposer.org/), add the following to `composer.json`:

```bash
composer require paymentrails/php-sdk
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

use PaymentRails;

// Configure API key authorization: merchantKey
PaymentRails\Configuration::environment('production');
PaymentRails\Configuration::publicKey(YOUR_PUBLIC_KEY);
PaymentRails\Configuration::privateKey(YOUR_PRIVATE_KEY);


try {
    $recipients = PaymentRails\Recipient::all();

    foreach ($recipients as $rcpt) {
      print_r($rcpt->id . "\n");
    }
} catch (Exception $e) {
    echo 'Exception when calling PaymentRails\\Recipient::all ', $e->getMessage(), PHP_EOL;
}
```

## Documentation for API Endpoints

All URIs are available at http://docs.paymentrails.com/
