<?php

namespace Rockschtar\WordPress\ColoredAdminPostList\Models;

class PostStatus
{
    private string $optionKey;
    private string $label;
    private string $name;
    private ?string $defaultColor = null;

    public function __construct(string $label, string $name, ?string $defaultColor = null)
    {
        $this->optionKey = "capl-color-" . sanitize_key($name);
        $this->label = $label;
        $this->name = $name;
        $this->defaultColor = $defaultColor;
    }
    public function getOptionKey(): string
    {
        return $this->optionKey;
    }

    public function getLabel(): string
    {
        return $this->label;
    }
    public function getName(): string
    {
        return $this->name;
    }
    public function getDefaultColor(): ?string
    {
        return $this->defaultColor;
    }
}
