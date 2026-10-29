<?php
require_once "../utilities/jsonResponse.php";
require_once "../utilities/readJson.php";

if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    sendJsonResponse(false, "Invalid request method.");
}

$input = json_decode(file_get_contents("php://input"), true);
$username = trim($input["username"] ?? "");
$password = trim($input["password"] ?? "");

if ($username === "" || $password === "") {
    sendJsonResponse(false, "Username and password are required.");
}

$users = readJsonFile("../../../users/users.json");

foreach ($users as $user) {
    if ($user["user"] === $username) {
        if (password_verify($password, $user["password"])) {
            sendJsonResponse(true, "Login successful.");
        }
        sendJsonResponse(false, "Incorrect password.");
    }
}
sendJsonResponse(false, "User not found.");