<?php
function view(string $file, array $params=[])
{
    return require_once BASIC_PATH . "/views/{$file}.php";
}