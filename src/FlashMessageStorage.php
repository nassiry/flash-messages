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


class FlashMessageStorage implements FlashMessageInterface
{
    /**
     * @var array<int, array{type: string, message: string}> The array of flash messages.
     */
    private array $messages = [];

    /**
     * FlashMessageStorage constructor.
     * Initializes messages from the session.
     */
    public function __construct()
    {
        $this->messages = $_SESSION['flash_messages'] ?? [];
        $_SESSION['flash_messages'] = [];
    }

    /**
     * {@inheritdoc}
     */
    public function addMessage(string $type, string $message, bool $instant): void
    {
        $messageData = ['type' => $type, 'message' => $message];

        if ($instant) {
            $this->messages[] = $messageData;
        } else {
            $_SESSION['flash_messages'][] = $messageData;
        }
    }

    /**
     * {@inheritdoc}
     */
    public function render(): void
    {
        //TODO: Render logic could be handled by the renderer class
    }

    /**
     * {@inheritdoc}
     */
    public function hasMessages(?string $type = null): bool
    {
        if ($type === null) {
            return !empty($this->messages);
        }

        foreach ($this->messages as $message) {
            if ($message['type'] === $type) {
                return true;
            }
        }

        return false;
    }

    /**
     * {@inheritdoc}
     */
    public function getMessages(?string $type = null): array
    {
        if ($type === null) {
            return $this->messages;
        }

        return array_values(
            array_filter(
                $this->messages,
                fn(array $message): bool => isset($message['type']) && $message['type'] === $type
            )
        );
    }

    /**
     * {@inheritdoc}
     */
    public function clear(): void
    {
        $this->messages = [];
    }
}