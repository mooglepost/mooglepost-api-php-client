# mooglepost-api-php-client

PHP client library for MooglePost API

[![Latest Stable Version](https://poser.pugx.org/mooglepost/mooglepost-api-php-client/v/stable)](https://packagist.org/packages/mooglepost/mooglepost-api-php-client)
[![License](https://poser.pugx.org/mooglepost/mooglepost-api-php-client/license)](https://packagist.org/packages/mooglepost/mooglepost-api-php-client)

## Requirements

- PHP >= 5.3

## Installation

Install directly via [Composer](https://getcomposer.org/):
```bash
$ composer require mooglepost-api-php-client
```

## Basic Usage

```php
<?php

require_once 'vendor/autoload.php';

$mglpst = new MooglePost\Client('YOUR_API_KEY');

try {
	$mglpst->send('email@example.com', 'template-name');
} catch (\Exception $e) {
	die('A MooglePost error occurred: '.$e->getMessage());
}

die('Your email has been sent !');
```
