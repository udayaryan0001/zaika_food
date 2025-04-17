<?php
if (!isset($_SESSION)) {
    session_start();
}
?>
<nav class="bg-white shadow-lg fixed w-full z-50">
    <div class="max-w-7xl mx-auto px-4">
        <div class="flex justify-between items-center h-20">
            <div class="flex items-center">
                <a href="index.php" class="text-3xl font-bold text-orange-600">
                    <span class="text-4xl">🍛</span> Zaika-e-Handi
                </a>
            </div>
            <div class="hidden md:flex items-center space-x-8">
                <a href="index.php" class="text-gray-600 hover:text-gray-900">Home</a>
                <a href="menu.php" class="text-gray-600 hover:text-gray-900">Menu</a>
                <a href="gallery.php" class="text-gray-600 hover:text-gray-900">Gallery</a>
                <?php if (isLoggedIn()): ?>
                    <div class="relative group">
                        <button class="text-gray-700 hover:text-orange-600 flex items-center">
                            <i class="fas fa-user mr-2"></i><?php echo htmlspecialchars($_SESSION['name']); ?>
                            <i class="fas fa-chevron-down ml-1 text-sm"></i>
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
                    <a href="login.php" class="text-gray-600 hover:text-gray-900">Login</a>
                    <a href="signup.php" class="bg-orange-600 text-white px-6 py-2 rounded-full hover:bg-orange-700">
                        Sign Up
                    </a>
                <?php endif; ?>
                <a href="cart.php" class="relative">
                    <i class="fas fa-shopping-cart text-2xl text-orange-600"></i>
                    <?php if (isset($_SESSION['cart']) && count($_SESSION['cart']) > 0): ?>
                        <span class="absolute -top-2 -right-2 bg-red-500 text-white rounded-full w-5 h-5 flex items-center justify-center text-xs">
                            <?= getCartItemCount() ?>
                        </span>
                    <?php endif; ?>
                </a>
            </div>
            <!-- Mobile menu button -->
            <div class="md:hidden">
                <button class="mobile-menu-button p-2" onclick="toggleMobileMenu()">
                    <i class="fas fa-bars text-gray-600 text-xl"></i>
                </button>
            </div>
        </div>
    </div>
    <!-- Mobile menu -->
    <div class="mobile-menu hidden md:hidden bg-white border-t border-gray-100">
        <a href="index.php" class="block py-3 px-4 text-gray-700 hover:bg-orange-50 hover:text-orange-600">Home</a>
        <a href="menu.php" class="block py-3 px-4 text-gray-700 hover:bg-orange-50 hover:text-orange-600">Menu</a>
        <a href="gallery.php" class="block py-3 px-4 text-gray-700 hover:bg-orange-50 hover:text-orange-600">Gallery</a>
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
            <a href="logout.php" class="block py-3 px-4 text-gray-700 hover:bg-orange-50 hover:text-orange-600">
                <i class="fas fa-sign-out-alt mr-2"></i>Logout
            </a>
        <?php else: ?>
            <a href="login.php" class="block py-3 px-4 text-gray-700 hover:bg-orange-50 hover:text-orange-600">Login</a>
            <a href="signup.php" class="block py-3 px-4 text-gray-700 hover:bg-orange-50 hover:text-orange-600">Sign Up</a>
        <?php endif; ?>
        <a href="cart.php" class="block py-3 px-4 text-gray-700 hover:bg-orange-50 hover:text-orange-600">
            <i class="fas fa-shopping-cart mr-2"></i>Cart (<?= getCartItemCount() ?>)
        </a>
    </div>
</nav>
<script>
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
</script> 