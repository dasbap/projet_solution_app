<?php require_once("../../Serveur/profil.php"); ?>

<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8"/>
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>EcoTrack – Classement</title>

  <!-- Google Fonts -->
  <link rel="preconnect" href="https://fonts.googleapis.com"/>
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin/>
  <link
    href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600&family=Manrope:wght@700&display=swap"
    rel="stylesheet"/>

  <!-- Bootstrap & FontAwesome -->
  <link
    href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css"
    rel="stylesheet"/>
  <link
    href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css"
    rel="stylesheet"/>

  <!-- CSS global -->
  <link rel="stylesheet" href="../res/css/global.css"/>
  <!-- CSS spécifique Classement -->
  <link rel="stylesheet" href="../res/css/classement.css"/>
</head>
<body class="d-flex flex-column min-vh-100">

  <!-- NAVBAR -->
  <nav class="navbar navbar-expand-lg bg-white border-bottom border-success fixed-top">
    <div class="container-fluid">
      <a class="navbar-brand fw-bold" href="index.php">
        <i class="fas fa-leaf text-success me-2"></i>EcoTrack
      </a>
      <button class="navbar-toggler" id="burgerBtn" type="button" aria-label="Toggle menu">
        <i class="fas fa-bars fa-lg"></i>
      </button>
      <div class="collapse navbar-collapse d-none d-lg-flex justify-content-end" id="mainNav">
        <ul class="navbar-nav">
          <li class="nav-item"><a class="nav-link" href="index.php">Accueil</a></li>
          <li class="nav-item"><a class="nav-link" href="formulaire.php">Quizz</a></li>
          <li class="nav-item"><a class="nav-link" href="contact.php">Contact</a></li>
          <li class="nav-item">
            <a class="nav-link" href="connexion.php">
              <i class="fas fa-user-circle me-1"></i>Mon Compte
            </a>
          </li>
        </ul>
      </div>
    </div>
  </nav>

  <!-- SIDEBAR -->
  <aside class="sidebar bg-white border-end border-success">
    <nav class="nav flex-column pt-4">
      <a class="nav-link" href="stat_perso.php"><i class="fas fa-user-circle me-2"></i>Stat Perso</a>
      <a class="nav-link" href="stat_entreprise.php"><i class="fas fa-building me-2"></i>Stat Entreprise</a>
      <a class="nav-link" href="actualites.php"><i class="fas fa-globe me-2"></i>Actualités ECO</a>
      <a class="nav-link" href="recompenses.php"><i class="fas fa-trophy me-2"></i>Récompenses</a>
      <a class="nav-link active" href="classement.php"><i class="fas fa-list-ol me-2"></i>Classement</a>
    </nav>
  </aside>

  <!-- MENU MOBILE overlay -->
  <div class="mobile-menu d-lg-none" id="mobileMenu">
    <nav class="nav flex-column text-center pt-4">
      <a class="nav-link py-2" href="index.php">Accueil</a>
      <a class="nav-link py-2" href="formulaire.php">Quizz</a>
      <a class="nav-link py-2" href="contact.php">Contact</a>
      <a class="nav-link py-2" href="connexion.php">Mon Compte</a>
      <hr/>
      <a class="nav-link py-2" href="stat_perso.php">Stat Perso</a>
      <a class="nav-link py-2" href="stat_entreprise.php">Stat Entreprise</a>
      <a class="nav-link py-2" href="actualites.php">Actualités ECO</a>
      <a class="nav-link py-2" href="recompenses.php">Récompenses</a>
      <a class="nav-link py-2" href="classement.php">Classement</a>
    </nav>
  </div>

  <!-- CONTENU PRINCIPAL -->
  <main class="flex-fill">
    <section class="intro mb-4">
      <h1 class="page-title">Classement</h1>
      <p class="page-subtitle">Découvrez votre position et celle des entreprises</p>
    </section>

    <section class="classement-grid mb-5">
      <!-- Classement Personnel -->
      <div class="classement-card">
        <div class="card-header text-center">
          <h5>Classement Personnel</h5>
        </div>
        <ul class="list-group list-group-flush" id="personal-list">
          <!-- Classement personnel dynamique -->
        </ul>
        <div class="card-footer text-center">
          <button class="btn btn-success" id="btn-personal">Voir mon rang</button>
        </div>
      </div>

      <!-- Classement Entreprises -->
      <div class="classement-card">
        <div class="card-header text-center">
          <h5>Classement Entreprises</h5>
        </div>
        <ul class="list-group list-group-flush" id="company-list">
          <!-- Classement entreprises dynamique -->
        </ul>
        <div class="card-footer text-center">
          <button class="btn btn-success" id="btn-company">Voir mon entreprise</button>
        </div>
      </div>
    </section>
  </main>

  <!-- FOOTER -->
  <footer class="footer bg-dark text-white text-center py-3">
    &copy; 2025 EcoTrack | Tous droits réservés
  </footer>

  <!-- Bootstrap JS + hamburger script -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
  <script src="../res/js/classement.js"></script>
  <script>
    document.addEventListener('DOMContentLoaded', () => {
      const burgerBtn  = document.getElementById('burgerBtn');
      const mobileMenu = document.getElementById('mobileMenu');
      burgerBtn.addEventListener('click', () => mobileMenu.classList.toggle('open'));
      mobileMenu.addEventListener('click', e => {
        if (e.target === mobileMenu) mobileMenu.classList.remove('open');
      });
    });
  </script>
</body>
</html>
