<?php
session_start();
require_once 'config.php';

// Check if user is logged in and is admin
if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] !== 'admin') {
    header("Location: login.php?type=admin");
    exit();
}

// Get total number of users
$sql = "SELECT COUNT(*) as total_users FROM users WHERE role = 'user'";
$result = $conn->query($sql);
$total_users = $result->fetch_assoc()['total_users'];

// Get total number of subscribers
$sql = "SELECT COUNT(*) as total_subscribers FROM subscribers";
$result = $conn->query($sql);
$total_subscribers = $result->fetch_assoc()['total_subscribers'];

// Get recent subscribers
$sql = "SELECT email, created_at FROM subscribers ORDER BY created_at DESC LIMIT 5";
$result = $conn->query($sql);
$recent_subscribers = $result->fetch_all(MYSQLI_ASSOC);

// Get total orders (if orders table exists)
$total_orders = 0;
$total_revenue = 0;
if ($conn->query("SHOW TABLES LIKE 'orders'")->num_rows > 0) {
    $result = $conn->query("SELECT COUNT(*) as total_orders, COALESCE(SUM(total_amount), 0) as total_revenue FROM orders");
    $order_stats = $result->fetch_assoc();
    $total_orders = $order_stats['total_orders'];
    $total_revenue = $order_stats['total_revenue'];
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - Zaika-e-Handi</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <style>
        .dashboard-card {
            transition: all 0.3s ease;
        }
        .dashboard-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 20px 25px -5px rgb(0 0 0 / 0.1), 0 8px 10px -6px rgb(0 0 0 / 0.1);
        }
    </style>
</head>
<body class="bg-gray-50">
    <!-- Navigation -->
    <nav class="bg-white shadow-lg fixed w-full z-50">
        <div class="max-w-7xl mx-auto px-4">
            <div class="flex justify-between items-center h-20">
                <div class="flex items-center">
                    <a href="dashboard.php" class="text-3xl font-bold text-orange-600">
                        <span class="text-4xl">🍛</span> Admin Dashboard
                    </a>
                </div>
                <div class="flex items-center space-x-4">
                    <span class="text-gray-600">Welcome, <?php echo htmlspecialchars($_SESSION['user_name']); ?></span>
                    <a href="logout.php" class="text-red-600 hover:text-red-700">
                        <i class="fas fa-sign-out-alt"></i> Logout
                    </a>
                </div>
            </div>
        </div>
    </nav>

    <!-- Dashboard Content -->
    <div class="pt-24 pb-12">
        <div class="max-w-7xl mx-auto px-4">
            <!-- Overview Cards -->
            <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
                <div class="dashboard-card bg-white rounded-xl shadow p-6">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-gray-500 text-sm">Total Orders</p>
                            <h3 class="text-2xl font-bold"><?php echo $total_orders; ?></h3>
                            <p class="text-green-500 text-sm">Active Orders</p>
                        </div>
                        <div class="w-12 h-12 bg-orange-100 rounded-full flex items-center justify-center">
                            <i class="fas fa-shopping-bag text-orange-600 text-xl"></i>
                        </div>
                    </div>
                </div>
                <div class="dashboard-card bg-white rounded-xl shadow p-6">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-gray-500 text-sm">Revenue</p>
                            <h3 class="text-2xl font-bold">₹<?php echo number_format($total_revenue, 2); ?></h3>
                            <p class="text-green-500 text-sm">Total Revenue</p>
                        </div>
                        <div class="w-12 h-12 bg-green-100 rounded-full flex items-center justify-center">
                            <i class="fas fa-rupee-sign text-green-600 text-xl"></i>
                        </div>
                    </div>
                </div>
                <div class="dashboard-card bg-white rounded-xl shadow p-6">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-gray-500 text-sm">Users</p>
                            <h3 class="text-2xl font-bold"><?php echo $total_users; ?></h3>
                            <p class="text-green-500 text-sm">Registered Users</p>
                        </div>
                        <div class="w-12 h-12 bg-blue-100 rounded-full flex items-center justify-center">
                            <i class="fas fa-users text-blue-600 text-xl"></i>
                        </div>
                    </div>
                </div>
                <div class="dashboard-card bg-white rounded-xl shadow p-6">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-gray-500 text-sm">Subscribers</p>
                            <h3 class="text-2xl font-bold"><?php echo $total_subscribers; ?></h3>
                            <p class="text-green-500 text-sm">Newsletter Subscribers</p>
                        </div>
                        <div class="w-12 h-12 bg-purple-100 rounded-full flex items-center justify-center">
                            <i class="fas fa-envelope text-purple-600 text-xl"></i>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Menu Management and Charts -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">
                <!-- Menu Management -->
                <div class="bg-white rounded-xl shadow p-6">
                    <div class="flex justify-between items-center mb-6">
                        <h2 class="text-xl font-bold">Menu Management</h2>
                        <button onclick="openAddMenuItemModal()" class="bg-orange-600 text-white px-4 py-2 rounded-lg hover:bg-orange-700 transition">
                            <i class="fas fa-plus mr-2"></i>Add Item
                        </button>
                    </div>
                    <div class="overflow-x-auto">
                        <table class="min-w-full table-auto">
                            <thead>
                                <tr class="bg-gray-50">
                                    <th class="px-4 py-2 text-left">Item</th>
                                    <th class="px-4 py-2 text-left">Category</th>
                                    <th class="px-4 py-2 text-left">Price</th>
                                    <th class="px-4 py-2 text-left">Actions</th>
                                </tr>
                            </thead>
                            <tbody id="menuItemsTableBody">
                                <!-- Menu items will be loaded here dynamically -->
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- Charts -->
                <div class="bg-white rounded-xl shadow p-6">
                    <h2 class="text-xl font-bold mb-6">Analytics</h2>
                    <canvas id="ordersChart"></canvas>
                </div>
            </div>

            <!-- Recent Subscribers -->
            <div class="bg-white rounded-xl shadow p-6 mb-8">
                <h2 class="text-xl font-bold mb-6">Recent Subscribers</h2>
                <div class="overflow-x-auto">
                    <table class="min-w-full table-auto">
                        <thead>
                            <tr class="bg-gray-50">
                                <th class="px-4 py-2 text-left">Email</th>
                                <th class="px-4 py-2 text-left">Date Subscribed</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($recent_subscribers as $subscriber): ?>
                            <tr class="border-b">
                                <td class="px-4 py-2"><?php echo htmlspecialchars($subscriber['email']); ?></td>
                                <td class="px-4 py-2"><?php echo date('M d, Y', strtotime($subscriber['created_at'])); ?></td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Quick Actions -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mt-8">
                <a href="manage_menu.php" class="bg-white rounded-lg shadow-md p-6 hover:shadow-lg transition-shadow">
                    <div class="flex items-center">
                        <div class="p-3 bg-orange-100 rounded-full">
                            <i class="fas fa-utensils text-orange-600 text-xl"></i>
                        </div>
                        <div class="ml-4">
                            <h3 class="text-lg font-semibold text-gray-700">Manage Menu</h3>
                            <p class="text-sm text-gray-500">Add, edit, or remove menu items</p>
                        </div>
                    </div>
                </a>
                <a href="manage_users.php" class="bg-white rounded-lg shadow-md p-6 hover:shadow-lg transition-shadow">
                    <div class="flex items-center">
                        <div class="p-3 bg-purple-100 rounded-full">
                            <i class="fas fa-user-cog text-purple-600 text-xl"></i>
                        </div>
                        <div class="ml-4">
                            <h3 class="text-lg font-semibold text-gray-700">Manage Users</h3>
                            <p class="text-sm text-gray-500">View and manage user accounts</p>
                        </div>
                    </div>
                </a>
                <a href="settings.php" class="bg-white rounded-lg shadow-md p-6 hover:shadow-lg transition-shadow">
                    <div class="flex items-center">
                        <div class="p-3 bg-gray-100 rounded-full">
                            <i class="fas fa-cog text-gray-600 text-xl"></i>
                        </div>
                        <div class="ml-4">
                            <h3 class="text-lg font-semibold text-gray-700">Settings</h3>
                            <p class="text-sm text-gray-500">Configure website settings</p>
                        </div>
                    </div>
                </a>
            </div>
        </div>
    </div>

    <!-- Add/Edit Menu Item Modal -->
    <div id="menuItemModal" class="fixed inset-0 bg-black bg-opacity-50 hidden items-center justify-center z-50">
        <div class="bg-white rounded-xl p-6 w-full max-w-md">
            <h3 class="text-xl font-bold mb-4" id="modalTitle">Add Menu Item</h3>
            <form id="menuItemForm" onsubmit="handleMenuItemSubmit(event)">
                <input type="hidden" id="itemId" name="id">
                <div class="mb-4">
                    <label class="block text-gray-700 text-sm font-bold mb-2" for="name">
                        Item Name
                    </label>
                    <input type="text" id="name" name="name" required
                        class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                </div>
                <div class="mb-4">
                    <label class="block text-gray-700 text-sm font-bold mb-2" for="category">
                        Category
                    </label>
                    <select id="category" name="category" required
                        class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                        <option value="">Select Category</option>
                        <option value="appetizer">Appetizer</option>
                        <option value="main_course">Main Course</option>
                        <option value="dessert">Dessert</option>
                        <option value="beverage">Beverage</option>
                    </select>
                </div>
                <div class="mb-4">
                    <label class="block text-gray-700 text-sm font-bold mb-2" for="price">
                        Price
                    </label>
                    <input type="number" id="price" name="price" step="0.01" required
                        class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                </div>
                <div class="mb-4">
                    <label class="block text-gray-700 text-sm font-bold mb-2" for="description">
                        Description
                    </label>
                    <textarea id="description" name="description" required
                        class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"></textarea>
                </div>
                <div class="mb-4">
                    <label class="block text-gray-700 text-sm font-bold mb-2" for="image">
                        Image URL
                    </label>
                    <input type="text" id="image" name="image" required
                        class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                </div>
                <div class="flex justify-end space-x-4">
                    <button type="button" onclick="closeMenuItemModal()"
                        class="bg-gray-500 text-white px-4 py-2 rounded hover:bg-gray-600 transition">
                        Cancel
                    </button>
                    <button type="submit"
                        class="bg-orange-600 text-white px-4 py-2 rounded hover:bg-orange-700 transition">
                        Save
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script>
        // Load menu items
        function loadMenuItems() {
            fetch('php/menu_items.php')
                .then(response => response.json())
                .then(data => {
                    const tbody = document.getElementById('menuItemsTableBody');
                    tbody.innerHTML = '';
                    data.forEach(item => {
                        tbody.innerHTML += `
                            <tr class="border-b">
                                <td class="px-4 py-2">${item.name}</td>
                                <td class="px-4 py-2">${item.category}</td>
                                <td class="px-4 py-2">₹${parseFloat(item.price).toFixed(2)}</td>
                                <td class="px-4 py-2">
                                    <button onclick="editMenuItem(${JSON.stringify(item)})" class="text-blue-600 hover:text-blue-700 mr-2">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                    <button onclick="deleteMenuItem(${item.id})" class="text-red-600 hover:text-red-700">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </td>
                            </tr>
                        `;
                    });
                })
                .catch(error => {
                    console.error('Error loading menu items:', error);
                    Swal.fire('Error', 'Failed to load menu items', 'error');
                });
        }

        // Initialize charts
        function initializeCharts() {
            const ctx = document.getElementById('ordersChart').getContext('2d');
            new Chart(ctx, {
                type: 'line',
                data: {
                    labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun'],
                    datasets: [{
                        label: 'Orders',
                        data: [12, 19, 3, 5, 2, 3],
                        borderColor: 'rgb(234, 88, 12)',
                        tension: 0.1
                    }]
                },
                options: {
                    responsive: true,
                    plugins: {
                        legend: {
                            position: 'top',
                        },
                        title: {
                            display: true,
                            text: 'Monthly Orders'
                        }
                    }
                }
            });
        }

        // Modal functions
        function openAddMenuItemModal() {
            document.getElementById('modalTitle').textContent = 'Add Menu Item';
            document.getElementById('menuItemForm').reset();
            document.getElementById('itemId').value = '';
            document.getElementById('menuItemModal').classList.remove('hidden');
            document.getElementById('menuItemModal').classList.add('flex');
        }

        function closeMenuItemModal() {
            document.getElementById('menuItemModal').classList.remove('flex');
            document.getElementById('menuItemModal').classList.add('hidden');
        }

        function editMenuItem(item) {
            document.getElementById('modalTitle').textContent = 'Edit Menu Item';
            document.getElementById('itemId').value = item.id;
            document.getElementById('name').value = item.name;
            document.getElementById('category').value = item.category;
            document.getElementById('price').value = item.price;
            document.getElementById('description').value = item.description;
            document.getElementById('image').value = item.image;
            document.getElementById('menuItemModal').classList.remove('hidden');
            document.getElementById('menuItemModal').classList.add('flex');
        }

        function deleteMenuItem(id) {
            Swal.fire({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    fetch(`php/menu_items.php?id=${id}`, {
                        method: 'DELETE'
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            Swal.fire('Deleted!', 'Menu item has been deleted.', 'success');
                            loadMenuItems();
                        } else {
                            throw new Error(data.message || 'Failed to delete menu item');
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        Swal.fire('Error', error.message, 'error');
                    });
                }
            });
        }

        function handleMenuItemSubmit(event) {
            event.preventDefault();
            const formData = new FormData(event.target);
            const data = Object.fromEntries(formData.entries());
            
            fetch('php/menu_items.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify(data)
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    Swal.fire('Success', 'Menu item saved successfully', 'success');
                    closeMenuItemModal();
                    loadMenuItems();
                } else {
                    throw new Error(data.message || 'Failed to save menu item');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                Swal.fire('Error', error.message, 'error');
            });
        }

        // Initialize
        document.addEventListener('DOMContentLoaded', () => {
            loadMenuItems();
            initializeCharts();
        });
    </script>
</body>
</html> 