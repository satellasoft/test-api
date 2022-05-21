<?php

namespace App\Helpers;

class  Input
{
    public static function post(string $field, int $filter = FILTER_SANITIZE_SPECIAL_CHARS)
    {
        return filter_input(INPUT_POST, $field, $filter);
    }

    public static function get(string $field, int $filter = FILTER_SANITIZE_SPECIAL_CHARS)
    {
        return filter_input(INPUT_GET, $field, $filter);
    }

    public static function getRaw(): ?array
    {
        $json = file_get_contents('php://input');

        return json_decode($json, true);
    }
}
