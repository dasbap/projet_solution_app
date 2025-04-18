let seconds = 5;
const countdownEl = document.getElementById('countdown');

const interval = setInterval(() => {
  seconds--;
  countdownEl.textContent = seconds;
  if (seconds <= 0) {
    clearInterval(interval);
    window.location.href = 'connexion.html';
  }
}, 1000);
