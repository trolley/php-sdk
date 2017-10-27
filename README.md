# Payment Rails PHP SDK

## Requirements

PHP 5.6.0 and later

## Installation & Usage

### Composer

To install the bindings via [Composer](http://getcomposer.org/), add the following to `composer.json`:

```
{
  "require": {
    "PaymentRails/php-sdk": "*"
  }
}
```

Then run `composer install`


## Getting Started

Please follow the [installation procedure](#installation--usage) and then run the following:

```php
<?php

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
