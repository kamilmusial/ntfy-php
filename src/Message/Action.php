<?php

namespace Kamilmusial\NtfyPhp\Message;

abstract class Action
{
    protected string $type;
    protected string $label;
    protected bool $clear = false;

    public function __construct(
        string $label,
        bool $clear = false,
    ) {
        $this->label = $label;
        $this->clear = $clear;
    }

    public function getType(): string
    {
        return $this->type;
    }

    /**
     * @return array<string, array|bool|string>
     */
    abstract public function getContent(): array;
}
