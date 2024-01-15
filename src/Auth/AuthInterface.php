<?php

namespace Kamilmusial\NtfyPhp\Auth;

interface AuthInterface
{
    public function getCredentials(): string;
}