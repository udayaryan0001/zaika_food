<?php
require_once 'config.php';

// Redirect if not logged in
if (!isLoggedIn()) {
    redirect('login.php');
}

$user_id = $_SESSION['user_id'];

// Fetch all orders for the user
$stmt = mysqli_prepare($conn, "
    SELECT o.*, 
           COUNT(oi.id) as total_items,
           u.name as customer_name 
    FROM orders o 
    JOIN users u ON o.user_id = u.id 
    LEFT JOIN order_items oi ON o.id = oi.order_id 
    WHERE o.user_id = ? 
    GROUP BY o.id 
    ORDER BY o.created_at DESC
");
mysqli_stmt_bind_param($stmt, "i", $user_id);
mysqli_stmt_execute($stmt);
$orders = mysqli_stmt_get_result($stmt);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Orders - Zaika-e-Handi</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body class="bg-gray-50">
    <?php include 'includes/header.php'; ?>

    <div class="max-w-7xl mx-auto px-4 py-8">
        <h1 class="text-3xl font-bold mb-8">My Orders</h1>

        <?php if (mysqli_num_rows($orders) > 0): ?>
            <div class="grid gap-6">
                <?php while ($order = mysqli_fetch_assoc($orders)): ?>
                    <div class="bg-white rounded-lg shadow-md overflow-hidden">
                        <div class="p-6">
                            <div class="flex items-center justify-between mb-4">
                                <div>
                                    <h2 class="text-xl font-semibold">
                                        Order #<?= str_pad($order['id'], 6, '0', STR_PAD_LEFT) ?>
                                    </h2>
                                    <p class="text-gray-600">
                                        <?= date('F j, Y g:i A', strtotime($order['created_at'])) ?>
                                    </p>
                                </div>
                                <div class="text-right">
                                    <p class="text-lg font-semibold">₹<?= number_format($order['total_amount'], 2) ?></p>
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-sm
                                        <?php
                                        switch ($order['status']) {
                                            case 'pending':
                                                echo 'bg-yellow-100 text-yellow-800';
                                                break;
                                            case 'processing':
                                                echo 'bg-blue-100 text-blue-800';
                                                break;
                                            case 'completed':
                                                echo 'bg-green-100 text-green-800';
                                                break;
                                            case 'cancelled':
                                                echo 'bg-red-100 text-red-800';
                                                break;
                                        }
                                        ?>">
                                        <i class="fas fa-circle text-xs mr-1"></i>
                                        <?= ucfirst($order['status']) ?>
                                    </span>
                                </div>
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-4">
                                <div>
                                    <p class="text-gray-600">Items</p>
                                    <p class="font-semibold"><?= $order['total_items'] ?> items</p>
                                </div>
                                <div>
                                    <p class="text-gray-600">Payment Method</p>
                                    <p class="font-semibold capitalize"><?= $order['payment_method'] ?></p>
                                </div>
                                <div>
                                    <p class="text-gray-600">Shipping Address</p>
                                    <p class="font-semibold truncate"><?= htmlspecialchars($order['shipping_address']) ?></p>
                                </div>
                            </div>

                            <div class="flex justify-end space-x-4">
                                <a href="order_confirmation.php?order_id=<?= $order['id'] ?>" 
                                   class="inline-flex items-center text-orange-600 hover:text-orange-700">
                                    <i class="fas fa-eye mr-1"></i>
                                    View Details
                                </a>
                                <?php if ($order['status'] === 'pending'): ?>
                                    <button onclick="cancelOrder(<?= $order['id'] ?>)" 
                                            class="inline-flex items-center text-red-600 hover:text-red-700">
                                        <i class="fas fa-times mr-1"></i>
                                        Cancel Order
                                    </button>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                <?php endwhile; ?>
            </div>
        <?php else: ?>
            <div class="text-center py-12">
                <div class="inline-flex items-center justify-center w-16 h-16 bg-gray-100 rounded-full mb-4">
                    <i class="fas fa-shopping-bag text-3xl text-gray-400"></i>
                </div>
                <h2 class="text-2xl font-semibold text-gray-900 mb-2">No Orders Yet</h2>
                <p class="text-gray-600 mb-6">Looks like you haven't placed any orders yet.</p>
                <a href="menu.php" 
                   class="inline-flex items-center px-6 py-3 bg-orange-600 text-white rounded-lg hover:bg-orange-700 transition-colors">
                    <i class="fas fa-utensils mr-2"></i>
                    Browse Menu
                </a>
            </div>
        <?php endif; ?>
    </div>

    <?php include 'includes/footer.php'; ?>

    <script>
    function cancelOrder(orderId) {
        if (confirm('Are you sure you want to cancel this order?')) {
            fetch('php/cancel_order.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify({ order_id: orderId })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    location.reload();
                } else {
                    alert(data.message || 'Error cancelling order');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Error cancelling order');
            });
        }
    }
    </script>
</body>
</html> 