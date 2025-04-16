<?php
require_once '../config.php';

header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST');
header('Access-Control-Allow-Headers: Content-Type');

// Get the raw POST data
$json = file_get_contents('php://input');
$data = json_decode($json, true);

if (!isset($data['email']) || empty($data['email'])) {
    echo json_encode([
        'success' => false,
        'message' => 'Email is required'
    ]);
    exit();
}

$email = filter_var($data['email'], FILTER_VALIDATE_EMAIL);
if (!$email) {
    echo json_encode([
        'success' => false,
        'message' => 'Invalid email format'
    ]);
    exit();
}

// Prepare and execute the query
$stmt = $conn->prepare("INSERT INTO subscribers (email) VALUES (?) ON DUPLICATE KEY UPDATE created_at = CURRENT_TIMESTAMP");
$stmt->bind_param("s", $email);

if ($stmt->execute()) {
    if ($stmt->affected_rows > 0) {
        echo json_encode([
            'success' => true,
            'message' => 'Thank you for subscribing!'
        ]);
    } else {
        echo json_encode([
            'success' => false,
            'message' => 'You are already subscribed!'
        ]);
    }
} else {
    echo json_encode([
        'success' => false,
        'message' => 'Error subscribing. Please try again later.'
    ]);
}

$stmt->close();
$conn->close();
?> 