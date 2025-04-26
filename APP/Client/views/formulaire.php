<?php require_once("../../Serveur/profil.php"); ?>

<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8"/>
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>EcoTrack – Formulaire d'Impact Carbone</title>

  <!-- Google Fonts -->
  <link rel="preconnect" href="https://fonts.googleapis.com"/>
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin/>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600&family=Manrope:wght@700&display=swap" rel="stylesheet"/>

  <!-- Bootstrap & FontAwesome -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet"/>
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet"/>

  <!-- Styles spécifiques -->
  <link rel="stylesheet" href="../res/css/formulaire.css"/>
  <link rel="stylesheet" href="../res/css/global.css"/>

</head>
<body class="d-flex flex-column min-vh-100">

<!-- NAVBAR -->
<nav class="navbar navbar-expand-lg bg-white border-bottom border-success fixed-top">
  <div class="container-fluid">
    <a class="navbar-brand fw-bold" href="index.php">
      <i class="fas fa-leaf text-success me-2"></i>EcoTrack
    </a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#mainNav">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse justify-content-end" id="mainNav">
      <ul class="navbar-nav">
        <li class="nav-item"><a class="nav-link" href="index.php">Accueil</a></li>
        <li class="nav-item"><a class="nav-link active" href="formulaire.php">Quizz</a></li>
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
<aside class="sidebar bg-white border-end border-success">
  <nav class="nav flex-column pt-4">
    <a class="nav-link" href="index.php"><i class="fas fa-home me-2"></i>Accueil</a>
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
<main class="flex-fill">
  <div class="container py-5">
    <!-- Logo centré -->
    <div class="text-center mb-4">
      <img src="../res/images/Logo-EcoTrack.svg" alt="Logo EcoTrack" class="logo">
    </div>

    <h1 class="text-center mb-4">Formulaire d’Impact Carbone</h1>

    <form id="carboneForm" action="../../Serveur/formulaire.php" method="POST" novalidate>
      <div id="formContent"></div> <!-- Contenu généré dynamiquement -->
    </form>

  </div>
</main>

<!-- FOOTER -->
<footer class="mt-auto bg-dark text-white text-center py-3">
  &copy; 2025 EcoTrack | Tous droits réservés
</footer>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
// Utilisation du fetch pour récupérer le fichier JSON des questions
fetch('../res/data/questions.json')
  .then(response => response.json())
  .then(questions => {
    const formContainer = document.getElementById('formContent');
    
    // Parcours des questions et création des éléments du formulaire
    questions.forEach(question => {
      const questionDiv = document.createElement('div');
      questionDiv.classList.add('mb-3');
      
      const questionTitle = document.createElement('h5');
      questionTitle.textContent = question.question_text;
      questionDiv.appendChild(questionTitle);
      
      if (question.type === 'select') {
        const selectElement = document.createElement('select');
        selectElement.classList.add('form-select');
        selectElement.name = question.id;

        question.options.forEach(option => {
          const optionElement = document.createElement('option');
          optionElement.value = option.score;
          optionElement.textContent = option.label;
          selectElement.appendChild(optionElement);
        });

        questionDiv.appendChild(selectElement);
      } else if (question.type === 'number') {
        const numberInput = document.createElement('input');
        numberInput.classList.add('form-control');
        numberInput.type = 'number';
        numberInput.name = question.id;
        numberInput.placeholder = `Entrez votre réponse pour ${question.question_text}`;
        questionDiv.appendChild(numberInput);
      }

      formContainer.appendChild(questionDiv);
    });
  })
  .catch(error => console.error('Erreur lors de la récupération des questions:', error));
</script>
</body>
</html>
