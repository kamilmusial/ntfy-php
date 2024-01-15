<?php

namespace Kamilmusial\NtfyPhp;

use Kamilmusial\NtfyPhp\Auth\AuthInterface;

readonly class Config
{
    public function __construct(
        public string $uri,
        public ?AuthInterface $auth = null
    ) {
    }
}