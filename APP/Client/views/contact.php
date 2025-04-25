<?php
  // Charge le profil utilisateur si nécessaire
  require_once __DIR__ . '/../../Serveur/profil.php';
?>
<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <title>Contact – EcoTrack</title>

  <!-- Google Fonts -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600&family=Manrope:wght@700&display=swap" rel="stylesheet">

  <!-- Bootstrap & FontAwesome -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">

  <!-- Vos styles -->
  <link rel="stylesheet" href="../res/css/global.css">
  <link rel="stylesheet" href="../res/css/contact.css">
</head>
<body class="d-flex flex-column min-vh-100">

  <!-- NAVBAR -->
  <nav class="navbar navbar-expand-lg bg-white fixed-top">
    <div class="container-fluid">
      <button id="burgerBtn" class="btn d-lg-none me-2">
        <i class="fas fa-bars fa-lg"></i>
      </button>
      <a class="navbar-brand fw-bold" href="index.php">
        <i class="fas fa-leaf text-success me-2"></i>EcoTrack
      </a>
      <div class="collapse navbar-collapse d-none d-lg-flex justify-content-end" id="mainNav">
        <ul class="navbar-nav">
          <li class="nav-item"><a class="nav-link" href="index.php">Accueil</a></li>
          <li class="nav-item"><a class="nav-link" href="formulaire.php">Quizz</a></li>
          <li class="nav-item"><a class="nav-link active" href="contact.php">Contact</a></li>
          <li class="nav-item">
            <a class="nav-link" href="connexion.php">
              <i class="fas fa-user-circle me-1"></i>Mon Compte
            </a>
          </li>
        </ul>
      </div>
    </div>
  </nav>

  <!-- SIDEBAR desktop -->
  <aside class="sidebar d-none d-lg-block">
    <nav class="nav flex-column">
      <a class="nav-link" href="stat_perso.php"><i class="fas fa-user-circle me-2"></i>Stat Perso</a>
      <a class="nav-link" href="stat_entreprise.php"><i class="fas fa-building me-2"></i>Stat Entreprise</a>
      <a class="nav-link" href="actualites.php"><i class="fas fa-globe me-2"></i>Actualités ECO</a>
      <a class="nav-link" href="recompenses.php"><i class="fas fa-trophy me-2"></i>Récompenses</a>
      <a class="nav-link" href="classement.php"><i class="fas fa-list-ol me-2"></i>Classement</a>
    </nav>
  </aside>

  <!-- MENU MOBILE overlay -->
  <div id="mobileMenu" class="mobile-menu d-lg-none">
    <nav class="nav flex-column text-center pt-4">
      <a class="nav-link py-2" href="index.php">Accueil</a>
      <a class="nav-link py-2" href="formulaire.php">Quizz</a>
      <a class="nav-link py-2 active" href="contact.php">Contact</a>
      <a class="nav-link py-2" href="connexion.php">Mon Compte</a>
      <hr>
      <a class="nav-link py-2" href="stat_perso.php">Stat Perso</a>
      <a class="nav-link py-2" href="stat_entreprise.php">Stat Entreprise</a>
      <a class="nav-link py-2" href="actualites.php">Actualités ECO</a>
      <a class="nav-link py-2" href="recompenses.php">Récompenses</a>
      <a class="nav-link py-2" href="classement.php">Classement</a>
    </nav>
  </div>

  <!-- MAIN -->
  <main class="flex-fill">
    <div class="container py-5">
      <div class="row">
        <!-- Formulaire -->
        <div class="col-lg-6">
          <div class="contact-container">
            <h1>Contactez-nous</h1>
            <form class="contact-form" action="#" method="POST" novalidate>
              <input type="text"    placeholder="Nom" required>
              <input type="email"   placeholder="Email" required>
              <textarea placeholder="Message" rows="5" required></textarea>
              <div class="checkbox-container">
                <input type="checkbox" id="newsletter">
                <label for="newsletter">Je souhaite recevoir la newsletter.</label>
              </div>
              <button type="submit" class="btn btn-success mt-3">Envoyer</button>
            </form>
            <div class="contact-info mt-4">
              <p><i class="fas fa-map-marker-alt me-2"></i>Bordeaux, France</p>
              <p><i class="fas fa-phone me-2"></i>000 111 222 333</p>
              <p><i class="fas fa-envelope me-2"></i>ecotrack@gmail.com</p>
            </div>
          </div>
        </div>
        <!-- Carte -->
        <div class="col-lg-6 d-flex justify-content-center align-items-start mt-4 mt-lg-0">
          <div class="iframe-container">
            <iframe
              src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d11571.9479!2d-0.57918!3d44.837789!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0xd5527c1b1b1b1b1%3A0x1b1b1b1b1b1b1b1b!2sBordeaux%2C%20France!5e0!3m2!1sen!2sfr!4v1618231811351!5m2!1sen!2sfr"
              width="100%" height="400" frameborder="0" style="border:0;" allowfullscreen="" loading="lazy">
            </iframe>
          </div>
        </div>
      </div>
    </div>
  </main>

  <!-- FOOTER -->
  <footer class="footer">
    &copy; 2025 EcoTrack | Tous droits réservés
  </footer>

  <!-- JS -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
  <script>
    document.addEventListener('DOMContentLoaded', () => {
      const burger = document.getElementById('burgerBtn');
      const sidebar = document.querySelector('.sidebar');
      const mobileMenu = document.getElementById('mobileMenu');
      burger.addEventListener('click', () => {
        sidebar.classList.toggle('closed');
        mobileMenu.classList.toggle('open');
      });
      mobileMenu.addEventListener('click', e => {
        if (e.target === mobileMenu) mobileMenu.classList.remove('open');
      });
    });
  </script>
</body>
</html>
