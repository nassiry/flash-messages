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

interface FlashMessageInterface
{
    /**
     * Adds a flash message to the storage.
     *
     * @param string $type    The type of the message.
     * @param string $message The content of the flash message.
     * @param bool   $instant Whether the message should be displayed instantly.
     */
    public function addMessage(string $type, string $message, bool $instant): void;

    /**
     * Renders all stored flash messages.
     */
    public function render(): void;

    /**
     * Checks if there are any stored flash messages, optionally filtered by type.
     *
     * @param string|null $type The type to check for, or null to check for any.
     * @return bool True if messages exist (of that type, if given), false otherwise.
     */
    public function hasMessages(?string $type = null): bool;

    /**
     * Retrieves all stored flash messages.
     *
     * @param string|null $type The type to filter messages by, or null for all.
     * @return array<int, array{type: string, message: string}> The array of flash messages.
     */
    public function getMessages(?string $type = null): array;

    /**
     * Clears all stored flash messages.
     */
    public function clear(): void;
}