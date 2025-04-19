<div align="center">

# Flash Messages

![Tests](https://github.com/nassiry/flash-messages/actions/workflows/tests.yml/badge.svg)
![Packagist Downloads](https://img.shields.io/packagist/dt/nassiry/flash-messages)
![Packagist Version](https://img.shields.io/packagist/v/nassiry/flash-messages)
![PHP](https://img.shields.io/badge/PHP-%5E7.4-blue)
![License](https://img.shields.io/github/license/nassiry/flash-messages)

</div>

A lightweight PHP library for handling flash messages with **session storage** & simple **HTML** rendering. This package does not depend on any framework, but it can be integrated with frameworks like **Laravel**, **Symfony**, **CakePHP**, and **CodeIgniter** if needed.

### Features
- Session-based flash message storage.
- Instant message rendering.
- Custom message types.
- Fully framework-agnostic.

## Table Of Contents
1. [Installation](#installation)
2. [Usage](#usage)
    - [Default Usage (Display on Next Page Load)](#1-default-usage-display-on-next-page-load)
    - [Current Page Usage (Display Immediately)](#2-current-page-usage-display-immediately)
    - [Checking for Messages](#3-checking-for-messages)
    - [Retrieving Messages](#4-retrieving-messages)
    - [Rendering Messages](#5-rendering-messages)
    - [Clearing Messages](#6-clearing-messages)
3. [Adding Different Types of Messages](#adding-different-types-of-messages)
    - [Adding a custom type message](#adding-a-custom-type-message)
4. [Adding a custom type message](#custom-rendering-logic)
5. [Testing](#testing)
    - [Prerequisites](#1-prerequisites)
    - [Running Tests](#2-running-tests)
6. [License](#license)
7. [Contributing](#contributing)

## Installation

The recommended way use Composer to install the package:

```
composer require nassiry/flash-messages
```

## Usage

By default, the package stores messages in sessions to be displayed on the next page load.
### 1. Default Usage (Display on Next Page Load)

```php
require __DIR__ . '/vendor/autoload.php';

use Nassiry\FlashMessages\FlashMessages;

// Create an instance
$flash = FlashMessages::create();

// Add flash messages to be displayed on the next page load
$flash->success('Operation successful!');
$flash->error('An error occurred.');

// Render messages on the next page template file
$flash->render();
```
> **Note**: Ensure that `session_start();` has been called in your script before using.
### 2. Current Page Usage (Display Immediately)

To display a message on the current page, set the second argument to `true` (default is `false`):

```php
require __DIR__ . '/vendor/autoload.php';

use Nassiry\FlashMessages\FlashMessages;

// Create an instance
$flash = FlashMessages::create();

// Add flash messages to be displayed immediately
$flash->error('An error occurred.', true);

// Render messages instantly in the same page
$flash->render();
```

### 3. Checking for Messages

You can check if there are any stored messages:

```php
// Check if ANY messages exist
if ($flash->hasMessages()) {
    echo "There are flash messages available.";
}

// Check if SPECIFIC TYPE messages exist
if ($flash->hasMessages('info')) {
    echo "There are info messages available.";
}
```

### 4. Retrieving Messages

You can retrieve all stored messages as an array:

```php
// Get ALL messages
$allMessages = $flash->getMessages();
foreach ($allMessages as $message) {
    echo $message['type'] . ': ' . $message['message'] . "<br>";
}

// Get messages of SPECIFIC TYPE
$infoMessages = $flash->getMessages('info');
if (!empty($infoMessages)) {
    foreach ($infoMessages as $message) {
        echo 'Info: ' . $message['message'] . "<br>";
    }
} else {
    echo "No info messages found.";
}
```

### 5. Rendering Messages
Outputs all flash messages with default HTML structure

```php
$flash->render();
```
```html
<div class="flash flash-success">Operation successful!</div>
<div class="flash flash-error">An error occurred!</div>
```

### 6. Clearing Messages

To clear all stored messages:

```php
$flash->clear();
```

### Adding Different Types of Messages
Currently, the package support following message types.
 - `$flash->success('Success message!');`
 - `$flash->error('Error message!');`
 - `$flash->info('Informational message!');`
 - `$flash->warning('Warning message!');`
#### Adding a custom type message
 - `addCustomType(string $type, string $message, bool $instant = false)`
```php
$flash->addCustomType('notification',
 'This is a custom notification message!',
  true
 );
$flash->addCustomType('alert',
 'This is an alert message!',
  false
);
```

### Custom Rendering Logic

If you need to customize the way messages are displayed, extend the `FlashMessageRenderer` class:

```php
use Nassiry\FlashMessages\FlashMessageRenderer;

class CustomRenderer extends FlashMessageRenderer
{
    public function renderMessage(string $type, string $message): void
    {
        echo sprintf('<div class="custom-%s">%s</div>', htmlspecialchars($type), htmlspecialchars($message));
    }
}

$renderer = new CustomRenderer();
$flash = new FlashMessages(new FlashMessageStorage(), $renderer);
$flash->success('Custom rendered message!');
$flash->render();
```

### Testing

Run the unit tests to ensure the package works as expected:
#### 1. Prerequisites
Ensure you have all dependencies installed by running:
```
composer install
```
#### 2. Running Tests
Execute the following command to run the test suite:

```
composer test
```

### License

This package is open-source software licensed under the [MIT license](LICENSE).

### Contributing

Contributions are welcome! Please feel free to submit a Pull Request or open an issue.