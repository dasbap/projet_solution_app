const form = document.getElementById("carboneForm");
const reponses = {};
let questions = [];

fetch("../res/data/questions.json")
    .then(res => res.json())
    .then(data => {
        questions = data;
        genererFormulaire();
        updateQuestions();
    });

function genererFormulaire() {
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
    submitBtn.style.display = "none";
    submitBtn.type = "submit";
    submitBtn.id = "submitBtn";
    form.appendChild(submitBtn);

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

        // Envoie des données au serveur PHP
        fetch("../../Serveur/formulaire.php", {
            method: "POST",
            headers: {
                "Content-Type": "application/json",
            },
            body: JSON.stringify(reponses),
        })
        .then(res => res.text())
        .then(msg => {
            alert("Formulaire envoyé avec succès !");
            console.log("Réponse du serveur :", msg);
            form.reset();
            Object.keys(reponses).forEach(key => delete reponses[key]);
            updateQuestions();
        })
        .catch(err => {
            console.error("Erreur lors de l'envoi :", err);
            alert("Une erreur est survenue lors de l'envoi.");
        });
    });
}

function handleChange(e) {
    const id = e.target.id;
    const value = e.target.value;
    reponses[id] = value;
    updateQuestions();
}

function updateQuestions() {
    let totalQuestionsActives = 0;
    let totalQuestionsRemplies = 0;

    questions.forEach(q => {
        const div = document.getElementById(`q_${q.id}`);
        const input = document.getElementById(q.id);
        if (!div || !input) return;

        div.classList.remove("active");

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
    }
}
