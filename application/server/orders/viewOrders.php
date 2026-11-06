<?php
// Only GET requests are allowed
if ($_SERVER["REQUEST_METHOD"] !== "GET") {
    http_response_code(405);
    exit("Method not allowed.");
}

/*
|--------------------------------------------------------------------------
| Show an HTML error page
|--------------------------------------------------------------------------
| This function is used when the orders file cannot be opened
| or when the requested order does not exist.
*/
function showError(string $message): void
{
    http_response_code(404);
    header("Content-Type: text/html; charset=UTF-8");

    echo "<h2>Error</h2>";
    echo "<p>" . htmlspecialchars($message) . "</p>";

    echo "<br>";

    echo '<button onclick="location.href=\'../../client/html/viewOrders.html\'">
            View Orders
          </button>';

    echo ' ';

    echo '<button onclick="location.href=\'../../client/html/menu.html\'">
            Operations Menu
          </button>';

    echo ' ';

    echo '<button onclick="location.href=\'../../client/html/index.html\'">
            Home
          </button>';

    exit;
}

/*
|--------------------------------------------------------------------------
| Read the JSON file
|--------------------------------------------------------------------------
*/
$filePath = "../../../orders/orders.json";

if (!file_exists($filePath) || !is_readable($filePath)) {
    showError("The orders file could not be opened.");
}

$content = file_get_contents($filePath);
$orders = json_decode($content, true);

if (!is_array($orders)) {
    showError("The orders file contains invalid data.");
}

/*
|--------------------------------------------------------------------------
| Escape HTML special characters
|--------------------------------------------------------------------------
| Prevents HTML injection when displaying user data.
*/
function escapeHtml($value): string
{
    return htmlspecialchars((string)$value, ENT_QUOTES, "UTF-8");
}

/*
|--------------------------------------------------------------------------
| Display one order
|--------------------------------------------------------------------------
| Shows all the information of one order inside a table.
*/
function showOrder(array $order): void
{
    echo '<table class="ordersTable">';

    echo '<tr>';
    echo '<th>Field</th>';
    echo '<th>Information</th>';
    echo '</tr>';

    echo '<tr><td>Order ID</td><td>' . escapeHtml($order["orderId"] ?? "") . '</td></tr>';
    echo '<tr><td>Customer Name</td><td>' . escapeHtml($order["customerName"] ?? "") . '</td></tr>';
    echo '<tr><td>Address</td><td>' . escapeHtml($order["customerAddress"] ?? "") . '</td></tr>';
    echo '<tr><td>Email</td><td>' . escapeHtml($order["customerEmail"] ?? "") . '</td></tr>';
    echo '<tr><td>Phone</td><td>' . escapeHtml($order["customerPhone"] ?? "") . '</td></tr>';

    // Display all products
    echo '<tr>';
    echo '<td>Products</td>';
    echo '<td>';

    if (isset($order["products"]) && is_array($order["products"])) {

        foreach ($order["products"] as $product) {

            echo "<p>";

            foreach ($product as $key => $value) {
                echo "<strong>" .
                    escapeHtml(ucfirst($key)) .
                    ":</strong> " .
                    escapeHtml($value) .
                    "<br>";
            }

            echo "</p>";
        }
    }

    echo '</td>';
    echo '</tr>';

    echo '<tr><td>Subtotal</td><td>€' . escapeHtml($order["subtotal"] ?? 0) . '</td></tr>';
    echo '<tr><td>VAT (21%)</td><td>€' . escapeHtml($order["vat"] ?? 0) . '</td></tr>';
    echo '<tr><td><strong>Total</strong></td><td><strong>€' . escapeHtml($order["total"] ?? 0) . '</strong></td></tr>';

    echo "</table>";
}

/*
|--------------------------------------------------------------------------
| Show one order
|--------------------------------------------------------------------------
*/
if (isset($_GET["orderId"])) {

    $orderId = trim($_GET["orderId"]);

    $foundOrder = null;

    foreach ($orders as $order) {

        if (($order["orderId"] ?? "") === $orderId) {
            $foundOrder = $order;
            break;
        }
    }

    if ($foundOrder === null) {
        showError("The requested order was not found.");
    }

    http_response_code(200);
    header("Content-Type: text/html; charset=UTF-8");

    echo "<h2>Order Details</h2>";

    showOrder($foundOrder);

} else {

    /*
    |--------------------------------------------------------------------------
    | Show all stored orders
    |--------------------------------------------------------------------------
    */

    http_response_code(200);
    header("Content-Type: text/html; charset=UTF-8");

    echo "<h2>All Orders</h2>";

    if (empty($orders)) {

        echo "<p>No orders found.</p>";

    } else {

        foreach ($orders as $order) {

            showOrder($order);

            echo "<br><br>";
        }
    }
}