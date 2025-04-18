// Fonction de validation du formulaire
function validateForm() {
    var email = document.getElementById("email_user").value;
    var password = document.getElementById("user_password").value;
    
    if (!email || !password) {
        showErrorMessage("Tous les champs sont obligatoires.");
        return false; 
    }
    
    hideErrorMessage();
    return true;
}

function showErrorMessage(message) {
    var errorMessage = document.getElementById("errorMessage");
    errorMessage.textContent = message;
    errorMessage.style.display = "block"; 
}


function hideErrorMessage() {
    var errorMessage = document.getElementById("errorMessage");
    errorMessage.style.display = "none"; 
}