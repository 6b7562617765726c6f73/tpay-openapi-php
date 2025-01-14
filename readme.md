# Tpay OpenAPI library

Library for all methods available via OpenAPI Tpay

# This library and some of openAPI methods are still under development.

## Requirements

  * PHP >= 5.6.0

## Installation

Install via composer:
```php
composer require tpay-com/tpay-openapi-php
```
Install via git over ssh:
```php
git clone git@github.com:tpay-com/tpay-openapi-php.git
```

Install via git over https:
```php
git clone https://github.com/tpay-com/tpay-openapi-php.git
```
manual download:
https://github.com/tpay-com/tpay-openapi-php/archive/master.zip

## Configuration

The only thing you need to do is to set your oAuth credentials like in example config file ([see example](Examples/ExamplesConfig.php))
You can generate access keys in tpay merchant panel (https://panel.tpay.com)

The [Loader.php](Loader.php) file handles all required class loading, so you can include this file to any file you are editing

All methods described in [Tpay OpenAPI documentation](https://openapi.tpay.com) can be easily executed by running one of the library methods like:
 ```php
 $TpayApi = new TpayApi($clientId, $clientSecret, true, 'read');
 $transactions = $this->TpayApi->Transactions->getTransactions();
 ```

All currently available API methods have an example usage in ([see examples](Examples)) directory.

### Example credentials
 
 #### for all API calls:

  Client id: 1010-e5736adfd4bc5d8c
  
  Client secret: 493e01af815383a687b747675010f65d1eefaeb42f63cfe197e7b30f14a556b7

 #### for notifications validation:
  
  Confirmation code: demo

 #### for credit card encrypting:
  
  Public Key: LS0tLS1CRUdJTiBQVUJMSUMgS0VZLS0tLS0NCk1JR2ZNQTBHQ1NxR1NJYjNEUUVCQVFVQUE0R05BRENCaVFLQmdRQ2NLRTVZNU1Wemd5a1Z5ODNMS1NTTFlEMEVrU2xadTRVZm1STS8NCmM5L0NtMENuVDM2ekU0L2dMRzBSYzQwODRHNmIzU3l5NVpvZ1kwQXFOVU5vUEptUUZGVyswdXJacU8yNFRCQkxCcU10TTVYSllDaVQNCmVpNkx3RUIyNnpPOFZocW9SK0tiRS92K1l1YlFhNGQ0cWtHU0IzeHBhSUJncllrT2o0aFJDOXk0WXdJREFRQUINCi0tLS0tRU5EIFBVQkxJQyBLRVktLS0tLQ==

### Examples of usage

##### Fronted forms and payment handlers: 

   [Payment method choice form](Examples/TransactionsApi/BankSelectionForm.php), [BLIK method form](Examples/TransactionsApi/BlikPayment.php), [Simple credit card form](Examples/TransactionsApi/CardGate.php), [Extended credit card form](Examples/TransactionsApi/CardGateExtended.php), [Recurrent payment example](Examples/TransactionsApi/RecurrentPayment.php)

##### Fronted forms and payment handlers: 

   [Payment notification webhook](Examples/Notifications/PaymentNotificationExample.php),

##### Merchant accounts registration (for partners only)

   [Example of usages](Examples/AccountsApi/AccountsApiExample.php)

## Logs
Library has own logging system to save all API calls, responses, webhook notifications, and exceptions.
Make sure that Logs directory is writable and add rule to Apache .htaccess or NGINX to deny access to this area from browser.
The log files are created for each day separately.

The logging is enabled by default but you can switch this feature by command:
 
 ```php
Logger::$loggingEnabled = false;
 ```

You can also set your own logging path by this command:

 ```php
Logger::$customLogPatch = '/my/own/path/Logs/';
 ```
 The logs file names will be assigned automatically.

## Custom templates and static files path

You can set your own templates path so you can copy and modify the phtml template files from this library.

 ```php
Util::$customTemplateDirectory = '/my/own/templates/path/';
 ```
 
You can set your own static files path so you can copy and modify the css and js files from this library. By default the path is based on $_SERVER['REQUEST_URI'].

  ```php
 Util::$libraryPath = '/my/own/path/';
  ```

## Language

The library supports two languages (EN, PL). Default language is english.
Change language example:

```php
//Any time you construct the class providing payment forms, you can pass pass the language in constructor
$PaymentForms = new PaymentForms('pl');
//After this line all static messages (input labels, buttons titles) will be displayed in Polish

//If you want to access translations manually, use:
$Lang = new Lang();
$Lang->setLang('pl'); //for setting language
$Lang->lang('pay'); //to echo translated key
```
