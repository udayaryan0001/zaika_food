<?php
// Enable error reporting
error_reporting(E_ALL);
ini_set('display_errors', 1);

require_once 'config.php';

// Initialize $images array
$images = [];

// Check if gallery table exists
$table_exists = $conn->query("SHOW TABLES LIKE 'gallery'");
if ($table_exists->num_rows > 0) {
    // Table exists, fetch images
    $sql = "SELECT * FROM gallery ORDER BY uploaded_at DESC";
    $result = $conn->query($sql);
    if ($result) {
        $images = $result->fetch_all(MYSQLI_ASSOC);
    }
}

// If no images from database, use default images
if (empty($images)) {
    $images = [
        ['image_path' => 'images/ilovepdf_pages-to-jpg (2)/premium_photo-1661432769134-758550b8fedb.jpeg', 'caption' => 'Restaurant Ambiance'],
        ['image_path' => 'images/ilovepdf_pages-to-jpg (2)/Chicken-Biryani-Recipe01.jpg', 'caption' => 'Special Biryani'],
        ['image_path' => 'images/ilovepdf_pages-to-jpg (2)/butter-chicken-01.jpg', 'caption' => 'Butter Chicken'],
        ['image_path' => 'images/ilovepdf_pages-to-jpg (2)/Paneer-Tikka01.jpg', 'caption' => 'Paneer Tikka'],
        ['image_path' => 'images/ilovepdf_pages-to-jpg (2)/f99886a97ba4e7b0aa4d8b33e00b060c.jpg', 'caption' => 'Special Curry'],
        ['image_path' => 'images/ilovepdf_pages-to-jpg (2)/zaikabg.jpg', 'caption' => 'Signature Dish']
    ];
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Food Gallery - Zaika-e-Handi</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@fancyapps/ui@5.0/dist/fancybox/fancybox.css"/>
    <style>
        .gallery-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
            gap: 2rem;
            padding: 2rem;
        }
        .gallery-item {
            position: relative;
            overflow: hidden;
            border-radius: 1rem;
            box-shadow: 0 4px 6px -1px rgb(0 0 0 / 0.1), 0 2px 4px -2px rgb(0 0 0 / 0.1);
            aspect-ratio: 1;
        }
        .gallery-item img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.5s ease;
        }
        .gallery-item:hover img {
            transform: scale(1.1);
        }
        .gallery-item .overlay {
            position: absolute;
            bottom: 0;
            left: 0;
            right: 0;
            background: linear-gradient(to top, rgba(0,0,0,0.8), transparent);
            padding: 2rem 1rem 1rem;
            transform: translateY(100%);
            transition: transform 0.3s ease;
        }
        .gallery-item:hover .overlay {
            transform: translateY(0);
        }
        .hero-section {
            background-image: linear-gradient(rgba(0,0,0,0.5), rgba(0,0,0,0.5)), url('images/ilovepdf_pages-to-jpg (2)/premium_photo-1661432769134-758550b8fedb.jpeg');
            background-size: cover;
            background-position: center;
            height: 60vh;
            display: flex;
            align-items: center;
            justify-content: center;
            text-align: center;
            color: white;
            margin-top: 64px; /* Add margin to prevent overlap with fixed navbar */
        }
        .section-title {
            position: relative;
            display: inline-block;
            padding-bottom: 1rem;
            margin-bottom: 2rem;
        }
        .section-title::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 50%;
            transform: translateX(-50%);
            width: 80px;
            height: 3px;
            background-color: #f97316;
        }
    </style>
</head>
<body class="bg-gray-50">
    <!-- Navigation -->
    <nav class="bg-white shadow-lg fixed w-full top-0 z-50">
        <div class="max-w-7xl mx-auto px-4">
            <div class="flex justify-between h-16">
                <div class="flex items-center">
                    <a href="index.php" class="text-2xl font-bold text-orange-600">
                        <span class="text-4xl">🍛</span> Zaika-e-Handi
                    </a>
                </div>
                <div class="flex items-center space-x-4">
                    <a href="index.php" class="text-gray-600 hover:text-gray-900">Home</a>
                    <a href="menu.php" class="text-gray-600 hover:text-gray-900">Menu</a>
                    <a href="gallery.php" class="text-orange-600 font-semibold">Gallery</a>
                    <a href="login.php" class="text-gray-600 hover:text-gray-900">Login</a>
                </div>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <section class="hero-section">
        <div class="container mx-auto px-4">
            <h1 class="text-5xl font-bold mb-4">Our Food Gallery</h1>
            <p class="text-xl">Explore our delicious dishes through beautiful imagery</p>
        </div>
    </section>

    <!-- Gallery Section -->
    <section class="py-16">
        <div class="container mx-auto px-4">
            <h2 class="text-4xl font-bold text-center section-title">Culinary Delights</h2>
            
            <!-- Gallery Grid -->
            <div class="gallery-grid">
                <?php
                foreach ($images as $image):
                    $imagePath = isset($image['image_path']) ? $image['image_path'] : $image['path'];
                    $caption = isset($image['caption']) ? $image['caption'] : 'Delicious dish from Zaika-e-Handi';
                ?>
                <div class="gallery-item">
                    <a href="<?php echo htmlspecialchars($imagePath); ?>" 
                       data-fancybox="gallery"
                       data-caption="<?php echo htmlspecialchars($caption); ?>">
                        <img src="<?php echo htmlspecialchars($imagePath); ?>" 
                             alt="<?php echo htmlspecialchars($caption); ?>"
                             loading="lazy">
                        <div class="overlay">
                            <p class="text-white text-lg"><?php echo htmlspecialchars($caption); ?></p>
                        </div>
                    </a>
                </div>
                <?php endforeach; ?>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-gray-800 text-white py-12">
        <div class="container mx-auto px-4">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <div>
                    <h3 class="text-2xl font-bold mb-4">Zaika-e-Handi</h3>
                    <p class="text-gray-400">Experience the finest Indian cuisine with our carefully curated menu and elegant ambiance.</p>
                </div>
                <div>
                    <h3 class="text-xl font-bold mb-4">Quick Links</h3>
                    <ul class="space-y-2">
                        <li><a href="index.php" class="text-gray-400 hover:text-white">Home</a></li>
                        <li><a href="menu.php" class="text-gray-400 hover:text-white">Menu</a></li>
                        <li><a href="gallery.php" class="text-gray-400 hover:text-white">Gallery</a></li>
                        <li><a href="login.php" class="text-gray-400 hover:text-white">Login</a></li>
                    </ul>
                </div>
                <div>
                    <h3 class="text-xl font-bold mb-4">Contact Us</h3>
                    <ul class="space-y-2 text-gray-400">
                        <li><i class="fas fa-phone mr-2"></i> +1 234 567 890</li>
                        <li><i class="fas fa-envelope mr-2"></i> info@zaikahandi.com</li>
                        <li><i class="fas fa-map-marker-alt mr-2"></i> 123 Restaurant Street, City</li>
                    </ul>
                </div>
            </div>
            <div class="border-t border-gray-700 mt-8 pt-8 text-center text-gray-400">
                <p>&copy; 2024 Zaika-e-Handi. All rights reserved.</p>
            </div>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/@fancyapps/ui@5.0/dist/fancybox/fancybox.umd.js"></script>
    <script>
        // Initialize Fancybox with updated options
        Fancybox.bind('[data-fancybox="gallery"]', {
            Toolbar: {
                display: [
                    "zoom",
                    "slideshow",
                    "fullscreen",
                    "close",
                ],
            },
            Carousel: {
                infinite: true,
            },
            Thumbs: {
                autoStart: true,
            },
        });
    </script>
</body>
</html> 