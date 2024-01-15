<?php

namespace Kamilmusial\NtfyPhp\Message\Action;

readonly class Header
{
    public function __construct(
        public string $key,
        public string $value,
    ) {
    }
}