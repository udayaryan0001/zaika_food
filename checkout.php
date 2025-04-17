<?php
require_once 'config.php';

// Redirect to login if not logged in
if (!isLoggedIn()) {
    redirect('login.php');
}

// Redirect to cart if cart is empty
if (!isset($_SESSION['cart']) || empty($_SESSION['cart'])) {
    redirect('cart.php');
}

// Calculate total amount
$total_amount = 0;
foreach ($_SESSION['cart'] as $item) {
    $total_amount += $item['price'] * $item['quantity'];
}

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $shipping_address = trim($_POST['shipping_address']);
    $phone_number = trim($_POST['phone_number']);
    $payment_method = $_POST['payment_method'];
    $user_id = $_SESSION['user_id'];
    
    // Validate inputs
    $errors = [];
    if (empty($shipping_address)) {
        $errors[] = "Shipping address is required";
    }
    if (empty($phone_number)) {
        $errors[] = "Phone number is required";
    }
    if (!in_array($payment_method, ['cash', 'card', 'upi'])) {
        $errors[] = "Invalid payment method";
    }
    
    if (empty($errors)) {
        // Start transaction
        mysqli_begin_transaction($conn);
        try {
            // Create order
            $stmt = mysqli_prepare($conn, "INSERT INTO orders (user_id, total_amount, shipping_address, phone_number, payment_method) VALUES (?, ?, ?, ?, ?)");
            mysqli_stmt_bind_param($stmt, "idsss", $user_id, $total_amount, $shipping_address, $phone_number, $payment_method);
            mysqli_stmt_execute($stmt);
            $order_id = mysqli_insert_id($conn);
            
            // Add order items
            $stmt = mysqli_prepare($conn, "INSERT INTO order_items (order_id, item_name, quantity, price) VALUES (?, ?, ?, ?)");
            foreach ($_SESSION['cart'] as $item) {
                mysqli_stmt_bind_param($stmt, "isid", $order_id, $item['name'], $item['quantity'], $item['price']);
                mysqli_stmt_execute($stmt);
            }
            
            // Commit transaction
            mysqli_commit($conn);
            
            // Clear cart
            unset($_SESSION['cart']);
            
            // Redirect to order confirmation
            redirect("order_confirmation.php?order_id=" . $order_id);
        } catch (Exception $e) {
            mysqli_rollback($conn);
            $errors[] = "Error processing your order. Please try again.";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Checkout - Zaika-e-Handi</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body class="bg-gray-50">
    <?php include 'includes/header.php'; ?>

    <div class="max-w-7xl mx-auto px-4 py-8">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
            <!-- Order Summary -->
            <div class="bg-white p-6 rounded-lg shadow-md">
                <h2 class="text-2xl font-bold mb-4">Order Summary</h2>
                <div class="space-y-4">
                    <?php foreach ($_SESSION['cart'] as $item): ?>
                        <div class="flex justify-between items-center">
                            <div>
                                <h3 class="font-semibold"><?= htmlspecialchars($item['name']) ?></h3>
                                <p class="text-gray-600">Quantity: <?= $item['quantity'] ?></p>
                            </div>
                            <p class="font-semibold">₹<?= number_format($item['price'] * $item['quantity'], 2) ?></p>
                        </div>
                    <?php endforeach; ?>
                    <div class="border-t pt-4 mt-4">
                        <div class="flex justify-between items-center font-bold">
                            <p>Total Amount:</p>
                            <p>₹<?= number_format($total_amount, 2) ?></p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Checkout Form -->
            <div class="bg-white p-6 rounded-lg shadow-md">
                <h2 class="text-2xl font-bold mb-4">Shipping & Payment</h2>
                
                <?php if (!empty($errors)): ?>
                    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
                        <ul class="list-disc list-inside">
                            <?php foreach ($errors as $error): ?>
                                <li><?= htmlspecialchars($error) ?></li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                <?php endif; ?>

                <form method="POST" class="space-y-6">
                    <div>
                        <label for="shipping_address" class="block text-gray-700 font-semibold mb-2">Shipping Address</label>
                        <textarea id="shipping_address" name="shipping_address" rows="3" 
                                class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-transparent"
                                required><?= isset($_POST['shipping_address']) ? htmlspecialchars($_POST['shipping_address']) : '' ?></textarea>
                    </div>

                    <div>
                        <label for="phone_number" class="block text-gray-700 font-semibold mb-2">Phone Number</label>
                        <input type="tel" id="phone_number" name="phone_number" 
                               class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-transparent"
                               value="<?= isset($_POST['phone_number']) ? htmlspecialchars($_POST['phone_number']) : '' ?>"
                               required>
                    </div>

                    <div>
                        <label class="block text-gray-700 font-semibold mb-2">Payment Method</label>
                        <div class="space-y-2">
                            <label class="flex items-center">
                                <input type="radio" name="payment_method" value="cash" 
                                       class="text-orange-600 focus:ring-orange-500"
                                       <?= (!isset($_POST['payment_method']) || $_POST['payment_method'] === 'cash') ? 'checked' : '' ?>>
                                <span class="ml-2">Cash on Delivery</span>
                            </label>
                            <label class="flex items-center">
                                <input type="radio" name="payment_method" value="card" 
                                       class="text-orange-600 focus:ring-orange-500"
                                       <?= (isset($_POST['payment_method']) && $_POST['payment_method'] === 'card') ? 'checked' : '' ?>>
                                <span class="ml-2">Credit/Debit Card</span>
                            </label>
                            <label class="flex items-center">
                                <input type="radio" name="payment_method" value="upi" 
                                       class="text-orange-600 focus:ring-orange-500"
                                       <?= (isset($_POST['payment_method']) && $_POST['payment_method'] === 'upi') ? 'checked' : '' ?>>
                                <span class="ml-2">UPI</span>
                            </label>
                        </div>
                    </div>

                    <button type="submit" class="w-full bg-orange-600 text-white py-3 rounded-lg font-semibold hover:bg-orange-700 transition-colors">
                        Place Order
                    </button>
                </form>
            </div>
        </div>
    </div>

    <?php include 'includes/footer.php'; ?>
</body>
</html> 