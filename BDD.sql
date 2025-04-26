create database score_carbone_db;
use score_carbone_db;

-- Table des entreprises
CREATE TABLE Table_company (
    siret_company CHAR(14),
    name_company VARCHAR(255) NOT NULL,
    PRIMARY KEY (siret_company)
);

-- Table des utilisateurs
CREATE TABLE Table_User (
    id_user INT AUTO_INCREMENT, 
    email_user VARCHAR(60) NOT NULL UNIQUE,
    user_name VARCHAR(15) NOT NULL,
    user_password_hash TEXT NOT NULL,
    role TINYINT NOT NULL, 
    siret_company CHAR(14) NOT NULL,
    PRIMARY KEY (id_user),
    FOREIGN KEY (siret_company) REFERENCES Table_company(siret_company) 
        ON DELETE CASCADE 
        ON UPDATE CASCADE
);

-- Table des scores de carbone
CREATE TABLE Table_score_carbon (
    id_score INT AUTO_INCREMENT, 
    id_user INT NOT NULL,
    score INT NOT NULL,
    date_assigned DATE NOT NULL,
    PRIMARY KEY (id_score),
    FOREIGN KEY (id_user) REFERENCES Table_User(id_user) 
        ON DELETE CASCADE 
        ON UPDATE CASCADE
);

-- Table des questions
CREATE TABLE Table_questions (
    id_question INT AUTO_INCREMENT,            
    question_text TEXT NOT NULL,               
    categorie VARCHAR(255),                    
    type_question VARCHAR(50) NOT NULL,       
    PRIMARY KEY (id_question)                   
);

-- Table des réponses
CREATE TABLE Table_reponses (
    id_reponse INT AUTO_INCREMENT,              
    id_user INT NOT NULL,                       
    id_question INT NOT NULL,                   
    reponse TEXT NOT NULL, 
    score_question int not null,
    date_reponse TIMESTAMP DEFAULT CURRENT_TIMESTAMP, 
    PRIMARY KEY (id_reponse),                    
    FOREIGN KEY (id_user) REFERENCES Table_User(id_user) 
        ON DELETE CASCADE 
        ON UPDATE CASCADE, 
    FOREIGN KEY (id_question) REFERENCES Table_questions(id_question) 
        ON DELETE CASCADE 
        ON UPDATE CASCADE 
);
