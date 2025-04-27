<!DOCTYPE html>
<?php require_once("../../Serveur/profil.php"); ?>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Formulaire d'Impact Carbone – EcoTrack</title>

  <!-- Google Fonts -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600&family=Manrope:wght@700&display=swap" rel="stylesheet">

  <!-- Bootstrap & FontAwesome -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">

  <!-- Styles spécifiques -->
  <link rel="stylesheet" href="../res/css/formulaire.css">
  <link rel="stylesheet" href="../res/css/index.css">

</head>
<body class="d-flex flex-column min-vh-100">

<!-- NAVBAR -->
<nav class="navbar navbar-expand-lg">
  <div class="container-fluid">
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
      <i class="fas fa-user-circle me-2"></i>Stat Perso
    </div>
    <div onclick="location.href='stat_entreprise.php'">
      <i class="fas fa-building me-2"></i>Stat Entreprise
    </div>
    <div onclick="location.href='actualites.php'">
      <i class="fas fa-globe me-2"></i>Actualités ECO
    </div>
    <div onclick="location.href='recompenses.php'">
      <i class="fas fa-trophy me-2"></i>Récompenses
    </div>
  </aside>

  <!-- CONTENU PRINCIPAL -->
  <main class="flex-fill" id="mainContent">
    <div class="container py-5">
      <!-- Logo centré -->
      <div class="text-center mb-4">
        <img src="../res/Images/merci.png"
              alt="Logo EcoTrack"
              class="logo">
      </div>

      <h1 class="text-center mb-4">Formulaire d’Impact Carbone</h1>

      <form id="carboneForm" action="../../Serveur/formulaire.php" method="POST" novalidate>
        <div id="formContent"></div> 
      </form>

    </div>
  </main>

  <!-- FOOTER -->
  <footer class="mt-auto bg-dark text-white text-center py-3">
    &copy; 2025 EcoTrack | Tous droits réservés
  </footer>

  <!-- Scripts -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
  <script src="../res/js/formulaire.js"></script>
</body>
</html>