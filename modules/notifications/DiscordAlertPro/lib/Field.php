<?php

namespace WHMCS\Module\Notification\DiscordAlertPro;

class Field
{
    public $name = "";
    public $value = "";
    public $inline = true;

    public function name($name)
    {
        $this->name = trim($name);
        return $this;
    }

    public function value($value)
    {
        $this->value = trim($value);
        return $this;
    }

    public function inline($inline = true)
    {
        $this->inline = (bool) $inline;
        return $this;
    }

    public function toArray()
    {
        return [
            'name' => $this->name,
            'value' => $this->value,
            'inline' => $this->inline
        ];
    }
}
