<?php

namespace WHMCS\Module\Notification\DiscordAlertPro;

class Message
{
    public $content = "";
    public $username = "";
    public $avatarUrl = "";
    public $embeds = [];

    public function content($content)
    {
        $this->content = trim($content);
        return $this;
    }

    public function username($username)
    {
        $this->username = trim($username);
        return $this;
    }

    public function avatarUrl($avatarUrl)
    {
        $this->avatarUrl = trim($avatarUrl);
        return $this;
    }

    public function embed($embed)
    {
        $this->embeds[] = $embed;
        return $this;
    }

    public function toArray()
    {
        $message = [];

        if (!empty($this->content)) {
            $message["content"] = $this->content;
        }

        if (!empty($this->username)) {
            $message["username"] = $this->username;
        }

        if (!empty($this->avatarUrl)) {
            $message["avatar_url"] = $this->avatarUrl;
        }

        if (!empty($this->embeds)) {
            $message["embeds"] = array_map(function ($embed) {
                return $embed->toArray();
            }, $this->embeds);
        }

        return $message;
    }
}
