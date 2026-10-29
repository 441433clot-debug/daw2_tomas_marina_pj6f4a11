<?php
require_once "../utilities/jsonResponse.php";
if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    sendJsonResponse(false, "Invalid request method.");
}
sendJsonResponse(true, "Create Order endpoint ready.");