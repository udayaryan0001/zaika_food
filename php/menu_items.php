<?php
require_once '../config.php';

// Start session and check if user is admin
session_start();
if (!isset($_SESSION['user_id']) || !isset($_SESSION['is_admin']) || !$_SESSION['is_admin']) {
    http_response_code(401);
    echo json_encode(['success' => false, 'message' => 'Unauthorized']);
    exit;
}

// Handle GET request - Fetch all menu items
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $sql = "SELECT * FROM menu_items ORDER BY category, name";
    $result = $conn->query($sql);
    
    if ($result) {
        $menu_items = $result->fetch_all(MYSQLI_ASSOC);
        echo json_encode($menu_items);
    } else {
        http_response_code(500);
        echo json_encode(['success' => false, 'message' => 'Failed to fetch menu items']);
    }
}

// Handle POST request - Create or Update menu item
else if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Check if image file was uploaded
    if (!isset($_FILES['image']) || $_FILES['image']['error'] !== UPLOAD_ERR_OK) {
        http_response_code(400);
        echo json_encode(['success' => false, 'message' => 'Image file is required']);
        exit;
    }

    // Validate other required fields
    $required_fields = ['name', 'category', 'price', 'description'];
    foreach ($required_fields as $field) {
        if (!isset($_POST[$field]) || empty($_POST[$field])) {
            http_response_code(400);
            echo json_encode(['success' => false, 'message' => "Missing required field: $field"]);
            exit;
        }
    }

    // Handle image upload
    $upload_dir = '../images/menu/';
    if (!file_exists($upload_dir)) {
        mkdir($upload_dir, 0777, true);
    }

    $file_extension = strtolower(pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION));
    $allowed_extensions = ['jpg', 'jpeg', 'png', 'gif'];

    if (!in_array($file_extension, $allowed_extensions)) {
        http_response_code(400);
        echo json_encode(['success' => false, 'message' => 'Invalid file type. Only JPG, JPEG, PNG, and GIF are allowed.']);
        exit;
    }

    $file_name = uniqid() . '.' . $file_extension;
    $file_path = $upload_dir . $file_name;

    if (!move_uploaded_file($_FILES['image']['tmp_name'], $file_path)) {
        http_response_code(500);
        echo json_encode(['success' => false, 'message' => 'Failed to upload image']);
        exit;
    }

    // Sanitize inputs
    $name = $conn->real_escape_string($_POST['name']);
    $category = $conn->real_escape_string($_POST['category']);
    $price = floatval($_POST['price']);
    $description = $conn->real_escape_string($_POST['description']);
    $image = 'images/menu/' . $file_name;

    if (isset($_POST['id']) && !empty($_POST['id'])) {
        // Update existing item
        $id = intval($_POST['id']);
        
        // Get old image path to delete
        $sql = "SELECT image FROM menu_items WHERE id = $id";
        $result = $conn->query($sql);
        if ($result && $row = $result->fetch_assoc()) {
            $old_image = '../' . $row['image'];
            if (file_exists($old_image)) {
                unlink($old_image);
            }
        }

        $sql = "UPDATE menu_items SET 
                name = '$name',
                category = '$category',
                price = $price,
                description = '$description',
                image = '$image'
                WHERE id = $id";
    } else {
        // Create new item
        $sql = "INSERT INTO menu_items (name, category, price, description, image)
                VALUES ('$name', '$category', $price, '$description', '$image')";
    }

    if ($conn->query($sql)) {
        echo json_encode(['success' => true]);
    } else {
        // Delete uploaded image if database insert/update fails
        unlink($file_path);
        http_response_code(500);
        echo json_encode(['success' => false, 'message' => 'Failed to save menu item']);
    }
}

// Handle DELETE request - Delete menu item
else if ($_SERVER['REQUEST_METHOD'] === 'DELETE') {
    if (!isset($_GET['id'])) {
        http_response_code(400);
        echo json_encode(['success' => false, 'message' => 'Missing item ID']);
        exit;
    }
    
    $id = intval($_GET['id']);

    // Get image path before deleting the record
    $sql = "SELECT image FROM menu_items WHERE id = $id";
    $result = $conn->query($sql);
    if ($result && $row = $result->fetch_assoc()) {
        $image_path = '../' . $row['image'];
        if (file_exists($image_path)) {
            unlink($image_path);
        }
    }

    $sql = "DELETE FROM menu_items WHERE id = $id";
    
    if ($conn->query($sql)) {
        echo json_encode(['success' => true]);
    } else {
        http_response_code(500);
        echo json_encode(['success' => false, 'message' => 'Failed to delete menu item']);
    }
}

$conn->close();
?> 