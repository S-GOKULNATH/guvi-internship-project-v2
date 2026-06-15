<?php

include "redis.php";

$session_token = $_POST['session_token'] ?? '';

if (!empty($session_token)) {
    $redis->del("session_" . $session_token);
}

echo json_encode([
    "status" => "success",
    "message" => "Logged out successfully"
]);

?>