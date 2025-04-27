<?php
// Charger le profil utilisateur si besoin
require_once __DIR__ . '/../../Serveur/profil.php';
?>
<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8"/>
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>EcoTrack – Accueil</title>

  <!-- Google Fonts -->
  <link rel="preconnect" href="https://fonts.googleapis.com"/>
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin/>
  <link
    href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600&family=Manrope:wght@200..800;700&display=swap"
    rel="stylesheet"/>

  <!-- Bootstrap & FontAwesome -->
  <link
    href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css"
    rel="stylesheet"/>
  <link
    href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css"
    rel="stylesheet"/>

  <!-- CSS unifié -->
  <link rel="stylesheet" href="../res/css/global.css"/>
</head>
<body class="d-flex flex-column min-vh-100">

  <!-- NAVBAR -->
  <nav class="navbar navbar-expand-lg navbar-light bg-white border-bottom border-success fixed-top">
    <div class="container-fluid">
      <button class="btn btn-outline-success d-lg-none me-2" id="sidebarToggle">
        <i class="fas fa-bars"></i>
      </button>
      <a class="navbar-brand fw-bold" href="index.php">
        <i class="fas fa-leaf text-success me-2"></i>EcoTrack
      </a>
      <button
        class="navbar-toggler"
        type="button"
        data-bs-toggle="collapse"
        data-bs-target="#mainNav"
        aria-controls="mainNav"
        aria-expanded="false"
        aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse justify-content-end" id="mainNav">
        <ul class="navbar-nav">
          <li class="nav-item"><a class="nav-link active" href="index.php">Accueil</a></li>
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
  <aside id="sidebar" class="sidebar bg-white border-end border-success d-none d-lg-block">
    <nav class="nav flex-column pt-4">
      <a class="nav-link" href="stat_perso.php"><i class="fas fa-user-circle me-2"></i>Stat Perso</a>
      <a class="nav-link" href="stat_entreprise.php"><i class="fas fa-building me-2"></i>Stat Entreprise</a>
      <a class="nav-link" href="actualites.php"><i class="fas fa-globe me-2"></i>Actualités ECO</a>
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
      <a class="nav-link py-2" href="actualites.php">Actualités ECO</a>
      <a class="nav-link py-2" href="recompenses.php">Récompenses</a>
      <a class="nav-link py-2" href="classement.php">Classement</a>
    </nav>
  </div>

  <!-- CONTENU PRINCIPAL -->
  <main class="flex-fill" style="margin-top:80px;">
    <div class="container my-5">
      <!-- Hero -->
      <section class="hero text-center mb-5">
        <h1 class="text-success fw-bold">RÉDUISEZ VOTRE EMPREINTE CARBONE</h1>
        <p class="lead">Un outil ludique pour agir au quotidien</p>
        <a href="formulaire.php" class="btn btn-success btn-lg">Commencer le Quizz</a>
      </section>

      <!-- Carousel centré avec descriptions -->
      <div id="carouselIndex" class="carousel slide" data-bs-ride="carousel">
        <div class="carousel-inner">
          <!-- Slide 1 -->
          <div class="carousel-item active">
            <div class="d-flex flex-column flex-md-row align-items-center justify-content-center">
              <!-- Texte gauche -->
              <div class="carousel-text-left text-center text-md-start mb-3 mb-md-0 me-md-4">
                <h5>Agissez pour la planète</h5>
                <p>Découvrez comment chaque geste compte au quotidien.</p>
              </div>
              <!-- Image -->
              <div class="carousel-item-img-container mx-4">
                <img
                  src="../res/Images/CARROUSSEL1.jpg"
                  alt="Paysage écologique"
                  class="d-block carousel-img"
                  style="max-width:500px; width:100%; border-radius:.5rem;"
                />
              </div>
              <!-- Texte droite -->
              <div class="carousel-text-right text-center text-md-end mt-3 mt-md-0 ms-md-4">
                <h5>Partagez vos progrès</h5>
                <p>Rejoignez une communauté engagée et inspirez vos proches.</p>
              </div>
            </div>
          </div>
          <!-- Slide 2 -->
          <div class="carousel-item">
            <div class="d-flex flex-column flex-md-row align-items-center justify-content-center">
              <div class="carousel-text-left text-center text-md-start mb-3 mb-md-0 me-md-4">
                <h5>Réduisez votre empreinte</h5>
                <p>Suivez vos progrès et comparez-vous aux autres.</p>
              </div>
              <div class="carousel-item-img-container mx-4">
                <img
                  src="../res/Images/terre.png"
                  alt="Énergie renouvelable"
                  class="d-block carousel-img"
                  style="max-width:500px; width:100%; border-radius:.5rem;"
                />
              </div>
              <div class="carousel-text-right text-center text-md-end mt-3 mt-md-0 ms-md-4">
                <h5>Gagnez des récompenses</h5>
                <p>Accumulez des points pour obtenir des avantages.</p>
              </div>
            </div>
          </div>
        </div>
        <button
          class="carousel-control-prev"
          type="button"
          data-bs-target="#carouselIndex"
          data-bs-slide="prev">
          <span class="carousel-control-prev-icon"></span>
        </button>
        <button
          class="carousel-control-next"
          type="button"
          data-bs-target="#carouselIndex"
          data-bs-slide="next">
          <span class="carousel-control-next-icon"></span>
        </button>
      </div>
    </div>
  </main>

  <!-- FOOTER -->
  <footer class="footer text-center py-4 bg-light border-top mt-auto">
    &copy; 2025 EcoTrack | Tous droits réservés
  </footer>

  <!-- Bootstrap JS + burger script -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
  <script>
    document.addEventListener('DOMContentLoaded', () => {
      // Toggle sidebar on mobile
      document.getElementById('sidebarToggle')
        .addEventListener('click', () =>
          document.getElementById('sidebar').classList.toggle('active')
        );
      // Toggle mobile menu
      const burger = document.querySelector('.navbar-toggler');
      const mobileMenu = document.getElementById('mobileMenu');
      burger.addEventListener('click', () => mobileMenu.classList.toggle('open'));
      mobileMenu.addEventListener('click', e => {
        if (e.target === mobileMenu) mobileMenu.classList.remove('open');
      });
    });
  </script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
  <script>
    document.addEventListener('DOMContentLoaded', () => {
      const burgerBtn  = document.getElementById('burgerBtn');
      const mobileMenu = document.getElementById('mobileMenu');
      burgerBtn.addEventListener('click', ()=> mobileMenu.classList.toggle('open'));
      mobileMenu.addEventListener('click', e => {
        if(e.target===mobileMenu) mobileMenu.classList.remove('open');
      });
    });
  </script>

</body>
</html>
