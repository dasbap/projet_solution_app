const form = document.getElementById("carboneForm");
const reponses = {};
let questions = [];

fetch("questions.json")
    .then(res => res.json())
    .then(data => {
    questions = data;
    genererFormulaire();
    updateQuestions();
    updateQuestions();
});

function genererFormulaire() {
    questions.forEach(q => {
    const div = document.createElement("div");
    div.classList.add("question");
    div.id = `q_${q.id}`;

    const label = document.createElement("label");
    label.textContent = q.text;
    div.appendChild(label);
    div.appendChild(document.createElement("br"));

    let input;
    if (q.type === "select") {
        input = document.createElement("select");
        input.innerHTML = `<option value="">-- Choisissez --</option>`;
        q.options.forEach(opt => {
        const option = document.createElement("option");
        option.value = opt;
        option.textContent = opt;
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
    
            // Si la question est active et la réponse est vide → invalide
            if (div.classList.contains("active") && (!input.value || input.value.trim() === "")) {
                valide = false;
            }
        });
    
        if (!valide) {
            alert("Veuillez remplir toutes les questions affichées avant de soumettre.");
            return; // On empêche l'envoi
        }
    
        // Si tout est rempli correctement, on continue
        console.log("Réponses :", reponses);
        alert("Merci pour vos réponses !");
    
        // Reset
        form.reset();
        Object.keys(reponses).forEach(k => delete reponses[k]);
        document.querySelectorAll(".question").forEach(div => div.classList.remove("active"));
        updateQuestions();
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


