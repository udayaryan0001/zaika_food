<?php
require_once '../config.php';

header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST');
header('Access-Control-Allow-Headers: Content-Type');

// Get POST data
$data = json_decode(file_get_contents('php://input'), true);
$response = ['success' => false, 'message' => ''];

if (!isset($data['email']) || empty($data['email'])) {
    $response['message'] = 'Email is required';
    echo json_encode($response);
    exit;
}

$email = filter_var($data['email'], FILTER_VALIDATE_EMAIL);
if (!$email) {
    $response['message'] = 'Invalid email format';
    echo json_encode($response);
    exit;
}

// Check if email already exists
$stmt = mysqli_prepare($conn, "SELECT id FROM subscribers WHERE email = ?");
mysqli_stmt_bind_param($stmt, "s", $email);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);

if (mysqli_num_rows($result) > 0) {
    $response['message'] = 'You are already subscribed!';
    echo json_encode($response);
    exit;
}

// Insert new subscriber
$stmt = mysqli_prepare($conn, "INSERT INTO subscribers (email) VALUES (?)");
mysqli_stmt_bind_param($stmt, "s", $email);

if (mysqli_stmt_execute($stmt)) {
    $response['success'] = true;
    $response['message'] = 'Thank you for subscribing!';
} else {
    $response['message'] = 'Error occurred while subscribing. Please try again.';
}

echo json_encode($response);
?> 