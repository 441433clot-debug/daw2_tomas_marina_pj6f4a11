<?php
require_once "../utilities/jsonResponse.php";
require_once "../utilities/readJson.php";
if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    sendJsonResponse(false, "Invalid request method.");
}

$input = json_decode(file_get_contents("php://input"), true);

if (!$input) {
    sendJsonResponse(false, "Invalid request.");
}

$orderId = trim($input["orderId"] ?? "");
$customerName = trim($input["customerName"] ?? "");
$customerAddress = trim($input["customerAddress"] ?? "");
$customerEmail = trim($input["customerEmail"] ?? "");
$customerPhone = trim($input["customerPhone"] ?? "");
$products = $input["products"] ?? [];

if (
    $orderId === "" ||
    $customerName === "" ||
    $customerAddress === "" ||
    $customerEmail === "" ||
    $customerPhone === ""
) {
    sendJsonResponse(false, "All fields are required.");
}

if (!filter_var($customerEmail, FILTER_VALIDATE_EMAIL)) {
    sendJsonResponse(false, "Invalid email address.");
}

if (!preg_match("/^[0-9]{9,15}$/", $customerPhone)) {
    sendJsonResponse(false, "Invalid phone number.");
}

if (count($products) === 0) {
    sendJsonResponse(false, "Select at least one product.");
}

$subtotal = 0;

foreach ($products as $product) {
    $subtotal += $product["price"] * $product["quantity"];
}

$vat = round($subtotal * 0.21, 2);
$total = round($subtotal + $vat, 2);

// Crear el pedido (AQUÍ)
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

// Leer pedidos

$orders = readJsonFile("../../../orders/orders.json");

// Añadir el nuevo

$orders[] = $order;

// Guardar

file_put_contents(
    "../../../orders/orders.json",
    json_encode($orders, JSON_PRETTY_PRINT)
);

// Y AHORA, AL FINAL DEL TODO
sendJsonResponse(
    true,
    "Order saved successfully."
);