CREATE DATABASE IF NOT EXISTS prompt_manager;
USE prompt_manager;
--TaBLE USERS
CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,

    name VARCHAR(100) NOT NULL,

    email VARCHAR(255) NOT NULL UNIQUE,

    password VARCHAR(255) NOT NULL,
    role ENUM('developer', 'admin') DEFAULT 'user',
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP
);

-- Table CATEGORIES
CREATE TABLE categories (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL UNIQUE,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP
);
--  Table PROMPTS

CREATE TABLE prompts (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(255) NOT NULL,
    content TEXT NOT NULL,
    user_id INT NOT NULL,
    category_id INT NOT NULL,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
    -- ON DELETE CASCADE : si on supprime un user, ses prompts sont supprimés aussi
    FOREIGN KEY (category_id) REFERENCES categories(id) ON DELETE CASCADE
  
);

-- Insertion des catégories
INSERT INTO categories (name) VALUES
('Code'),
('Marketing'),
('DevOps'),
('SQL'),
('Documentation');

