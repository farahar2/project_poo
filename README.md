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
├── 📁 config/
│   └── 📄 Database.php                    # Classe de connexion PDO
│
├── 📁 classes/
│   ├── 📄 User.php                        # Gestion des utilisateurs
│   ├── 📄 Category.php                    # Gestion des catégories
│   └── 📄 Prompt.php                      # Gestion des prompts
│
├── 📁 public/
│   │
│   ├── 📁 css/
│   │   └── 📄 style.css                   # Styles CSS personnalisés
│   │
│   ├── 📁 includes/
│   │   ├── 📄 head.php                    # Liens CSS (Bootstrap + Icons + style.css)
│   │   └── 📄 scripts.php                 # Liens JS (Bootstrap JS)
│   │
│   ├── 📁 admin/
│   │   ├── 📄 dashboard.php               # Dashboard admin (stats + top contributeurs)
│   │   └── 📄 categories.php              # Gestion complète des catégories (CRUD)
│   │
│   ├── 📄 index.php                       # Page d'accueil (liste + filtres des prompts)
│   ├── 📄 login.php                       # Page de connexion
│   ├── 📄 register.php                    # Page d'inscription
│   ├── 📄 logout.php                      # Déconnexion (destruction session)
│   ├── 📄 create_prompt.php               # Créer un nouveau prompt
│   ├── 📄 edit_prompt.php                 # Modifier un prompt existant
│   ├── 📄 delete_prompt.php               # Supprimer un prompt
│   └── 📄 categories.php                  # Liste des catégories (utilisateurs)
│
├── 📄 database.sql                        # Script de création BDD + seeding
├── 📄 README.md                           # Documentation du projet
└── 📄 .gitignore                          # (optionnel) Fichiers à ignorer par Git

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