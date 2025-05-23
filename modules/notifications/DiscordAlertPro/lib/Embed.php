<?php

namespace WHMCS\Module\Notification\DiscordAlertPro;

class Embed
{
    public $title = "";
    public $url = "";
    public $description = "";
    public $fields = [];
    public $timestamp = "";
    public $color = "";
    public $footer = [];

    public function title($title) { $this->title = trim($title); return $this; }
    public function url($url) { $this->url = trim($url); return $this; }
    public function description($description) { $this->description = trim($description); return $this; }
    public function timestamp($timestamp) { $this->timestamp = trim($timestamp); return $this; }
    public function color($color) { $this->color = $color; return $this; }
    public function footer($text, $icon = "") {
        $this->footer["text"] = trim($text);
        $this->footer["icon_url"] = trim($icon);
        return $this;
    }

    public function addField(Field $field) {
        $this->fields[] = $field;
        return $this;
    }

    public function toArray() {
        $embed = [];
        if (!empty($this->title)) $embed["title"] = $this->title;
        if (!empty($this->url)) $embed["url"] = $this->url;
        if (!empty($this->description)) $embed["description"] = $this->description;
        if (!empty($this->timestamp)) $embed["timestamp"] = $this->timestamp;
        if (!empty($this->color)) $embed["color"] = $this->color;
        if (!empty($this->footer)) $embed["footer"] = $this->footer;

        if (!empty($this->fields)) {
            $embed["fields"] = array_map(function (Field $field) {
                return $field->toArray();
            }, $this->fields);
        }

        return $embed;
    }
}
