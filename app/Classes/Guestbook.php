<?php

namespace App\Classes;

class Guestbook
{
    public $id, $title, $body, $author, $published, $created_at, $entry;

    public function __construct()
    {
        $this->entry = "{$this->author} posted: {$this->body}";
    }

}