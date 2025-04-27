document.addEventListener('DOMContentLoaded', () => {
  fetch('../../Serveur/reqBdd/getstatentreprise.php', { 
    credentials: 'include' 
  })
  .then(res => {
    if (!res.ok) throw new Error('Erreur réseau');
    return res.json();
  })
  .then(data => {
    if (!data || typeof data.avg_total_score === 'undefined') {
      throw new Error('Données invalides');
    }

    document.getElementById('avgEntScore').textContent = 
      `${data.avg_total_score} (sur ${data.user_count} utilisateurs)`;

    const palette = {
      lineBg: 'rgba(51, 112, 183, 0.2)',
      lineBd: '#1e70bf',
      barColor: '#28a745',
      pieColors: ['#2a9d8f', '#6cc57a', '#a2d5a0', '#d8f3dc']
    };

    const questionsData = data.questions.sort((a, b) => a.id_question - b.id_question);

    new Chart(
      document.getElementById('chartLineEnt').getContext('2d'),
      {
        type: 'line',
        data: {
          labels: questionsData.map(q => `Q${q.id_question}`),
          datasets: [{
            label: 'Score moyen par question',
            data: questionsData.map(q => q.average_score),
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
            x: { title: { display: true, text: 'Questions' } },
            y: { title: { display: true, text: 'Score moyen' }, beginAtZero: true }
          }
        }
      }
    );

    const categories = {
      'Environnement': questionsData.filter(q => q.id_question <= 5).reduce((sum, q) => sum + q.average_score, 0),
      'Social': questionsData.filter(q => q.id_question > 5 && q.id_question <= 10).reduce((sum, q) => sum + q.average_score, 0),
      'Gouvernance': questionsData.filter(q => q.id_question > 10).reduce((sum, q) => sum + q.average_score, 0)
    };
    
    new Chart(
      document.getElementById('chartBarEnt').getContext('2d'),
      {
        type: 'bar',
        data: {
          labels: Object.keys(categories),
          datasets: [{
            label: 'Score par catégorie',
            data: Object.values(categories),
            backgroundColor: palette.barColor,
            borderColor: palette.barColor,
            borderWidth: 1
          }]
        },
        options: {
          responsive: true,
          maintainAspectRatio: false,
          scales: {
            x: { title: { display: true, text: 'Catégories' } },
            y: { title: { display: true, text: 'Score total' }, beginAtZero: true }
          }
        }
      }
    );

    const scoreDistribution = {
      'Excellent (80-100)': questionsData.filter(q => q.average_score >= 80).length,
      'Bon (60-79)': questionsData.filter(q => q.average_score >= 60 && q.average_score < 80).length,
      'Moyen (40-59)': questionsData.filter(q => q.average_score >= 40 && q.average_score < 60).length,
      'Faible (<40)': questionsData.filter(q => q.average_score < 40).length
    };

    new Chart(
      document.getElementById('chartPieEnt').getContext('2d'),
      {
        type: 'pie',
        data: {
          labels: Object.keys(scoreDistribution),
          datasets: [{
            data: Object.values(scoreDistribution),
            backgroundColor: palette.pieColors
          }]
        },
        options: {
          responsive: true,
          maintainAspectRatio: false
        }
      }
    );
  })
  .catch(err => {
    console.error(err);
    document.getElementById('avgEntScore').textContent = 'Erreur de chargement';
  });
});