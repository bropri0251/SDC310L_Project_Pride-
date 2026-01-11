-- SDC310L Phase 2 Database Export
-- Student: Broderick Pride
-- Project: PHP Shopping Cart Application
-- Date: Week 2

CREATE DATABASE IF NOT EXISTS SDC310L_Project_Pride;
USE SDC310L_Project_Pride;

-- ----------------------------
-- Products Table
-- ----------------------------
CREATE TABLE products (
    product_id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    description TEXT NOT NULL,
    price DECIMAL(10,2) NOT NULL,
    image VARCHAR(255),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- ----------------------------
-- Shopping Cart Table
-- ----------------------------
CREATE TABLE cart_items (
    cart_id INT AUTO_INCREMENT PRIMARY KEY,
    product_id INT NOT NULL,
    quantity INT NOT NULL DEFAULT 1,
    session_id VARCHAR(255) NOT NULL,
    added_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (product_id) REFERENCES products(product_id)
);

-- ----------------------------
-- Orders Table
-- ----------------------------
CREATE TABLE orders (
    order_id INT AUTO_INCREMENT PRIMARY KEY,
    order_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    customer_name VARCHAR(100),
    customer_email VARCHAR(100),
    total_amount DECIMAL(10,2)
);

-- ----------------------------
-- Order Items Table
-- ----------------------------
CREATE TABLE order_items (
    order_item_id INT AUTO_INCREMENT PRIMARY KEY,
    order_id INT NOT NULL,
    product_id INT NOT NULL,
    quantity INT NOT NULL,
    price DECIMAL(10,2),
    FOREIGN KEY (order_id) REFERENCES orders(order_id),
    FOREIGN KEY (product_id) REFERENCES products(product_id)
);

-- ----------------------------
-- Sample Products
-- ----------------------------
INSERT INTO products (name, description, price, image) VALUES
('Gaming Mouse', 'High precision wireless gaming mouse', 49.99, 'mouse.jpg'),
('Mechanical Keyboard', 'RGB mechanical keyboard with blue switches', 89.99, 'keyboard.jpg'),
('Gaming Headset', 'Surround sound headset with noise cancellation', 79.99, 'headset.jpg'),
('Mouse Pad', 'Large extended gaming mouse pad', 19.99, 'mousepad.jpg');
