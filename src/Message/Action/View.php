<?php

namespace Kamilmusial\NtfyPhp\Message\Action;

use Kamilmusial\NtfyPhp\Message\Action;

class View extends Action
{
    const TYPE = 'view';

    private string $url;

    public function __construct(string $label, bool $clear = false)
    {
        parent::__construct($label, $clear);
        $this->type = self::TYPE;
    }

    public function getUrl(): string
    {
        return $this->url;
    }

    public function setUrl(string $url): self
    {
        $this->url = $url;

        return $this;
    }

    public function getContent(): array
    {
        return [
            'action' => $this->type,
            'label' => $this->label,
            'url' => $this->url,
            'clear' => $this->clear,
        ];
    }
}
