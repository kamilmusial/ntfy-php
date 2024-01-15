<?php

namespace Kamilmusial\NtfyPhpTest\Factory;

use Kamilmusial\NtfyPhp\Auth\AccessToken;
use Kamilmusial\NtfyPhp\Auth\Basic;
use Kamilmusial\NtfyPhp\Config;
use Kamilmusial\NtfyPhp\Factory\GuzzleRequestFactory;
use Kamilmusial\NtfyPhp\Message\Action\Broadcast;
use Kamilmusial\NtfyPhp\Message\Action\Extras;
use Kamilmusial\NtfyPhp\Message\Action\Http;
use Kamilmusial\NtfyPhp\Message\Action\View;
use Kamilmusial\NtfyPhp\Message\Message;
use Kamilmusial\NtfyPhp\Message\Priority;
use PHPUnit\Framework\TestCase;

class GuzzleRequestFactoryTest extends TestCase
{
    public function testCreation(): void
    {
        $message = new Message(
            'test_topic',
            Priority::HIGH,
            true,
            'test_title',
            '##Message',
            ['foo', 'bar'],
            [
                (new View('view_label'))->setUrl('view_url'),
                (new Http('http_label'))->setUrl('http_url')->setMethod('put')->setHeaders(['header1' => 'foo'])->setBody('http_body'),
                (new Broadcast('broadcast_label', true))->setExtras([new Extras('extras', 'foo'), new Extras('extras2', 'bar')]),
            ],
            'http://example.com',
            '30m',
            'http://example.com/icon.png',
            'file.txt',
            'text.jpg',
            'test@example.com',
            'no',
        );

        $requestFactory = new GuzzleRequestFactory(new Config('http://example.com'));
        $request = $requestFactory->create($message);

        $expectedBody = '{"content":{"topic":"test_topic","message":"##Message","title":"test_title","tags":"foo,bar","priority":4,"markdown":true,"icon":"http:\/\/example.com\/icon.png","actions":[{"action":"view","label":"view_label","url":"view_url","clear":false},{"action":"http","label":"http_label","url":"http_url","method":"put","headers":{"header1":"foo"},"body":"http_body","clear":false},{"action":"broadcast","label":"broadcast_label","intent":"io.heckel.ntfy.USER_ACTION","extras":{"extras":"foo","extras2":"bar"},"clear":true}],"click":"http:\/\/example.com","attach":"text.jpg","filename":"file.txt","delay":"30m","email":"test@example.com"}}';
        $this->assertEquals($expectedBody, $request->getBody()->getContents());
        $this->assertEquals(['Host' => ['example.com'], 'cache' => ['no']], $request->getHeaders());
    }

    public function testBasicAuth(): void
    {
        $message = new Message('basic_auth_test');
        $basic = new Basic('test_user', 'test_pass');
        $requestFactory = new GuzzleRequestFactory(new Config('http://example.com', $basic));
        $request = $requestFactory->create($message);
        $this->assertEquals(['Basic dGVzdF91c2VyOnRlc3RfcGFzcw=='], $request->getHeader('Authorization'));
    }

    public function testAccessTokenAuth(): void
    {
        $message = new Message('basic_auth_test');
        $basic = new AccessToken('eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJzdWIiOiIxMjM0NTY3ODkwIiwibmFtZSI6IkpvaG4gRG9lIiwiaWF0IjoxNTE2MjM5MDIyfQ.SflKxwRJSMeKKF2QT4fwpMeJf36POk6yJV_adQssw5c');
        $requestFactory = new GuzzleRequestFactory(new Config('http://example.com', $basic));
        $request = $requestFactory->create($message);
        $this->assertEquals(['Bearer eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJzdWIiOiIxMjM0NTY3ODkwIiwibmFtZSI6IkpvaG4gRG9lIiwiaWF0IjoxNTE2MjM5MDIyfQ.SflKxwRJSMeKKF2QT4fwpMeJf36POk6yJV_adQssw5c'], $request->getHeader('Authorization'));
    }
}