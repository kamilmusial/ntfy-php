<?php

namespace Kamilmusial\NtfyPhpTest\Auth;

use Kamilmusial\NtfyPhp\Auth\Basic;
use PHPUnit\Framework\TestCase;

class BasicTest extends TestCase
{
    public function testGetCredentials(): void
    {
        $basic = new Basic('test_user', 'test_pass');
        $this->assertEquals('Basic dGVzdF91c2VyOnRlc3RfcGFzcw==', $basic->getCredentials());
    }
}