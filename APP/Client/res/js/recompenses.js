document.addEventListener('DOMContentLoaded', () => {
    // Lier les avatars avec une action de mise à jour
    const avatarButtons = document.querySelectorAll('.avatar-item button');
    
    avatarButtons.forEach((button, index) => {
      button.addEventListener('click', () => {
        const selectedAvatar = `Avatar ${index + 1}`;
        alert(`Vous avez sélectionné ${selectedAvatar}! Votre avatar a été mis à jour.`);
        // Mettre à jour l'avatar dans l'application (cela dépend de la structure de votre app)
        // Exemple : document.getElementById('avatarDisplay').src = `avatar${index + 1}.png`;
      });
    });
  });
  