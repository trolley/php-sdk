# CHANGELOG

## v2.1.3 - 2022-07-27
* Added new attributes to `Recipient` and `Payment` classes:
   * `Recipient.routeMinimum`
   * `Payment.estimatedDeliveryAt`, `Payment.initiatedAt`, `Payment.returnedAt`

## v2.1.2 - 2022-07-13

* `StandardException` class now handles String error messages
* Introduced a new test folder for Exceptions, starting with a test fo StandardException
