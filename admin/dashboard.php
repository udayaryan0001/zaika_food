<?php
session_start();
require_once('../config.php');

// Check if user is logged in and is admin
if (!isset($_SESSION['user_id']) || !isset($_SESSION['is_admin']) || $_SESSION['is_admin'] != 1) {
    header("Location: ../login.php");
    exit();
}

// Handle menu item operations (add, edit, delete)
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['action'])) {
        switch ($_POST['action']) {
            case 'add':
                // Add menu item logic here
                break;
            case 'edit':
                // Edit menu item logic here
                break;
            case 'delete':
                // Delete menu item logic here
                break;
        }
    }
}

// Fetch all menu items
$query = "SELECT * FROM menu_items ORDER BY category, name";
$result = mysqli_query($conn, $query);
$menu_items = mysqli_fetch_all($result, MYSQLI_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - Zaika-e-Handi</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100">
    <nav class="bg-white shadow-lg">
        <div class="max-w-7xl mx-auto px-4">
            <div class="flex justify-between h-16">
                <div class="flex items-center">
                    <a href="../index.php" class="text-2xl font-bold text-orange-600">Zaika-e-Handi</a>
                </div>
                <div class="flex items-center space-x-4">
                    <span class="text-gray-600">Welcome, Admin</span>
                    <a href="../logout.php" class="bg-red-500 text-white px-4 py-2 rounded-md hover:bg-red-600">Logout</a>
                </div>
            </div>
        </div>
    </nav>

    <div class="max-w-7xl mx-auto px-4 py-6">
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-3xl font-bold text-gray-800">Menu Management</h1>
            <button onclick="openAddModal()" class="bg-green-500 text-white px-4 py-2 rounded-md hover:bg-green-600">
                <i class="fas fa-plus mr-2"></i>Add New Item
            </button>
        </div>

        <!-- Search and Filter -->
        <div class="bg-white p-4 rounded-lg shadow mb-6">
            <div class="flex gap-4">
                <input type="text" id="searchInput" placeholder="Search menu items..." 
                       class="flex-1 p-2 border rounded-md">
                <select id="categoryFilter" class="p-2 border rounded-md">
                    <option value="">All Categories</option>
                    <option value="appetizer">Appetizers</option>
                    <option value="main">Main Course</option>
                    <option value="dessert">Desserts</option>
                    <option value="beverage">Beverages</option>
                </select>
            </div>
        </div>

        <!-- Menu Items Table -->
        <div class="bg-white rounded-lg shadow overflow-hidden">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Name</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Category</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Price</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Description</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    <?php foreach ($menu_items as $item): ?>
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="flex items-center">
                                <div class="flex-shrink-0 h-10 w-10">
                                    <img class="h-10 w-10 rounded-full object-cover" 
                                         src="../<?php echo htmlspecialchars($item['image']); ?>" 
                                         alt="<?php echo htmlspecialchars($item['name']); ?>">
                                </div>
                                <div class="ml-4">
                                    <?php echo htmlspecialchars($item['name']); ?>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap"><?php echo htmlspecialchars($item['category']); ?></td>
                        <td class="px-6 py-4 whitespace-nowrap">₹<?php echo number_format($item['price'], 2); ?></td>
                        <td class="px-6 py-4"><?php echo htmlspecialchars($item['description']); ?></td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <button onclick="openEditModal(<?php echo htmlspecialchars(json_encode($item)); ?>)" 
                                    class="text-blue-600 hover:text-blue-900 mr-3">
                                <i class="fas fa-edit"></i>
                            </button>
                            <button onclick="deleteItem(<?php echo $item['id']; ?>)" 
                                    class="text-red-600 hover:text-red-900">
                                <i class="fas fa-trash"></i>
                            </button>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>

    <!-- Add/Edit Modal Template -->
    <div id="itemModal" class="hidden fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full">
        <div class="relative top-20 mx-auto p-5 border w-[600px] shadow-lg rounded-md bg-white">
            <div class="mt-3">
                <h3 class="text-lg font-medium text-gray-900" id="modalTitle">Add New Item</h3>
                <form id="itemForm" class="mt-4" enctype="multipart/form-data">
                    <input type="hidden" id="itemId" name="id">
                    <div class="grid grid-cols-2 gap-4">
                        <div class="col-span-2">
                            <label class="block text-gray-700 text-sm font-bold mb-2" for="name">Name</label>
                            <input type="text" id="name" name="name" required
                                   class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700">
                        </div>
                        <div>
                            <label class="block text-gray-700 text-sm font-bold mb-2" for="category">Category</label>
                            <select id="category" name="category" required
                                    class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700">
                                <option value="appetizer">Appetizer</option>
                                <option value="main_course">Main Course</option>
                                <option value="dessert">Dessert</option>
                                <option value="beverage">Beverage</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-gray-700 text-sm font-bold mb-2" for="price">Price</label>
                            <input type="number" step="0.01" id="price" name="price" required
                                   class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700">
                        </div>
                        <div class="col-span-2">
                            <label class="block text-gray-700 text-sm font-bold mb-2" for="description">Description</label>
                            <textarea id="description" name="description" required rows="3"
                                    class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700"></textarea>
                        </div>
                        <div class="col-span-2">
                            <label class="block text-gray-700 text-sm font-bold mb-2" for="image">Image</label>
                            <div class="flex items-center space-x-4">
                                <div class="flex-1">
                                    <input type="file" id="image" name="image" accept="image/*" required
                                           class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700"
                                           onchange="previewImage(event)">
                                </div>
                                <div id="imagePreviewContainer" class="hidden">
                                    <img id="imagePreview" class="h-20 w-20 object-cover rounded-lg">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="flex justify-end mt-6 space-x-4">
                        <button type="button" onclick="closeModal()"
                                class="bg-gray-500 text-white px-4 py-2 rounded-md hover:bg-gray-600">Cancel</button>
                        <button type="submit"
                                class="bg-blue-500 text-white px-4 py-2 rounded-md hover:bg-blue-600">Save</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        // Load menu items
        function loadMenuItems() {
            fetch('../php/menu_items.php')
                .then(response => response.json())
                .then(data => {
                    const tbody = document.querySelector('tbody');
                    tbody.innerHTML = '';
                    data.forEach(item => {
                        tbody.innerHTML += `
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center">
                                        <div class="flex-shrink-0 h-10 w-10">
                                            <img class="h-10 w-10 rounded-full object-cover" 
                                                 src="../${item.image}" 
                                                 alt="${item.name}">
                                        </div>
                                        <div class="ml-4">
                                            ${item.name}
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">${item.category}</td>
                                <td class="px-6 py-4 whitespace-nowrap">₹${parseFloat(item.price).toFixed(2)}</td>
                                <td class="px-6 py-4">${item.description}</td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <button onclick='openEditModal(${JSON.stringify(item)})' 
                                            class="text-blue-600 hover:text-blue-900 mr-3">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                    <button onclick="deleteItem(${item.id})" 
                                            class="text-red-600 hover:text-red-900">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </td>
                            </tr>
                        `;
                    });
                })
                .catch(error => {
                    console.error('Error loading menu items:', error);
                    alert('Failed to load menu items');
                });
        }

        // Preview image before upload
        function previewImage(event) {
            const file = event.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    const preview = document.getElementById('imagePreview');
                    preview.src = e.target.result;
                    document.getElementById('imagePreviewContainer').classList.remove('hidden');
                }
                reader.readAsDataURL(file);
            }
        }

        // Modal functions
        function openAddModal() {
            document.getElementById('modalTitle').textContent = 'Add New Item';
            document.getElementById('itemForm').reset();
            document.getElementById('itemId').value = '';
            document.getElementById('imagePreviewContainer').classList.add('hidden');
            document.getElementById('image').required = true;
            document.getElementById('itemModal').classList.remove('hidden');
        }

        function openEditModal(item) {
            document.getElementById('modalTitle').textContent = 'Edit Item';
            document.getElementById('itemId').value = item.id;
            document.getElementById('name').value = item.name;
            document.getElementById('category').value = item.category;
            document.getElementById('price').value = item.price;
            document.getElementById('description').value = item.description;
            
            // Show current image preview
            const preview = document.getElementById('imagePreview');
            preview.src = '../' + item.image;
            document.getElementById('imagePreviewContainer').classList.remove('hidden');
            
            // Image is not required when editing
            document.getElementById('image').required = false;
            
            document.getElementById('itemModal').classList.remove('hidden');
        }

        function closeModal() {
            document.getElementById('itemModal').classList.add('hidden');
        }

        // Handle form submission
        document.getElementById('itemForm').addEventListener('submit', function(e) {
            e.preventDefault();
            const formData = new FormData(this);

            fetch('../php/menu_items.php', {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    closeModal();
                    loadMenuItems();
                    alert('Menu item saved successfully');
                } else {
                    throw new Error(data.message || 'Failed to save menu item');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert(error.message);
            });
        });

        function deleteItem(itemId) {
            if (confirm('Are you sure you want to delete this item?')) {
                fetch(`../php/menu_items.php?id=${itemId}`, {
                    method: 'DELETE'
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        loadMenuItems();
                        alert('Item deleted successfully');
                    } else {
                        throw new Error(data.message || 'Failed to delete item');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert(error.message);
                });
            }
        }

        // Search and filter functionality
        document.getElementById('searchInput').addEventListener('input', filterItems);
        document.getElementById('categoryFilter').addEventListener('change', filterItems);

        function filterItems() {
            const searchTerm = document.getElementById('searchInput').value.toLowerCase();
            const category = document.getElementById('categoryFilter').value.toLowerCase();
            const rows = document.querySelectorAll('tbody tr');

            rows.forEach(row => {
                const name = row.querySelector('.ml-4').textContent.toLowerCase();
                const itemCategory = row.cells[1].textContent.toLowerCase();
                const matchesSearch = name.includes(searchTerm);
                const matchesCategory = category === '' || itemCategory === category;
                row.style.display = matchesSearch && matchesCategory ? '' : 'none';
            });
        }

        // Initialize
        document.addEventListener('DOMContentLoaded', loadMenuItems);
    </script>
</body>
</html> 