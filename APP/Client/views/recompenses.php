<!DOCTYPE html>

<?php require_once("../../Serveur/profil.php"); ?>


<html lang="fr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>EcoTrack - Récompenses</title>
  
  <!-- Lier le CSS des récompenses -->
  <link rel="stylesheet" href="../res/css/recompenses.css">
  <link rel="stylesheet" href="../res/css/base.css"/>
  
  <!-- Lien vers Bootstrap & FontAwesome -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">

   <!-- Bootstrap CSS -->
   <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
   <!-- FontAwesome (icônes) -->
   <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
</head>
<body>
  
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

  <!-- Navbar -->
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

  <!-- Main Content -->
  <main>
    <section class="hero">
      <h1>Récompenses</h1>
      <p>Utilisez vos points pour personnaliser votre avatar !</p>
    </section>
    
    <div class="container">
      <p>Vous avez <strong>150 points</strong> disponibles.</p>
      
      <div class="row">
        <div class="col-md-4">
          <div class="avatar-item">
            <img src="../res/Images/avatar_1.webp" alt="Avatar 1" class="img-fluid">
            <button class="btn btn-success">Sélectionner</button>
          </div>
        </div>
        <div class="col-md-4">
          <div class="avatar-item">
            <img src="../res/Images/avatar_2.webp" alt="Avatar 2" class="img-fluid">
            <button class="btn btn-success">Sélectionner</button>
          </div>
        </div>
        <div class="col-md-4">
          <div class="avatar-item">
            <img src="../res/Images/avatar_3.webp" alt="Avatar 3" class="img-fluid">
            <button class="btn btn-success">Sélectionner</button>
          </div>
        </div>
      </div>
    </div>
    
  </main>

  <!-- Footer -->
  <footer class="bg-dark text-white text-center py-3">
    <p>&copy; 2025 EcoTrack | Tous droits réservés</p>
  </footer>
  
  <!-- JavaScript -->
  <script src="../res/js/recompenses.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
