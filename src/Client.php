<?php

namespace Kamilmusial\NtfyPhp;

use GuzzleHttp\Client as GuzzleClient;
use GuzzleHttp\ClientInterface as GuzzleClientInterface;
use GuzzleHttp\Promise\PromiseInterface;
use JMS\Serializer\SerializerBuilder;
use JMS\Serializer\SerializerInterface;
use Kamilmusial\NtfyPhp\Factory\GuzzleRequestFactory;
use Kamilmusial\NtfyPhp\Message\Message;
use Kamilmusial\NtfyPhp\Response\Response;
use Psr\Http\Message\ResponseInterface;

readonly class Client
{
    public function __construct(
        private GuzzleClientInterface $client,
        private GuzzleRequestFactory  $requestFactory,
        private SerializerInterface   $serializer
    ) {
    }

    public static function create(Config $config): self
    {
        return new self(
            new GuzzleClient(),
            new GuzzleRequestFactory($config),
            SerializerBuilder::create()->build()
        );
    }

    public function sendMessage(Message $message): Response
    {
        return $this->sendMessageAsync($message)->wait();
    }

    public function sendMessageAsync(Message $message): PromiseInterface
    {
        $request = $this->requestFactory->create($message);
        $promise = $this->client->sendAsync($request);

        return $promise->then(function(ResponseInterface $response): Response {
            return $this->serializer->deserialize(
                $response->getBody()->getContents(),
                Response::class,
                'json'
            );
        });
    }
}