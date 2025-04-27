
# 🌱 Carbon Footprint Assessment Platform EcoTrack

Plateforme web d'évaluation d'empreinte carbone avec scoring et gestion utilisateurs.

## ✨ Fonctionnalités principales

### 👤 Utilisateurs
- Formulaire dynamique d'évaluation carbone
- Calcul automatique du score personnel
- Visualisation des résultats (graphiques)
- Classement comparatif entre utilisateurs

### 👨‍💼 Administrateurs
- Interface d'inscription des utilisateurs
- Association automatique entreprise → domaine email
- Liste des fichiers HTML disponibles
- Système de journalisation des activités

---

## 🛠 Architecture

```
projet_solution_app/
├── ADMIN/
│   ├── index.php
│   ├── register.php
│   └── style.css
├── APP/
│   ├── Client/
│   └── Serveur/
├── Images/
└── BDD.sql
```

---

## 🔐 Sécurité

- Hachage des mots de passe (`bcrypt`)
- Validation des emails et mots de passe
- Protection contre les inscriptions doublons
- Logs d'activités

---

## 🚀 Installation

### 1. Démarrer MySQL

- Lancer votre serveur MySQL localement.
- Importer la base de données :

```bash
mysql -u votre_utilisateur -p
```
Puis dans MySQL :

```sql
CREATE DATABASE score_carbone_db;
USE score_carbone_db;
SOURCE chemin/vers/BDD.sql;
```

---

### 2. Configurer PHP

- Modifier `APP/Serveur/config.php` :

```php
define('DB_SERVER', 'localhost');
define('DB_USERNAME', 'votre_utilisateur');
define('DB_PASSWORD', 'votre_mot_de_passe');
define('DB_NAME', 'score_carbone_db');
```

---

### 3. Lancer le serveur PHP

À la racine du projet :

```bash
php -S localhost:8000
```

Accéder ensuite à :  
👉 http://localhost:8000/

---

### 4. Interface Admin

- Accéder à l'administration :  
http://localhost:8000/ADMIN/

- Remplir le formulaire d'inscription avec :
  - Email professionnel (`prenom@entreprise.com`)
  - Mot de passe sécurisé

---

## 🛠 Technologies

- PHP 8+
- MySQL / MariaDB
- HTML5, CSS3, JavaScript
- Chart.js (visualisation graphique)

---

## 📋 Notes

- Utiliser un environnement local type XAMPP/MAMP pour faciliter le développement.
- Sécuriser la configuration en production (`.env`, HTTPS, etc.).

---
