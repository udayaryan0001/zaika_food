<?php
require_once 'config.php';
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Zaika-e-Handi - Authentic Indian Restaurant</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="https://unpkg.com/aos@next/dist/aos.css" />
    <style>
        html {
            scroll-behavior: smooth;
        }
        .hero-section {
            background: linear-gradient(rgba(0, 0, 0, 0.6), rgba(0, 0, 0, 0.6)), 
                        url('images/ilovepdf_pages-to-jpg (2)/premium_photo-1661432769134-758550b8fedb.jpeg');
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            min-height: 100vh;
        }
        .dish-card {
            transition: all 0.3s ease;
        }
        .dish-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 20px 25px -5px rgba(176, 16, 16, 0.1), 0 8px 10px -6px rgb(0 0 0 / 0.1);
        }
        .nav-link {
            position: relative;
        }
        .nav-link::after {
            content: '';
            position: absolute;
            width: 0;
            height: 2px;
            bottom: -2px;
            left: 0;
            background-color: #f97316;
            transition: width 0.3s ease;
        }
        .nav-link:hover::after {
            width: 100%;
        }
        .button-hover {
            transition: all 0.3s ease;
        }
        .button-hover:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 15px -3px rgb(249 115 22 / 0.3);
        }
        .gallery-img {
            transition: all 0.5s ease;
        }
        .gallery-img:hover {
            transform: scale(1.1) rotate(2deg);
        }
        @keyframes float {
            0% { transform: translateY(0px); }
            50% { transform: translateY(-10px); }
            100% { transform: translateY(0px); }
        }
        .float-animation {
            animation: float 3s ease-in-out infinite;
        }
        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        .fade-in-up {
            animation: fadeInUp 0.6s ease-out;
        }
    </style>
</head>
<body>
<!-- Navigation -->
<nav class="bg-white shadow-lg fixed w-full z-50">
    <div class="max-w-7xl mx-auto px-4">
        <div class="flex justify-between items-center h-20">
            <div class="flex items-center">
                <a href="index.php" class="text-3xl font-bold text-orange-600">
                    <span class="text-4xl">🍛</span> Zaika-e-Handi
                </a>
            </div>
            <div class="hidden md:flex items-center space-x-8">
                <a href="index.php" class="nav-link text-gray-700 hover:text-orange-600">Home</a>
                <a href="menu.php" class="nav-link text-gray-700 hover:text-orange-600">Menu</a>
                <?php if (isLoggedIn()): ?>
                    <div class="relative group">
                        <button class="nav-link text-gray-700 hover:text-orange-600 flex items-center">
                            <i class="fas fa-user mr-2"></i><?php echo htmlspecialchars($_SESSION['name']); ?> <i class="fas fa-chevron-down ml-1 text-sm"></i>
                        </button>
                        <div class="absolute right-0 mt-2 w-48 bg-white rounded-lg shadow-lg py-2 hidden group-hover:block">
                            <?php if (isAdmin()): ?>
                                <a href="dashboard.php" class="block px-4 py-2 text-gray-700 hover:bg-orange-50 hover:text-orange-600">
                                    <i class="fas fa-tachometer-alt mr-2"></i>Dashboard
                                </a>
                            <?php endif; ?>
                            <a href="profile.php" class="block px-4 py-2 text-gray-700 hover:bg-orange-50 hover:text-orange-600">
                                <i class="fas fa-user-circle mr-2"></i>Profile
                            </a>
                            <a href="orders.php" class="block px-4 py-2 text-gray-700 hover:bg-orange-50 hover:text-orange-600">
                                <i class="fas fa-shopping-bag mr-2"></i>Orders
                            </a>
                            <div class="border-t border-gray-100 my-1"></div>
                            <a href="logout.php" class="block px-4 py-2 text-gray-700 hover:bg-orange-50 hover:text-orange-600">
                                <i class="fas fa-sign-out-alt mr-2"></i>Logout
                            </a>
                        </div>
                    </div>
                <?php else: ?>
                    <div class="relative group">
                        <button class="nav-link text-gray-700 hover:text-orange-600 flex items-center">
                            Login <i class="fas fa-chevron-down ml-1 text-sm"></i>
                        </button>
                        <div class="absolute right-0 mt-2 w-48 bg-white rounded-lg shadow-lg py-2 hidden group-hover:block">
                            <a href="login.php?type=user" class="block px-4 py-2 text-gray-700 hover:bg-orange-50 hover:text-orange-600">
                                <i class="fas fa-user mr-2"></i>User Login
                            </a>
                            <a href="login.php?type=admin" class="block px-4 py-2 text-gray-700 hover:bg-orange-50 hover:text-orange-600">
                                <i class="fas fa-user-shield mr-2"></i>Admin Login
                            </a>
                        </div>
                    </div>
                    <a href="signup.php" class="bg-orange-600 text-white px-6 py-2 rounded-full hover:bg-orange-700 transform hover:scale-105 transition-all">
                        Sign Up
                    </a>
                <?php endif; ?>
            </div>
            <!-- Mobile menu button -->
            <div class="md:hidden">
                <button class="mobile-menu-button p-2" onclick="toggleMobileMenu()">
                    <i class="fas fa-bars text-gray-600 text-xl"></i>
                </button>
                <div class="mobile-menu hidden absolute top-20 left-0 w-full bg-white border-t border-gray-100">
                    <a href="index.php" class="block py-3 px-4 text-gray-700 hover:bg-orange-50 hover:text-orange-600">Home</a>
                    <a href="menu.php" class="block py-3 px-4 text-gray-700 hover:bg-orange-50 hover:text-orange-600">Menu</a>
                    <?php if (isLoggedIn()): ?>
                        <?php if (isAdmin()): ?>
                            <a href="dashboard.php" class="block py-3 px-4 text-gray-700 hover:bg-orange-50 hover:text-orange-600">
                                <i class="fas fa-tachometer-alt mr-2"></i>Dashboard
                            </a>
                        <?php endif; ?>
                        <a href="profile.php" class="block py-3 px-4 text-gray-700 hover:bg-orange-50 hover:text-orange-600">
                            <i class="fas fa-user-circle mr-2"></i>Profile
                        </a>
                        <a href="orders.php" class="block py-3 px-4 text-gray-700 hover:bg-orange-50 hover:text-orange-600">
                            <i class="fas fa-shopping-bag mr-2"></i>Orders
                        </a>
                        <div class="border-t border-gray-100"></div>
                        <a href="logout.php" class="block py-3 px-4 text-gray-700 hover:bg-orange-50 hover:text-orange-600">
                            <i class="fas fa-sign-out-alt mr-2"></i>Logout
                        </a>
                    <?php else: ?>
                        <div class="border-t border-gray-100">
                            <a href="login.php?type=user" class="block py-3 px-4 text-gray-700 hover:bg-orange-50 hover:text-orange-600">
                                <i class="fas fa-user mr-2"></i>User Login
                            </a>
                            <a href="login.php?type=admin" class="block py-3 px-4 text-gray-700 hover:bg-orange-50 hover:text-orange-600">
                                <i class="fas fa-user-shield mr-2"></i>Admin Login
                            </a>
                        </div>
                        <a href="signup.php" class="block py-3 px-4 text-gray-700 hover:bg-orange-50 hover:text-orange-600">Sign Up</a>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</nav>

<!-- Hero Section -->
<div class="relative h-screen">
    <div class="absolute inset-0 bg-cover bg-center" style="background-image: url('images/ilovepdf_pages-to-jpg (2)/premium_photo-1661432769134-758550b8fedb.jpeg');">
        <div class="absolute inset-0 bg-black opacity-50"></div>
    </div>
    <div class="relative h-full flex items-center justify-center text-center text-white px-4">
        <div class="max-w-3xl">
            <h1 class="text-5xl md:text-6xl font-bold mb-6">Welcome to Zaika-e-Handi</h1>
            <p class="text-xl md:text-2xl mb-8">Experience the authentic flavors of India in every bite</p>
            <a href="menu.php" class="bg-orange-600 text-white px-8 py-3 rounded-lg text-lg font-semibold hover:bg-orange-700 transition-colors">View Our Menu</a>
        </div>
    </div>
</div>

<!-- Featured Dishes Section -->
<section class="py-16 bg-gray-50">
    <div class="max-w-7xl mx-auto px-4">
        <h2 class="text-4xl font-bold text-center mb-12">Featured Dishes</h2>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            <!-- Featured Dish 1 -->
            <div class="bg-white rounded-lg shadow-lg overflow-hidden">
                <img src="images/ilovepdf_pages-to-jpg (2)/zaikabg.jpg" alt="Biryani" class="w-full h-64 object-cover">
                <div class="p-6">
                    <h3 class="text-xl font-bold mb-2">Special Biryani</h3>
                    <p class="text-gray-600 mb-4">Aromatic basmati rice cooked with tender meat and special spices</p>
                    <p class="text-orange-600 font-bold">₹299</p>
                </div>
            </div>
            <!-- Featured Dish 2 -->
            <div class="bg-white rounded-lg shadow-lg overflow-hidden">
                <img src="images/ilovepdf_pages-to-jpg (2)/f99886a97ba4e7b0aa4d8b33e00b060c.jpg" alt="Butter Chicken" class="w-full h-64 object-cover">
                <div class="p-6">
                    <h3 class="text-xl font-bold mb-2">Butter Chicken</h3>
                    <p class="text-gray-600 mb-4">Creamy tomato curry with tender chicken pieces</p>
                    <p class="text-orange-600 font-bold">₹349</p>
                </div>
            </div>
            <!-- Featured Dish 3 -->
            <div class="bg-white rounded-lg shadow-lg overflow-hidden">
                <img src="images/ilovepdf_pages-to-jpg (2)/zaikabg.jpg" alt="Paneer Tikka" class="w-full h-64 object-cover">
                <div class="p-6">
                    <h3 class="text-xl font-bold mb-2">Paneer Tikka</h3>
                    <p class="text-gray-600 mb-4">Grilled cottage cheese with aromatic spices</p>
                    <p class="text-orange-600 font-bold">₹249</p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Special Offers Section -->
<section class="py-16">
    <div class="max-w-7xl mx-auto px-4">
        <h2 class="text-4xl font-bold text-center mb-12">Special Offers</h2>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
            <!-- Offer 1 -->
            <div class="bg-orange-100 rounded-lg p-8">
                <h3 class="text-2xl font-bold text-orange-600 mb-4">Weekend Special</h3>
                <p class="text-gray-700 mb-4">20% off on family meals every weekend</p>
                <a href="menu.php" class="inline-block bg-orange-600 text-white px-6 py-2 rounded-lg hover:bg-orange-700 transition-colors">Order Now</a>
            </div>
            <!-- Offer 2 -->
            <div class="bg-orange-100 rounded-lg p-8">
                <h3 class="text-2xl font-bold text-orange-600 mb-4">Lunch Combo</h3>
                <p class="text-gray-700 mb-4">Get complimentary dessert with every lunch combo</p>
                <a href="menu.php" class="inline-block bg-orange-600 text-white px-6 py-2 rounded-lg hover:bg-orange-700 transition-colors">View Menu</a>
            </div>
        </div>
    </div>
</section>

<!-- Newsletter Section -->
<section class="py-20 bg-orange-600">
    <div class="max-w-7xl mx-auto px-4">
        <div class="text-center">
            <h2 class="text-4xl font-bold text-white mb-4">Stay Updated</h2>
            <p class="text-orange-100 mb-8">Subscribe to our newsletter for exclusive offers and updates</p>
            <form id="newsletterForm" class="max-w-md mx-auto">
                <div class="flex gap-4">
                    <input type="email" 
                           id="newsletterEmail"
                           placeholder="Enter your email" 
                           class="flex-1 px-6 py-3 rounded-full focus:outline-none focus:ring-2 focus:ring-orange-500">
                    <button type="submit" 
                            class="bg-white text-orange-600 px-8 py-3 rounded-full hover:bg-orange-50 transition-colors">
                        Subscribe
                    </button>
                </div>
                <p id="newsletterMessage" class="mt-4 text-sm text-white hidden"></p>
            </form>
            <div class="mt-8 max-w-md mx-auto">
                <button onclick="toggleSubscribersList()" 
                        class="text-white underline text-sm hover:text-orange-200">
                    Show Subscribers List
                </button>
                <div id="subscribersList" class="hidden mt-4 bg-white/10 rounded-lg p-4">
                    <h3 class="text-white font-semibold mb-2">Current Subscribers:</h3>
                    <ul id="subscribersListItems" class="text-left text-orange-50 text-sm space-y-1">
                    </ul>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Gallery Section -->
<section class="py-20 bg-gray-50">
    <div class="max-w-7xl mx-auto px-4">
        <h2 class="text-4xl font-bold text-center mb-4" data-aos="fade-up">Our Food Gallery</h2>
        <p class="text-gray-600 text-center mb-12" data-aos="fade-up" data-aos-delay="200">A feast for your eyes</p>
        <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
            <div class="relative overflow-hidden rounded-xl aspect-square" data-aos="zoom-in" data-aos-delay="0">
                <img src="images/ilovepdf_pages-to-jpg (2)/premium_photo-1661432769134-758550b8fedb.jpeg" 
                     alt="Gallery Image 1" 
                     class="gallery-img w-full h-full object-cover">
            </div>
            <div class="relative overflow-hidden rounded-xl aspect-square" data-aos="zoom-in" data-aos-delay="200">
                <img src="images/ilovepdf_pages-to-jpg (2)/zaika - e- handi restaurant menu_page-0002.jpg" 
                     alt="Gallery Image 2" 
                     class="gallery-img w-full h-full object-cover">
            </div>
            <div class="relative overflow-hidden rounded-xl aspect-square" data-aos="zoom-in" data-aos-delay="400">
                <img src="images/ilovepdf_pages-to-jpg (2)/zaika - e- handi restaurant menu_page-0003.jpg" 
                     alt="Gallery Image 3" 
                     class="gallery-img w-full h-full object-cover">
            </div>
            <div class="relative overflow-hidden rounded-xl aspect-square" data-aos="zoom-in" data-aos-delay="600">
                <img src="images/ilovepdf_pages-to-jpg (2)/zaika - e- handi restaurant menu_page-0004.jpg" 
                     alt="Gallery Image 4" 
                     class="gallery-img w-full h-full object-cover">
            </div>
        </div>
    </div>
</section>

<!-- Testimonials Section -->
<section class="py-20 bg-white">
    <div class="max-w-7xl mx-auto px-4">
        <h2 class="text-4xl font-bold text-center mb-4">What Our Customers Say</h2>
        <p class="text-gray-600 text-center mb-12">Don't just take our word for it</p>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            <div class="bg-gray-50 p-8 rounded-xl shadow-sm">
                <div class="text-orange-600 mb-4">
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                </div>
                <p class="text-gray-600 mb-6">"The best Indian food I've had outside of India. The flavors are authentic and the service is exceptional!"</p>
                <div class="flex items-center">
                    <div class="w-12 h-12 bg-orange-200 rounded-full flex items-center justify-center">
                        <span class="text-orange-600 font-bold">JD</span>
                    </div>
                    <div class="ml-4">
                        <h4 class="font-semibold">John Doe</h4>
                        <p class="text-gray-500 text-sm">Regular Customer</p>
                    </div>
                </div>
            </div>
            <div class="bg-gray-50 p-8 rounded-xl shadow-sm">
                <div class="text-orange-600 mb-4">
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                </div>
                <p class="text-gray-600 mb-6">"Their biryani is to die for! And the delivery is always on time. Highly recommended!"</p>
                <div class="flex items-center">
                    <div class="w-12 h-12 bg-orange-200 rounded-full flex items-center justify-center">
                        <span class="text-orange-600 font-bold">AS</span>
                    </div>
                    <div class="ml-4">
                        <h4 class="font-semibold">Alice Smith</h4>
                        <p class="text-gray-500 text-sm">Food Blogger</p>
                    </div>
                </div>
            </div>
            <div class="bg-gray-50 p-8 rounded-xl shadow-sm">
                <div class="text-orange-600 mb-4">
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                </div>
                <p class="text-gray-600 mb-6">"Perfect for family dinners! The portions are generous and the taste is consistently amazing."</p>
                <div class="flex items-center">
                    <div class="w-12 h-12 bg-orange-200 rounded-full flex items-center justify-center">
                        <span class="text-orange-600 font-bold">RK</span>
                    </div>
                    <div class="ml-4">
                        <h4 class="font-semibold">Robert King</h4>
                        <p class="text-gray-500 text-sm">Verified Customer</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Footer -->
<footer class="bg-gray-900 text-white py-12">
    <div class="max-w-7xl mx-auto px-4">
        <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
            <div>
                <h3 class="text-2xl font-bold mb-4 flex items-center">
                    <span class="text-3xl mr-2">🍛</span> Zaika-e-Handi
                </h3>
                <p class="text-gray-400">Bringing authentic Indian flavors to your table since 2024.</p>
            </div>
            <div>
                <h3 class="text-xl font-bold mb-4">Quick Links</h3>
                <ul class="space-y-2">
                    <li><a href="index.php" class="text-gray-400 hover:text-orange-600 transition-colors">Home</a></li>
                    <li><a href="menu.php" class="text-gray-400 hover:text-orange-600 transition-colors">Menu</a></li>
                    <li><a href="login.php" class="text-gray-400 hover:text-orange-600 transition-colors">Login</a></li>
                    <li><a href="signup.php" class="text-gray-400 hover:text-orange-600 transition-colors">Sign Up</a></li>
                </ul>
            </div>
            <div>
                <h3 class="text-xl font-bold mb-4">Contact Us</h3>
                <ul class="space-y-2 text-gray-400">
                    <li class="flex items-center">
                        <i class="fas fa-map-marker-alt mr-2"></i>
                        123 Restaurant Street, City
                    </li>
                    <li class="flex items-center">
                        <i class="fas fa-phone mr-2"></i>
                        (123) 456-7890
                    </li>
                    <li class="flex items-center">
                        <i class="fas fa-envelope mr-2"></i>
                        info@zaikaehandi.com
                    </li>
                </ul>
            </div>
            <div>
                <h3 class="text-xl font-bold mb-4">Opening Hours</h3>
                <ul class="space-y-2 text-gray-400">
                    <li>Monday - Friday: 11:00 AM - 10:00 PM</li>
                    <li>Saturday - Sunday: 10:00 AM - 11:00 PM</li>
                </ul>
            </div>
        </div>
        <div class="border-t border-gray-800 mt-12 pt-8 text-center">
            <div class="flex justify-center space-x-4 mb-4">
                <a href="#" class="text-gray-400 hover:text-orange-600 transition-colors">
                    <i class="fab fa-facebook-f"></i>
                </a>
                <a href="#" class="text-gray-400 hover:text-orange-600 transition-colors">
                    <i class="fab fa-instagram"></i>
                </a>
                <a href="#" class="text-gray-400 hover:text-orange-600 transition-colors">
                    <i class="fab fa-twitter"></i>
                </a>
            </div>
            <p class="text-gray-400">&copy; 2024 Zaika-e-Handi. All rights reserved.</p>
        </div>
    </div>
</footer>

<!-- Add AOS initialization script before closing body tag -->
<script src="https://unpkg.com/aos@next/dist/aos.js"></script>
<script>
    AOS.init({
        duration: 800,
        once: true,
        offset: 100,
        easing: 'ease-out-cubic'
    });

    // Mobile menu toggle
    function toggleMobileMenu() {
        const mobileMenu = document.querySelector('.mobile-menu');
        mobileMenu.classList.toggle('hidden');
    }

    // Close mobile menu when clicking outside
    document.addEventListener('click', function(event) {
        const mobileMenu = document.querySelector('.mobile-menu');
        const mobileMenuButton = document.querySelector('.mobile-menu-button');
        
        if (!mobileMenuButton.contains(event.target) && !mobileMenu.contains(event.target)) {
            mobileMenu.classList.add('hidden');
        }
    });

    function toggleSubscribersList() {
        const list = document.getElementById('subscribersList');
        const isHidden = list.classList.contains('hidden');
        
        if (isHidden) {
            fetchSubscribers();
            list.classList.remove('hidden');
        } else {
            list.classList.add('hidden');
        }
    }

    function fetchSubscribers() {
        fetch('php/get_subscribers.php')
            .then(response => response.json())
            .then(data => {
                const listElement = document.getElementById('subscribersListItems');
                
                if (!data.subscribers || data.subscribers.length === 0) {
                    listElement.innerHTML = '<li class="text-center">No subscribers yet</li>';
                    return;
                }
                
                listElement.innerHTML = data.subscribers
                    .map(email => `<li>📧 ${email}</li>`)
                    .join('');
            })
            .catch(error => {
                console.error('Error fetching subscribers:', error);
            });
    }

    document.getElementById('newsletterForm').addEventListener('submit', function(e) {
        e.preventDefault();
        
        const email = document.getElementById('newsletterEmail').value;
        const messageElement = document.getElementById('newsletterMessage');
        
        // Basic email validation
        if (!email || !/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email)) {
            messageElement.textContent = 'Please enter a valid email address';
            messageElement.classList.remove('hidden', 'text-green-200');
            messageElement.classList.add('text-yellow-200');
            return;
        }

        // Send subscription request to PHP backend
        fetch('php/subscribe.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify({ email: email })
        })
        .then(response => response.json())
        .then(data => {
            messageElement.textContent = data.message;
            messageElement.classList.remove('hidden');
            
            if (data.success) {
                messageElement.classList.remove('text-yellow-200');
                messageElement.classList.add('text-green-200');
                document.getElementById('newsletterEmail').value = ''; // Clear the input
                
                // Update the subscribers list if it's visible
                fetchSubscribers();
            } else {
                messageElement.classList.remove('text-green-200');
                messageElement.classList.add('text-yellow-200');
            }
        })
        .catch(error => {
            messageElement.textContent = 'An error occurred. Please try again later.';
            messageElement.classList.remove('hidden', 'text-green-200');
            messageElement.classList.add('text-yellow-200');
        });
    });
</script>
</body>
</html> 