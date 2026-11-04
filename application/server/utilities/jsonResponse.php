<?php

// Send a JSON response with an HTTP status code
function sendJsonResponse(
    bool $success,
    string $message,
    array $data = [],
    int $statusCode = 200
): void {

    http_response_code($statusCode);

    header("Content-Type: application/json; charset=UTF-8");

    echo json_encode([
        "success" => $success,
        "message" => $message,
        "data" => $data
    ]);
    exit;
}