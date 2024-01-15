<?php

namespace Kamilmusial\NtfyPhp\Auth;

readonly class AccessToken implements AuthInterface
{
    public function __construct(
        public string $token,
    ) {
    }

    public function getCredentials(): string
    {
        return sprintf('Bearer %s', $this->token);
    }
}