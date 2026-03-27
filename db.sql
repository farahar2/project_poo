CREATE DATABASE IF NOT EXISTS prompt_manager;
USE prompt_manager;
--  Table USERS
CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    -- AUTO_INCREMENT : l'id se génère tout seul (1, 2, 3...)
    -- PRIMARY KEY : c'est l'identifiant unique

    name VARCHAR(100) NOT NULL,
    -- VARCHAR(100) : texte de max 100 caractères
    -- NOT NULL : ce champ est OBLIGATOIRE

    email VARCHAR(255) NOT NULL UNIQUE,
    -- UNIQUE : deux utilisateurs ne peuvent pas avoir le même email

    password VARCHAR(255) NOT NULL,
    -- 255 car password_hash() génère une chaîne longue

    role ENUM('user', 'admin') DEFAULT 'user',
    -- ENUM : seulement 2 valeurs possibles
    -- DEFAULT 'user' : si on ne précise rien, c'est "user"

    created_at DATETIME DEFAULT CURRENT_TIMESTAMP
    -- Se remplit automatiquement avec la date/heure actuelle
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
    -- TEXT : pour les longs textes (pas de limite de 255)

    user_id INT NOT NULL,
    -- Va stocker l'ID de l'utilisateur qui a créé le prompt

    category_id INT NOT NULL,
    -- Va stocker l'ID de la catégorie du prompt

    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,

    -- === LES FOREIGN KEYS (les liens entre tables) ===

    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
    -- "user_id fait référence à id dans la table users"
    -- ON DELETE CASCADE : si on supprime un user, ses prompts sont supprimés aussi

    FOREIGN KEY (category_id) REFERENCES categories(id) ON DELETE CASCADE
    -- "category_id fait référence à id dans la table categories"
);


 -- SEEDING (données de test)


-- Insertion des catégories
INSERT INTO categories (name) VALUES
('Code'),
('Marketing'),
('DevOps'),
('SQL'),
('Documentation');

-- Insertion d'un admin (mot de passe : admin123)
-- Le hash ci-dessous correspond à "admin123"
INSERT INTO users (name, email, password, role) VALUES
('Admin', 'admin@devgenius.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'admin');

-- Insertion d'un utilisateur test (mot de passe : user123)
INSERT INTO users (name, email, password, role) VALUES
('Alice Dev', 'alice@devgenius.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'user');

-- Insertion de prompts de test
INSERT INTO prompts (title, content, user_id, category_id) VALUES
('Générer un composant React', 'Génère un composant React avec TypeScript qui affiche une liste de produits avec pagination.', 2, 1),
('Slogan publicitaire', 'Crée 5 slogans créatifs pour une startup de livraison de repas bio.', 2, 2),
('Script de déploiement', 'Écris un script Bash pour déployer une application Node.js sur un serveur Ubuntu.', 1, 3);
