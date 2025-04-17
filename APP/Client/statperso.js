document.addEventListener('DOMContentLoaded', () => {
    // 1) Simulez le nombre de questions (fictif pour l'instant)
    const questionCount = 6;
    document.getElementById('count').textContent = questionCount;
  
    // 2) Graphique en ligne
    new Chart(document.getElementById('chartLine'), {
      type: 'line',
      data: {
        labels: ['S1','S2','S3','S4','S5','S6'],
        datasets: [{
          label: 'kg CO₂',
          data: [12, 15, 14, 10, 8, 11],
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
  
    // 3) Graphique à barres
    new Chart(document.getElementById('chartBar'), {
      type: 'bar',
      data: {
        labels: ['Transport','Alimentation','Énergie','Déchets','Autres'],
        datasets: [{
          label: 'kg CO₂',
          data: [8, 5, 3, 2, 1],
          backgroundColor: '#28a745'
        }]
      },
      options: {
        responsive: true,
        maintainAspectRatio: false,
        scales: { y: { beginAtZero: true } }
      }
    });
  
    // 4) Camembert
    new Chart(document.getElementById('chartPie'), {
      type: 'pie',
      data: {
        labels: ['France','Europe','Monde','Autres'],
        datasets: [{
          data: [40, 30, 20, 10],
          backgroundColor: ['#28a745','#6cc57a','#a2d5a0','#d8f3dc']
        }]
      },
      options: {
        responsive: true,
        maintainAspectRatio: false
      }
    });
  });
  document.addEventListener('DOMContentLoaded', () => {
    const sidebarToggle = document.getElementById('sidebar-toggle');
    const sidebar = document.querySelector('.sidebar');

    // Gestion du clic sur le bouton hamburger
    sidebarToggle.addEventListener('click', () => {
        sidebar.classList.toggle('active');
    });
});

  