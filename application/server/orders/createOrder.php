<?php
require_once "../utilities/jsonResponse.php";
require_once "../utilities/readJson.php";

// Only POST requests are allowed
if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    sendJsonResponse(false, "Invalid request method.", [], 405);
}

// Read the data sent by JavaScript
$input = json_decode(file_get_contents("php://input"), true);

if (!is_array($input)) {
    sendJsonResponse(false, "Invalid request.", [], 400);
}

// Get customer information
$orderId = trim($input["orderId"] ?? "");
$customerName = trim($input["customerName"] ?? "");
$customerAddress = trim($input["customerAddress"] ?? "");
$customerEmail = trim($input["customerEmail"] ?? "");
$customerPhone = trim($input["customerPhone"] ?? "");
$products = $input["products"] ?? [];

// Check required fields
if (
    $orderId === "" ||
    $customerName === "" ||
    $customerAddress === "" ||
    $customerEmail === "" ||
    $customerPhone === ""
) {
    sendJsonResponse(false, "All fields are required.", [], 400);
}

// Validate email and phone
if (!filter_var($customerEmail, FILTER_VALIDATE_EMAIL)) {
    sendJsonResponse(false, "Invalid email address.", [], 400);
}

if (!preg_match("/^[0-9]{9,15}$/", $customerPhone)) {
    sendJsonResponse(false, "Invalid phone number.", [], 400);
}

// Check products
if (!is_array($products) || count($products) === 0) {
    sendJsonResponse(false, "Select at least one product.", [], 400);
}

// Calculate the subtotal
$subtotal = 0;

foreach ($products as $product) {

    if (
        !isset($product["price"], $product["quantity"]) ||
        !is_numeric($product["price"]) ||
        !is_numeric($product["quantity"]) ||
        $product["price"] <= 0 ||
        $product["quantity"] <= 0
    ) {
        sendJsonResponse(false, "Invalid product information.", [], 400);
    }

    $subtotal += $product["price"] * $product["quantity"];
}

// Calculate VAT (21%) and total
$vat = round($subtotal * 0.21, 2);
$total = round($subtotal + $vat, 2);

// Create the order
$order = [
    "orderId" => $orderId,
    "customerName" => $customerName,
    "customerAddress" => $customerAddress,
    "customerEmail" => $customerEmail,
    "customerPhone" => $customerPhone,
    "products" => $products,
    "subtotal" => $subtotal,
    "vat" => $vat,
    "total" => $total
];

// Define the JSON file
$filePath = "../../../orders/orders.json";

// Read existing orders
if (file_exists($filePath)) {

    if (!is_readable($filePath)) {
        sendJsonResponse(false, "The orders file cannot be opened.", [], 404);
    }

    $orders = readJsonFile($filePath);

} else {
    $orders = [];
}

// Check if the order ID already exists
foreach ($orders as $existingOrder) {

    if (($existingOrder["orderId"] ?? "") === $orderId) {
        sendJsonResponse(false, "This order ID already exists.", [], 400);
    }
}

// Add the new order
$orders[] = $order;

// Save orders in the JSON file
$jsonData = json_encode($orders, JSON_PRETTY_PRINT);

if ($jsonData === false || file_put_contents($filePath, $jsonData, LOCK_EX) === false) {
    sendJsonResponse(false, "The order could not be saved.", [], 404);
}

// Confirm that the order was saved
sendJsonResponse(true, "Order saved successfully.", [], 200);
