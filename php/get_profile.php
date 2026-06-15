<?php

require '../vendor/autoload.php';
include "redis.php";

use MongoDB\Client;

$session_token = $_GET['session_token'] ?? '';
$user_id = $_GET['user_id'] ?? '';

$sessionData = $redis->get("session_" . $session_token);

if (!$sessionData) {
    echo json_encode([
        "status" => "error",
        "message" => "Session expired"
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

$mongoClient = new Client("mongodb://localhost:27017");

$collection = $mongoClient->guvi_project_v2->profiles;

$profile = $collection->findOne([
    "user_id" => (int)$user_id
]);

if ($profile) {

    echo json_encode([
        "status" => "success",
        "data" => [
            "dob" => $profile['dob'],
            "contact" => $profile['contact'],
            "age" => $profile['age']
        ]
    ]);

} else {

    echo json_encode([
        "status" => "error",
        "message" => "Profile not found"
    ]);
}