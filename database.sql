CREATE DATABASE IF NOT EXISTS oceango CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE oceango;

CREATE TABLE IF NOT EXISTS users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(120) NOT NULL UNIQUE,
    phone VARCHAR(30),
    password VARCHAR(255) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Data demo opsional:
-- INSERT INTO users (name,email,phone,password)
-- VALUES ('Erinna','erinna@example.com','08123456789',
-- '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC3H6ZxJ6nQxGq2Y7q');
