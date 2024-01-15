<?php

namespace Kamilmusial\NtfyPhp\Message\Action;

readonly class Extras
{
    public function __construct(
        public string $param,
        public string $value,
    ) {
    }
}