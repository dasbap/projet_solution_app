document.addEventListener('DOMContentLoaded', () => {
  // Récupération des données JSON depuis PHP
  fetch('../../Serveur/reqBdd/getclassement.php', { credentials: 'include' })
    .then(res => res.json())
    .then(({ users, companies }) => {
      console.log('Users:', users); // Ajouter un log pour déboguer
      console.log('Companies:', companies); // Ajouter un log pour déboguer

      // Vérification que les données sont bien présentes
      if (!users || !companies) {
        console.error('Données manquantes pour classement');
        return;
      }

      // Trie décroissant des utilisateurs et entreprises
      users.sort((a, b) => b.score - a.score);
      companies.sort((a, b) => b.total_score - a.total_score);

      // Fonction pour afficher les classements
      function renderList(containerId, items, isUser) {
        const ul = document.getElementById(containerId);
        ul.innerHTML = '';
        items.forEach((it, idx) => {
          const li = document.createElement('li');
          li.className = 'list-group-item';
          // Affichage des utilisateurs et des entreprises
          li.textContent = isUser
            ? `${idx + 1}. ${it.user_name} – ${it.score} pts`
            : `${idx + 1}. ${it.name_company} – ${it.total_score.toLocaleString('fr-FR')} kg CO₂ économisés`;

          // Ajout de la classe 'table-primary' pour l'utilisateur actuel ou l'entreprise
          if (it.user_name.startsWith('Vous')) li.classList.add('table-primary');
          ul.appendChild(li);
        });
      }

      renderList('personal-list', users, true);  // Classement des utilisateurs
      renderList('company-list', companies, false);  // Classement des entreprises

      // Boutons “Voir mon rang”
      document.getElementById('btn-personal')
        .addEventListener('click', () => {
          const my = document.querySelector('#personal-list .table-primary');
          if (my) my.scrollIntoView({ behavior: 'smooth', block: 'center' });
        });

      document.getElementById('btn-company')
        .addEventListener('click', () => {
          const my = document.querySelector('#company-list .table-primary');
          if (my) my.scrollIntoView({ behavior: 'smooth', block: 'center' });
        });
    })
    .catch(err => console.error('Erreur fetch classement :', err));
});
