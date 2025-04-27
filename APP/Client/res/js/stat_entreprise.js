document.addEventListener('DOMContentLoaded', () => {
  // Récupération des données depuis le serveur pour afficher les graphiques
  fetch('../../Serveur/reqBdd/getstatentreprise.php', { credentials: 'include' })
    .then(res => res.json())
    .then(data => {
      // Vérifier si la réponse contient des données valides
      if (!data || !data.line || !data.bar || !data.pie) {
        console.error("Données manquantes ou mal formatées");
        return;
      }

      // Mise à jour du score moyen de l'entreprise
      const avgEntScore = data.avg_score || 0;
      document.getElementById('avgEntScore').textContent = avgEntScore;

      // Palette écologique pour les couleurs des graphiques
      const palette = {
        lineBg: 'rgba(51, 112, 183, 0.2)', // bleu
        lineBd: '#1e70bf', // bleu bordure
        barColor: '#28a745', // vert
        pieColors: ['#2a9d8f', '#6cc57a', '#a2d5a0', '#d8f3dc'] // couleurs pour le camembert
      };

      // 1️⃣ Graphique : Évolution des scores (Line chart)
      new Chart(
        document.getElementById('chartLineEnt').getContext('2d'),
        {
          type: 'line',
          data: {
            labels: data.line.labels.map((_, i) => `Q${i + 1}`), // Raccourcir les labels
            datasets: [{
              label: 'Scores (points)',
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
              x: { title: { display: true, text: 'Questions' }, ticks: { maxRotation: 0 } },
              y: { title: { display: true, text: 'Points' }, beginAtZero: true }
            },
            plugins: {
              legend: { display: true, position: 'top' },
              tooltip: {
                callbacks: {
                  label: ctx => `Points : ${ctx.parsed.y}`
                }
              }
            }
          }
        }
      );

      // 2️⃣ Graphique : Répartition par catégorie (Bar chart)
      new Chart(
        document.getElementById('chartBarEnt').getContext('2d'),
        {
          type: 'bar',
          data: {
            labels: data.bar.labels,
            datasets: [{
              label: 'Points par catégorie',
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
              x: { title: { display: true, text: 'Catégories' }, ticks: { maxRotation: 45 } },
              y: { title: { display: true, text: 'Points' }, beginAtZero: true }
            },
            plugins: {
              legend: { display: true, position: 'top' }
            }
          }
        }
      );

      // 3️⃣ Graphique : Totaux mensuels (Pie chart)
      new Chart(
        document.getElementById('chartPieEnt').getContext('2d'),
        {
          type: 'pie',
          data: {
            labels: data.pie.labels,
            datasets: [{
              data: data.pie.data,
              backgroundColor: palette.pieColors
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
    .catch(err => {
      console.error('Erreur fetch stat entreprise :', err);
    });
});
