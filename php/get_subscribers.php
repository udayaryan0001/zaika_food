<?php
require_once '../config.php';

// Check if user is admin
if (!isAdmin()) {
    echo json_encode([
        'success' => false,
        'message' => 'Unauthorized access',
        'subscribers' => []
    ]);
    exit;
}

// Fetch subscribers
$result = mysqli_query($conn, "SELECT email FROM subscribers ORDER BY subscribed_at DESC");
$subscribers = [];

while ($row = mysqli_fetch_assoc($result)) {
    $subscribers[] = $row['email'];
}

echo json_encode([
    'success' => true,
    'message' => '',
    'subscribers' => $subscribers
]);
?>