<?php
require_once 'config.php';

// Initialize cart if it doesn't exist
if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}

// Handle cart actions
if (isset($_POST['action'])) {
    $action = $_POST['action'];
    $item_id = isset($_POST['item_id']) ? $_POST['item_id'] : null;
    
    switch ($action) {
        case 'remove':
            if (isset($_SESSION['cart'][$item_id])) {
                unset($_SESSION['cart'][$item_id]);
            }
            break;
            
        case 'update':
            $quantity = isset($_POST['quantity']) ? (int)$_POST['quantity'] : 1;
            if ($quantity > 0 && isset($_SESSION['cart'][$item_id])) {
                $_SESSION['cart'][$item_id]['quantity'] = $quantity;
            }
            break;
    }
    
    // If it's an AJAX request, return JSON response
    if (!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
        echo json_encode(['success' => true]);
        exit;
    }
    
    // Redirect back to cart page
    header('Location: cart.php');
    exit;
}

// Calculate total
$total = 0;
foreach ($_SESSION['cart'] as $item) {
    $total += $item['price'] * $item['quantity'];
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Shopping Cart - Zaika-e-Handi</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body class="bg-gray-50">
    <?php include 'includes/header.php'; ?>

    <div class="max-w-7xl mx-auto px-4 py-8">
        <h1 class="text-3xl font-bold mb-8">Shopping Cart</h1>

        <?php if (!empty($_SESSION['cart'])): ?>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <!-- Cart Items -->
                <div class="md:col-span-2">
                    <div class="bg-white rounded-lg shadow-md overflow-hidden">
                        <div class="divide-y divide-gray-200">
                            <?php foreach ($_SESSION['cart'] as $id => $item): ?>
                                <div class="p-6 flex items-center">
                                    <div class="flex-1">
                                        <h3 class="text-lg font-semibold"><?= htmlspecialchars($item['name']) ?></h3>
                                        <p class="text-gray-600">₹<?= number_format($item['price'], 2) ?></p>
                                    </div>
                                    <div class="flex items-center space-x-4">
                                        <form method="POST" class="flex items-center space-x-2">
                                            <input type="hidden" name="action" value="update">
                                            <input type="hidden" name="item_id" value="<?= $id ?>">
                                            <input type="number" name="quantity" value="<?= $item['quantity'] ?>" 
                                                   min="1" max="99" 
                                                   class="w-16 px-2 py-1 border rounded-lg"
                                                   onchange="this.form.submit()">
                                        </form>
                                        <form method="POST" class="flex items-center">
                                            <input type="hidden" name="action" value="remove">
                                            <input type="hidden" name="item_id" value="<?= $id ?>">
                                            <button type="submit" class="text-red-600 hover:text-red-700">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                </div>

                <!-- Order Summary -->
                <div class="bg-white rounded-lg shadow-md p-6 h-fit">
                    <h2 class="text-xl font-semibold mb-4">Order Summary</h2>
                    <div class="space-y-4">
                        <div class="flex justify-between">
                            <span>Subtotal</span>
                            <span>₹<?= number_format($total, 2) ?></span>
                        </div>
                        <div class="flex justify-between font-semibold text-lg border-t pt-4">
                            <span>Total</span>
                            <span>₹<?= number_format($total, 2) ?></span>
                        </div>
                        <a href="checkout.php" 
                           class="block w-full bg-orange-600 text-white text-center py-3 rounded-lg font-semibold hover:bg-orange-700 transition-colors">
                            Proceed to Checkout
                        </a>
                        <a href="menu.php" 
                           class="block w-full text-center text-orange-600 hover:text-orange-700">
                            Continue Shopping
                        </a>
                    </div>
                </div>
            </div>
        <?php else: ?>
            <div class="text-center py-12">
                <div class="inline-flex items-center justify-center w-16 h-16 bg-gray-100 rounded-full mb-4">
                    <i class="fas fa-shopping-cart text-3xl text-gray-400"></i>
                </div>
                <h2 class="text-2xl font-semibold text-gray-900 mb-2">Your cart is empty</h2>
                <p class="text-gray-600 mb-6">Looks like you haven't added any items to your cart yet.</p>
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
    // Add any JavaScript for cart interactions here
    </script>
</body>
</html> 