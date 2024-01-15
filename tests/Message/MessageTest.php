<?php

namespace Kamilmusial\NtfyPhpTest\Message;

use Kamilmusial\NtfyPhp\Message\Action\Broadcast;
use Kamilmusial\NtfyPhp\Message\Action\Extras;
use Kamilmusial\NtfyPhp\Message\Action\Http;
use Kamilmusial\NtfyPhp\Message\Action\View;
use Kamilmusial\NtfyPhp\Message\Message;
use Kamilmusial\NtfyPhp\Message\Priority;
use PHPUnit\Framework\TestCase;

class MessageTest extends TestCase
{
    public function testSimple(): void
    {
        $message = new Message('test_topic');
        $expected = [
            'topic' => 'test_topic',
            'message' => null,
            'title' => null,
            'tags' => '',
            'priority' => Priority::DEFAULT->value,
            'markdown' => false,
            'icon' => null,
        ];
        $this->assertEquals($expected, $message->getContent());
    }

    public function testActions(): void
    {
        $actions = [
            (new View('view_label'))->setUrl('view_url'),
            (new Http('http_label'))->setUrl('http_url')->setMethod('put')->setHeaders(['header1' => 'foo'])->setBody('http_body'),
            (new Broadcast('broadcast_label', true))->setExtras([new Extras('extras', 'foo'), new Extras('extras2', 'bar')]),
        ];
        $message = new Message('test_topic', actions: $actions);
        $content = $message->getContent();
        $actions = $content['actions'];
        $this->assertCount(3, $actions);
        $this->assertEquals('view', $actions[0]['action']);
        $this->assertEquals('view_url', $actions[0]['url']);

        $this->assertEquals('http', $actions[1]['action']);
        $this->assertEquals('http_url', $actions[1]['url']);
        $this->assertEquals('put', $actions[1]['method']);
        $this->assertEquals(['header1' => 'foo'], $actions[1]['headers']);
        $this->assertEquals('http_body', $actions[1]['body']);

        $this->assertEquals('broadcast', $actions[2]['action']);
        $this->assertEquals('io.heckel.ntfy.USER_ACTION', $actions[2]['intent']);
        $this->assertEquals(['extras' => 'foo', 'extras2' => 'bar'], $actions[2]['extras']);
    }

    public function testNotRequired(): void
    {
        $message = new Message(
            'test_topic',
            Priority::HIGH,
            true,
            'test_title',
            '##Message',
            ['foo', 'bar'],
            [],
            'http://example.com',
            '30m',
            'http://example.com/icon.png',
            'file.txt',
            'text.jpg',
            'test@example.com'
        );
        $expected = [
            'topic' => 'test_topic',
            'message' => '##Message',
            'title' => 'test_title',
            'tags' => 'foo,bar',
            'priority' => 4,
            'markdown' => true,
            'icon' => 'http://example.com/icon.png',
            'click' => 'http://example.com',
            'attach' => 'text.jpg',
            'filename' => 'file.txt',
            'delay' => '30m',
            'email' => 'test@example.com',
        ];
        $this->assertEquals($expected, $message->getContent());

    }
}