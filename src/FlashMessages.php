<?php
/**
 * Copyright (c) A.S Nassiry
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @see https://github.com/nassiry/flash-messages
 */

namespace Nassiry\FlashMessages;


class FlashMessages
{
    private FlashMessageStorage $storage;
    private FlashMessageRenderer $renderer;

    /**
     * FlashMessages constructor.
     *
     * @param FlashMessageStorage $storage  The storage mechanism for messages.
     * @param FlashMessageRenderer $renderer The renderer for displaying messages.
     */
    public function __construct(
        FlashMessageStorage $storage,
        FlashMessageRenderer $renderer
    ) {
        $this->storage = $storage;
        $this->renderer = $renderer;
    }

    /**
     * Create a new FlashMessages instance with default storage and renderer.
     *
     * @return FlashMessages
     */
    public static function create(): FlashMessages
    {
        return new self(
            new FlashMessageStorage(),
            new FlashMessageRenderer()
        );
    }

    /**
     * Add a success message.
     *
     * @param string $message The message content.
     * @param bool   $instant Whether to display the message instantly.
     */
    public function success(string $message, bool $instant = false): void
    {
        $this->addMessage('success', $message, $instant);
    }

    /**
     * Add an error message.
     *
     * @param string $message The message content.
     * @param bool   $instant Whether to display the message instantly.
     */
    public function error(string $message, bool $instant = false): void
    {
        $this->addMessage('error', $message, $instant);
    }

    /**
     * Add an info message.
     *
     * @param string $message The message content.
     * @param bool   $instant Whether to display the message instantly.
     */
    public function info(string $message, bool $instant = false): void
    {
        $this->addMessage('info', $message, $instant);
    }

    /**
     * Add a warning message.
     *
     * @param string $message The message content.
     * @param bool   $instant Whether to display the message instantly.
     */
    public function warning(string $message, bool $instant = false): void
    {
        $this->addMessage('warning', $message, $instant);
    }

    /**
     * Add a custom type message.
     *
     * @param string $type    The custom type.
     * @param string $message The message content.
     * @param bool   $instant Whether to display the message instantly.
     */
    public function addCustomType(string $type, string $message, bool $instant = false): void
    {
        $this->addMessage($type, $message, $instant);
    }

    /**
     * Add a message to the storage.
     *
     * @param string $type    The type of the message.
     * @param string $message The message content.
     * @param bool   $instant Whether to display the message instantly.
     */
    private function addMessage(string $type, string $message, bool $instant): void
    {
        try {
            $this->storage->addMessage($type, $message, $instant);
        } catch (\Exception $e) {
            error_log('Error adding flash message: ' . $e->getMessage());
        }
    }

    /**
     * Render all stored messages.
     */
    public function render(): void
    {
        foreach ($this->storage->getMessages() as $message) {
            $this->renderer->renderMessage($message['type'], $message['message']);
        }
        $this->storage->clear();
    }

    /**
     * {@inheritdoc}
     */
    public function hasMessages(?string $type = null): bool
    {
        return $this->storage->hasMessages($type);
    }

    /**
     * {@inheritdoc}
     */
    public function getMessages(?string $type = null): array
    {
        return $this->storage->getMessages($type);
    }

    /**
     * Clear all stored messages.
     */
    public function clear(): void
    {
        $this->storage->clear();
    }
}