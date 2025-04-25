// À chaque changement de champ
function handleChange(e) {
    const selectedValue = e.target.value;
    const questionId = e.target.id;
    const question = questions.find(q => q.id === questionId);
  
    // Pour les champs de type number, stocke directement la valeur
    if (question.type === "number") {
      reponses[questionId] = {
        value: selectedValue,
        score: parseFloat(selectedValue) || 0
      };
    } 
    // Pour les select, trouve l'option correspondante
    else if (question.type === "select") {
      const selectedOption = question.options.find(opt => opt.label === selectedValue);
      reponses[questionId] = selectedOption ? {
        value: selectedValue,
        score: selectedOption.score
      } : { value: selectedValue, score: 0 };
    }
  
    updateQuestions();
  }
  
  // Affiche/masque les questions et le bouton Envoi
  function updateQuestions() {
    let actives = 0, remplies = 0;
  
    questions.forEach(q => {
      const div = document.getElementById(`q_${q.id}`);
      const input = document.getElementById(q.id);
      div.classList.remove("active");
  
      // Condition d'affichage
      const cond = q.showIf;
      let doitAfficher = true;
  
      if (cond) {
        const reponseCondition = reponses[cond.id];
        if (reponseCondition) {
          const valeurCondition = reponseCondition.value;
          const scoreCondition = reponseCondition.score;
          
          // Vérifie soit la valeur exacte, soit le score, soit un tableau de valeurs
          if (Array.isArray(cond.value)) {
            doitAfficher = cond.value.includes(valeurCondition);
          } else if (cond.value !== undefined) {
            doitAfficher = valeurCondition === cond.value;
          } else if (cond.score !== undefined) {
            doitAfficher = scoreCondition === cond.score;
          }
        } else {
          doitAfficher = false;
        }
      }
  
      if (doitAfficher) {
        div.classList.add("active");
        actives++;
        if (input.value.trim() !== "") remplies++;
      } else {
        // Réinitialise la valeur si la question est masquée
        input.value = "";
        delete reponses[q.id];
      }
    });
  
    // Affiche le bouton si tout est rempli
    document.getElementById("submitBtn").style.display =
      actives > 0 && actives === remplies ? "inline-block" : "none";
  }