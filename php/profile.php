<?php

include "config.php";
include "redis.php";

/*
    MongoDB connection (Profile storage)
*/
require __DIR__ . '/../vendor/autoload.php';

use MongoDB\Client;
use MongoDB\BSON\UTCDateTime;

$mongoClient = new Client("mongodb://localhost:27017");
$collection = $mongoClient->guvi_project_v2->profiles;

/*
    Get data from AJAX
*/
$user_id = $_POST['user_id'];
$session_token = $_POST['session_token'];
$dob = $_POST['dob'];
$contact = $_POST['contact'];
$sessionData = $redis->get("session_" . $session_token);

if (!$sessionData) {
    echo json_encode([
        "status" => "error",
        "message" => "Session expired. Please login again."
    ]);
    exit;
}

$sessionUser = json_decode($sessionData, true);

if ($sessionUser['user_id'] != $user_id) {
    echo json_encode([
        "status" => "error",
        "message" => "Unauthorized access"
    ]);
    exit;
}
/*
    Basic validation
*/
if (empty($user_id) || empty($dob) || empty($contact)) {
    echo json_encode([
        "status" => "error",
        "message" => "All fields are required"
    ]);
    exit;
}

/*
    Age calculation
*/
$birthDate = new DateTime($dob);
$today = new DateTime();
$age = $today->diff($birthDate)->y;

/*
    Insert / Update profile in MongoDB
*/
$result = $collection->updateOne(
    ["user_id" => (int)$user_id],
    [
        '$set' => [
            "user_id" => (int)$user_id,
            "dob" => $dob,
            "contact" => $contact,
            "age" => $age,
            "updated_at" => new UTCDateTime()
        ]
    ],
    ["upsert" => true]
);

echo json_encode([
    "status" => "success",
    "message" => "Profile updated successfully"
]);

?>