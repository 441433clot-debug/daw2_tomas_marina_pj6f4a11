<?php

function readJsonFile(string $filePath): array
{
    if (!file_exists($filePath)) {
        return [];
    }
    $content = file_get_contents($filePath);
    $data = json_decode($content, true);
    if (!is_array($data)) {
        return [];
    }
    return $data;
}