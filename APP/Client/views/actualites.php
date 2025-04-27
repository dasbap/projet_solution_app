<?php require_once("../../Serveur/profil.php"); ?>
<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8"/>
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>EcoTrack – Actualités Écologiques</title>

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

  <style>
    /* Ajustements spécifiques Actualités */
    .carousel-img {
      max-width: 600px;
      width: 100%;
      border-radius: .5rem;
    }
    .carousel-caption-custom {
      display: inline-block;
      background: rgba(255,255,255,0.9);
      padding: .75rem 1rem;
      border-radius: .5rem;
      margin-top: 1rem;
    }
  </style>
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

  <!-- SIDEBAR desktop -->
  <aside class="sidebar bg-white border-end border-success d-none d-lg-block">
    <nav class="nav flex-column pt-4">
      <a class="nav-link" href="stat_perso.php"><i class="fas fa-user-circle me-2"></i>Stat Perso</a>
      <a class="nav-link" href="stat_entreprise.php"><i class="fas fa-building me-2"></i>Stat Entreprise</a>
      <a class="nav-link active" href="actualites.php"><i class="fas fa-globe me-2"></i>Actualités ECO</a>
      <a class="nav-link" href="recompenses.php"><i class="fas fa-trophy me-2"></i>Récompenses</a>
      <a class="nav-link" href="classement.php"><i class="fas fa-list-ol me-2"></i>Classement</a>
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
      <a class="nav-link py-2 active" href="actualites.php">Actualités ECO</a>
      <a class="nav-link py-2" href="recompenses.php">Récompenses</a>
      <a class="nav-link py-2" href="classement.php">Classement</a>
    </nav>
  </div>

  <!-- CONTENU PRINCIPAL -->
  <main class="flex-fill">
    <section class="intro mb-4">
      <h1 class="page-title">Actualités Écologiques</h1>
      <p class="page-subtitle">Restez informé des dernières avancées et initiatives pour la planète.</p>
    </section>

    <!-- Carousel Actualités -->
    <div id="carouselActualites" class="carousel slide" data-bs-ride="carousel">
      <div class="carousel-inner">

        <!-- Slide 1 -->
        <div class="carousel-item active text-center">
          <img
            src="../res/Images/ACTU1.png"
            alt="Projet Nogent"
            class="d-block mx-auto carousel-img"
          />
          <div class="carousel-caption-custom">
            <p>
              Le projet de restauration écologique “Nogent” du parc national a été sélectionné lauréat du programme Mission Nature 2025.
              <br>
              <a href="https://la1ere.francetvinfo.fr/guadeloupe/le-projet-de-restauration-ecologique-nogent-du-parc-national-laureat-du-programme-mission-nature-2025-1581581.html">En savoir plus →</a>
            </p>
          </div>
        </div>

        <!-- Slide 2 -->
        <div class="carousel-item text-center">
          <img
            src="../res/Images/actu2.webp"
            alt="Initiative XYZ"
            class="d-block mx-auto carousel-img"
          />
          <div class="carousel-caption-custom">
            <p>
            « La rivière est le meilleur pisciculteur » : la continuité écologique, l'autre mission de la fédération de pêche de l'Yonne
              <br>
              <a href="https://www.lyonne.fr/flogny-la-chapelle-89360/actualites/la-riviere-est-le-meilleur-pisciculteur-la-continuite-ecologique-l-autre-mission-de-la-federation-de-peche-de-l-yonne_14676185/">En savoir plus →</a>
            </p>
          </div>
        </div>

      </div>
      <button
        class="carousel-control-prev"
        type="button"
        data-bs-target="#carouselActualites"
        data-bs-slide="prev"
      >
        <span class="carousel-control-prev-icon"></span>
      </button>
      <button
        class="carousel-control-next"
        type="button"
        data-bs-target="#carouselActualites"
        data-bs-slide="next"
      >
        <span class="carousel-control-next-icon"></span>
      </button>
    </div>
  </main>

  <!-- FOOTER -->
  <footer class="footer bg-dark text-white text-center py-3 mt-auto">
    &copy; 2025 EcoTrack | Tous droits réservés
  </footer>

  <!-- Bootstrap JS -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
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
