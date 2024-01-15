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

    public function getLabel(): string
    {
        return $this->label;
    }

    public function setLabel(string $label): void
    {
        $this->label = $label;
    }

    public function isClear(): bool
    {
        return $this->clear;
    }

    public function setClear(bool $clear): void
    {
        $this->clear = $clear;
    }

    abstract public function getContent(): array;
}
