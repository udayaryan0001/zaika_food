<?php
require_once 'config.php';

// Redirect if not logged in
if (!isLoggedIn()) {
    redirect('login.php');
}

// Check if order ID is provided
if (!isset($_GET['order_id'])) {
    redirect('index.php');
}

$order_id = (int)$_GET['order_id'];
$user_id = $_SESSION['user_id'];

// Fetch order details
$stmt = mysqli_prepare($conn, "
    SELECT o.*, u.name as customer_name, u.email 
    FROM orders o 
    JOIN users u ON o.user_id = u.id 
    WHERE o.id = ? AND o.user_id = ?
");
mysqli_stmt_bind_param($stmt, "ii", $order_id, $user_id);
mysqli_stmt_execute($stmt);
$order = mysqli_fetch_assoc(mysqli_stmt_get_result($stmt));

if (!$order) {
    redirect('index.php');
}

// Fetch order items
$stmt = mysqli_prepare($conn, "SELECT * FROM order_items WHERE order_id = ?");
mysqli_stmt_bind_param($stmt, "i", $order_id);
mysqli_stmt_execute($stmt);
$items = mysqli_stmt_get_result($stmt);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order Confirmation - Zaika-e-Handi</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body class="bg-gray-50">
    <?php include 'includes/header.php'; ?>

    <div class="max-w-3xl mx-auto px-4 py-8">
        <div class="bg-white rounded-lg shadow-md p-6">
            <!-- Success Message -->
            <div class="text-center mb-8">
                <div class="inline-flex items-center justify-center w-16 h-16 bg-green-100 rounded-full mb-4">
                    <i class="fas fa-check text-3xl text-green-600"></i>
                </div>
                <h1 class="text-3xl font-bold text-gray-900 mb-2">Order Confirmed!</h1>
                <p class="text-gray-600">Thank you for your order. We'll start preparing it right away!</p>
            </div>

            <!-- Order Details -->
            <div class="border-t border-gray-200 pt-6">
                <h2 class="text-2xl font-bold mb-4">Order Details</h2>
                <div class="grid grid-cols-2 gap-4 mb-6">
                    <div>
                        <p class="text-gray-600">Order Number:</p>
                        <p class="font-semibold">#<?= str_pad($order['id'], 6, '0', STR_PAD_LEFT) ?></p>
                    </div>
                    <div>
                        <p class="text-gray-600">Order Date:</p>
                        <p class="font-semibold"><?= date('F j, Y g:i A', strtotime($order['created_at'])) ?></p>
                    </div>
                    <div>
                        <p class="text-gray-600">Payment Method:</p>
                        <p class="font-semibold capitalize"><?= $order['payment_method'] ?></p>
                    </div>
                    <div>
                        <p class="text-gray-600">Order Status:</p>
                        <p class="font-semibold capitalize"><?= $order['status'] ?></p>
                    </div>
                </div>

                <!-- Shipping Details -->
                <div class="mb-6">
                    <h3 class="text-lg font-semibold mb-2">Shipping Details</h3>
                    <div class="bg-gray-50 rounded p-4">
                        <p class="font-semibold"><?= htmlspecialchars($order['customer_name']) ?></p>
                        <p class="text-gray-600"><?= nl2br(htmlspecialchars($order['shipping_address'])) ?></p>
                        <p class="text-gray-600">Phone: <?= htmlspecialchars($order['phone_number']) ?></p>
                    </div>
                </div>

                <!-- Order Items -->
                <div class="mb-6">
                    <h3 class="text-lg font-semibold mb-2">Order Items</h3>
                    <div class="border rounded-lg overflow-hidden">
                        <table class="w-full">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-4 py-2 text-left text-gray-600">Item</th>
                                    <th class="px-4 py-2 text-center text-gray-600">Quantity</th>
                                    <th class="px-4 py-2 text-right text-gray-600">Price</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200">
                                <?php while ($item = mysqli_fetch_assoc($items)): ?>
                                    <tr>
                                        <td class="px-4 py-3"><?= htmlspecialchars($item['item_name']) ?></td>
                                        <td class="px-4 py-3 text-center"><?= $item['quantity'] ?></td>
                                        <td class="px-4 py-3 text-right">₹<?= number_format($item['price'] * $item['quantity'], 2) ?></td>
                                    </tr>
                                <?php endwhile; ?>
                                <tr class="bg-gray-50 font-semibold">
                                    <td class="px-4 py-3" colspan="2">Total Amount</td>
                                    <td class="px-4 py-3 text-right">₹<?= number_format($order['total_amount'], 2) ?></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- Actions -->
                <div class="flex justify-center space-x-4">
                    <a href="orders.php" class="inline-flex items-center px-6 py-3 bg-orange-600 text-white rounded-lg hover:bg-orange-700 transition-colors">
                        <i class="fas fa-list-ul mr-2"></i>
                        View All Orders
                    </a>
                    <a href="menu.php" class="inline-flex items-center px-6 py-3 bg-gray-600 text-white rounded-lg hover:bg-gray-700 transition-colors">
                        <i class="fas fa-utensils mr-2"></i>
                        Continue Shopping
                    </a>
                </div>
            </div>
        </div>
    </div>

    <?php include 'includes/footer.php'; ?>
</body>
</html> 