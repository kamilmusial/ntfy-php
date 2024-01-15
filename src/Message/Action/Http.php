<?php

namespace Kamilmusial\NtfyPhp\Message\Action;

use Kamilmusial\NtfyPhp\Message\Action;

class Http extends Action
{
    const TYPE = 'http';

    private string $url;
    private string $method = 'POST';
    private array $headers = [];
    private string $body = '';

    public function __construct(string $label, bool $clear = false)
    {
        parent::__construct($label, $clear);
        $this->type = self::TYPE;
    }

    public function getUrl(): string
    {
        return $this->url;
    }

    public function setUrl(string $url): self
    {
        $this->url = $url;

        return $this;
    }

    public function getMethod(): string
    {
        return $this->method;
    }

    public function setMethod(string $method): self
    {
        $this->method = $method;

        return $this;
    }

    public function getHeaders(): array
    {
        return $this->headers;
    }

    public function setHeaders(array $headers): self
    {
        $this->headers = $headers;

        return $this;
    }

    public function getBody(): string
    {
        return $this->body;
    }

    public function setBody(string $body): self
    {
        $this->body = $body;

        return $this;
    }

    public function getContent(): array
    {
        return [
            'action' => $this->type,
            'label' => $this->label,
            'url' => $this->url,
            'method' => $this->method,
            'headers' => $this->headers,
            'body' => $this->body,
            'clear' => $this->clear,
        ];
    }
}
