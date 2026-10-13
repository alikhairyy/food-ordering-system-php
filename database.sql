-- ============================================================
--  Food Ordering System — Database Schema & Seed Data
--
--  STEP 1: Run this file in phpMyAdmin or MySQL CLI:
--    mysql -u root -p < database.sql
--
--  That's it! Passwords are pre-hashed and ready.
--  Login credentials:
--    admin@food.com  /  admin123  (Admin)
--    ahmed@food.com  /  cust123   (Customer)
--    sara@food.com   /  cust123   (Customer)
-- ============================================================

CREATE DATABASE IF NOT EXISTS food_ordering_system
    CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;

USE food_ordering_system;

-- ─── 1. user_types ───────────────────────────────────────────
CREATE TABLE IF NOT EXISTS user_types (
    id        INT AUTO_INCREMENT PRIMARY KEY,
    type_name VARCHAR(50) NOT NULL UNIQUE
) ENGINE=InnoDB;

-- ─── 2. users ────────────────────────────────────────────────
CREATE TABLE IF NOT EXISTS users (
    id           INT AUTO_INCREMENT PRIMARY KEY,
    name         VARCHAR(100) NOT NULL,
    email        VARCHAR(150) NOT NULL UNIQUE,
    password     VARCHAR(255) NOT NULL,
    user_type_id INT NOT NULL,
    created_at   TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_type_id) REFERENCES user_types(id) ON DELETE RESTRICT
) ENGINE=InnoDB;

-- ─── 3. menu ─────────────────────────────────────────────────
CREATE TABLE IF NOT EXISTS menu (
    id          INT AUTO_INCREMENT PRIMARY KEY,
    name        VARCHAR(100) NOT NULL,
    description TEXT
) ENGINE=InnoDB;

-- ─── 4. products ─────────────────────────────────────────────
CREATE TABLE IF NOT EXISTS products (
    id      INT AUTO_INCREMENT PRIMARY KEY,
    name    VARCHAR(150) NOT NULL,
    price   DECIMAL(10,2) NOT NULL DEFAULT 0.00,
    menu_id INT NOT NULL,
    FOREIGN KEY (menu_id) REFERENCES menu(id) ON DELETE CASCADE
) ENGINE=InnoDB;

-- ─── 5. orders ───────────────────────────────────────────────
CREATE TABLE IF NOT EXISTS orders (
    id          INT AUTO_INCREMENT PRIMARY KEY,
    user_id     INT NOT NULL,
    total_price DECIMAL(10,2) NOT NULL DEFAULT 0.00,
    status      ENUM('pending','processing','delivered','cancelled') DEFAULT 'pending',
    created_at  TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
) ENGINE=InnoDB;

-- ─── 6. order_details ────────────────────────────────────────
CREATE TABLE IF NOT EXISTS order_details (
    id         INT AUTO_INCREMENT PRIMARY KEY,
    order_id   INT NOT NULL,
    product_id INT NOT NULL,
    quantity   INT NOT NULL DEFAULT 1,
    price      DECIMAL(10,2) NOT NULL,
    FOREIGN KEY (order_id)   REFERENCES orders(id)   ON DELETE CASCADE,
    FOREIGN KEY (product_id) REFERENCES products(id) ON DELETE RESTRICT
) ENGINE=InnoDB;

-- ─── 7. usertype_menu ────────────────────────────────────────
CREATE TABLE IF NOT EXISTS usertype_menu (
    id           INT AUTO_INCREMENT PRIMARY KEY,
    user_type_id INT NOT NULL,
    menu_id      INT NOT NULL,
    UNIQUE KEY uq_type_menu (user_type_id, menu_id),
    FOREIGN KEY (user_type_id) REFERENCES user_types(id) ON DELETE CASCADE,
    FOREIGN KEY (menu_id)      REFERENCES menu(id)       ON DELETE CASCADE
) ENGINE=InnoDB;

-- ============================================================
--  SEED DATA
-- ============================================================

INSERT IGNORE INTO user_types (id, type_name) VALUES (1,'Admin'), (2,'Customer');

-- Passwords are real bcrypt hashes (cost 12, $2b$ prefix — PHP password_verify accepts this)
-- admin@food.com  → admin123
-- ahmed@food.com  → cust123
-- sara@food.com   → cust123
INSERT IGNORE INTO users (id, name, email, password, user_type_id) VALUES
  (1, 'Admin User',   'admin@food.com', '$2y$12$UYrPo92UVLHkkRgA.fSVpOOjrFE53KRWH5Ojh8WeLzMU8HSWy.0u6', 1),
  (2, 'Ahmed Hassan', 'ahmed@food.com', '$2y$12$jYyaZNb6E8s651265Zg.9u9xF2wzlnX/bXJKj.TREd8TlG7xQnZhG', 2),
  (3, 'Sara Mohamed', 'sara@food.com',  '$2y$12$kf/FMqN9gnddPWyalQoJVeFvGcnYqpmt8Adq8WAbbgvKylq9OA.HK',  2);

INSERT IGNORE INTO menu (id, name, description) VALUES
  (1, 'Breakfast',   'Start your day with our delicious breakfast options'),
  (2, 'Main Course', 'Hearty meals to satisfy your appetite'),
  (3, 'Desserts',    'Sweet treats to end your meal'),
  (4, 'Beverages',   'Hot and cold drinks for every taste');

INSERT IGNORE INTO products (id, name, price, menu_id) VALUES
  (1,  'Scrambled Eggs',       4.99, 1),
  (2,  'Pancakes with Syrup',  6.50, 1),
  (3,  'French Toast',         5.75, 1),
  (4,  'Grilled Chicken',     12.99, 2),
  (5,  'Beef Burger',         10.50, 2),
  (6,  'Pasta Carbonara',      9.99, 2),
  (7,  'Grilled Salmon',      15.99, 2),
  (8,  'Chocolate Cake',       4.50, 3),
  (9,  'Cheesecake',           5.00, 3),
  (10, 'Ice Cream Sundae',     3.99, 3),
  (11, 'Fresh Orange Juice',   3.50, 4),
  (12, 'Coffee',               2.99, 4),
  (13, 'Mango Smoothie',       4.25, 4);

INSERT IGNORE INTO usertype_menu (user_type_id, menu_id) VALUES
  (1,1),(1,2),(1,3),(1,4),
  (2,1),(2,2),(2,3),(2,4);

INSERT IGNORE INTO orders (id, user_id, total_price, status) VALUES
  (1, 2, 23.48, 'delivered'),
  (2, 3, 15.99, 'processing'),
  (3, 2, 10.50, 'pending');

INSERT IGNORE INTO order_details (order_id, product_id, quantity, price) VALUES
  (1, 4,  1, 12.99),
  (1, 12, 2,  5.98),
  (1, 10, 1,  3.99),
  (1, 8,  1,  4.50),
  (2, 7,  1, 15.99),
  (3, 5,  1, 10.50);
