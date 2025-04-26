const form = document.getElementById("carboneForm");
const reponses = {};
let questions = [];

fetch("../res/data/questions.json")
    .then(res => res.json())
    .then(data => {
        questions = data;
        genererFormulaire();
        updateAllQuestionsVisibility();
    });

function genererFormulaire() {
    questions.forEach(q => {
        const div = createQuestionDiv(q);
        form.appendChild(div);
    });

    const submitBtn = createSubmitButton();
    form.appendChild(submitBtn);

    form.addEventListener("submit", handleSubmit);
}

function createQuestionDiv(q) {
    const div = document.createElement("div");
    div.classList.add("question");
    div.id = `q_${q.id}`;

    const label = document.createElement("label");
    label.textContent = q.question_text;
    div.appendChild(label);
    div.appendChild(document.createElement("br"));

    const input = createInputElement(q);
    div.appendChild(input);

    return div;
}

function createInputElement(q) {
    let input;
    if (q.type === "select") {
        input = document.createElement("select");
        const defaultOption = document.createElement("option");
        defaultOption.value = "";
        defaultOption.textContent = "-- Choisissez --";
        input.appendChild(defaultOption);
        
        q.options.forEach(opt => {
            const option = document.createElement("option");
            option.value = opt.value || opt.label;
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

    return input;
}

function createSubmitButton() {
    const submitBtn = document.createElement("button");
    submitBtn.textContent = "Envoyer";
    submitBtn.style.display = "none";
    submitBtn.type = "submit";
    submitBtn.id = "submitBtn";

    return submitBtn;
}

function handleSubmit(e) {
    e.preventDefault();

    if (!isFormValid()) {
        alert("Veuillez remplir toutes les questions affichées avant de soumettre.");
        return;
    }

    const questionsAvecReponses = getQuestionsWithResponses();

    fetch("../../Serveur/formulaire.php", {
        method: "POST",
        headers: {
            "Content-Type": "application/json",
        },
        body: JSON.stringify(questionsAvecReponses),
    })
    .then(res => res.text())
    .then(handleServerResponse)
    .catch(handleError);
}

function isFormValid() {
    const activeQuestions = questions.filter(q => {
        const div = document.getElementById(`q_${q.id}`);
        return div && div.classList.contains("active");
    });

    return activeQuestions.every(q => {
        const input = document.getElementById(q.id);
        return input && input.value.trim() !== "";
    });
}

function getQuestionsWithResponses() {
    return questions.map(q => ({
        id: q.id,
        question_text: q.question_text,
        reponse: reponses[q.id] || ""
    }));
}

function handleServerResponse(msg) {
    console.log("Réponse du serveur :", msg);
    form.reset();
    Object.keys(reponses).forEach(key => delete reponses[key]);
    updateAllQuestionsVisibility();
}

function handleError(err) {
    console.error("Erreur lors de l'envoi :", err);
    alert("Une erreur est survenue lors de l'envoi.");
}

function handleChange(e) {
    const id = e.target.id;
    const value = e.target.value;
    reponses[id] = value;
    updateAllQuestionsVisibility();
}

function updateAllQuestionsVisibility() {
    questions.forEach(q => {
        const div = document.getElementById(`q_${q.id}`);
        const input = document.getElementById(q.id);
        if (!div || !input) return;

        const doitAfficher = shouldDisplayQuestion(q);
        
        if (doitAfficher) {
            div.classList.add("active");
        } else {
            div.classList.remove("active");
            input.value = "";
            delete reponses[q.id];
        }
    });
    
    updateQuestions();
}

function shouldDisplayQuestion(q) {
    const condition = q.showIf;
    if (!condition) return true;

    // Trouver toutes les questions de la catégorie spécifiée
    const questionsLiees = questions.filter(question => question.categorie === condition.categorie);
    if (questionsLiees.length === 0) return false;

    // Vérifier si au moins une des questions liées a une réponse qui correspond
    return questionsLiees.some(questionLiee => {
        const val = reponses[questionLiee.id];
        if (val === undefined) return false;

        return Array.isArray(condition.value) 
            ? condition.value.includes(val)
            : val === condition.value;
    });
}

function updateQuestions() {
    let totalQuestionsActives = 0;
    let totalQuestionsRemplies = 0;

    questions.forEach(q => {
        const div = document.getElementById(`q_${q.id}`);
        const input = document.getElementById(q.id);
        if (!div || !input) return;

        if (div.classList.contains("active")) {
            totalQuestionsActives++;
            if (input.value.trim() !== "") {
                totalQuestionsRemplies++;
            }
        }
    });

    toggleSubmitButton(totalQuestionsActives, totalQuestionsRemplies);
}

function toggleSubmitButton(totalQuestionsActives, totalQuestionsRemplies) {
    const submitBtn = document.getElementById("submitBtn");
    if (totalQuestionsActives > 0 && totalQuestionsActives === totalQuestionsRemplies) {
        submitBtn.style.display = "inline-block";
    } else {
        submitBtn.style.display = "none";
    }
}
