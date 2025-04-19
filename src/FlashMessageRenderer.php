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


class FlashMessageRenderer
{
    /**
     * Render a single flash message.
     *
     * @param string $type    The type of the message.
     * @param string $message The message content.
     * @return void
     */
    public function renderMessage(string $type, string $message): void
    {
        echo sprintf(
            '<div class="flash flash-%s">%s</div>',
            htmlspecialchars($type, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8'),
            htmlspecialchars($message, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8')
        );
    }
}