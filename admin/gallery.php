<?php
session_start();
require_once('../config.php');

// Check if user is logged in and is admin
if (!isset($_SESSION['user_id']) || !isset($_SESSION['is_admin']) || $_SESSION['is_admin'] != 1) {
    header("Location: ../login.php");
    exit();
}

// Handle image upload
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $upload_dir = '../images/gallery/';
    if (!file_exists($upload_dir)) {
        mkdir($upload_dir, 0777, true);
    }

    $response = ['success' => false, 'message' => ''];

    if (isset($_FILES['images'])) {
        $files = $_FILES['images'];
        $uploaded = 0;
        $failed = 0;

        for ($i = 0; $i < count($files['name']); $i++) {
            if ($files['error'][$i] === UPLOAD_ERR_OK) {
                $tmp_name = $files['tmp_name'][$i];
                $name = $files['name'][$i];
                $ext = strtolower(pathinfo($name, PATHINFO_EXTENSION));
                
                // Validate file type
                if (!in_array($ext, ['jpg', 'jpeg', 'png', 'gif'])) {
                    $failed++;
                    continue;
                }

                // Generate unique filename
                $new_name = uniqid() . '.' . $ext;
                $destination = $upload_dir . $new_name;

                if (move_uploaded_file($tmp_name, $destination)) {
                    // Insert into gallery table
                    $sql = "INSERT INTO gallery (image_path, uploaded_at) VALUES (?, NOW())";
                    $stmt = $conn->prepare($sql);
                    $path = 'images/gallery/' . $new_name;
                    $stmt->bind_param("s", $path);
                    
                    if ($stmt->execute()) {
                        $uploaded++;
                    } else {
                        unlink($destination);
                        $failed++;
                    }
                } else {
                    $failed++;
                }
            } else {
                $failed++;
            }
        }

        $response['success'] = true;
        $response['message'] = "Uploaded $uploaded images successfully." . ($failed > 0 ? " Failed to upload $failed images." : "");
    }

    header('Content-Type: application/json');
    echo json_encode($response);
    exit;
}

// Fetch all gallery images
$sql = "SELECT * FROM gallery ORDER BY uploaded_at DESC";
$result = $conn->query($sql);
$images = [];
if ($result) {
    $images = $result->fetch_all(MYSQLI_ASSOC);
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gallery Management - Zaika-e-Handi</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@fancyapps/ui@5.0/dist/fancybox/fancybox.css"/>
    <style>
        .gallery-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
            gap: 1.5rem;
        }
        .image-container {
            position: relative;
            padding-bottom: 100%;
            overflow: hidden;
        }
        .image-container img {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.3s ease;
        }
        .image-container:hover img {
            transform: scale(1.05);
        }
        .delete-btn {
            position: absolute;
            top: 0.5rem;
            right: 0.5rem;
            z-index: 10;
            opacity: 0;
            transition: opacity 0.2s ease;
        }
        .image-container:hover .delete-btn {
            opacity: 1;
        }
    </style>
</head>
<body class="bg-gray-50">
    <!-- Navigation -->
    <nav class="bg-white shadow-lg">
        <div class="max-w-7xl mx-auto px-4">
            <div class="flex justify-between h-16">
                <div class="flex items-center">
                    <a href="dashboard.php" class="text-2xl font-bold text-orange-600">
                        <span class="text-4xl">🍛</span> Admin Dashboard
                    </a>
                </div>
                <div class="flex items-center space-x-4">
                    <a href="dashboard.php" class="text-gray-600 hover:text-gray-900">
                        <i class="fas fa-arrow-left"></i> Back to Dashboard
                    </a>
                    <a href="../logout.php" class="text-red-600 hover:text-red-700">
                        <i class="fas fa-sign-out-alt"></i> Logout
                    </a>
                </div>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <div class="max-w-7xl mx-auto px-4 py-8">
        <div class="flex justify-between items-center mb-8">
            <h1 class="text-3xl font-bold text-gray-800">Gallery Management</h1>
            <label class="bg-orange-600 text-white px-6 py-3 rounded-lg hover:bg-orange-700 cursor-pointer transition-colors">
                <input type="file" multiple accept="image/*" class="hidden" id="imageUpload">
                <i class="fas fa-upload mr-2"></i> Upload Images
            </label>
        </div>

        <!-- Upload Progress -->
        <div id="uploadProgress" class="hidden mb-8">
            <div class="bg-blue-50 p-4 rounded-lg">
                <div class="flex items-center">
                    <div class="mr-3">
                        <i class="fas fa-spinner fa-spin text-blue-500"></i>
                    </div>
                    <div class="flex-1">
                        <div class="text-sm text-blue-700" id="uploadStatus">Uploading images...</div>
                        <div class="mt-1 relative">
                            <div class="h-2 bg-blue-200 rounded-full">
                                <div class="h-2 bg-blue-500 rounded-full transition-all duration-300" id="progressBar" style="width: 0%"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Gallery Grid -->
        <div class="gallery-grid" id="galleryGrid">
            <?php foreach ($images as $image): ?>
            <div class="image-container rounded-lg overflow-hidden shadow-lg" data-id="<?php echo $image['id']; ?>">
                <a href="../<?php echo htmlspecialchars($image['image_path']); ?>" 
                   data-fancybox="gallery"
                   class="block">
                    <img src="../<?php echo htmlspecialchars($image['image_path']); ?>" 
                         alt="Gallery Image"
                         class="rounded-lg">
                </a>
                <button class="delete-btn bg-red-500 hover:bg-red-600 text-white p-2 rounded-full shadow-lg"
                        onclick="deleteImage(<?php echo $image['id']; ?>)">
                    <i class="fas fa-trash"></i>
                </button>
            </div>
            <?php endforeach; ?>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/@fancyapps/ui@5.0/dist/fancybox/fancybox.umd.js"></script>
    <script>
        // Initialize Fancybox
        Fancybox.bind("[data-fancybox]", {
            // Custom options
        });

        // Handle image upload
        document.getElementById('imageUpload').addEventListener('change', async function(e) {
            const files = e.target.files;
            if (files.length === 0) return;

            const formData = new FormData();
            for (let i = 0; i < files.length; i++) {
                formData.append('images[]', files[i]);
            }

            // Show progress bar
            const progress = document.getElementById('uploadProgress');
            const progressBar = document.getElementById('progressBar');
            const uploadStatus = document.getElementById('uploadStatus');
            progress.classList.remove('hidden');
            progressBar.style.width = '0%';

            try {
                const response = await fetch('gallery.php', {
                    method: 'POST',
                    body: formData
                });

                const result = await response.json();
                if (result.success) {
                    uploadStatus.textContent = result.message;
                    progressBar.style.width = '100%';
                    setTimeout(() => {
                        progress.classList.add('hidden');
                        location.reload(); // Reload to show new images
                    }, 1500);
                } else {
                    throw new Error(result.message || 'Upload failed');
                }
            } catch (error) {
                uploadStatus.textContent = error.message;
                uploadStatus.classList.remove('text-blue-700');
                uploadStatus.classList.add('text-red-700');
            }
        });

        // Handle image deletion
        function deleteImage(imageId) {
            if (!confirm('Are you sure you want to delete this image?')) return;

            fetch(`delete_gallery_image.php?id=${imageId}`, {
                method: 'DELETE'
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    const imageContainer = document.querySelector(`[data-id="${imageId}"]`);
                    imageContainer.remove();
                } else {
                    throw new Error(data.message || 'Failed to delete image');
                }
            })
            .catch(error => {
                alert(error.message);
            });
        }
    </script>
</body>
</html> 