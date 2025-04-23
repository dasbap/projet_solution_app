# 🌿 Projet Solution App

Application web simple de gestion d’utilisateurs, inscription automatique par nom de domaine d’entreprise, et formulaire dynamique selon l’entreprise.  
Projet structuré pour séparer proprement les couches client, serveur, ressources et administration.

---

## 📁 Structure du projet

C:. ├───ADMIN # (réservé pour outils d’administration de création et de modification direct de la bdd)
    ├───APP 
    │    ├───Client # Frontend : HTML, CSS, JS │
    │    └───Serveur # Backend : scripts PHP 
    ├───Images # Logos, illustrations
    ├── .gitignore
    ├── .gitattributes 
    ├── README.md 
    ├── BDD.sql # Dump de la base de données principale 


---

## 🧪 Fonctionnalités principales

- Connexion/inscription sécurisée
- Association automatique d’un utilisateur à une entreprise via le domaine email
- Vérification d’existence de l’entreprise en base
- Formulaire dynamique en fonction de l’entreprise (côté client)
- Système de session pour gestion d’utilisateur connecté
- Base de données relationnelle via MySQL

---

## ⚙️ Configuration `.env`

Un fichier `.env` est requis dans `APP/Serveur/` :
    DB_HOST=localhost 
    DB_NAME=nom_base 
    DB_USER=utilisateur 
    DB_PASS=motdepasse


> ⚠️ Ce fichier ne doit **jamais** être versionné (protégé par `.gitignore`)

---

## 🖥️ Scripts côté serveur (`APP/Serveur/`)

### `config.php`
Connexion PDO à la base MySQL via les variables du fichier `.env`.

### `register.php`
- Vérifie que l’email est unique
- Récupère automatiquement l’entreprise à partir du domaine email (`@entreprise.com`)
- Hash le mot de passe avec `password_hash`
- Ajoute l’utilisateur dans `Table_User`

### `login.php`
- Vérifie que l’utilisateur existe
- Vérifie le mot de passe avec `password_verify`
- Démarre une session avec l’`id_user` et redirige vers `Client/index.php`

### `logout.php`
- Détruit la session et redirige vers `connexion.html`

---

## 🧱 Structure de base de données (simplifiée)

### `Table_User`

| Champ              | Type         |
|--------------------|--------------|
| id_user            | INT PK AI    |
| email_user         | VARCHAR      |
| user_password_hash | TEXT         |
| role               | INT (0=user) |
| siret_company      | VARCHAR FK   |

### `Table_Company`

| Champ         | Type      |
|---------------|-----------|
| siret_company | VARCHAR PK|
| name_company  | VARCHAR   |

---

## 🎨 Côté Client (`APP/Client/`)

- `formulaire.php` : formulaire dynamique basé sur `questions.json`
- `inscription.html` / `connexion.html` : formulaire de création de compte et d’accès
- `formulaire.js` : script pour gérer l’affichage dynamique des questions selon l’entreprise
- `style.css` / `formulaire.css` : styles
- `questions.json` : base de questions conditionnelles

---

## 🚀 Pour démarrer (local)

1. Cloner le projet  
   `git clone https://github.com/dasbap/projet_solution_app`

2. Importer les fichiers `.sql` dans votre base (ex: via phpMyAdmin ou MySQL CLI)

3. Configurer le fichier `.env` dans `APP/Serveur/`

4. Lancer un serveur PHP local dans `APP/Client/` :  
   `php -S localhost:8000`

---

## ✅ À faire

- Ajout de rôles supplémentaires (admin, RH, etc.)
- Sauvegarde automatique des réponses des formulaires
- Création des HTML et css pour le projet

---

## 📄 Licence

Ce projet est réalisé à des fins pédagogiques.