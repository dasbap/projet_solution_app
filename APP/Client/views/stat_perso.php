<?php require_once __DIR__ . '/../../Serveur/profil.php'; ?>
<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8"/>
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>EcoTrack – Mes statistiques</title>

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

  <!-- Chart.js -->
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

  <!-- CSS global & spécifique -->
  <link rel="stylesheet" href="../res/css/global.css"/>
  <link rel="stylesheet" href="../res/css/statperso.css"/>
</head>
<body class="d-flex flex-column min-vh-100">

  <!-- NAVBAR -->
  <nav class="navbar navbar-expand-lg bg-white border-bottom border-primary fixed-top">
    <div class="container-fluid">
      <a class="navbar-brand fw-bold text-primary" href="index.php">
        <i class="fas fa-leaf me-2"></i>EcoTrack
      </a>
      <button class="navbar-toggler" id="burgerBtn">
        <i class="fas fa-bars fa-lg text-primary"></i>
      </button>
      <div class="collapse navbar-collapse d-none d-lg-flex justify-content-end" id="mainNav">
        <ul class="navbar-nav">
          <li class="nav-item"><a class="nav-link" href="index.php">Accueil</a></li>
          <li class="nav-item"><a class="nav-link" href="formulaire.php">Quizz</a></li>
          <li class="nav-item"><a class="nav-link" href="contact.php">Contact</a></li>
          <li class="nav-item">
            <a class="nav-link" href="connexion.php"><i class="fas fa-user-circle me-1"></i>Mon Compte</a>
          </li>
        </ul>
      </div>
    </div>
  </nav>

  <!-- SIDEBAR -->
  <aside class="sidebar bg-white border-end border-primary d-none d-lg-block">
    <nav class="nav flex-column pt-4">
      <a class="nav-link active"><i class="fas fa-user-circle me-2 text-primary"></i>Stat Perso</a>
      <a class="nav-link" href="stat_entreprise.php"><i class="fas fa-building me-2 text-success"></i>Stat Entreprise</a>
      <a class="nav-link" href="actualites.php"><i class="fas fa-globe me-2 text-info"></i>Actualités</a>
      <a class="nav-link" href="recompenses.php"><i class="fas fa-trophy me-2 text-warning"></i>Récompenses</a>
      <a class="nav-link" href="classement.php"><i class="fas fa-list-ol me-2 text-secondary"></i>Classement</a>
    </nav>
  </aside>

  <!-- MENU MOBILE -->
  <div class="mobile-menu d-lg-none" id="mobileMenu">
    <nav class="nav flex-column text-center pt-4">
      <a class="nav-link py-2" href="index.php">Accueil</a>
      <a class="nav-link py-2" href="formulaire.php">Quizz</a>
      <a class="nav-link py-2" href="contact.php">Contact</a>
      <a class="nav-link py-2" href="connexion.php">Mon Compte</a>
      <hr/>
      <a class="nav-link py-2 active" href="#">Stat Perso</a>
      <a class="nav-link py-2" href="stat_entreprise.php">Stat Entreprise</a>
      <a class="nav-link py-2" href="actualites.php">Actualités</a>
      <a class="nav-link py-2" href="recompenses.php">Récompenses</a>
      <a class="nav-link py-2" href="classement.php">Classement</a>
    </nav>
  </div>

  <!-- CONTENU -->
  <main class="flex-fill">
    <section class="intro py-5">
      <div class="container">
        <h1 class="page-title">Mes statistiques personnelles</h1>
        <p class="page-subtitle mb-3">Résumé de vos dernières réponses au quiz</p>
        <p class="mb-0">Vous avez répondu à <strong id="count">0</strong> questions lors de votre dernière session.</p>
      </div>
    </section>

    <section class="dash-row container">
      <article class="dash-card">
        <h2>Évolution par question</h2>
        <canvas id="chartLine"></canvas>
      </article>
      <article class="dash-card">
        <h2>Répartition par catégorie</h2>
        <canvas id="chartBar"></canvas>
      </article>
      <article class="dash-card">
        <h2>Totaux mensuels</h2>
        <canvas id="chartPie"></canvas>
      </article>
    </section>

    <section class="summary-card mb-4">
  <i class="fas fa-heart"></i>
  <!-- Affichage du score total ce mois-ci -->
  <p>Total de points ce mois-ci : <strong><span id="totalPoints">0</span></strong></p>
</section>
  </main>

  <!-- FOOTER -->
  <footer class="footer bg-dark text-white text-center py-3 mt-auto">
    &copy; 2025 EcoTrack | Tous droits réservés
  </footer>

  <!-- JS -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
  <script src="../res/js/statperso.js"></script>
</body>
</html>
