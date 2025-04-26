
<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Connexion – EcoTrack</title>

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

  <!-- Votre CSS spécifique -->
  <link rel="stylesheet" href="../res/css/connexion.css"/>
</head>
<body class="d-flex align-items-center justify-content-center min-vh-100 bg-light">

  <div class="card p-4 shadow-sm" style="max-width: 400px; width: 100%;">
    <!-- Logo centré -->
    <div class="text-center mb-3">
      <img src="../res/images/Logo-EcoTrack.svg"
           alt="Logo EcoTrack"
           style="max-width: 150px; width: 100%; height: auto;">
    </div>
    <h2 class="h5 text-center mb-4">Se connecter</h2>

    <form action="../../Serveur/login.php" method="POST" novalidate>
      <div class="mb-3">
        <label for="email" class="form-label">Email :</label>
        <input type="email"
               id="email"
               name="email"
               class="form-control"
               placeholder="votre.email@exemple.com"
               required>
      </div>
      <div class="mb-3">
        <label for="password" class="form-label">Mot de passe :</label>
        <input type="password"
               id="password"
               name="password"
               class="form-control"
               placeholder="Votre mot de passe"
               required>
        <a href="motdepasseoublie.php" class="small">Mot de passe oublié ?</a>
      </div>
      <button type="submit" class="btn btn-success w-100">Connexion</button>
    </form>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
