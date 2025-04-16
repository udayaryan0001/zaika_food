<?php
session_start();
require_once 'config.php';

// Check if user is admin
if (!isset($_SESSION['user_role']) || $_SESSION['user_role'] !== 'admin') {
    header("Location: ../login.html");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_FILES["menuImage"])) {
    $target_dir = "../uploads/";
    $target_file = $target_dir . basename($_FILES["menuImage"]["name"]);
    $uploadOk = 1;
    $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
    
    // Check if image file is a actual image or fake image
    $check = getimagesize($_FILES["menuImage"]["tmp_name"]);
    if($check === false) {
        $_SESSION['error'] = "File is not an image.";
        header("Location: ../admin.html");
        exit();
    }
    
    // Check file size
    if ($_FILES["menuImage"]["size"] > 10000000) { // 10MB
        $_SESSION['error'] = "Sorry, your file is too large.";
        header("Location: ../admin.html");
        exit();
    }
    
    // Allow certain file formats
    if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif" ) {
        $_SESSION['error'] = "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
        header("Location: ../admin.html");
        exit();
    }
    
    // Create uploads directory if it doesn't exist
    if (!file_exists($target_dir)) {
        mkdir($target_dir, 0777, true);
    }
    
    // Generate unique filename
    $new_filename = uniqid() . '.' . $imageFileType;
    $target_file = $target_dir . $new_filename;
    
    if (move_uploaded_file($_FILES["menuImage"]["tmp_name"], $target_file)) {
        // Process the image with Tesseract OCR
        $output = [];
        $return_var = 0;
        
        // Make sure Tesseract is installed and in PATH
        exec("tesseract " . escapeshellarg($target_file) . " stdout", $output, $return_var);
        
        if ($return_var === 0) {
            $text = implode("\n", $output);
            
            // Process the extracted text to identify menu items and prices
            $menu_items = process_menu_text($text);
            
            // Store menu items in database
            if (!empty($menu_items)) {
                $stmt = $conn->prepare("INSERT INTO menu_items (name, price, category) VALUES (?, ?, ?)");
                
                foreach ($menu_items as $item) {
                    $stmt->bind_param("sds", $item['name'], $item['price'], $item['category']);
                    $stmt->execute();
                }
                
                $stmt->close();
                
                $_SESSION['success'] = "Menu items successfully extracted and saved!";
            } else {
                $_SESSION['error'] = "No menu items could be extracted from the image.";
            }
        } else {
            $_SESSION['error'] = "Error processing image with OCR.";
        }
    } else {
        $_SESSION['error'] = "Sorry, there was an error uploading your file.";
    }
    
    header("Location: ../admin.html");
    exit();
}

function process_menu_text($text) {
    // This is a basic implementation. You might need to adjust the regex patterns
    // based on your specific menu format.
    
    $menu_items = [];
    $current_category = "Uncategorized";
    
    // Split text into lines
    $lines = explode("\n", $text);
    
    foreach ($lines as $line) {
        // Check if line might be a category
        if (preg_match('/^(starters?|main course|biryani|desserts?|drinks?)$/i', trim($line))) {
            $current_category = ucfirst(trim($line));
            continue;
        }
        
        // Try to extract item name and price
        if (preg_match('/^(.+?)\s*₹?\s*(\d+\.?\d*)$/i', trim($line), $matches)) {
            $name = trim($matches[1]);
            $price = floatval($matches[2]);
            
            if (!empty($name) && $price > 0) {
                $menu_items[] = [
                    'name' => $name,
                    'price' => $price,
                    'category' => $current_category
                ];
            }
        }
    }
    
    return $menu_items;
}

// If not a POST request, redirect to admin page
header("Location: ../admin.html");
exit();
?> 