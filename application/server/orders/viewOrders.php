<?php

require_once "../utilities/jsonResponse.php";
require_once "../utilities/readJson.php";

// Only GET requests are allowed
if ($_SERVER["REQUEST_METHOD"] !== "GET") {
    sendJsonResponse(false, "Invalid request method.");
}

// Read all stored orders
$orders = readJsonFile("../../../orders/orders.json");

// Return the orders to JavaScript
sendJsonResponse(
    true,
    "Orders loaded successfully.",
    $orders
);