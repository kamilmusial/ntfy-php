<?php

namespace Kamilmusial\NtfyPhp\Response;

use DateTimeImmutable;
use GuzzleHttp\Psr7\MessageTrait;
use JMS\Serializer\Annotation as Serializer;
use Psr\Http\Message\ResponseInterface;

class Response implements ResponseInterface
{
    use MessageTrait;

    public int $code;
    public string $reasonPhrase;
    public function __construct(
        readonly public string $id,
        #[Serializer\Type('DateTimeImmutable<"U">')]
        readonly public DateTimeImmutable $time,
        #[Serializer\Type('DateTimeImmutable<"U">')]
        readonly public DateTimeImmutable $expires,
        readonly public string $event,
        readonly public string $topic,
        readonly public string $message
    ) {
    }

    public function getStatusCode(): int
    {
        return $this->code;
    }

    public function withStatus(int $code, string $reasonPhrase = ''): ResponseInterface
    {
        $this->code = $code;
        $this->reasonPhrase = $reasonPhrase;

        return $this;
    }

    public function getReasonPhrase(): string
    {
        return $this->reasonPhrase;
    }
}