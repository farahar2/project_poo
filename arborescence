prompt-manager/
│
├── config/
│   └── Database.php          ← Classe de connexion PDO
│
├── classes/
│   ├── User.php              ← Classe Utilisateur
│   ├── Category.php          ← Classe Catégorie
│   └── Prompt.php            ← Classe Prompt
│
├── public/                   ← Pages visibles par l'utilisateur
│   ├── index.php             ← Page d'accueil (liste des prompts)
│   ├── register.php          ← Inscription
│   ├── login.php             ← Connexion
│   ├── logout.php            ← Déconnexion
│   ├── create_prompt.php     ← Créer un prompt
│   ├── edit_prompt.php       ← Modifier un prompt
│   ├── delete_prompt.php     ← Supprimer un prompt
│   └── admin/
│       ├── categories.php    ← Gérer les catégories
│       └── dashboard.php     ← Stats (top contributeurs)
│
├── templates/                ← Morceaux HTML réutilisables
│   ├── header.php
│   └── footer.php
│
├── database.sql              ← Script SQL de création
└── README.md


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

