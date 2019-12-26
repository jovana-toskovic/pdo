<?php
session_start();

function view(string $file, $params=null)
{
    return require_once BASIC_PATH . "/views/{$file}.php";
}