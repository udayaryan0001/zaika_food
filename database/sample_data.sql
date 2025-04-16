USE zaika;

-- Insert default admin user (password: password)
INSERT INTO users (name, email, password, role) 
VALUES ('Admin', 'admin@zaika.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'admin')
ON DUPLICATE KEY UPDATE role = 'admin';

-- Insert sample menu items
INSERT INTO menu_items (name, description, price, category, image_url, featured) VALUES
('Butter Chicken', 'Tender chicken pieces in rich, creamy tomato sauce', 350.00, 'main-course', 'images/ilovepdf_pages-to-jpg (2)/premium_photo-1661432769134-758550b8fedb.jpeg', 1),
('Biryani', 'Fragrant rice dish with aromatic spices and tender meat', 300.00, 'biryani', 'images/ilovepdf_pages-to-jpg (2)/zaika - e- handi restaurant menu_page-0003.jpg', 1),
('Paneer Tikka', 'Grilled cottage cheese with spices and vegetables', 250.00, 'starters', 'images/ilovepdf_pages-to-jpg (2)/zaika - e- handi restaurant menu_page-0002.jpg', 1),
('Dal Makhani', 'Creamy black lentils cooked overnight', 200.00, 'main-course', 'images/ilovepdf_pages-to-jpg (2)/zaika - e- handi restaurant menu_page-0004.jpg', 0),
('Naan', 'Freshly baked Indian bread', 40.00, 'breads', 'images/ilovepdf_pages-to-jpg (2)/zaika - e- handi restaurant menu_page-0005.jpg', 0)
ON DUPLICATE KEY UPDATE featured = VALUES(featured); 