<?php

namespace Kamilmusial\NtfyPhpTest;

use GuzzleHttp\ClientInterface;
use GuzzleHttp\Promise\FulfilledPromise;
use GuzzleHttp\Psr7\Response;
use JMS\Serializer\SerializerBuilder;
use Kamilmusial\NtfyPhp\Client;
use Kamilmusial\NtfyPhp\Config;
use Kamilmusial\NtfyPhp\Factory\GuzzleRequestFactory;
use Kamilmusial\NtfyPhp\Message\Message;
use PHPUnit\Framework\TestCase;

class ClientTest extends TestCase
{
    public function testPromiseFulfilled(): void
    {
        $promise = new FulfilledPromise(new Response(body: '{
            "id": "JKZVSZ3sJI92",
            "time": 1705336197,
            "expires": 1705379397,
            "event": "message",
            "topic": "test",
            "message": "{\"topic\": \"test_topic\"}"
        }'));
        $clientMock = $this->getMockBuilder(ClientInterface::class)->getMock();
        $clientMock->method('sendAsync')->willReturn($promise);
        $serializer = SerializerBuilder::create()->build();
        $client = new Client($clientMock, new GuzzleRequestFactory(new Config('http://example.com')), $serializer);
        $response = $client->sendMessage(new Message('test'));

        $this->assertEquals('JKZVSZ3sJI92', $response->id);
        $this->assertEquals('2024-01-15T16:29:57+00:00', $response->time->format('c'));
        $this->assertEquals('2024-01-16T04:29:57+00:00', $response->expires->format('c'));
        $this->assertEquals('message', $response->event);
        $this->assertEquals('test', $response->topic);
        $this->assertEquals('{"topic": "test_topic"}', $response->message);
    }
}