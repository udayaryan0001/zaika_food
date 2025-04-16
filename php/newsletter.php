<?php
require_once 'config.php';

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = json_decode(file_get_contents('php://input'), true);
    $subscriber_email = isset($data['email']) ? trim($data['email']) : '';

    if (empty($subscriber_email)) {
        echo json_encode(['success' => false, 'message' => 'Email is required']);
        exit;
    }

    if (!filter_var($subscriber_email, FILTER_VALIDATE_EMAIL)) {
        echo json_encode(['success' => false, 'message' => 'Invalid email format']);
        exit;
    }

    // Your Gmail address where you want to receive notifications
    $admin_email = 'udayaryan0001@gmail.com';
    
    // Email headers
    $headers = "MIME-Version: 1.0" . "\r\n";
    $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
    $headers .= "From: Zaika-e-Handi <noreply@zaikaehandi.com>" . "\r\n";
    
    // Email content
    $subject = "New Newsletter Subscription";
    $message = "
    <html>
    <body>
        <h2>New Newsletter Subscription</h2>
        <p>A new user has subscribed to the Zaika-e-Handi newsletter.</p>
        <p><strong>Subscriber Email:</strong> {$subscriber_email}</p>
        <p><strong>Date:</strong> " . date('Y-m-d H:i:s') . "</p>
    </body>
    </html>
    ";

    // Send email to admin
    mail($admin_email, $subject, $message, $headers);

    try {
        // Store in database
        $stmt = $conn->prepare("INSERT INTO newsletter_subscribers (email) VALUES (?)");
        $stmt->bind_param("s", $subscriber_email);
        
        if ($stmt->execute()) {
            echo json_encode([
                'success' => true, 
                'message' => 'Thank you for subscribing! You will receive our updates soon.'
            ]);
        } else {
            if ($conn->errno === 1062) { // Duplicate entry error
                echo json_encode([
                    'success' => false, 
                    'message' => 'You are already subscribed to our newsletter!'
                ]);
            } else {
                throw new Exception($stmt->error);
            }
        }
    } catch (Exception $e) {
        echo json_encode([
            'success' => false, 
            'message' => 'An error occurred. Please try again later.'
        ]);
    }

    $stmt->close();
} else {
    http_response_code(405);
    echo json_encode(['success' => false, 'message' => 'Method not allowed']);
}

$conn->close();
?> 