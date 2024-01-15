<?php

namespace Kamilmusial\NtfyPhp\Message\Action;

use Kamilmusial\NtfyPhp\Message\Action;

class Broadcast extends Action
{
    const TYPE = 'broadcast';
    private string $url;
    private string $intent = 'io.heckel.ntfy.USER_ACTION';
    private array $extras = [];

    public function __construct(string $label, bool $clear = false)
    {
        parent::__construct($label, $clear);
        $this->type = self::TYPE;
    }

    public function getIntent(): string
    {
        return $this->intent;
    }

    public function setIntent(string $intent): self
    {
        $this->intent = $intent;

        return $this;
    }

    /**
     * @return Extras[]
     */
    public function getExtras(): array
    {
        return $this->extras;
    }

    /**
     * @param Extras[] $extras
     */
    public function setExtras(array $extras): self
    {
        $this->extras = $extras;

        return $this;
    }

    public function getContent(): array
    {
        return [
            'action' => $this->type,
            'label' => $this->label,
            'intent' => $this->intent,
            'extras' => array_merge(...array_map(fn (Extras $extras) => [$extras->param => $extras->value], $this->extras)),
            'clear' => $this->clear,
        ];
    }
}
