document.addEventListener('DOMContentLoaded', () => {
    // Graphique en ligne pour l'évolution hebdomadaire
    new Chart(document.getElementById('chartLine'), {
      type: 'line',
      data: {
        labels: ['S1','S2','S3','S4','S5','S6'],
        datasets: [{
          label: 'kg CO₂',
          data: [12, 15, 14, 10, 8, 11],  // Données fictives, tu peux les remplacer par les données réelles des entreprises
          backgroundColor: 'rgba(40,167,69,0.2)',
          borderColor: '#28a745',
          borderWidth: 2,
          fill: true
        }]
      },
      options: {
        responsive: true,
        maintainAspectRatio: false,
        scales: { y: { beginAtZero: true } }
      }
    });
  
    // Graphique à barres pour la répartition par catégorie
    new Chart(document.getElementById('chartBar'), {
      type: 'bar',
      data: {
        labels: ['Transport','Alimentation','Énergie','Déchets','Autres'],
        datasets: [{
          label: 'kg CO₂',
          data: [8, 5, 3, 2, 1],  // Données fictives
          backgroundColor: '#28a745'
        }]
      },
      options: {
        responsive: true,
        maintainAspectRatio: false,
        scales: { y: { beginAtZero: true } }
      }
    });
  
    // Graphique camembert pour les totaux mensuels
    new Chart(document.getElementById('chartPie'), {
      type: 'pie',
      data: {
        labels: ['France','Europe','Monde','Autres'],
        datasets: [{
          data: [40, 30, 20, 10],  // Données fictives
          backgroundColor: ['#28a745','#6cc57a','#a2d5a0','#d8f3dc']
        }]
      },
      options: {
        responsive: true,
        maintainAspectRatio: false
      }
    });
  });
  