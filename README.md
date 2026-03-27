# 🧠 Prompt Manager — Knowledge Management Platform

Une plateforme de gestion de prompts pour développeurs, permettant de stocker, catégoriser et partager des instructions performantes pour les LLM (Large Language Models).

---

## 📌 À propos du projet

**Contexte :** DevGenius Solutions, une agence Full-Stack, perd souvent ses meilleurs prompts dans l'historique des chats. Cette plateforme résout ce problème en centralisant les prompts testés et approuvés.

**Objectif :** Permettre aux développeurs de :
- Stocker leurs prompts efficaces
- Les catégoriser (Code, Marketing, DevOps, SQL, Documentation)
- Les partager avec l'équipe
- Filtrer et retrouver rapidement les prompts utiles

---

## 🛠️ Technologies utilisées

- **Backend :** PHP 8+ (POO)
- **Base de données :** MySQL / MariaDB
- **Sécurité :** PDO avec Prepared Statements, password_hash(), Sessions
- **Frontend :** HTML5, CSS3 (responsive)
- **Serveur local :** XAMPP / WAMP

---

## ⚙️ Fonctionnalités

### Pour tous les utilisateurs :
- ✅ Inscription / Connexion sécurisée
- ✅ Créer, modifier, supprimer ses propres prompts
- ✅ Filtrer les prompts par catégorie
- ✅ Voir les prompts de tous les utilisateurs

### Pour les administrateurs :
- ✅ Dashboard avec statistiques (nombre d'utilisateurs, prompts, catégories)
- ✅ Top des contributeurs
- ✅ Gestion complète des catégories (CRUD)

---

## 📂 Structure du projet
project_poo/
│
├── config/
│ └── Database.php # Connexion PDO centralisée
│
├── classes/
│ ├── User.php # Gestion des utilisateurs
│ ├── Category.php # Gestion des catégories
│ └── Prompt.php # Gestion des prompts
│
├── public/
│ ├── index.php # Page d'accueil (liste des prompts)
│ ├── register.php # Inscription
│ ├── login.php # Connexion
│ ├── logout.php # Déconnexion
│ ├── create_prompt.php # Créer un prompt
│ ├── edit_prompt.php # Modifier un prompt
│ ├── delete_prompt.php # Supprimer un prompt
│ ├── categories.php # Voir toutes les catégories
│ └── admin/
│ ├── dashboard.php # Dashboard admin
│ └── categories.php # Gérer les catégories (admin)
│
├── database.sql # Script de création de la base
└── README.md # Ce fichier

## 🗄️ Schéma de la Base de Données

### Relations entre les tables
┌──────────────┐       ┌──────────────┐
│   USERS      │       │  CATEGORIES  │
│──────────────│       │──────────────│
│ id (PK)      │       │ id (PK)      │
│ name         │       │ name         │
│ email        │       │ created_at   │
│ password     │       └──────┬───────┘
│ role         │              │
│ created_at   │              │
└──────┬───────┘              │
       │                      │
       │    ┌─────────────────┘
       │    │
       ▼    ▼
┌──────────────────┐
│     PROMPTS      │
│──────────────────│
│ id (PK)          │
│ title            │
│ content          │
│ user_id (FK) ────┤──→ référence users.id
│ category_id (FK) ┤──→ référence categories.id
│ created_at       │
└──────────────────┘