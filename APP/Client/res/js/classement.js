document.addEventListener('DOMContentLoaded', () => {
  fetch('../../Serveur/reqBdd/getclassement.php', { credentials: 'include' })
    .then(res => res.json())
    .then(({ users, companies }) => {
      if (!users || !companies) {
        console.error('Données manquantes pour classement');
        return;
      }

      users.sort((a, b) => b.score - a.score);
      companies.sort((a, b) => b.average_score - a.average_score);

      function renderList(containerId, items, isUser) {
        const ul = document.getElementById(containerId);
        ul.innerHTML = '';

        items.forEach((it, idx) => {
          const li = document.createElement('li');
          li.className = 'list-group-item';
          
          if (isUser) {
            li.innerHTML = `${idx + 1}. ${it.user_name} – ${it.score} pts <br> <span style="font-size: 0.8em;">(Entreprise: ${it.company})</span>`;
          } else {
            li.textContent = `${idx + 1}. ${it.name_company} – ${parseFloat(it.average_score).toFixed(2).replace(/\.00$/, '')} pts`;
          }

          if (it.user_name && it.user_name.startsWith('Vous')) {
            li.classList.add('table-primary');
          }
          ul.appendChild(li);
        });
      }

      renderList('personal-list', users, true);
      renderList('company-list', companies, false);

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
