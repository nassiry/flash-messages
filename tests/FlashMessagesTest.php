<?php
/**
 * Copyright (c) A.S Nassiry
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @see https://github.com/nassiry/flash-messages
 */

namespace Nassiry\FlashMessages\Tests;

use Nassiry\FlashMessages\FlashMessages;
use Nassiry\FlashMessages\FlashMessageStorage;
use Nassiry\FlashMessages\FlashMessageRenderer;
use PHPUnit\Framework\TestCase;

class FlashMessagesTest extends TestCase
{
    private FlashMessages $flashMessages;
    private FlashMessageStorage $mockStorage;
    private FlashMessageRenderer $mockRenderer;

    protected function setUp(): void
    {
        $this->mockStorage = $this->createMock(FlashMessageStorage::class);
        $this->mockRenderer = $this->createMock(FlashMessageRenderer::class);
        $this->flashMessages = new FlashMessages($this->mockStorage, $this->mockRenderer);
    }

    public function testAddSuccessMessage(): void
    {
        $message = 'Operation successful';
        $this->mockStorage
            ->expects($this->once())
            ->method('addMessage')
            ->with('success', $message, false);

        $this->flashMessages->success($message);
    }

    public function testAddErrorMessage(): void
    {
        $message = 'An error occurred';
        $this->mockStorage
            ->expects($this->once())
            ->method('addMessage')
            ->with('error', $message, false);

        $this->flashMessages->error($message);
    }

    public function testAddInfoMessage(): void
    {
        $message = 'Here is some information';
        $this->mockStorage
            ->expects($this->once())
            ->method('addMessage')
            ->with('info', $message, false);

        $this->flashMessages->info($message);
    }

    public function testAddWarningMessage(): void
    {
        $message = 'This is a warning';
        $this->mockStorage
            ->expects($this->once())
            ->method('addMessage')
            ->with('warning', $message, false);

        $this->flashMessages->warning($message);
    }

    public function testAddCustomTypeMessage(): void
    {
        $type = 'custom';
        $message = 'This is a custom message';
        $this->mockStorage
            ->expects($this->once())
            ->method('addMessage')
            ->with($type, $message, false);

        $this->flashMessages->addCustomType($type, $message);
    }

    public function testRenderMessages(): void
    {
        $messages = [
            ['type' => 'success', 'message' => 'Success message'],
            ['type' => 'error', 'message' => 'Error message'],
        ];

        $this->mockStorage
            ->expects($this->once())
            ->method('getMessages')
            ->willReturn($messages);

        $this->mockRenderer
            ->expects($this->exactly(count($messages)))
            ->method('renderMessage')
            ->withConsecutive(
                ['success', 'Success message'],
                ['error', 'Error message']
            );

        $this->mockStorage
            ->expects($this->once())
            ->method('clear');

        $this->flashMessages->render();
    }

    public function testHasMessages(): void
    {
        $this->mockStorage
            ->expects($this->once())
            ->method('hasMessages')
            ->willReturn(true);

        $this->assertTrue($this->flashMessages->hasMessages());
    }

    public function testGetMessages(): void
    {
        $messages = [
            ['type' => 'info', 'message' => 'Information message'],
        ];

        $this->mockStorage
            ->expects($this->once())
            ->method('getMessages')
            ->willReturn($messages);

        $this->assertSame($messages, $this->flashMessages->getMessages());
    }

    public function testGetMessagesWithTypeFilter(): void
    {
        $messages = [
            ['type' => 'info', 'message' => 'Information message'],
            ['type' => 'error', 'message' => 'Error message'],
            ['type' => 'info', 'message' => 'Another info message'],
        ];

        $this->mockStorage
            ->expects($this->once())
            ->method('getMessages')
            ->willReturn($messages);

        $filteredMessages = $this->flashMessages->getMessages('info');

        $expected = [
            ['type' => 'info', 'message' => 'Information message'],
            ['type' => 'error', 'message' => 'Error message'],
            ['type' => 'info', 'message' => 'Another info message'],
        ];

        $this->assertSame($expected, $filteredMessages);
    }

    public function testClearMessages(): void
    {
        $this->mockStorage
            ->expects($this->once())
            ->method('clear');

        $this->flashMessages->clear();
    }
}
