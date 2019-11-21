<?php

namespace App\Classes;

class Guestbook
{
    public $id, $title, $body, $author, $published, $creted_at, $entry;

    public function __construct()
    {
        $this->entry = "{$this->author} posted: {$this->body}";
    }

}