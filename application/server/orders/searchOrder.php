<?php

require_once "../utilities/jsonResponse.php";
require_once "../utilities/readJson.php";

// Only POST requests are allowed
if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    sendJsonResponse(false, "Invalid request method.");
}

// Read the JSON received from JavaScript
$input = json_decode(file_get_contents("php://input"), true);

$orderId = trim($input["orderId"] ?? "");

// Check that the ID has been provided
if ($orderId === "") {
    sendJsonResponse(false, "Order ID is required.");
}

// Read all stored orders
$orders = readJsonFile("../../../orders/orders.json");

// Search the order by its ID
foreach ($orders as $order) {

    if ($order["orderId"] === $orderId) {

        sendJsonResponse(
            true,
            "Order found.",
            $order
        );
    }
}

// No matching order found
sendJsonResponse(false, "Order not found.");