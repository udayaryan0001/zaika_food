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
    <!-- Navigation -->
    <nav class="bg-white shadow-lg fixed w-full z-50">
        <div class="max-w-7xl mx-auto px-4">
            <div class="flex justify-between items-center h-20">
                <div class="flex items-center">
                    <a href="index.html" class="text-3xl font-bold text-orange-600">
                        <span class="text-4xl">🍛</span> Zaika-e-Handi
                    </a>
                </div>
                <div class="hidden md:flex items-center space-x-8">
                    <a href="index.html" class="text-gray-700 hover:text-orange-600">Home</a>
                    <a href="#starters" class="text-gray-700 hover:text-orange-600">Starters</a>
                    <a href="#main-course" class="text-gray-700 hover:text-orange-600">Main Course</a>
                    <a href="#biryani" class="text-gray-700 hover:text-orange-600">Biryani</a>
                    <button onclick="toggleCart()" class="relative">
                        <i class="fas fa-shopping-cart text-2xl text-orange-600"></i>
                        <span id="cart-count" class="absolute -top-2 -right-2 bg-red-500 text-white rounded-full w-5 h-5 flex items-center justify-center text-xs">0</span>
                    </button>
                </div>
            </div>
        </div>
    </nav>

    <!-- Menu Header -->
    <div class="pt-32 pb-10 bg-orange-50">
        <div class="max-w-7xl mx-auto px-4">
            <h1 class="text-5xl font-bold text-center mb-4" data-aos="fade-up">Our Menu</h1>
            <p class="text-gray-600 text-center max-w-2xl mx-auto" data-aos="fade-up" data-aos-delay="200">
                Discover our authentic Indian dishes made with love and tradition
            </p>
        </div>
    </div>

    <!-- Menu Categories -->
    <div class="sticky top-20 z-40 bg-white shadow-sm">
        <div class="max-w-7xl mx-auto px-4">
            <div class="flex justify-center space-x-4 py-4">
                <a href="#starters" class="px-6 py-2 rounded-full bg-orange-100 text-orange-600 hover:bg-orange-200">Starters</a>
                <a href="#main-course" class="px-6 py-2 rounded-full bg-orange-100 text-orange-600 hover:bg-orange-200">Main Course</a>
                <a href="#biryani" class="px-6 py-2 rounded-full bg-orange-100 text-orange-600 hover:bg-orange-200">Biryani</a>
            </div>
        </div>
    </div>

    <!-- Menu Sections -->
    <div class="max-w-7xl mx-auto px-4 py-12">
        <!-- Starters Section -->
        <section id="starters" class="menu-section mb-16" data-aos="fade-up">
            <h2 class="text-3xl font-bold mb-8">Starters</h2>
            <div class="flex overflow-x-auto gap-6 pb-4">
                <!-- Starter Items -->
                <div class="bg-white rounded-xl shadow-lg overflow-hidden min-w-[300px]">
                    <img src="images/ilovepdf_pages-to-jpg (2)/zaika - e- handi restaurant menu_page-0002.jpg" 
                         alt="Paneer Tikka" 
                         class="w-full h-48 object-cover">
                    <div class="p-6">
                        <h3 class="text-xl font-semibold mb-2">Paneer Tikka</h3>
                        <p class="text-gray-600 mb-4">Marinated cottage cheese grilled to perfection</p>
                        <div class="flex justify-between items-center">
                            <span class="text-2xl font-bold text-orange-600">₹249</span>
                            <button onclick="addToCart('Paneer Tikka', 249)" 
                                    class="bg-orange-600 text-white px-4 py-2 rounded-full hover:bg-orange-700">
                                Add to Cart
                            </button>
                        </div>
                    </div>
                </div>
                <div class="bg-white rounded-xl shadow-lg overflow-hidden min-w-[300px]">
                    <img src="images/ilovepdf_pages-to-jpg (2)/zaika - e- handi restaurant menu_page-0002.jpg" 
                         alt="Chicken Tikka" 
                         class="w-full h-48 object-cover">
                    <div class="p-6">
                        <h3 class="text-xl font-semibold mb-2">Chicken Tikka</h3>
                        <p class="text-gray-600 mb-4">Tender chicken pieces marinated and grilled</p>
                        <div class="flex justify-between items-center">
                            <span class="text-2xl font-bold text-orange-600">₹299</span>
                            <button onclick="addToCart('Chicken Tikka', 299)" 
                                    class="bg-orange-600 text-white px-4 py-2 rounded-full hover:bg-orange-700">
                                Add to Cart
                            </button>
                        </div>
                    </div>
                </div>
                <div class="bg-white rounded-xl shadow-lg overflow-hidden min-w-[300px]">
                    <img src="images/ilovepdf_pages-to-jpg (2)/zaika - e- handi restaurant menu_page-0002.jpg" 
                         alt="Fish Tikka" 
                         class="w-full h-48 object-cover">
                    <div class="p-6">
                        <h3 class="text-xl font-semibold mb-2">Fish Tikka</h3>
                        <p class="text-gray-600 mb-4">Fresh fish marinated in spices and grilled</p>
                        <div class="flex justify-between items-center">
                            <span class="text-2xl font-bold text-orange-600">₹349</span>
                            <button onclick="addToCart('Fish Tikka', 349)" 
                                    class="bg-orange-600 text-white px-4 py-2 rounded-full hover:bg-orange-700">
                                Add to Cart
                            </button>
                        </div>
                    </div>
                </div>
                <div class="bg-white rounded-xl shadow-lg overflow-hidden min-w-[300px]">
                    <img src="images/ilovepdf_pages-to-jpg (2)/zaika - e- handi restaurant menu_page-0002.jpg" 
                         alt="Seekh Kebab" 
                         class="w-full h-48 object-cover">
                    <div class="p-6">
                        <h3 class="text-xl font-semibold mb-2">Seekh Kebab</h3>
                        <p class="text-gray-600 mb-4">Minced meat skewers with herbs and spices</p>
                        <div class="flex justify-between items-center">
                            <span class="text-2xl font-bold text-orange-600">₹329</span>
                            <button onclick="addToCart('Seekh Kebab', 329)" 
                                    class="bg-orange-600 text-white px-4 py-2 rounded-full hover:bg-orange-700">
                                Add to Cart
                            </button>
                        </div>
                    </div>
                </div>
                <div class="bg-white rounded-xl shadow-lg overflow-hidden min-w-[300px]">
                    <img src="images/ilovepdf_pages-to-jpg (2)/zaika - e- handi restaurant menu_page-0002.jpg" 
                         alt="Tandoori Mushroom" 
                         class="w-full h-48 object-cover">
                    <div class="p-6">
                        <h3 class="text-xl font-semibold mb-2">Tandoori Mushroom</h3>
                        <p class="text-gray-600 mb-4">Grilled mushrooms with Indian spices</p>
                        <div class="flex justify-between items-center">
                            <span class="text-2xl font-bold text-orange-600">₹279</span>
                            <button onclick="addToCart('Tandoori Mushroom', 279)" 
                                    class="bg-orange-600 text-white px-4 py-2 rounded-full hover:bg-orange-700">
                                Add to Cart
                            </button>
                        </div>
                    </div>
                </div>
                <!-- Additional Starters -->
                <div class="bg-white rounded-xl shadow-lg overflow-hidden min-w-[300px]">
                    <img src="images/ilovepdf_pages-to-jpg (2)/zaika - e- handi restaurant menu_page-0002.jpg" 
                         alt="Hara Bhara Kebab" 
                         class="w-full h-48 object-cover">
                    <div class="p-6">
                        <h3 class="text-xl font-semibold mb-2">Hara Bhara Kebab</h3>
                        <p class="text-gray-600 mb-4">Vegetable patties with spinach and herbs</p>
                        <div class="flex justify-between items-center">
                            <span class="text-2xl font-bold text-orange-600">₹229</span>
                            <button onclick="addToCart('Hara Bhara Kebab', 229)" 
                                    class="bg-orange-600 text-white px-4 py-2 rounded-full hover:bg-orange-700">
                                Add to Cart
                            </button>
                        </div>
                    </div>
                </div>
                <div class="bg-white rounded-xl shadow-lg overflow-hidden min-w-[300px]">
                    <img src="images/ilovepdf_pages-to-jpg (2)/zaika - e- handi restaurant menu_page-0002.jpg" 
                         alt="Malai Tikka" 
                         class="w-full h-48 object-cover">
                    <div class="p-6">
                        <h3 class="text-xl font-semibold mb-2">Malai Tikka</h3>
                        <p class="text-gray-600 mb-4">Creamy marinated chicken tikka</p>
                        <div class="flex justify-between items-center">
                            <span class="text-2xl font-bold text-orange-600">₹319</span>
                            <button onclick="addToCart('Malai Tikka', 319)" 
                                    class="bg-orange-600 text-white px-4 py-2 rounded-full hover:bg-orange-700">
                                Add to Cart
                            </button>
                        </div>
                    </div>
                </div>
                <!-- Add more starter items here -->
            </div>
        </section>

        <!-- Main Course Section -->
        <section id="main-course" class="menu-section mb-16" data-aos="fade-up">
            <h2 class="text-3xl font-bold mb-8">Main Course</h2>
            <div class="flex overflow-x-auto gap-6 pb-4">
                <!-- Main Course Items -->
                <div class="bg-white rounded-xl shadow-lg overflow-hidden min-w-[300px]">
                    <img src="images/ilovepdf_pages-to-jpg (2)/zaika - e- handi restaurant menu_page-0003.jpg" 
                         alt="Butter Chicken" 
                         class="w-full h-48 object-cover">
                    <div class="p-6">
                        <h3 class="text-xl font-semibold mb-2">Butter Chicken</h3>
                        <p class="text-gray-600 mb-4">Tender chicken in rich tomato gravy</p>
                        <div class="flex justify-between items-center">
                            <span class="text-2xl font-bold text-orange-600">₹349</span>
                            <button onclick="addToCart('Butter Chicken', 349)" 
                                    class="bg-orange-600 text-white px-4 py-2 rounded-full hover:bg-orange-700">
                                Add to Cart
                            </button>
                        </div>
                    </div>
                </div>
                <div class="bg-white rounded-xl shadow-lg overflow-hidden min-w-[300px]">
                    <img src="images/ilovepdf_pages-to-jpg (2)/zaika - e- handi restaurant menu_page-0003.jpg" 
                         alt="Paneer Butter Masala" 
                         class="w-full h-48 object-cover">
                    <div class="p-6">
                        <h3 class="text-xl font-semibold mb-2">Paneer Butter Masala</h3>
                        <p class="text-gray-600 mb-4">Cottage cheese in creamy tomato gravy</p>
                        <div class="flex justify-between items-center">
                            <span class="text-2xl font-bold text-orange-600">₹299</span>
                            <button onclick="addToCart('Paneer Butter Masala', 299)" 
                                    class="bg-orange-600 text-white px-4 py-2 rounded-full hover:bg-orange-700">
                                Add to Cart
                            </button>
                        </div>
                    </div>
                </div>
                <div class="bg-white rounded-xl shadow-lg overflow-hidden min-w-[300px]">
                    <img src="images/ilovepdf_pages-to-jpg (2)/zaika - e- handi restaurant menu_page-0003.jpg" 
                         alt="Dal Makhani" 
                         class="w-full h-48 object-cover">
                    <div class="p-6">
                        <h3 class="text-xl font-semibold mb-2">Dal Makhani</h3>
                        <p class="text-gray-600 mb-4">Creamy black lentils cooked overnight</p>
                        <div class="flex justify-between items-center">
                            <span class="text-2xl font-bold text-orange-600">₹249</span>
                            <button onclick="addToCart('Dal Makhani', 249)" 
                                    class="bg-orange-600 text-white px-4 py-2 rounded-full hover:bg-orange-700">
                                Add to Cart
                            </button>
                        </div>
                    </div>
                </div>
                <div class="bg-white rounded-xl shadow-lg overflow-hidden min-w-[300px]">
                    <img src="images/ilovepdf_pages-to-jpg (2)/zaika - e- handi restaurant menu_page-0003.jpg" 
                         alt="Chicken Curry" 
                         class="w-full h-48 object-cover">
                    <div class="p-6">
                        <h3 class="text-xl font-semibold mb-2">Chicken Curry</h3>
                        <p class="text-gray-600 mb-4">Traditional Indian chicken curry</p>
                        <div class="flex justify-between items-center">
                            <span class="text-2xl font-bold text-orange-600">₹329</span>
                            <button onclick="addToCart('Chicken Curry', 329)" 
                                    class="bg-orange-600 text-white px-4 py-2 rounded-full hover:bg-orange-700">
                                Add to Cart
                            </button>
                        </div>
                    </div>
                </div>
                <div class="bg-white rounded-xl shadow-lg overflow-hidden min-w-[300px]">
                    <img src="images/ilovepdf_pages-to-jpg (2)/zaika - e- handi restaurant menu_page-0003.jpg" 
                         alt="Palak Paneer" 
                         class="w-full h-48 object-cover">
                    <div class="p-6">
                        <h3 class="text-xl font-semibold mb-2">Palak Paneer</h3>
                        <p class="text-gray-600 mb-4">Cottage cheese in spinach gravy</p>
                        <div class="flex justify-between items-center">
                            <span class="text-2xl font-bold text-orange-600">₹289</span>
                            <button onclick="addToCart('Palak Paneer', 289)" 
                                    class="bg-orange-600 text-white px-4 py-2 rounded-full hover:bg-orange-700">
                                Add to Cart
                            </button>
                        </div>
                    </div>
                </div>
                <!-- Additional Main Course -->
                <div class="bg-white rounded-xl shadow-lg overflow-hidden min-w-[300px]">
                    <img src="images/ilovepdf_pages-to-jpg (2)/zaika - e- handi restaurant menu_page-0003.jpg" 
                         alt="Kadai Chicken" 
                         class="w-full h-48 object-cover">
                    <div class="p-6">
                        <h3 class="text-xl font-semibold mb-2">Kadai Chicken</h3>
                        <p class="text-gray-600 mb-4">Spicy chicken with bell peppers</p>
                        <div class="flex justify-between items-center">
                            <span class="text-2xl font-bold text-orange-600">₹339</span>
                            <button onclick="addToCart('Kadai Chicken', 339)" 
                                    class="bg-orange-600 text-white px-4 py-2 rounded-full hover:bg-orange-700">
                                Add to Cart
                            </button>
                        </div>
                    </div>
                </div>
                <div class="bg-white rounded-xl shadow-lg overflow-hidden min-w-[300px]">
                    <img src="images/ilovepdf_pages-to-jpg (2)/zaika - e- handi restaurant menu_page-0003.jpg" 
                         alt="Malai Kofta" 
                         class="w-full h-48 object-cover">
                    <div class="p-6">
                        <h3 class="text-xl font-semibold mb-2">Malai Kofta</h3>
                        <p class="text-gray-600 mb-4">Cheese dumplings in rich gravy</p>
                        <div class="flex justify-between items-center">
                            <span class="text-2xl font-bold text-orange-600">₹299</span>
                            <button onclick="addToCart('Malai Kofta', 299)" 
                                    class="bg-orange-600 text-white px-4 py-2 rounded-full hover:bg-orange-700">
                                Add to Cart
                            </button>
                        </div>
                    </div>
                </div>
                <!-- Add more main course items here -->
            </div>
        </section>

        <!-- Biryani Section -->
        <section id="biryani" class="menu-section" data-aos="fade-up">
            <h2 class="text-3xl font-bold mb-8">Biryani</h2>
            <div class="flex overflow-x-auto gap-6 pb-4">
                <!-- Biryani Items -->
                <div class="bg-white rounded-xl shadow-lg overflow-hidden min-w-[300px]">
                    <img src="images/ilovepdf_pages-to-jpg (2)/zaika - e- handi restaurant menu_page-0004.jpg" 
                         alt="Hyderabadi Biryani" 
                         class="w-full h-48 object-cover">
                    <div class="p-6">
                        <h3 class="text-xl font-semibold mb-2">Hyderabadi Biryani</h3>
                        <p class="text-gray-600 mb-4">Aromatic rice with tender meat and spices</p>
                        <div class="flex justify-between items-center">
                            <span class="text-2xl font-bold text-orange-600">₹399</span>
                            <button onclick="addToCart('Hyderabadi Biryani', 399)" 
                                    class="bg-orange-600 text-white px-4 py-2 rounded-full hover:bg-orange-700">
                                Add to Cart
                            </button>
                        </div>
                    </div>
                </div>
                <div class="bg-white rounded-xl shadow-lg overflow-hidden min-w-[300px]">
                    <img src="images/ilovepdf_pages-to-jpg (2)/zaika - e- handi restaurant menu_page-0004.jpg" 
                         alt="Chicken Biryani" 
                         class="w-full h-48 object-cover">
                    <div class="p-6">
                        <h3 class="text-xl font-semibold mb-2">Chicken Biryani</h3>
                        <p class="text-gray-600 mb-4">Classic chicken biryani with long grain rice</p>
                        <div class="flex justify-between items-center">
                            <span class="text-2xl font-bold text-orange-600">₹349</span>
                            <button onclick="addToCart('Chicken Biryani', 349)" 
                                    class="bg-orange-600 text-white px-4 py-2 rounded-full hover:bg-orange-700">
                                Add to Cart
                            </button>
                        </div>
                    </div>
                </div>
                <div class="bg-white rounded-xl shadow-lg overflow-hidden min-w-[300px]">
                    <img src="images/ilovepdf_pages-to-jpg (2)/zaika - e- handi restaurant menu_page-0004.jpg" 
                         alt="Veg Biryani" 
                         class="w-full h-48 object-cover">
                    <div class="p-6">
                        <h3 class="text-xl font-semibold mb-2">Veg Biryani</h3>
                        <p class="text-gray-600 mb-4">Mixed vegetables cooked with aromatic rice</p>
                        <div class="flex justify-between items-center">
                            <span class="text-2xl font-bold text-orange-600">₹299</span>
                            <button onclick="addToCart('Veg Biryani', 299)" 
                                    class="bg-orange-600 text-white px-4 py-2 rounded-full hover:bg-orange-700">
                                Add to Cart
                            </button>
                        </div>
                    </div>
                </div>
                <div class="bg-white rounded-xl shadow-lg overflow-hidden min-w-[300px]">
                    <img src="images/ilovepdf_pages-to-jpg (2)/zaika - e- handi restaurant menu_page-0004.jpg" 
                         alt="Mutton Biryani" 
                         class="w-full h-48 object-cover">
                    <div class="p-6">
                        <h3 class="text-xl font-semibold mb-2">Mutton Biryani</h3>
                        <p class="text-gray-600 mb-4">Tender mutton pieces with fragrant rice</p>
                        <div class="flex justify-between items-center">
                            <span class="text-2xl font-bold text-orange-600">₹449</span>
                            <button onclick="addToCart('Mutton Biryani', 449)" 
                                    class="bg-orange-600 text-white px-4 py-2 rounded-full hover:bg-orange-700">
                                Add to Cart
                            </button>
                        </div>
                    </div>
                </div>
                <div class="bg-white rounded-xl shadow-lg overflow-hidden min-w-[300px]">
                    <img src="images/ilovepdf_pages-to-jpg (2)/zaika - e- handi restaurant menu_page-0004.jpg" 
                         alt="Egg Biryani" 
                         class="w-full h-48 object-cover">
                    <div class="p-6">
                        <h3 class="text-xl font-semibold mb-2">Egg Biryani</h3>
                        <p class="text-gray-600 mb-4">Flavorful rice with boiled eggs</p>
                        <div class="flex justify-between items-center">
                            <span class="text-2xl font-bold text-orange-600">₹279</span>
                            <button onclick="addToCart('Egg Biryani', 279)" 
                                    class="bg-orange-600 text-white px-4 py-2 rounded-full hover:bg-orange-700">
                                Add to Cart
                            </button>
                        </div>
                    </div>
                </div>
                <!-- Additional Biryani -->
                <div class="bg-white rounded-xl shadow-lg overflow-hidden min-w-[300px]">
                    <img src="images/ilovepdf_pages-to-jpg (2)/zaika - e- handi restaurant menu_page-0004.jpg" 
                         alt="Prawn Biryani" 
                         class="w-full h-48 object-cover">
                    <div class="p-6">
                        <h3 class="text-xl font-semibold mb-2">Prawn Biryani</h3>
                        <p class="text-gray-600 mb-4">Seafood biryani with aromatic rice</p>
                        <div class="flex justify-between items-center">
                            <span class="text-2xl font-bold text-orange-600">₹469</span>
                            <button onclick="addToCart('Prawn Biryani', 469)" 
                                    class="bg-orange-600 text-white px-4 py-2 rounded-full hover:bg-orange-700">
                                Add to Cart
                            </button>
                        </div>
                    </div>
                </div>
                <div class="bg-white rounded-xl shadow-lg overflow-hidden min-w-[300px]">
                    <img src="images/ilovepdf_pages-to-jpg (2)/zaika - e- handi restaurant menu_page-0004.jpg" 
                         alt="Mushroom Biryani" 
                         class="w-full h-48 object-cover">
                    <div class="p-6">
                        <h3 class="text-xl font-semibold mb-2">Mushroom Biryani</h3>
                        <p class="text-gray-600 mb-4">Fragrant rice with mushrooms</p>
                        <div class="flex justify-between items-center">
                            <span class="text-2xl font-bold text-orange-600">₹289</span>
                            <button onclick="addToCart('Mushroom Biryani', 289)" 
                                    class="bg-orange-600 text-white px-4 py-2 rounded-full hover:bg-orange-700">
                                Add to Cart
                            </button>
                        </div>
                    </div>
                </div>
                <!-- Add more biryani items here -->
            </div>
        </section>
    </div>

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