<?php

namespace Kamilmusial\NtfyPhp\Message;

enum Priority: int
{
    case MAX = 5;
    case HIGH = 4;
    case DEFAULT = 3;
    case LOW = 2;
    case MIN = 1;
}
