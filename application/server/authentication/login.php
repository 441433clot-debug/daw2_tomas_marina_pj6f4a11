<?php

require_once "../utilities/jsonResponse.php";
require_once "../utilities/readJson.php";

// Only POST requests are allowed
if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    sendJsonResponse(false, "Invalid request method.", [], 405);
}

// Read login information
$input = json_decode(file_get_contents("php://input"), true);

if (!is_array($input)) {
    sendJsonResponse(false, "Invalid request.", [], 400);
}

$username = trim($input["username"] ?? "");
$password = $input["password"] ?? "";

// Check required fields
if ($username === "" || $password === "") {
    sendJsonResponse(false, "Username and password are required.", [], 400);
}

// Read registered users
$users = readJsonFile("../../../users/users.json");

// Find the user and verify the password
foreach ($users as $user) {

    if (($user["user"] ?? "") === $username) {

        if (password_verify($password, $user["password"])) {
            sendJsonResponse(true, "Login successful.", [], 200);
        }

        sendJsonResponse(false, "Incorrect password.", [], 401);
    }
}
// User does not exist
sendJsonResponse(false, "User not found.", [], 401);