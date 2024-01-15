<?php

namespace Kamilmusial\NtfyPhp\Factory;

use GuzzleHttp\Psr7\Request;
use Kamilmusial\NtfyPhp\Config;
use Kamilmusial\NtfyPhp\Message\Message;
use Psr\Http\Message\RequestInterface;

readonly class GuzzleRequestFactory implements RequestFactoryInterface
{
    public function __construct(private Config $config)
    {
    }

    public function create(Message $message): RequestInterface
    {
        $headers = [];
        if ($this->config->auth) {
            $headers['Authorization'] = $this->config->auth->getCredentials();
        }
        if ($message->cache) {
            $headers['cache'] = $message->cache;
        }

        $body = json_encode([
            'content' => $message->getContent(),
        ]);

        return new Request(
            'POST',
            $this->config->uri,
            $headers,
            (string) $body
        );
    }
}