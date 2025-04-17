<?php
require_once '../config.php';

header('Content-Type: application/json');

// Check if user is logged in
if (!isLoggedIn()) {
    echo json_encode([
        'success' => false,
        'message' => 'Please login to continue'
    ]);
    exit;
}

// Get POST data
$data = json_decode(file_get_contents('php://input'), true);
if (!isset($data['order_id'])) {
    echo json_encode([
        'success' => false,
        'message' => 'Order ID is required'
    ]);
    exit;
}

$order_id = (int)$data['order_id'];
$user_id = $_SESSION['user_id'];

// Check if order exists and belongs to user
$stmt = mysqli_prepare($conn, "SELECT status FROM orders WHERE id = ? AND user_id = ?");
mysqli_stmt_bind_param($stmt, "ii", $order_id, $user_id);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
$order = mysqli_fetch_assoc($result);

if (!$order) {
    echo json_encode([
        'success' => false,
        'message' => 'Order not found'
    ]);
    exit;
}

if ($order['status'] !== 'pending') {
    echo json_encode([
        'success' => false,
        'message' => 'Only pending orders can be cancelled'
    ]);
    exit;
}

// Update order status to cancelled
$stmt = mysqli_prepare($conn, "UPDATE orders SET status = 'cancelled' WHERE id = ? AND user_id = ?");
mysqli_stmt_bind_param($stmt, "ii", $order_id, $user_id);

if (mysqli_stmt_execute($stmt)) {
    echo json_encode([
        'success' => true,
        'message' => 'Order cancelled successfully'
    ]);
} else {
    echo json_encode([
        'success' => false,
        'message' => 'Error cancelling order'
    ]);
}
?> 