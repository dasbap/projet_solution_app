// Récupère le <form> et initialise les données
const form = document.getElementById("carboneForm");
let questions = [];
const reponses = {};

// Charge les questions depuis le JSON
fetch("../res/data/questions.json")
  .then(res => res.json())
  .then(data => {
    questions = data;
    genererFormulaire();
    updateQuestions();
  })
  .catch(err => console.error("Erreur de chargement des questions :", err));

// Génère dynamiquement le formulaire
function genererFormulaire() {
  questions.forEach(q => {
    const container = document.createElement("div");
    container.className = "question";
    container.id = `q_${q.id}`;

    // Label
    const label = document.createElement("label");
    label.htmlFor = q.id;
    label.textContent = q.text;
    container.append(label);

    // Champ input ou select
    let input;
    if (q.type === "select") {
      input = document.createElement("select");
      input.innerHTML = `<option value="">-- Choisissez --</option>`;
      q.options.forEach(opt => {
        const optEl = document.createElement("option");
        optEl.value = opt;
        optEl.textContent = opt;
        input.append(optEl);
      });
    } else if (q.type === "number") {
      input = document.createElement("input");
      input.type = "number";
      input.min = "0";
    }

    input.id = q.id;
    input.addEventListener("change", handleChange);
    container.append(input);

    form.append(container);
  });

  // Bouton Envoi (caché par défaut)
  const submitBtn = document.createElement("button");
  submitBtn.id = "submitBtn";
  submitBtn.type = "submit";
  submitBtn.textContent = "Envoyer";
  submitBtn.style.display = "none";
  form.append(submitBtn);

  // Écoute de la soumission
  form.addEventListener("submit", onSubmit);
}

// Gestion du clic sur Envoyer
function onSubmit(event) {
  event.preventDefault();

  // Vérifie que tous les champs affichés sont remplis
  const incomplets = questions.some(q => {
    const div = document.getElementById(`q_${q.id}`);
    const val = document.getElementById(q.id).value.trim();
    return div.classList.contains("active") && !val;
  });

  if (incomplets) {
    return alert("Veuillez remplir toutes les questions affichées avant de soumettre.");
  }

  // Envoi au serveur PHP
  fetch("../../Serveur/formulaire.php", {
    method: "POST",
    headers: { "Content-Type": "application/json" },
    body: JSON.stringify(reponses)
  })
    .then(res => res.text())
    .then(msg => {
      alert("Formulaire envoyé avec succès !");
      console.log("Réponse serveur :", msg);
      form.reset();
      Object.keys(reponses).forEach(k => delete reponses[k]);
      updateQuestions();
    })
    .catch(err => {
      console.error("Erreur lors de l'envoi :", err);
      alert("Une erreur est survenue lors de l'envoi.");
    });
}

// À chaque changement de champ
function handleChange(e) {
  reponses[e.target.id] = e.target.value;
  updateQuestions();
}

// Affiche/masque les questions et le bouton Envoi
function updateQuestions() {
  let actives = 0, remplies = 0;

  questions.forEach(q => {
    const div = document.getElementById(`q_${q.id}`);
    const input = document.getElementById(q.id);
    div.classList.remove("active");

    // Condition d’affichage
    const cond = q.showIf;
    const doitAfficher = !cond
      ? true
      : (() => {
          const val = reponses[cond.id];
          return Array.isArray(cond.value)
            ? cond.value.includes(val)
            : val === cond.value;
        })();

    if (doitAfficher) {
      div.classList.add("active");
      actives++;
      if (input.value.trim() !== "") remplies++;
    }
  });

  // Affiche le bouton si tout est rempli
  document.getElementById("submitBtn").style.display =
    actives > 0 && actives === remplies ? "inline-block" : "none";
}
