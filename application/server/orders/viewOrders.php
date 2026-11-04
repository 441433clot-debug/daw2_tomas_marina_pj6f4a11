<?php

// Only GET requests are allowed
if ($_SERVER["REQUEST_METHOD"] !== "GET") {
    http_response_code(405);
    exit("Method not allowed.");
}

// Show an HTML error page
function showError(string $message): void
{
    http_response_code(404);
    header("Content-Type: text/html; charset=UTF-8");

    echo "<h2>Error</h2>";
    echo "<p>" . htmlspecialchars($message) . "</p>";

    echo '<a href="../../client/html/viewOrders.html">View Orders</a><br>';
    echo '<a href="../../client/html/menu.html">Operations Menu</a><br>';
    echo '<a href="../../client/html/index.html">Home</a>';

    exit;
}

// Read the orders file
$filePath = "../../../orders/orders.json";

if (!file_exists($filePath) || !is_readable($filePath)) {
    showError("The orders file could not be opened.");
}

$content = file_get_contents($filePath);
$orders = json_decode($content, true);

if (!is_array($orders)) {
    showError("The orders file contains invalid data.");
}

// Escape values before displaying them in HTML
function escapeHtml($value): string
{
    return htmlspecialchars((string) $value, ENT_QUOTES, "UTF-8");
}

// Display one order as an HTML table
function showOrder(array $order): void
{
    echo '<table border="1">';
    echo '<tr><th>Field</th><th>Information</th></tr>';

    echo '<tr><td>Order ID</td><td>' . escapeHtml($order["orderId"] ?? "") . '</td></tr>';
    echo '<tr><td>Customer Name</td><td>' . escapeHtml($order["customerName"] ?? "") . '</td></tr>';
    echo '<tr><td>Address</td><td>' . escapeHtml($order["customerAddress"] ?? "") . '</td></tr>';
    echo '<tr><td>Email</td><td>' . escapeHtml($order["customerEmail"] ?? "") . '</td></tr>';
    echo '<tr><td>Phone</td><td>' . escapeHtml($order["customerPhone"] ?? "") . '</td></tr>';

    // Display the products
    echo '<tr><td>Products</td><td>';

    if (isset($order["products"]) && is_array($order["products"])) {
        foreach ($order["products"] as $product) {
            echo '<p>';

            foreach ($product as $key => $value) {
                echo escapeHtml($key) . ': ' . escapeHtml($value) . '<br>';
            }

            echo '</p>';
        }
    }

    echo '</td></tr>';

    echo '<tr><td>Subtotal</td><td>€' . escapeHtml($order["subtotal"] ?? 0) . '</td></tr>';
    echo '<tr><td>VAT</td><td>€' . escapeHtml($order["vat"] ?? 0) . '</td></tr>';
    echo '<tr><td>Total</td><td>€' . escapeHtml($order["total"] ?? 0) . '</td></tr>';

    echo '</table>';
}

// Check if a specific order was requested
if (isset($_GET["orderId"])) {

    $orderId = trim($_GET["orderId"]);
    $found = false;

    foreach ($orders as $order) {
        if (($order["orderId"] ?? "") === $orderId) {
            $found = true;
            break;
        }
    }

    if (!$found) {
        showError("The requested order was not found.");
    }

    http_response_code(200);
    header("Content-Type: text/html; charset=UTF-8");

    echo "<h2>Order Details</h2>";
    showOrder($order);

} else {

    // Display all stored orders
    http_response_code(200);
    header("Content-Type: text/html; charset=UTF-8");

    echo "<h2>All Orders</h2>";

    if (empty($orders)) {
        echo "<p>No orders found.</p>";
    } else {
        foreach ($orders as $order) {
            showOrder($order);
            echo "<br>";
        }
    }
}
