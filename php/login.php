<?php

include "config.php";
include "redis.php";

$email = trim($_POST['email']);
$password = trim($_POST['password']);

if (empty($email) || empty($password)) {
    echo json_encode([
        "status" => "error",
        "message" => "All fields are required"
    ]);
    exit;
}

$stmt = $conn->prepare(
    "SELECT id, username, password FROM users WHERE email = ?"
);

$stmt->bind_param("s", $email);
$stmt->execute();

$result = $stmt->get_result();

if ($result->num_rows === 0) {
    echo json_encode([
        "status" => "error",
        "message" => "Invalid email or password"
    ]);
    exit;
}

$user = $result->fetch_assoc();

if (!password_verify($password, $user['password'])) {
    echo json_encode([
        "status" => "error",
        "message" => "Invalid email or password"
    ]);
    exit;
}

$sessionToken = bin2hex(random_bytes(32));

$redis->setex(
    "session_" . $sessionToken,
    3600,
    json_encode([
        "user_id" => $user['id'],
        "username" => $user['username']
    ])
);

echo json_encode([
    "status" => "success",
    "message" => "Login successful",
    "user_id" => $user['id'],
    "username" => $user['username'],
    "session_token" => $sessionToken
]);

$stmt->close();
$conn->close();

?>