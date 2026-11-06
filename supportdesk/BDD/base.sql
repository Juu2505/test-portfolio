DROP DATABASE IF EXISTS supportdesk;

CREATE DATABASE supportdesk CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;

USE supportdesk;

CREATE TABLE utilisateur (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nom VARCHAR(100) NOT NULL,
    email VARCHAR(150) NOT NULL UNIQUE
);

CREATE TABLE categorie (
    id INT AUTO_INCREMENT PRIMARY KEY,
    libelle VARCHAR(100) NOT NULL UNIQUE
);

create table priorite (
    id INT AUTO_INCREMENT PRIMARY KEY,
    niveau VARCHAR(20) NOT NULL UNIQUE
);

CREATE TABLE incident (
    id INT AUTO_INCREMENT PRIMARY KEY,
    titre VARCHAR(150) NOT NULL,
    description TEXT NOT NULL,
    priorite VARCHAR(20) NOT NULL,
    utilisateur_id INT NOT NULL,
    categorie_id INT NOT NULL,
    bloquant TINYINT(1) NOT NULL DEFAULT 0,
    date_creation DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,

    CONSTRAINT fk_incident_utilisateur
        FOREIGN KEY (utilisateur_id) REFERENCES utilisateur(id),

    CONSTRAINT fk_incident_categorie
        FOREIGN KEY (categorie_id) REFERENCES categorie(id)
);

INSERT INTO utilisateur (nom, email) VALUES
('Alice Martin', 'alice.martin@example.com'),
('Karim Benali', 'karim.benali@example.com'),
('Sophie Durand', 'sophie.durand@example.com');

INSERT INTO categorie (libelle) VALUES
('Matériel'),
('Logiciel'),
('Réseau'),
('Compte utilisateur');

INSERT INTO incident
(titre, description, priorite, utilisateur_id, categorie_id, bloquant)
VALUES
('Impossible de se connecter au Wi-Fi',
 'Le poste ne parvient plus à rejoindre le réseau sans fil.',
 'haute', 1, 3, 1),
('Erreur au démarrage du logiciel',
 'Une fenêtre d''erreur apparaît lors du lancement.',
 'normale', 2, 2, 0);

 INSERT INTO priorite (niveau) VALUES
('Basse'),
('Normale'),
('Haute');

