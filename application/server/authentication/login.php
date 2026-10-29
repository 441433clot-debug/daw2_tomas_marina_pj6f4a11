<?php

require_once "../utilities/jsonResponse.php";
require_once "../utilities/readJson.php";
if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    sendJsonResponse(false, "Invalid request method.");
}
sendJsonResponse(true, "Server connection established.");