<?php
session_start();
require_once '../config.php';

// Redirect to dashboard if already logged in as admin
if(isset($_SESSION['user_id']) && isset($_SESSION['role']) && $_SESSION['role'] === 'admin') {
    header('Location: ../dashboard.php');
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Staff Portal - Zaika-e-Handi</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        .bg-pattern {
            background-color: #ffffff;
            background-image: url("data:image/svg+xml,%3Csvg width='60' height='60' viewBox='0 0 60 60' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='none' fill-rule='evenodd'%3E%3Cg fill='%23f97316' fill-opacity='0.08'%3E%3Cpath d='M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E");
        }
    </style>
</head>
<body class="bg-pattern min-h-screen">
    <div class="min-h-screen flex flex-col items-center justify-center p-4">
        <div class="bg-white p-8 rounded-xl shadow-lg max-w-md w-full text-center">
            <img src="../images/logo.png" alt="Zaika-e-Handi Logo" class="w-24 h-24 mx-auto mb-4">
            <h1 class="text-3xl font-bold text-orange-600 mb-2">Staff Portal</h1>
            <p class="text-gray-600 mb-8">Welcome to Zaika-e-Handi restaurant management system</p>
            
            <div class="space-y-4">
                <a href="login.php" 
                   class="block w-full bg-orange-600 text-white py-3 rounded-lg hover:bg-orange-700 transition-colors">
                    <i class="fas fa-user-shield mr-2"></i>Admin Login
                </a>
                
                <div class="relative">
                    <div class="absolute inset-0 flex items-center">
                        <div class="w-full border-t border-gray-300"></div>
                    </div>
                    <div class="relative flex justify-center text-sm">
                        <span class="px-2 bg-white text-gray-500">Quick Links</span>
                    </div>
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <a href="../" class="flex items-center justify-center p-3 border rounded-lg hover:bg-gray-50 transition-colors">
                        <i class="fas fa-home mr-2"></i>
                        Main Website
                    </a>
                    <a href="https://docs.google.com/document/d/staff-manual" target="_blank" 
                       class="flex items-center justify-center p-3 border rounded-lg hover:bg-gray-50 transition-colors">
                        <i class="fas fa-book mr-2"></i>
                        Staff Manual
                    </a>
                </div>
            </div>
        </div>
        
        <div class="mt-8 text-center text-gray-600">
            <p class="text-sm">Need help? Contact IT Support</p>
            <p class="text-sm">Email: support@zaikahandi.com</p>
        </div>
    </div>

    <script>
        // Add any additional JavaScript functionality here
    </script>
</body>
</html> 