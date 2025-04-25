document.addEventListener('DOMContentLoaded', () => {
  // Récupération des données JSON depuis PHP
  fetch('classement.php')
    .then(res => res.json())
    .then(({ users, companies }) => {
      // Trie décroissant
      users.sort((a,b) => b.pts - a.pts);
      companies.sort((a,b) => b.eco - a.eco);

      // Fonction de rendu
      function renderList(containerId, items, isUser) {
        const ul = document.getElementById(containerId);
        ul.innerHTML = '';
        items.forEach((it, idx) => {
          const li = document.createElement('li');
          li.className = 'list-group-item';
          li.textContent = isUser
            ? `${idx+1}. ${it.name} – ${it.pts} pts`
            : `${idx+1}. ${it.name} – ${it.eco.toLocaleString('fr-FR')} kg CO₂ économisés`;
          if (it.name.startsWith('Vous')) li.classList.add('table-primary');
          ul.appendChild(li);
        });
      }

      renderList('personal-list', users, true);
      renderList('company-list', companies, false);

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
    .catch(err => console.error('Erreur fetch classement :', err));
});