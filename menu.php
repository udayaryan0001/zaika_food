<?php
require_once 'config.php';

// Handle add to cart action
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_to_cart'])) {
    $item_id = $_POST['item_id'];
    $name = $_POST['name'];
    $price = $_POST['price'];
    $quantity = isset($_POST['quantity']) ? (int)$_POST['quantity'] : 1;
    
    addToCart($item_id, $name, $price, $quantity);
    
    // Redirect to prevent form resubmission
    header('Location: menu.php?added=1');
    exit;
}

// Sample menu items (in a real application, these would come from a database)
$menu_items = [
    [
        'id' => 1,
        'name' => 'Butter Chicken',
        'description' => 'Tender chicken pieces in rich, creamy tomato gravy',
        'price' => 349.00,
        'category' => 'Main Course',
        'image' => 'images/butter-chicken.jpg'
    ],
    [
        'id' => 2,
        'name' => 'Paneer Tikka',
        'description' => 'Marinated and grilled cottage cheese with vegetables',
        'price' => 299.00,
        'category' => 'Starters',
        'image' => 'images/paneer-tikka.jpg'
    ],
    [
        'id' => 3,
        'name' => 'Special Biryani',
        'description' => 'Fragrant basmati rice cooked with tender meat and spices',
        'price' => 399.00,
        'category' => 'Main Course',
        'image' => 'images/biryani.jpg'
    ],
    // Add more menu items as needed
];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Menu - Zaika-e-Handi</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="https://unpkg.com/aos@next/dist/aos.css" />
    <style>
        .menu-section {
            scroll-margin-top: 80px;
        }
        .cart-item {
            transition: all 0.3s ease;
        }
        .cart-item:hover {
            background-color: #fff3e0;
        }
    </style>
</head>
<body class="bg-gray-50">
    <?php include 'includes/header.php'; ?>

    <!-- Success Message -->
    <?php if (isset($_GET['added'])): ?>
        <div class="fixed top-4 right-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded z-50" 
             id="success-message">
            <div class="flex items-center">
                <i class="fas fa-check-circle mr-2"></i>
                <span>Item added to cart successfully!</span>
            </div>
        </div>
        <script>
            setTimeout(() => {
                document.getElementById('success-message').style.display = 'none';
            }, 3000);
        </script>
    <?php endif; ?>

    <div class="max-w-7xl mx-auto px-4 py-8">
        <div class="flex justify-between items-center mb-8">
            <h1 class="text-3xl font-bold">Our Menu</h1>
            <a href="cart.php" class="inline-flex items-center bg-orange-600 text-white px-4 py-2 rounded-lg hover:bg-orange-700">
                <i class="fas fa-shopping-cart mr-2"></i>
                Cart (<?= getCartItemCount() ?>)
            </a>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            <?php foreach ($menu_items as $item): ?>
                <div class="bg-white rounded-lg shadow-md overflow-hidden">
                    <img src="<?= htmlspecialchars($item['image']) ?>" 
                         alt="<?= htmlspecialchars($item['name']) ?>" 
                         class="w-full h-48 object-cover">
                    <div class="p-6">
                        <h3 class="text-xl font-semibold mb-2"><?= htmlspecialchars($item['name']) ?></h3>
                        <p class="text-gray-600 mb-4"><?= htmlspecialchars($item['description']) ?></p>
                        <div class="flex items-center justify-between">
                            <span class="text-2xl font-bold text-orange-600">₹<?= number_format($item['price'], 2) ?></span>
                            <form method="POST" class="flex items-center space-x-2">
                                <input type="hidden" name="item_id" value="<?= $item['id'] ?>">
                                <input type="hidden" name="name" value="<?= htmlspecialchars($item['name']) ?>">
                                <input type="hidden" name="price" value="<?= $item['price'] ?>">
                                <input type="number" name="quantity" value="1" min="1" max="99"
                                       class="w-16 px-2 py-1 border rounded-lg">
                                <button type="submit" name="add_to_cart" 
                                        class="bg-orange-600 text-white px-4 py-2 rounded-lg hover:bg-orange-700">
                                    Add to Cart
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>

    <?php include 'includes/footer.php'; ?>

    <!-- Shopping Cart Sidebar -->
    <div id="cart-sidebar" class="fixed top-0 right-0 w-96 h-full bg-white shadow-lg transform translate-x-full transition-transform duration-300 z-50">
        <div class="p-6 h-full flex flex-col">
            <div class="flex justify-between items-center mb-6">
                <h2 class="text-2xl font-bold">Your Cart</h2>
                <button onclick="toggleCart()" class="text-gray-500 hover:text-gray-700">
                    <i class="fas fa-times text-2xl"></i>
                </button>
            </div>
            <div id="cart-items" class="flex-1 overflow-auto">
                <!-- Cart items will be added here dynamically -->
            </div>
            <div class="border-t pt-4">
                <div class="flex justify-between mb-4">
                    <span class="text-lg font-semibold">Total:</span>
                    <span id="cart-total" class="text-lg font-bold text-orange-600">₹0</span>
                </div>
                <button onclick="checkout()" 
                        class="w-full bg-orange-600 text-white py-3 rounded-full hover:bg-orange-700">
                    Proceed to Checkout
                </button>
            </div>
        </div>
    </div>

    <!-- Add this modal component before the closing body tag -->
    <div id="item-modal" class="fixed inset-0 bg-black bg-opacity-50 hidden items-center justify-center z-50">
        <div class="bg-white rounded-xl max-w-2xl w-full mx-4 overflow-hidden">
            <div class="relative">
                <img id="modal-image" src="" alt="" class="w-full h-64 object-cover">
                <button onclick="closeModal()" class="absolute top-4 right-4 bg-white rounded-full p-2 shadow-lg">
                    <i class="fas fa-times text-gray-600"></i>
                </button>
            </div>
            <div class="p-6">
                <h2 id="modal-title" class="text-3xl font-bold mb-4"></h2>
                <div class="flex items-center mb-4">
                    <span id="modal-price" class="text-2xl font-bold text-orange-600 mr-4"></span>
                    <span id="modal-veg-status" class="px-2 py-1 rounded text-sm"></span>
                </div>
                <div class="mb-6">
                    <h3 class="text-lg font-semibold mb-2">Description</h3>
                    <p id="modal-description" class="text-gray-600"></p>
                </div>
                <div class="mb-6">
                    <h3 class="text-lg font-semibold mb-2">Ingredients</h3>
                    <p id="modal-ingredients" class="text-gray-600"></p>
                </div>
                <div class="mb-6">
                    <h3 class="text-lg font-semibold mb-2">Nutritional Info</h3>
                    <div class="grid grid-cols-2 gap-4">
                        <div class="bg-gray-50 p-3 rounded">
                            <span class="block text-sm text-gray-500">Calories</span>
                            <span id="modal-calories" class="font-semibold"></span>
                        </div>
                        <div class="bg-gray-50 p-3 rounded">
                            <span class="block text-sm text-gray-500">Protein</span>
                            <span id="modal-protein" class="font-semibold"></span>
                        </div>
                    </div>
                </div>
                <div class="flex justify-between items-center">
                    <div class="flex items-center">
                        <button onclick="decrementQuantity()" class="bg-gray-100 px-3 py-1 rounded-l">-</button>
                        <span id="modal-quantity" class="bg-gray-100 px-4 py-1">1</span>
                        <button onclick="incrementQuantity()" class="bg-gray-100 px-3 py-1 rounded-r">+</button>
                    </div>
                    <button id="modal-add-to-cart" 
                            class="bg-orange-600 text-white px-6 py-2 rounded-full hover:bg-orange-700">
                        Add to Cart
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Add AOS initialization script -->
    <script src="https://unpkg.com/aos@next/dist/aos.js"></script>
    <script>
        AOS.init({
            duration: 800,
            once: true,
            offset: 100,
            easing: 'ease-out-cubic'
        });

        // Cart functionality
        let cart = [];
        let cartOpen = false;

        function toggleCart() {
            cartOpen = !cartOpen;
            document.getElementById('cart-sidebar').style.transform = 
                cartOpen ? 'translateX(0)' : 'translateX(100%)';
        }

        function addToCart(name, price) {
            cart.push({ name, price });
            updateCart();
        }

        function removeFromCart(index) {
            cart.splice(index, 1);
            updateCart();
        }

        function updateCart() {
            const cartItems = document.getElementById('cart-items');
            const cartCount = document.getElementById('cart-count');
            const cartTotal = document.getElementById('cart-total');
            
            cartCount.textContent = cart.length;
            cartItems.innerHTML = '';
            
            let total = 0;
            cart.forEach((item, index) => {
                total += item.price;
                cartItems.innerHTML += `
                    <div class="cart-item flex justify-between items-center p-4 mb-2 bg-gray-50 rounded-lg">
                        <div>
                            <h4 class="font-semibold">${item.name}</h4>
                            <p class="text-orange-600">₹${item.price}</p>
                        </div>
                        <button onclick="removeFromCart(${index})" class="text-red-500 hover:text-red-700">
                            <i class="fas fa-trash"></i>
                        </button>
                    </div>
                `;
            });
            
            cartTotal.textContent = `₹${total}`;
        }

        function checkout() {
            if (cart.length === 0) {
                alert('Please add items to your cart first!');
                return;
            }
            // Here you would typically redirect to a checkout page
            alert('Proceeding to checkout...');
        }

        // Modal functionality
        const itemDetails = {
            'Paneer Tikka': {
                description: 'Marinated cottage cheese grilled to perfection in a traditional clay oven. Served with mint chutney and onion rings.',
                ingredients: 'Cottage cheese, yogurt, ginger-garlic paste, tandoori masala, bell peppers, onions',
                calories: '320 kcal',
                protein: '18g',
                isVeg: true
            },
            'Chicken Tikka': {
                description: 'Tender pieces of chicken marinated in yogurt and spices, grilled to perfection in tandoor.',
                ingredients: 'Chicken, yogurt, ginger-garlic paste, tandoori masala, lemon juice',
                calories: '280 kcal',
                protein: '26g',
                isVeg: false
            },
            'Butter Chicken': {
                description: 'Tender chicken pieces cooked in rich, creamy tomato gravy with butter and aromatic spices.',
                ingredients: 'Chicken, tomatoes, cream, butter, cashew paste, spices',
                calories: '450 kcal',
                protein: '28g',
                isVeg: false
            },
            // Add more item details here
        };

        let currentItem = null;
        let currentQuantity = 1;

        function showItemDetails(name, price, imgSrc) {
            currentItem = { name, price };
            currentQuantity = 1;
            const details = itemDetails[name] || {
                description: 'A delicious dish prepared with finest ingredients.',
                ingredients: 'Fresh quality ingredients',
                calories: '300 kcal',
                protein: '15g',
                isVeg: true
            };

            document.getElementById('modal-image').src = imgSrc;
            document.getElementById('modal-title').textContent = name;
            document.getElementById('modal-price').textContent = `₹${price}`;
            document.getElementById('modal-description').textContent = details.description;
            document.getElementById('modal-ingredients').textContent = details.ingredients;
            document.getElementById('modal-calories').textContent = details.calories;
            document.getElementById('modal-protein').textContent = details.protein;
            document.getElementById('modal-quantity').textContent = '1';
            document.getElementById('modal-veg-status').textContent = details.isVeg ? 'Vegetarian' : 'Non-Vegetarian';
            document.getElementById('modal-veg-status').className = 
                `px-2 py-1 rounded text-sm ${details.isVeg ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800'}`;
            
            document.getElementById('modal-add-to-cart').onclick = () => {
                for(let i = 0; i < currentQuantity; i++) {
                    addToCart(name, price);
                }
                closeModal();
            };

            document.getElementById('item-modal').style.display = 'flex';
        }

        function closeModal() {
            document.getElementById('item-modal').style.display = 'none';
            currentItem = null;
            currentQuantity = 1;
        }

        function incrementQuantity() {
            currentQuantity = Math.min(currentQuantity + 1, 10);
            document.getElementById('modal-quantity').textContent = currentQuantity;
        }

        function decrementQuantity() {
            currentQuantity = Math.max(currentQuantity - 1, 1);
            document.getElementById('modal-quantity').textContent = currentQuantity;
        }

        // Update all menu item cards to be clickable
        document.querySelectorAll('.menu-section .bg-white').forEach(card => {
            const name = card.querySelector('h3').textContent;
            const price = parseInt(card.querySelector('.text-orange-600').textContent.replace('₹', ''));
            const imgSrc = card.querySelector('img').src;
            
            card.style.cursor = 'pointer';
            card.addEventListener('click', (e) => {
                // Don't show modal if clicking the Add to Cart button
                if (!e.target.closest('button')) {
                    showItemDetails(name, price, imgSrc);
                }
            });
        });
    </script>
</body>
</html> 