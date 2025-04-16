<?php
session_start();
require_once 'config.php';

$error = '';
$login_type = isset($_GET['type']) ? $_GET['type'] : 'user';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $conn->real_escape_string($_POST['email']);
    $password = $_POST['password'];
    $type = $_POST['login_type'];
    
    // Prepare and execute the query with role check
    $sql = "SELECT id, name, email, password, role FROM users WHERE email = ?";
    if ($type === 'admin') {
        $sql .= " AND role = 'admin'";
    }
    
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows == 1) {
        $user = $result->fetch_assoc();
        
        // Special case for default admin
        if ($type === 'admin' && $email === 'admin@zaika.com' && $password === 'password') {
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['user_name'] = 'Admin';
            $_SESSION['user_email'] = $email;
            $_SESSION['user_role'] = 'admin';
            header("Location: dashboard.php");
            exit();
        }
        
        // Verify password for other users
        if ($password === $user['password']) { // For now using plain password comparison
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['user_name'] = $user['name'];
            $_SESSION['user_email'] = $user['email'];
            $_SESSION['user_role'] = $user['role'];
            
            if ($user['role'] === 'admin') {
                header("Location: dashboard.php");
            } else {
                header("Location: index.php");
            }
            exit();
        } else {
            $error = "Invalid password";
        }
    } else {
        $error = $type === 'admin' ? 'Invalid admin credentials' : 'Invalid user credentials';
    }
    
    $stmt->close();
}

// Debug: Show current session data
error_log("Current session data: " . print_r($_SESSION, true));
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $login_type === 'admin' ? 'Admin Login' : 'User Login'; ?> - Zaika-e-Handi</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        .login-container {
            background: linear-gradient(rgba(0, 0, 0, 0.6), rgba(0, 0, 0, 0.6)), 
                        url('images/ilovepdf_pages-to-jpg (2)/premium_photo-1661432769134-758550b8fedb.jpeg');
            background-size: cover;
            background-position: center;
            min-height: 100vh;
        }
    </style>
</head>
<body class="bg-gray-100">
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
                    <a href="index.php" class="text-gray-700 hover:text-orange-600">Home</a>
                    <a href="menu.php" class="text-gray-700 hover:text-orange-600">Menu</a>
                    <a href="signup.php" class="bg-orange-600 text-white px-4 py-2 rounded-lg hover:bg-orange-700 transition-colors">Sign Up</a>
                </div>
            </div>
        </div>
    </nav>

    <div class="login-container flex items-center justify-center px-4">
        <div class="bg-white rounded-2xl shadow-2xl w-full max-w-md p-8 relative">
            <div class="text-center mb-8">
                <h2 class="text-3xl font-bold text-orange-600">
                    <span class="text-4xl">🍛</span> Zaika-e-Handi
                </h2>
                <p class="text-gray-600 mt-2"><?php echo $login_type === 'admin' ? 'Admin Dashboard Access' : 'Welcome back! Please login to your account'; ?></p>
            </div>

            <!-- Login Type Toggle -->
            <div class="flex rounded-lg bg-gray-100 p-1 mb-6">
                <a href="?type=user" 
                   class="flex-1 text-center py-2 rounded-lg <?php echo $login_type === 'user' ? 'bg-white shadow-md' : 'text-gray-600 hover:text-gray-800' ?>">
                    <i class="fas fa-user mr-2"></i>User Login
                </a>
                <a href="?type=admin" 
                   class="flex-1 text-center py-2 rounded-lg <?php echo $login_type === 'admin' ? 'bg-white shadow-md' : 'text-gray-600 hover:text-gray-800' ?>">
                    <i class="fas fa-user-shield mr-2"></i>Admin Login
                </a>
            </div>

            <?php if($error): ?>
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
                    <?php echo $error; ?>
                </div>
            <?php endif; ?>

            <form method="POST" class="space-y-6">
                <input type="hidden" name="login_type" value="<?php echo $login_type; ?>">
                
                <div>
                    <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                    <div class="relative">
                        <span class="absolute inset-y-0 left-0 pl-3 flex items-center text-gray-500">
                            <i class="fas fa-envelope"></i>
                        </span>
                        <input type="email" id="email" name="email" required
                               class="w-full pl-10 pr-4 py-3 border rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-orange-500" 
                               placeholder="Enter your email">
                    </div>
                </div>

                <div>
                    <label for="password" class="block text-sm font-medium text-gray-700 mb-1">Password</label>
                    <div class="relative">
                        <span class="absolute inset-y-0 left-0 pl-3 flex items-center text-gray-500">
                            <i class="fas fa-lock"></i>
                        </span>
                        <input type="password" id="password" name="password" required
                               class="w-full pl-10 pr-12 py-3 border rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-orange-500" 
                               placeholder="Enter your password">
                        <button type="button" onclick="togglePassword()"
                                class="absolute inset-y-0 right-0 pr-3 flex items-center text-gray-500 hover:text-gray-700">
                            <i class="fas fa-eye" id="toggleIcon"></i>
                        </button>
                    </div>
                </div>

                <div class="flex items-center justify-between">
                    <div class="flex items-center">
                        <input type="checkbox" id="remember" name="remember" class="h-4 w-4 text-orange-600 rounded">
                        <label for="remember" class="ml-2 text-sm text-gray-600">Remember me</label>
                    </div>
                    <a href="#" class="text-sm text-orange-600 hover:text-orange-700">Forgot Password?</a>
                </div>

                <button type="submit" 
                        class="w-full bg-orange-600 text-white py-3 rounded-lg hover:bg-orange-700 transition-colors font-medium">
                    <?php echo $login_type === 'admin' ? 'Login as Admin' : 'Login'; ?>
                </button>
            </form>

            <?php if($login_type === 'user'): ?>
                <div class="mt-6 text-center">
                    <p class="text-gray-600">Don't have an account? 
                        <a href="signup.php" class="text-orange-600 hover:text-orange-700 font-medium">Sign up</a>
                    </p>
                </div>
            <?php endif; ?>

            <div class="mt-6 text-center">
                <a href="index.php" class="text-orange-600 hover:text-orange-700 inline-flex items-center">
                    <i class="fas fa-arrow-left mr-2"></i>Back to Home
                </a>
            </div>
        </div>
    </div>

    <script>
        function togglePassword() {
            const passwordInput = document.getElementById('password');
            const toggleIcon = document.getElementById('toggleIcon');
            
            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                toggleIcon.classList.remove('fa-eye');
                toggleIcon.classList.add('fa-eye-slash');
            } else {
                passwordInput.type = 'password';
                toggleIcon.classList.remove('fa-eye-slash');
                toggleIcon.classList.add('fa-eye');
            }
        }
    </script>
</body>
</html> 