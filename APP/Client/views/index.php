<!DOCTYPE html>


<?php require_once("../../Serveur/profil.php"); ?>


<html lang="fr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>EcoTrack</title>

  <!-- Préconnexion pour les polices Google Fonts -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>

  <!-- Polices Manrope et Inter -->
  <link href="https://fonts.googleapis.com/css2?family=Manrope:wght@200..800&display=swap" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=Inter:ital,opsz,wght@0,14..32,100..900;1,14..32,100..900&display=swap" rel="stylesheet">

  <!-- Bootstrap CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <!-- FontAwesome (icônes) -->
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">

  <link rel="stylesheet" href="../res/css/index.css">
  <link rel="stylesheet" href="../res/css/base.css"/>
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
      </div>
    </div>
    <button class="carousel-control-prev" type="button" data-bs-target="#carouselEcoTrack" data-bs-slide="prev">
      <span class="carousel-control-prev-icon"></span>
    </button>
    <button class="carousel-control-next" type="button" data-bs-target="#carouselEcoTrack" data-bs-slide="next">
      <span class="carousel-control-next-icon"></span>
    </button>
</div>
  
</main>

<!-- FOOTER -->
<footer class="bg-dark text-white text-center py-3">
  <p>&copy; 2025 EcoTrack | Tous droits réservés</p>
</footer>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
