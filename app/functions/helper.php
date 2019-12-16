<?php
function view(string $file, array $params=[])
{
    return require_once __DIR__ . "/../../views/{$file}.php";
}