<?php

namespace Kamilmusial\NtfyPhp\Auth;

readonly class Basic implements AuthInterface
{
    public function __construct(
        public string $username,
        public string $password,
    ) {
    }

    public function getCredentials(): string
    {
        return 'Basic ' . base64_encode(sprintf('%s:%s', $this->username, $this->password));
    }
}