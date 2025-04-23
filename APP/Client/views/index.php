<!DOCTYPE html>


<?php require_once("../../Serveur/profil.php"); ?>


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

  <!-- Vos styles unifiés -->
  <link rel="stylesheet" href="../res/css/global.css"/>
</head>
<body>

<!-- NAVBAR -->
<nav class="navbar navbar-expand-lg">
  <div class="container-fluid">
    <a class="navbar-brand fw-bold" href="#">
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
        <li class="nav-item"><a class="nav-link" href="contact.html">Contact</a></li>
        <li class="nav-item">
          <a class="nav-link" href="connexion.html">
            <i class="fas fa-user-circle me-1"></i>Mon Compte
          </a>
        </li>
      </ul>
    </div>
  </div>
</nav>

  <!-- SIDEBAR -->
  <aside class="sidebar bg-white border-end border-success">
    <div onclick="location.href='stat_perso.php'">
      <i class="fas fa-user-circle me-2"></i>Stat Perso
    </div>
    <div onclick="location.href='stat_entreprise.php'">
      <i class="fas fa-building me-2"></i>Stat Entreprise
    </div>
    <div onclick="location.href='actualites.php'">
      <i class="fas fa-globe me-2"></i>Actualités ECO
    </div>
    <div onclick="location.href='recompenses.php'">
      <i class="fas fa-trophy me-2"></i>Récompenses
    </div>
  </aside>

<!-- CONTENU PRINCIPAL -->
<main>
  <!-- Hero -->
  <section class="hero text-center">
    <h1 class="text-success fw-bold">RÉDUISEZ VOTRE EMPREINTE CARBONE</h1>
    <p class="lead">Un outil ludique pour agir au quotidien</p>
    <a href="formulaire.php" class="btn btn-success btn-lg">Commencer le Quizz</a>
  </section>

<!-- Carousel -->
<div id="carouselEcoTrack" class="carousel slide my-5" data-bs-ride="carousel">
    <div class="carousel-inner">
      <!-- Premier item du carousel -->
      <div class="carousel-item active">
        <div class="carousel-item-img-container">
          <img src="../res/Images/Firefly image 1.jpg" class="d-block w-100" alt="slide 1">
        </div>
        <div class="carousel-item-text">
          <div class="carousel-text-left">
            <h3>Description à gauche</h3>
            <p>Cette application EcoTrack vous permet de calculer et de réduire votre empreinte carbone, avec des outils ludiques et interactifs.</p>
          </div>
          <div class="carousel-text-right">
            <h3>Description à droite</h3>
            <p>Explorez les statistiques et récompenses tout en suivant votre impact écologique et en ajustant vos habitudes pour un avenir plus vert.</p>
          </div>
        </div>
      </div>

      <!-- Deuxième item du carousel -->
      <div class="carousel-item">
        <div class="carousel-item-img-container">
          <img src="../res/Images/Firefly image 2.jpg" class="d-block w-100" alt="slide 2">
        </div>
        <div class="carousel-item-text">
          <div class="carousel-text-left">
            <h3>Description à gauche</h3>
            <p>Grâce à EcoTrack, vous pouvez suivre votre impact écologique au quotidien et faire des choix plus responsables.</p>
          </div>
          <div class="carousel-text-right">
            <h3>Description à droite</h3>
            <p>Restez motivé avec des statistiques en temps réel et des défis écologiques pour améliorer vos habitudes de consommation.</p>
          </div>
        </div>
      </div>

      <!-- Troisième item du carousel -->
      <div class="carousel-item">
        <div class="carousel-item-img-container">
          <img src="../res/Images/Firefly image 3.jpg" class="d-block w-100" alt="slide 3">
        </div>
        <div class="carousel-item-text">
          <div class="carousel-text-left">
            <h3>Description à gauche</h3>
            <p>Suivez votre progression et obtenez des récompenses en fonction de vos efforts pour réduire votre empreinte carbone.</p>
          </div>
          <div class="carousel-text-right">
            <h3>Description à droite</h3>
            <p>Partagez vos réussites avec vos amis et inspirez-les à rejoindre l'initiative pour un monde plus vert.</p>
          </div>
        </div>
  <!-- NAVBAR -->
  <nav class="navbar navbar-expand-lg bg-white border-bottom border-success">
    <div class="container-fluid">
      <a class="navbar-brand fw-bold" href="index.php">
        <i class="fas fa-leaf text-success me-2"></i>EcoTrack
      </a>
      <button class="navbar-toggler" id="burgerBtn" type="button" aria-label="Toggle menu">
        <i class="fas fa-bars fa-lg"></i>
      </button>
      <div class="collapse navbar-collapse d-none d-lg-flex justify-content-end" id="mainNav">
        <ul class="navbar-nav">
          <li class="nav-item"><a class="nav-link active" href="index.php">Accueil</a></li>
          <li class="nav-item"><a class="nav-link" href="formulaire.php">Quizz</a></li>
          <li class="nav-item"><a class="nav-link" href="contact.html">Contact</a></li>
          <li class="nav-item">
            <a class="nav-link" href="connexion.html">
              <i class="fas fa-user-circle me-1"></i>Mon Compte
            </a>
          </li>
        </ul>
      </div>
    </div>
  </nav>

  <!-- SIDEBAR desktop -->
  <aside class="sidebar d-none d-lg-block">
    <nav class="nav flex-column pt-4">
      <a class="nav-link active" href="index.php"><i class="fas fa-home me-2"></i>Accueil</a>
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
      <a class="nav-link py-2" href="contact.html">Contact</a>
      <a class="nav-link py-2" href="connexion.html">Mon Compte</a>
      <hr/>
      <a class="nav-link py-2" href="stat_perso.php">Stat Perso</a>
      <a class="nav-link py-2" href="stat_entreprise.php">Stat Entreprise</a>
      <a class="nav-link py-2" href="actualites.php">Actualités ECO</a>
      <a class="nav-link py-2" href="recompenses.php">Récompenses</a>
      <a class="nav-link py-2" href="classement.php">Classement</a>
    </nav>
  </div>

  <!-- MAIN CONTENT -->
  <main>
    <section class="hero text-center">
      <h1>RÉDUISEZ VOTRE EMPREINTE CARBONE</h1>
      <p>Un outil ludique pour agir au quotidien</p>
      <a href="formulaire.php" class="btn btn-success cta-btn">Commencer le Quizz</a>
    </section>

    <div id="carouselIndex" class="carousel slide my-5" data-bs-ride="carousel">
      <div class="carousel-inner">
    
        <div class="carousel-item active">
          <div class="carousel-item-content d-flex align-items-center justify-content-center flex-wrap">
    
            <!-- Texte à gauche -->
            <div class="carousel-text-left text-center text-md-start mb-3 mb-md-0 me-md-4">
              <h5>Agissez pour la planète</h5>
              <p>Découvrez comment chaque geste compte au quotidien.</p>
            </div>
    
            <!-- Image au centre -->
            <div class="carousel-item-img-container mx-4">
              <img 
                src="../res/images/Firefly image 1.jpg" 
                alt="Paysage écologique" 
                class="d-block carousel-img" />
            </div>
    
            <!-- Texte à droite -->
            <div class="carousel-text-right text-center text-md-end mt-3 mt-md-0 ms-md-4">
              <h5>Partagez vos progrès</h5>
              <p>Rejoignez une communauté engagée et inspirez vos proches.</p>
            </div>
    
          </div>
        </div>
    
        <!-- Répétez la même structure pour les autres slides -->
        <div class="carousel-item">
          <div class="carousel-item-content d-flex align-items-center justify-content-center flex-wrap">
            <div class="carousel-text-left text-center text-md-start mb-3 mb-md-0 me-md-4">
              <h5>Titre 2 à gauche</h5>
              <p>Description 2 …</p>
            </div>
    
            <div class="carousel-item-img-container mx-4">
              <img src="../res/images/Firefly image 2.jpg" alt="" class="d-block carousel-img" />
            </div>
    
            <div class="carousel-text-right text-center text-md-end mt-3 mt-md-0 ms-md-4">
              <h5>Titre 2 à droite</h5>
              <p>Description 2 …</p>
            </div>
          </div>
        </div>
    
      </div>
      <button class="carousel-control-prev" type="button" data-bs-target="#carouselIndex" data-bs-slide="prev">
        <span class="carousel-control-prev-icon"></span>
      </button>
      <button class="carousel-control-next" type="button" data-bs-target="#carouselIndex" data-bs-slide="next">
        <span class="carousel-control-next-icon"></span>
      </button>
    </div>
    
  </main>

  <!-- FOOTER -->
  <footer class="footer">
    &copy; 2025 EcoTrack | Tous droits réservés
  </footer>

  <!-- Bootstrap JS + burger script -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
  <script>
    document.addEventListener('DOMContentLoaded', () => {
      const burgerBtn  = document.getElementById('burgerBtn');
      const mobileMenu = document.getElementById('mobileMenu');
      burgerBtn.addEventListener('click', ()=> mobileMenu.classList.toggle('open'));
      mobileMenu.addEventListener('click', e => {
        if(e.target === mobileMenu) mobileMenu.classList.remove('open');
      });
    });
  </script>
</body>
</html>
