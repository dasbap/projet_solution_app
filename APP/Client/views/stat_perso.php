<!DOCTYPE html>

<?php require_once("../../Serveur/profil.php"); ?>


<html lang="fr">
<head>
  <meta charset="UTF-8"/>
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>EcoTrack - Stat Perso</title>

  <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com"/>
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin/>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600&family=Manrope:wght@700&display=swap" rel="stylesheet"/>
    <link href="https://fonts.googleapis.com/css2?family=Manrope:wght@200..800&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:ital,opsz,wght@0,14..32,100..900;1,14..32,100..900&display=swap" rel="stylesheet">


  <!-- Bootstrap & FontAwesome -->
  <link
    href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css"
    rel="stylesheet"/>
  <link
    href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css"
    rel="stylesheet"/>

  <!-- Chart.js (nécessaire avant statperso.js) -->
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

  <!-- Styles spécifiques Stat Perso -->
  <link rel="stylesheet" href="../res/css/statperso.css"/>
  <link rel="stylesheet" href="../res/css/base.css"/>
</head>
<body>

  <!-- HEADER / NAVBAR -->
  <header>
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
  </header>

  <!-- SIDEBAR -->
  <aside class="sidebar">
    <nav class="nav flex-column">
      <a class="nav-link" href="#stat-perso">
        <i class="fas fa-star me-2"></i>Stat Perso
      </a>
      <a class="nav-link" href="#stat-entreprise">
        <i class="fas fa-building me-2"></i>Stat Entreprise
      </a>
      <a class="nav-link" href="#actus">
        <i class="fas fa-globe me-2"></i>Actualités ECO
      </a>
      <a class="nav-link" href="#recompenses">
        <i class="fas fa-trophy me-2"></i>Récompenses
      </a>
    </nav>
  </aside>

  <!-- CONTENU PRINCIPAL -->
  <main>
    <!-- Intro + compteur -->
    <section class="intro mb-4">
      <h1 class="page-title">Mes Statistiques Personnelles</h1>
      <p class="page-subtitle">Suivi de votre consommation carbone issue du quizz</p>

      <!-- ← Compteur de questions -->
      <p class="question-count">
        Vous avez répondu à <strong id="count">0</strong> questions
      </p>
    </section>

    <!-- Dashboards -->
    <section class="dash-row mb-4">
      <article class="dash-card">
        <h2>Évolution Hebdo (kg CO₂)</h2>
        <canvas id="chartLine"></canvas>
      </article>
      <article class="dash-card">
        <h2>Répartition par Catégorie</h2>
        <canvas id="chartBar"></canvas>
      </article>
      <article class="dash-card">
        <h2>Totaux Mensuels</h2>
        <canvas id="chartPie"></canvas>
      </article>
    </section>

    <!-- Synthèse -->
    <section class="summary-card">
      <i class="fas fa-heart"></i>
      <p>Vous avez économisé&nbsp;<strong>24 kg CO₂</strong>&nbsp;ce mois-ci</p>
    </section>
  </main>
  <footer class="bg-dark text-white text-center py-3">
    <p>&copy; 2025 EcoTrack | Tous droits réservés</p>
  </footer>

  <!-- Scripts -->
  <!-- statperso.js (doit venir après Chart.js) -->
  <script src="../res/js/statperso.js"></script>
  <!-- Bootstrap JS -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
