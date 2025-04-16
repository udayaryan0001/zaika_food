-- Create the database
CREATE DATABASE IF NOT EXISTS zaika_handi;
USE zaika_handi;

-- Create table for newsletter subscribers
CREATE TABLE IF NOT EXISTS newsletter_subscribers (
    id INT AUTO_INCREMENT PRIMARY KEY,
    email VARCHAR(255) NOT NULL UNIQUE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Create table for menu items
CREATE TABLE IF NOT EXISTS menu_items (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    category ENUM('starters', 'main-course', 'biryani') NOT NULL,
    price DECIMAL(10,2) NOT NULL,
    description TEXT,
    image_path VARCHAR(255),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- Insert sample menu items
INSERT INTO menu_items (name, category, price, description, image_path) VALUES
('Butter Chicken', 'main-course', 349.00, 'Tender chicken pieces in rich tomato gravy', 'images/menu/butter-chicken.jpg'),
('Paneer Tikka', 'starters', 249.00, 'Marinated cottage cheese grilled to perfection', 'images/menu/paneer-tikka.jpg'),
('Chicken Biryani', 'biryani', 299.00, 'Fragrant rice cooked with tender chicken and aromatic spices', 'images/menu/chicken-biryani.jpg'),
('Dal Makhani', 'main-course', 249.00, 'Creamy black lentils slow-cooked to perfection', 'images/menu/dal-makhani.jpg'),
('Chicken 65', 'starters', 279.00, 'Spicy deep-fried chicken with curry leaves', 'images/menu/chicken-65.jpg'); 