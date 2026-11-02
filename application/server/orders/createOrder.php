<?php
require_once "../utilities/jsonResponse.php";
if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    sendJsonResponse(false, "Invalid request method.");
}

$input = json_decode(file_get_contents("php://input"), true);

if (!$input) {
    sendJsonResponse(false, "Invalid request.");
}

sendJsonResponse(
    true,
    "Order received successfully.",
    $input
);