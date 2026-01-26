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
INSERT INTO products (name, description, price) VALUES
('Gaming Mouse', 'High precision wireless gaming mouse', 49.99),
('Mechanical Keyboard', 'RGB mechanical keyboard with blue switches', 89.99),
('Gaming Headset', 'Surround sound headset with noise cancellation', 79.99),
('Mouse Pad', 'Large extended gaming mouse pad', 19.99),
('Gaming Chair', 'High back ergonomic gaming chair with lumbar support.', 229.99),
('USB Gaming Controller', 'Wired USB controller compatible with PC gaming.', 39.99),
('27 Inch Gaming Monitor', 'Full HD 144Hz gaming monitor.', 249.99),
('Mechanical Keyboard (Compact)', '60 percent RGB mechanical keyboard.', 74.99),
('Wireless Gaming Mouse', 'Rechargeable wireless gaming mouse.', 59.99),
('RGB LED Light Strip', 'USB powered RGB lighting for desk setups.', 19.99),
('1080p Webcam', 'HD webcam for streaming and video calls.', 49.99),
('USB Hub', '4 port USB 3.0 hub.', 24.99),
('Laptop Cooling Pad', 'Dual fan cooling pad for laptops.', 34.99),
('Bluetooth Headphones', 'Over ear wireless headphones.', 89.99),
('Desk Microphone', 'USB condenser microphone for streaming.', 79.99),
('Gaming Desk', 'Large gaming desk with cable management.', 199.99),
('Surge Protector', '8 outlet surge protected power strip.', 29.99),
('Ethernet Cable', 'High speed Cat6 ethernet cable.', 9.99),
('Streaming Capture Card', 'HDMI capture device for recording.', 149.99),
('Gaming Router', 'Low latency Wi-Fi gaming router.', 179.99),
('External Hard Drive', '2TB USB external storage drive.', 89.99),
('USB Flash Drive', '128GB USB 3.1 flash drive.', 19.99),
('Mouse Bungee', 'Desk mounted cable holder for mouse.', 14.99),
('Monitor Stand', 'Adjustable monitor riser.', 39.99),
('Dual Monitor Mount', 'Desk mount for two monitors.', 89.99),
('RGB Keyboard Wrist Rest', 'Soft padded wrist support.', 24.99),
('Gaming Glasses', 'Blue light blocking glasses.', 19.99),
('Wireless Charger', 'Fast charge Qi wireless pad.', 29.99),
('Desk Fan', 'Quiet USB powered fan.', 14.99),
('Noise Cancelling Headphones', 'Active noise cancellation.', 149.99),
('Bluetooth Speaker', 'Portable wireless speaker.', 59.99),
('USB-C Dock', 'Multi port laptop dock.', 119.99),
('Micro SD Card', '256GB high speed micro SD.', 39.99),
('VR Headset', 'Virtual reality gaming headset.', 399.99),
('Gaming Backpack', 'Laptop backpack with USB charging.', 69.99),
('PC Speakers', 'Stereo speakers with subwoofer.', 79.99),
('Streaming Ring Light', 'Adjustable LED light.', 34.99),
('Mechanical Keycap Set', 'Custom colorful keycaps.', 29.99),
('CPU Air Cooler', 'High performance CPU cooler.', 49.99),
('Thermal Paste', 'High conductivity thermal compound.', 9.99),
('RGB Case Fans', 'Triple pack of RGB cooling fans.', 59.99),
('PC Tool Kit', 'PC building tool set.', 29.99),
('Cable Sleeves', 'Braided cable management kit.', 24.99),
('Gaming Floor Mat', 'Chair floor protection mat.', 39.99),
('SSD 1TB', 'High speed solid state drive.', 99.99),
('SSD 2TB', 'High capacity solid state drive.', 189.99),
('Power Supply 750W', 'Fully modular power supply.', 129.99),
('Motherboard ATX', 'Gaming motherboard.', 179.99),
('Graphics Card Stand', 'GPU anti sag bracket.', 19.99),
('PC Case', 'Mid tower tempered glass case.', 109.99),
('Liquid CPU Cooler', '240mm liquid cooling system.', 149.99),
('PC RGB Controller', 'Lighting controller hub.', 39.99),
('Wi-Fi Adapter', 'USB wireless network adapter.', 29.99),
('Keyboard Cleaning Kit', 'Cleaning tools for electronics.', 14.99),
('Screen Cleaning Spray', 'Safe monitor cleaning solution.', 9.99),
('Gaming Gloves', 'Fingerless gaming gloves.', 19.99),
('Desk Cable Tray', 'Under desk cable management.', 34.99),
('Portable SSD', 'Fast USB-C portable SSD.', 129.99),
('Laptop Stand', 'Adjustable aluminum stand.', 49.99),
('Wireless Earbuds', 'Bluetooth in ear earbuds.', 79.99),
('Keyboard Carry Case', 'Protective keyboard bag.', 39.99),
('Streaming Boom Arm', 'Microphone desk mount.', 49.99),
('Gaming Hoodie', 'Comfortable gaming hoodie.', 59.99),
('PC Dust Filter', 'Magnetic dust filters.', 14.99),
('Thermal Monitoring Sensor', 'Internal PC temperature probe.', 19.99),
('External Blu-ray Drive', 'USB Blu-ray reader.', 99.99),
('Gaming Mouse Skates', 'Replacement PTFE skates.', 9.99),
('Sound Card USB', 'External USB sound card.', 29.99),
('Cable Tester', 'RJ45 and USB tester.', 24.99),
('Streaming Deck', 'Programmable control pad.', 149.99),
('Desk LED Panel', 'RGB lighting panels.', 89.99),
('Gaming Notebook', 'Dot grid gaming journal.', 14.99),
('PC Carry Case', 'Transport case for PC.', 129.99),
('Smart Power Strip', 'Wi-Fi enabled power strip.', 49.99);
