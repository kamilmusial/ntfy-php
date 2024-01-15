<?php

namespace Kamilmusial\NtfyPhp;

use GuzzleHttp\ClientInterface as GuzzleClientInterface;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Promise\PromiseInterface;
use Kamilmusial\NtfyPhp\Factory\GuzzleRequestFactory;
use Kamilmusial\NtfyPhp\Message\Message;
use Psr\Http\Message\ResponseInterface;

readonly class Client
{
    public function __construct(
        private GuzzleClientInterface $client,
        private GuzzleRequestFactory  $requestFactory,
    ) {
    }

    public function sendMessage(Message $message): ResponseInterface
    {
        return $this->sendMessageAsync($message)->wait();
    }

    public function sendMessageAsync(Message $message): PromiseInterface
    {
        $request = $this->requestFactory->create($message);
        $promise = $this->client->sendAsync($request);

        return $promise->then(function(ResponseInterface $response) {
            dd($response);
        })->otherwise(function (ClientException $exception) {
            dd($exception);
        });
    }
}