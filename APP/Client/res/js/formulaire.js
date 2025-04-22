// Récupère le <form> et initialise les données
const form = document.getElementById("carboneForm");
let questions = [];
const reponses = {};

// Charge les questions depuis le JSON
fetch("../res/data/questions.json")
<<<<<<< HEAD
    .then(res => res.json())
    .then(data => {
        questions = data;
        genererFormulaire();
        updateQuestions();
    });
=======
  .then(res => res.json())
  .then(data => {
    questions = data;
    genererFormulaire();
    updateQuestions();
  })
  .catch(err => console.error("Erreur de chargement des questions :", err));
>>>>>>> d2fa79e6b13b2f8c7d480cee0fc0ab071bd4a0f0

// Génère dynamiquement le formulaire
function genererFormulaire() {
<<<<<<< HEAD
    questions.forEach(q => {
        const div = document.createElement("div");
        div.classList.add("question");
        div.id = `q_${q.id}`;

        const label = document.createElement("label");
        label.textContent = q.question_text;
        div.appendChild(label);
        div.appendChild(document.createElement("br"));

        let input;
        if (q.type === "select") {
            input = document.createElement("select");
            input.innerHTML = `<option value="">-- Choisissez --</option>`;
            q.options.forEach(opt => {
                const option = document.createElement("option");
                option.value = opt.label;
                option.textContent = opt.label;
                input.appendChild(option);
            });
        } else if (q.type === "number") {
            input = document.createElement("input");
            input.type = "number";
            input.min = "0";
        }

        input.id = q.id;
        input.addEventListener("change", handleChange);
        div.appendChild(input);
        form.appendChild(div);
    });

    const submitBtn = document.createElement("button");
    submitBtn.textContent = "Envoyer";
    submitBtn.style.display = "none"; // Bouton caché jusqu'à ce que toutes les réponses soient remplies
    submitBtn.type = "submit";
    submitBtn.id = "submitBtn";
    form.appendChild(submitBtn);

    // Soumission du formulaire
    form.addEventListener("submit", function (e) {
        e.preventDefault();

        let valide = true;

        questions.forEach(q => {
            const div = document.getElementById(`q_${q.id}`);
            const input = document.getElementById(q.id);

            if (div.classList.contains("active") && (!input.value || input.value.trim() === "")) {
                valide = false;
            }
        });

        if (!valide) {
            alert("Veuillez remplir toutes les questions affichées avant de soumettre.");
            return;
        }

        // Envoie des données au serveur PHP avec XMLHttpRequest
        const formData = new FormData();
        questions.forEach(q => {
            const input = document.getElementById(q.id);
            if (input && input.value) {
                formData.append(q.id, input.value);
            }
        });

        const xhr = new XMLHttpRequest();
        xhr.open("POST", "../../Serveur/formulaire.php", true);
        xhr.onload = function () {
            if (xhr.status === 200) {
                console.log("Réponse du serveur :", xhr.responseText);
                form.reset();
                Object.keys(reponses).forEach(key => delete reponses[key]);
                updateQuestions();
            } else {
                console.error("Erreur lors de l'envoi :", xhr.statusText);
                alert("Une erreur est survenue lors de l'envoi.");
            }
        };
        xhr.send(formData);
    });
=======
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
>>>>>>> d2fa79e6b13b2f8c7d480cee0fc0ab071bd4a0f0
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

<<<<<<< HEAD
        const condition = q.showIf;

        let doitAfficher = false;
        if (!condition) {
            doitAfficher = true;
        } else {
            const val = reponses[condition.id];
            if (val && (Array.isArray(condition.value) ? condition.value.includes(val) : val === condition.value)) {
                doitAfficher = true;
            }
        }

        if (doitAfficher) {
            div.classList.add("active");
            totalQuestionsActives++;

            if (input.value !== "") {
                totalQuestionsRemplies++;
            }
        }
    });

    const submitBtn = document.getElementById("submitBtn");
    if (totalQuestionsActives > 0 && totalQuestionsActives === totalQuestionsRemplies) {
        submitBtn.style.display = "inline-block"; 
    } else {
        submitBtn.style.display = "none";
=======
    if (doitAfficher) {
      div.classList.add("active");
      actives++;
      if (input.value.trim() !== "") remplies++;
>>>>>>> d2fa79e6b13b2f8c7d480cee0fc0ab071bd4a0f0
    }
  });

  // Affiche le bouton si tout est rempli
  document.getElementById("submitBtn").style.display =
    actives > 0 && actives === remplies ? "inline-block" : "none";
}
