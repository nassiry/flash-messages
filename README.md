<div align="center">

# Flash Messages Package

![PHP](https://img.shields.io/badge/PHP-%5E7.4-blue)


</div>

---

A lightweight PHP library for handling flash messages with session storage & rendering. This package does not depend on any framework, but it can be integrated with frameworks like Laravel, Symfony, CakePHP, and CodeIgniter if needed.

- Session-based flash message storage.
- Instant message rendering.
- Custom message types.
- Fully framework-agnostic.

## Installation

The recommended way use Composer to install the package:

```
composer require nassiry/flash-messages
```

## Usage

By default, the package stores messages in sessions to be displayed on the next page load.

### 1. Default Usage (Display on Next Page Load)

```
use Nassiry\FlashMessages\FlashMessages;

// Create an instance
$flash = FlashMessages::create();

// Add flash messages to be displayed on the next page load
$flash->success('Operation successful!');
$flash->error('An error occurred.');

// Render messages on the next page template file
$flash->render();
```

### 2. Current Page Usage (Display Immediately)

To display a message on the current page, set the second argument to `true` (default is `false`):

```
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

```
if ($flash->hasMessages()) {
    echo "There are flash messages available.";
}
```

### 4. Retrieving Messages

You can retrieve all stored messages as an array:

```
$messages = $flash->getMessages();
foreach ($messages as $message) {
    echo $message['type'] . ': ' . $message['message'] . "<br>";
}
```

### 5. Rendering Messages
Outputs all flash messages with default HTML structure

```
$flash->render();

<div class="flash flash-success">Operation successful!</div>
<div class="flash flash-error">An error occurred!</div>
```

### 6. Clearing Messages

To clear all stored messages:

```
$flash->clear();
```

### Adding Different Types of Messages
Currently, the package support following message types.

```
$flash->success('Success message!');
$flash->error('Error message!');
$flash->info('Informational message!');
$flash->warning('Warning message!');
```

### Custom Rendering Logic

If you need to customize the way messages are displayed, extend the `FlashMessageRenderer` class:

```
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