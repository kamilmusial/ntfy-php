<?php

namespace Kamilmusial\NtfyPhp\Factory;

use Kamilmusial\NtfyPhp\Config;
use Kamilmusial\NtfyPhp\Message\Message;
use Psr\Http\Message\RequestInterface;

interface RequestFactoryInterface
{
    public function create(Message $message): RequestInterface;
}