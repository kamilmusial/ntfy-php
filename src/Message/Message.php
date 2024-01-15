<?php

namespace Kamilmusial\NtfyPhp\Message;

readonly class Message
{
    /**
     * @param string[] $tags
     * @param Action[] $actions
     */
    public function __construct(
        public string $topic,
        public Priority $priority = Priority::DEFAULT,
        public bool $isMarkdown = false,
        public ?string $title = null,
        public ?string $message = null,
        public ?array $tags = [],
        public ?array $actions = null,
        public ?string $click = null,
        public ?string $delay = null,
        public ?string $icon = null,
        public ?string $filename = null,
        public ?string $attach = null,
        public ?string $email = null,
        public ?string $cache = null
    ) {
    }

    /**
     * @return array<string, mixed>
     */
    public function getContent(): array
    {
        $content = [
            'topic' => $this->topic,
            'message' => $this->message,
            'title' => $this->title,
            'tags' => implode(',', $this->tags),
            'priority' => $this->priority->value,
            'markdown' => $this->isMarkdown,
            'icon' => $this->icon,
        ];

        if ($this->actions) {
            $content['actions'] = array_map(fn(Action $action) => $action->getContent(), $this->actions);
        }

        if ($this->click) {
            $content['click'] = $this->click;
        }

        if ($this->attach) {
            $content['attach'] = $this->attach;
        }

        if ($this->filename) {
            $content['filename'] = $this->filename;
        }

        if ($this->delay) {
            $content['delay'] = $this->delay;
        }

        if ($this->email) {
            $content['email'] = $this->email;
        }

        return $content;
    }
}