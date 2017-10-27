# Payment Rails PHP SDK

## Requirements

PHP 5.6.0 and later

## Installation & Usage

### Composer

To install the bindings via [Composer](http://getcomposer.org/), add the following to `composer.json`:

```
{
  "repositories": [
    {
      "type": "git",
      "url": "https://github.com/PaymentRails/php-sdk.git"
    }
  ],
  "require": {
    "PaymentRails/php-sdk": "*"
  }
}
```

Then run `composer install`


## Tests

To run the unit tests:

```
composer install
./vendor/bin/phpunit test
```

## Getting Started

Please follow the [installation procedure](#installation--usage) and then run the following:

```php
<?php
require_once 'PATH_TO_PAYMENTRAILS/lib/PaymentRails.php';

// Configure API key authorization: merchantKey
PaymentRails_Configuration::publicKey(YOUR_PUBLIC_KEY);
PaymentRails_Configuration::privateKey(YOUR_PRIVATE_KEY);

$recipients = new PaymentRails_Recipient::all()

try {
    foreach ($recipients as $rcpt) {
      print_r($rcpt->id . "\n");
    }
} catch (Exception $e) {
    echo 'Exception when calling PaymentRailsRecipient::all ', $e->getMessage(), PHP_EOL;
}
?>
```

## Documentation for API Endpoints

All URIs are available at http://docs.paymentrails.com/