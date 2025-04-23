<!DOCTYPE html>

<?php require_once("../../Serveur/profil.php"); ?>


<html lang="fr">
<head>
  <meta charset="UTF-8"/>
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>EcoTrack – Stat Entreprise</title>

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

  <!-- CSS spécifique Stat Entreprise -->
  <link rel="stylesheet" href="../res/css/statentreprise.css"/>
  <link rel="stylesheet" href="../res/css/global.css">
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
  <nav class="nav flex-column pt-4">
    <a class="nav-link" href="stat_perso.php">
      <i class="fas fa-user-circle me-2"></i>Stat Perso
    </a>
    <a class="nav-link" href="stat_entreprise.php">
      <i class="fas fa-building me-2"></i>Stat Entreprise
    </a>
    <a class="nav-link" href="actualites.php">
      <i class="fas fa-globe me-2"></i>Actualités ECO
    </a>
    <a class="nav-link" href="recompenses.php">
      <i class="fas fa-trophy me-2"></i>Récompenses
    </a>
    <a class="nav-link" href="classement.php">
      <i class="fas fa-list-ol me-2"></i>Classement
    </a>
  </nav>
</aside>

  <!-- SIDEBAR desktop -->
  <aside class="sidebar bg-white border-end border-success">
  <nav class="nav flex-column pt-4">
    <a class="nav-link" href="stat_perso.php">
      <i class="fas fa-user-circle me-2"></i>Stat Perso
    </a>
    <a class="nav-link" href="stat_entreprise.php">
      <i class="fas fa-building me-2"></i>Stat Entreprise
    </a>
    <a class="nav-link" href="actualites.php">
      <i class="fas fa-globe me-2"></i>Actualités ECO
    </a>
    <a class="nav-link" href="recompenses.php">
      <i class="fas fa-trophy me-2"></i>Récompenses
    </a>
    <a class="nav-link" href="classement.php">
      <i class="fas fa-list-ol me-2"></i>Classement
    </a>
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
      <a class="nav-link py-2 active" href="actualites.php">Actualités ECO</a>
      <a class="nav-link py-2" href="recompenses.php">Récompenses</a>
      <a class="nav-link py-2" href="classement.php">Classement</a>
    </nav>
  </div>

  <!-- CONTENU PRINCIPAL -->
  <main class="flex-fill">
    <section class="intro mb-4">
      <h1 class="page-title">Statistiques des Entreprises</h1>
      <p class="page-subtitle">Suivi des résultats des entreprises ayant participé au Quizz</p>
    </section>

    <section class="dash-row mb-4">
      <article class="dash-card">
        <h2>Évolution Hebdo (kg CO₂)</h2>
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

    <section class="summary-card mb-4">
      <i class="fas fa-building"></i>
      <p>L’entreprise moyenne a économisé <strong>150 kg CO₂</strong> ce mois-ci</p>
    </section>
  </main>

  <!-- FOOTER -->
  <footer class="footer bg-dark text-white text-center py-3">
    &copy; 2025 EcoTrack | Tous droits réservés
  </footer>

  <!-- Bootstrap JS + burger + Chart.init -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
  <script>
    document.addEventListener('DOMContentLoaded', () => {
      // burger mobile
      const burgerBtn  = document.getElementById('burgerBtn');
      const mobileMenu = document.getElementById('mobileMenu');
      burgerBtn.addEventListener('click', () => mobileMenu.classList.toggle('open'));
      mobileMenu.addEventListener('click', e => {
        if (e.target === mobileMenu) mobileMenu.classList.remove('open');
      });

      // Graphique en ligne
      new Chart(document.getElementById('chartLine'), {
        type: 'line',
        data: {
          labels: ['S1','S2','S3','S4','S5','S6'],
          datasets: [{
            label: 'kg CO₂',
            data: [20, 22, 19, 23, 21, 24],
            backgroundColor: 'rgba(40,167,69,0.2)',
            borderColor: '#28a745',
            borderWidth: 2,
            fill: true
          }]
        },
        options: { responsive: true, maintainAspectRatio: false, scales: { y: { beginAtZero: true } } }
      });

      // Graphique à barres
      new Chart(document.getElementById('chartBar'), {
        type: 'bar',
        data: {
          labels: ['Transport','Alimentation','Énergie','Déchets','Autres'],
          datasets: [{ label: 'kg CO₂', data: [12, 8, 5, 3, 2], backgroundColor: '#28a745' }]
        },
        options: { responsive: true, maintainAspectRatio: false, scales: { y: { beginAtZero: true } } }
      });

      // Camembert
      new Chart(document.getElementById('chartPie'), {
        type: 'pie',
        data: {
          labels: ['France','Europe','Monde','Autres'],
          datasets: [{ data: [50, 25, 15, 10], backgroundColor: ['#28a745','#6cc57a','#a2d5a0','#d8f3dc'] }]
        },
        options: { responsive: true, maintainAspectRatio: false }
      });
    });
  </script>
  
</body>
</html>
