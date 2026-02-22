CREATE DATABASE IF NOT EXISTS arts_shop;
USE arts_shop;

CREATE TABLE users (
  id INT AUTO_INCREMENT PRIMARY KEY,
  full_name VARCHAR(120) NOT NULL,
  email VARCHAR(120) NOT NULL UNIQUE,
  password_hash VARCHAR(255) NOT NULL,
  role ENUM('admin', 'employee', 'customer') NOT NULL,
  phone VARCHAR(20),
  address TEXT,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE products (
  id INT AUTO_INCREMENT PRIMARY KEY,
  product_id CHAR(7) NOT NULL UNIQUE,
  name VARCHAR(120) NOT NULL,
  category VARCHAR(80) NOT NULL,
  description TEXT,
  price DECIMAL(10,2) NOT NULL,
  stock_qty INT NOT NULL DEFAULT 0,
  warranty_months INT NOT NULL DEFAULT 0,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE orders (
  id INT AUTO_INCREMENT PRIMARY KEY,
  order_number CHAR(16) NOT NULL UNIQUE,
  customer_id INT NOT NULL,
  product_id CHAR(7) NOT NULL,
  quantity INT NOT NULL,
  delivery_type TINYINT NOT NULL,
  payment_type ENUM('credit_card','cheque','vpp') NOT NULL,
  payment_status VARCHAR(30) NOT NULL,
  dispatch_status VARCHAR(30) NOT NULL,
  status VARCHAR(30) NOT NULL,
  total_amount DECIMAL(10,2) NOT NULL,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (customer_id) REFERENCES users(id),
  FOREIGN KEY (product_id) REFERENCES products(product_id)
);

CREATE TABLE feedback (
  id INT AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(120) NOT NULL,
  email VARCHAR(120) NOT NULL,
  comments TEXT NOT NULL,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

INSERT INTO users (full_name, email, password_hash, role, phone, address)
VALUES
('System Admin', 'admin@arts.local', '$2y$10$3fEBl74af6RPxwCLfn6XDu3oyQAkjt90f6EaTs7QvPQyh5VZf6M/e', 'admin', '0000000000', 'Head Office'),
('Dispatch Employee', 'employee@arts.local', '$2y$10$3fEBl74af6RPxwCLfn6XDu3oyQAkjt90f6EaTs7QvPQyh5VZf6M/e', 'employee', '1111111111', 'Branch');

INSERT INTO products (product_id, name, category, description, price, stock_qty, warranty_months) VALUES
('1000001', 'Premium Greeting Card Set', 'Greeting Cards', 'Handmade premium greeting card collection.', 299.00, 40, 0),
('2000001', 'Classic Leather Wallet', 'Wallets', 'Elegant wallet with multiple compartments.', 899.00, 25, 6),
('3000001', 'Designer Hand Bag', 'Hand Bags', 'Stylish everyday hand bag.', 1599.00, 15, 12),
('4000001', 'Gift Combo Hamper', 'Gift Articles', 'Festive gift combo for special occasions.', 1299.00, 20, 0);
