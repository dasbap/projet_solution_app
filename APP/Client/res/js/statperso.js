document.addEventListener('DOMContentLoaded', () => {
  // Récupération des données du formulaire pour construire les graphiques
  fetch('../../Serveur/reqBdd/getformdata.php', { credentials: 'include' })
    .then(r => r.json())
    .then(data => {
      console.log(data)
      // Mise à jour du compteur de questions répondues
      document.getElementById('count').textContent =
        Object.keys(data.form || {}).length;

      // Short labels Q1, Q2… + infobulles avec la question
      const fullLabels  = data.line.labels;
      const shortLabels = fullLabels.map((_, i) => `Q${i + 1}`);

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
              backgroundColor: 'rgba(30,112,191,0.2)', // couleur bleu
              borderColor: '#1e70bf', // bordure bleu
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
              backgroundColor: '#2a9d8f', // couleur vert d’eau
              borderColor: '#2a9d8f',
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
            datasets: [{
              data: data.pie.data,
              backgroundColor: ['#2a9d8f', '#8ab17d', '#e9c46a', '#f4a261', '#d17357'] // couleurs variées
            }]
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
          
          const total = scoresArr.score || 0;  // Vérification que le score existe
          document.getElementById('totalPoints').textContent = total;

          // Ajout d'un log pour vérifier si tout est bon
          console.log("Score total:", total);
        })
        .catch(err => console.error('Erreur fetch lastscore :', err));
    });
});
