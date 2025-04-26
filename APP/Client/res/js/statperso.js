// File: Client/res/js/statperso.js
document.addEventListener('DOMContentLoaded', () => {
  // Toggle mobile menu
  const burgerBtn  = document.getElementById('burgerBtn');
  const mobileMenu = document.getElementById('mobileMenu');
  burgerBtn?.addEventListener('click', () => mobileMenu?.classList.toggle('open'));
  mobileMenu?.addEventListener('click', e => {
    if (e.target === mobileMenu) mobileMenu.classList.remove('open');
  });

  // Palette écologique
  const palette = {
    lineBg:    'rgba(30,112,191,0.2)',
    lineBd:    '#1e70bf',
    barColor:  '#2a9d8f',
    pieColors: ['#2a9d8f','#8ab17d','#e9c46a','#f4a261','#d17357']
  };

  // 1️⃣ On récupère d’abord les données du formulaire pour construire les charts
  fetch('../../Serveur/reqBdd/getformdata.php', { credentials: 'include' })
    .then(r => r.json())
    .then(data => {
      // Nombre de questions répondues
      document.getElementById('count').textContent =
        Object.keys(data.form || {}).length;

      // Short labels Q1, Q2… + infobulles avec la question
      const fullLabels  = data.line.labels;
      const shortLabels = fullLabels.map((_,i) => `Q${i+1}`);

      // 1) Evolution par question (Line)
      new Chart(
        document.getElementById('chartLine').getContext('2d'),
        {
          type: 'line',
          data: {
            labels: shortLabels,
            datasets: [{
              label: 'Points par question',
              data: data.line.data,
              backgroundColor: palette.lineBg,
              borderColor: palette.lineBd,
              borderWidth: 2,
              pointRadius: 4,
              fill: true
            }]
          },
          options: {
            responsive: true,
            maintainAspectRatio: false,
            scales: {
              x: { title: { display: true, text: 'Question' }, ticks: { autoSkip: false } },
              y: { title: { display: true, text: 'Points' }, beginAtZero: true }
            },
            plugins: {
              legend: { display: true, position: 'top' },
              tooltip: {
                callbacks: {
                  title: ctx => fullLabels[ctx[0].dataIndex],
                  label: ctx => `Points : ${ctx.parsed.y}`
                }
              }
            }
          }
        }
      );

      // 2) Répartition par catégorie (Bar)
      new Chart(
        document.getElementById('chartBar').getContext('2d'),
        {
          type: 'bar',
          data: {
            labels: data.bar.labels,
            datasets: [{
              label: 'Total points',
              data: data.bar.data,
              backgroundColor: palette.barColor,
              borderColor: palette.barColor,
              borderWidth: 1
            }]
          },
          options: {
            responsive: true,
            maintainAspectRatio: false,
            scales: {
              x: { title: { display: true, text: 'Catégorie' }, ticks: { autoSkip: false, maxRotation: 45 } },
              y: { title: { display: true, text: 'Points' }, beginAtZero: true }
            },
            plugins: { legend: { display: true, position: 'top' } }
          }
        }
      );

      // 3) Totaux mensuels (Pie)
      new Chart(
        document.getElementById('chartPie').getContext('2d'),
        {
          type: 'pie',
          data: {
            labels: data.pie.labels,
            datasets: [{ data: data.pie.data, backgroundColor: palette.pieColors }]
          },
          options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
              legend: { display: true, position: 'bottom' },
              tooltip: {
                callbacks: {
                  label: ctx => `${ctx.label} : ${ctx.parsed} pts`
                }
              }
            }
          }
        }
      );
    })
    .catch(err => console.error('Erreur fetch formdata :', err))
    .finally(() => {
      // 2️⃣ Puis on récupère le score total via votre nouvel endpoint
      fetch('../../Serveur/reqBdd/getlastscore.php', { credentials: 'include' })
        .then(r => r.json())
        .then(scoresArr => {
          // Somme des scores
          const total = scoresArr.reduce((sum, q) => sum + (q.score||0), 0);
          document.getElementById('totalPoints').textContent = total;
        })
        .catch(err => console.error('Erreur fetch lastscore :', err));
    });
});
