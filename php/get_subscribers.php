<?php
require_once '../config.php';

header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET');

$sql = "SELECT email FROM subscribers ORDER BY created_at DESC";
$result = $conn->query($sql);

$subscribers = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $subscribers[] = $row['email'];
    }
}

echo json_encode([
    'success' => true,
    'subscribers' => $subscribers
]);

$conn->close();
?>