<?php
require_once 'config.php';

// Set headers for better display
header('Content-Type: text/html; charset=utf-8');
?>

<!DOCTYPE html>
<html>
<head>
    <title>Newsletter Subscribers</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 20px; }
        table { border-collapse: collapse; width: 100%; }
        th, td { border: 1px solid #ddd; padding: 8px; text-align: left; }
        th { background-color: #f97316; color: white; }
        tr:nth-child(even) { background-color: #f2f2f2; }
        .container { max-width: 800px; margin: 0 auto; }
    </style>
</head>
<body>
    <div class="container">
        <h1>Newsletter Subscribers</h1>
        
        <?php
        // Get all subscribers
        $sql = "SELECT * FROM newsletter_subscribers ORDER BY subscribed_at DESC";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            echo "<table>
                    <tr>
                        <th>ID</th>
                        <th>Email</th>
                        <th>Subscribed At</th>
                    </tr>";

            while($row = $result->fetch_assoc()) {
                echo "<tr>
                        <td>".$row["id"]."</td>
                        <td>".$row["email"]."</td>
                        <td>".$row["subscribed_at"]."</td>
                    </tr>";
            }
            echo "</table>";
        } else {
            echo "<p>No subscribers found</p>";
        }

        $conn->close();
        ?>
    </div>
</body>
</html> 