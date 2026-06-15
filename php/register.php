<?php

include "config.php";

$username = trim($_POST['username']);
$email = trim($_POST['email']);
$password = trim($_POST['password']);

if (empty($username) || empty($email) || empty($password)) {
    echo json_encode([
        "status" => "error",
        "message" => "All fields are required"
    ]);
    exit;
}

if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    echo json_encode([
        "status" => "error",
        "message" => "Invalid email format"
    ]);
    exit;
}

$check = $conn->prepare("SELECT id FROM users WHERE email = ?");
$check->bind_param("s", $email);
$check->execute();
$result = $check->get_result();

if ($result->num_rows > 0) {
    echo json_encode([
        "status" => "error",
        "message" => "Email already exists"
    ]);
    exit;
}

$hashedPassword = password_hash($password, PASSWORD_DEFAULT);

$stmt = $conn->prepare(
    "INSERT INTO users (username, email, password) VALUES (?, ?, ?)"
);

$stmt->bind_param(
    "sss",
    $username,
    $email,
    $hashedPassword
);

if ($stmt->execute()) {

    echo json_encode([
        "status" => "success",
        "message" => "Registration successful"
    ]);

} else {

    echo json_encode([
        "status" => "error",
        "message" => "Registration failed"
    ]);
}

$stmt->close();
$conn->close();

?>