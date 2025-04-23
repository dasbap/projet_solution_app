<!DOCTYPE html>

<?php require_once("../../Serveur/profil.php"); ?>


<html lang="fr">
<head>
  <meta charset="UTF-8"/>
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>EcoTrack – Stat Perso</title>

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

  <!-- CSS spécifique -->
  <link rel="stylesheet" href="../res/css/statperso.css"/>
</head>
<body class="d-flex flex-column min-vh-100">

<<<<<<< Updated upstream:APP/Client/views/stat_perso.php
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
=======
  <!-- NAVBAR -->
  <nav class="navbar navbar-expand-lg bg-white border-bottom border-success fixed-top">
    <div class="container-fluid">
      <a class="navbar-brand fw-bold" href="index.html">
        <i class="fas fa-leaf text-success me-2"></i>EcoTrack
      </a>
      <button class="navbar-toggler" id="burgerBtn" type="button" aria-label="Toggle menu">
        <i class="fas fa-bars fa-lg"></i>
      </button>
      <div class="collapse navbar-collapse d-none d-lg-flex justify-content-end" id="mainNav">
        <ul class="navbar-nav">
          <li class="nav-item"><a class="nav-link" href="index.html">Accueil</a></li>
          <li class="nav-item"><a class="nav-link" href="formulaire.html">Quizz</a></li>
          <li class="nav-item"><a class="nav-link" href="contact.html">Contact</a></li>
          <li class="nav-item">
            <a class="nav-link" href="connexion.html">
              <i class="fas fa-user-circle me-1"></i>Mon Compte
            </a>
          </li>
        </ul>
>>>>>>> Stashed changes:APP/Client/views/stat_perso.html
      </div>
    </div>
  </nav>

<<<<<<< Updated upstream:APP/Client/views/stat_perso.php
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
=======
  <!-- SIDEBAR desktop -->
  <aside class="sidebar bg-white border-end border-success d-none d-lg-block">
    <nav class="nav flex-column pt-4">
      <a class="nav-link" href="stat_perso.html"><i class="fas fa-user-circle me-2"></i>Stat Perso</a>
      <a class="nav-link" href="stat_entreprise.html"><i class="fas fa-building me-2"></i>Stat Entreprise</a>
      <a class="nav-link" href="actualites.html"><i class="fas fa-globe me-2"></i>Actualités ECO</a>
      <a class="nav-link" href="recompenses.html"><i class="fas fa-trophy me-2"></i>Récompenses</a>
      <a class="nav-link" href="classement.html"><i class="fas fa-list-ol me-2"></i>Classement</a>
    </nav>
>>>>>>> Stashed changes:APP/Client/views/stat_perso.html
  </aside>

  <!-- MENU MOBILE overlay -->
  <div class="mobile-menu d-lg-none" id="mobileMenu">
    <nav class="nav flex-column text-center pt-4">
      <a class="nav-link py-2" href="index.html">Accueil</a>
      <a class="nav-link py-2" href="formulaire.html">Quizz</a>
      <a class="nav-link py-2" href="contact.html">Contact</a>
      <a class="nav-link py-2" href="connexion.html">Mon Compte</a>
      <hr/>
      <a class="nav-link py-2" href="stat_perso.html">Stat Perso</a>
      <a class="nav-link py-2" href="stat_entreprise.html">Stat Entreprise</a>
      <a class="nav-link py-2" href="actualites.html">Actualités ECO</a>
      <a class="nav-link py-2" href="recompenses.html">Récompenses</a>
      <a class="nav-link py-2" href="classement.html">Classement</a>
    </nav>
  </div>

  <!-- CONTENU PRINCIPAL -->
  <main class="flex-fill">
    <section class="intro mb-4">
      <h1 class="page-title">Mes Statistiques Personnelles</h1>
      <p class="page-subtitle">Suivi de votre consommation carbone issue du quizz</p>
      <p class="question-count">Vous avez répondu à <strong id="count">0</strong> questions</p>
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
      <i class="fas fa-heart"></i>
      <p>Vous avez économisé <strong>24 kg CO₂</strong> ce mois-ci</p>
    </section>
  </main>

  <!-- FOOTER -->
  <footer class="footer bg-dark text-white text-center py-3">
    &copy; 2025 EcoTrack | Tous droits réservés
  </footer>

  <!-- Bootstrap JS + burger script + Chart init -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
  <script>
    document.addEventListener('DOMContentLoaded', () => {
      // burger toggle
      const burgerBtn  = document.getElementById('burgerBtn');
      const mobileMenu = document.getElementById('mobileMenu');
      burgerBtn.addEventListener('click', () => mobileMenu.classList.toggle('open'));
      mobileMenu.addEventListener('click', e => {
        if (e.target === mobileMenu) mobileMenu.classList.remove('open');
      });

      // simulate count
      document.getElementById('count').textContent = 6;

      // charts
      new Chart(document.getElementById('chartLine'), {
        type: 'line',
        data: {
          labels: ['S1','S2','S3','S4','S5','S6'],
          datasets: [{ label: 'kg CO₂', data:[12,15,14,10,8,11],
            backgroundColor:'rgba(40,167,69,0.2)', borderColor:'#28a745',
            borderWidth:2, fill:true }]
        },
        options:{ responsive:true, maintainAspectRatio:false, scales:{ y:{ beginAtZero:true } } }
      });
      new Chart(document.getElementById('chartBar'), {
        type: 'bar',
        data:{
          labels:['Transport','Alimentation','Énergie','Déchets','Autres'],
          datasets:[{ label:'kg CO₂', data:[8,5,3,2,1], backgroundColor:'#28a745' }]
        },
        options:{ responsive:true, maintainAspectRatio:false, scales:{ y:{ beginAtZero:true } } }
      });
      new Chart(document.getElementById('chartPie'), {
        type:'pie',
        data:{
          labels:['France','Europe','Monde','Autres'],
          datasets:[{ data:[40,30,20,10],
            backgroundColor:['#28a745','#6cc57a','#a2d5a0','#d8f3dc'] }]
        },
        options:{ responsive:true, maintainAspectRatio:false }
      });
    });
  </script>
</body>
</html>
