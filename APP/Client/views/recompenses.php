<!DOCTYPE html>

<?php require_once("../../Serveur/profil.php"); ?>


<html lang="fr">
<head>
  <meta charset="UTF-8"/>
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>EcoTrack – Récompenses</title>

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

  <!-- Votre CSS global -->
  <link rel="stylesheet" href="../res/css/global.css"/>
  <!-- CSS spécifique Récompenses -->
  <link rel="stylesheet" href="../res/css/recompenses.css"/>
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
      <a class="nav-link" href="index.php"><i class="fas fa-home me-2"></i>Accueil</a>
      <a class="nav-link" href="stat_perso.php"><i class="fas fa-user-circle me-2"></i>Stat Perso</a>
      <a class="nav-link" href="stat_entreprise.php"><i class="fas fa-building me-2"></i>Stat Entreprise</a>
      <a class="nav-link" href="actualites.php"><i class="fas fa-globe me-2"></i>Actualités ECO</a>
      <a class="nav-link active" href="recompenses.php"><i class="fas fa-trophy me-2"></i>Récompenses</a>
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
      <a class="nav-link py-2 active" href="recompenses.php">Récompenses</a>
      <a class="nav-link py-2" href="classement.php">Classement</a>
    </nav>
  </div>

  <!-- CONTENU PRINCIPAL -->
  <main class="flex-fill">
  <section class="rewards-grid mb-5">
  <!-- 1 -->
  <div class="reward-card">
    <i class="fas fa-seedling fa-2x text-success"></i>
    <h5>Badge “Green Starter”</h5>
    <p>Obtenu après 5 réponses au quiz.</p>
  </div>

  <!-- 2 -->
  <div class="reward-card">
    <i class="fas fa-leaf fa-2x text-success"></i>
    <h5>Badge “Eco Warrior”</h5>
    <p>Obtenu après 10 réponses correctes.</p>
  </div>

  <!-- 3 -->
  <div class="reward-card">
    <i class="fas fa-tree fa-2x text-success"></i>
    <h5>Badge “Tree Planter”</h5>
    <p>Obtenu après 20 kg de CO₂ économisés.</p>
  </div>

  <!-- 4 -->
  <div class="reward-card">
    <i class="fas fa-recycle fa-2x text-success"></i>
    <h5>Badge “Recycler Pro”</h5>
    <p>Obtenu après 15 objets recyclés.</p>
  </div>

  <!-- 5 -->
  <div class="reward-card">
    <i class="fas fa-solar-panel fa-2x text-success"></i>
    <h5>Badge “Solar Champion”</h5>
    <p>Obtenu après 30 € d’électricité renouvelable achetée.</p>
  </div>

  <!-- 6 -->
  <div class="reward-card">
    <i class="fas fa-tint fa-2x text-success"></i>
    <h5>Badge “Water Saver”</h5>
    <p>Obtenu après 10 jours de consommation d’eau réduite.</p>
  </div>

  <!-- 7 -->
  <div class="reward-card">
    <i class="fas fa-biking fa-2x text-success"></i>
    <h5>Badge “Bike Commuter”</h5>
    <p>Obtenu après 5 trajets à vélo.</p>
  </div>

  <!-- 8 -->
  <div class="reward-card">
    <i class="fas fa-shopping-basket fa-2x text-success"></i>
    <h5>Badge “Zero Waste Shopper”</h5>
    <p>Obtenu après 7 courses zéro déchet.</p>
  </div>

  <!-- 9 -->
  <div class="reward-card">
    <i class="fas fa-fire-alt fa-2x text-success"></i>
    <h5>Badge “Carbon Cutter”</h5>
    <p>Obtenu après 25 kg de CO₂ en moins.</p>
  </div>

  <!-- 10 -->
  <div class="reward-card">
    <i class="fas fa-trash-restore fa-2x text-success"></i>
    <h5>Badge “Plastic Buster”</h5>
    <p>Obtenu après 20 plastiques à usage unique évités.</p>
  </div>

  <!-- 11 -->
  <div class="reward-card">
    <i class="fas fa-bolt fa-2x text-success"></i>
    <h5>Badge “Energy Saver”</h5>
    <p>Obtenu après 10 % d’économie d’électricité.</p>
  </div>

  <!-- 12 -->
  <div class="reward-card">
    <i class="fas fa-seedling fa-2x text-success"></i>
    <h5>Badge “Composter”</h5>
    <p>Obtenu après 5 kg de déchets compostés.</p>
  </div>

  <!-- 13 -->
  <div class="reward-card">
    <i class="fas fa-users fa-2x text-success"></i>
    <h5>Badge “Community Leader”</h5>
    <p>Obtenu après avoir invité 5 amis.</p>
  </div>

  <!-- 14 -->
  <div class="reward-card">
    <i class="fas fa-tree fa-2x text-success"></i>
    <h5>Badge “Forest Guardian”</h5>
    <p>Obtenu après 50 arbres plantés.</p>
  </div>

  <!-- 15 -->
  <div class="reward-card">
    <i class="fas fa-wind fa-2x text-success"></i>
    <h5>Badge “Clean Air Advocate”</h5>
    <p>Obtenu après réduction de 30 % du transport en voiture.</p>
  </div>

  <!-- 16 -->
  <div class="reward-card">
    <i class="fas fa-water fa-2x text-success"></i>
    <h5>Badge “Marine Protector”</h5>
    <p>Obtenu après nettoyage de 10 m de plage.</p>
  </div>

  <!-- 17 -->
  <div class="reward-card">
    <i class="fas fa-utensils fa-2x text-success"></i>
    <h5>Badge “Sustainable Chef”</h5>
    <p>Obtenu après 7 repas végétariens.</p>
  </div>

  <!-- 18 -->
  <div class="reward-card">
    <i class="fas fa-plane-departure fa-2x text-success"></i>
    <h5>Badge “Eco Traveler”</h5>
    <p>Obtenu après 3 voyages en train.</p>
  </div>

  <!-- 19 -->
  <div class="reward-card">
    <i class="fas fa-laptop fa-2x text-success"></i>
    <h5>Badge “Tech Recycler”</h5>
    <p>Obtenu après recyclage d’un appareil électronique.</p>
  </div>

  <!-- 20 -->
  <div class="reward-card">
    <i class="fas fa-globe fa-2x text-success"></i>
    <h5>Badge “Earth Ambassador”</h5>
    <p>Obtenu après avoir partagé 10 actions écologiques.</p>
  </div>
</section>


  </main>

  <!-- FOOTER -->
  <footer class="footer bg-dark text-white text-center py-3">
    &copy; 2025 EcoTrack | Tous droits réservés
  </footer>

  <!-- Bootstrap JS + hamburger script -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
  <script>
    document.addEventListener('DOMContentLoaded', () => {
      const burgerBtn  = document.getElementById('burgerBtn');
      const mobileMenu = document.getElementById('mobileMenu');
      burgerBtn.addEventListener('click', ()=> mobileMenu.classList.toggle('open'));
      mobileMenu.addEventListener('click', e => {
        if (e.target === mobileMenu) mobileMenu.classList.remove('open');
      });
    });
  </script>
</body>
</html>
