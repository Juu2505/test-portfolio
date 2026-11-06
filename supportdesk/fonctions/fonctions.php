<?php
function connexion(): ?mysqli {
    $connexion = @mysqli_connect("localhost", "root", "", "supportdesk");
    if (!$connexion) {
        return null;
    }
    mysqli_set_charset($connexion, "utf8mb4");
    return $connexion;
}

function recupererUtilisateurs(?mysqli $connexion): array {
    if ($connexion === null) {
        return [];
    }
    $resultat = mysqli_query($connexion, "SELECT id, nom FROM utilisateur ORDER BY nom");
    return $resultat ? mysqli_fetch_all($resultat, MYSQLI_ASSOC) : [];
}

function recupererCategories(?mysqli $connexion): array {
    if ($connexion === null) {
        return [];
    }
    $resultat = mysqli_query($connexion, "SELECT id, libelle FROM categorie ORDER BY libelle");
    return $resultat ? mysqli_fetch_all($resultat, MYSQLI_ASSOC) : [];
}

function deconnexion(?mysqli $connexion): void {
    if ($connexion !== null) {
        mysqli_close($connexion);
    }
}

function recupérerUtilisateurParId(?mysqli $connexion, int $id): ?array {
    if ($connexion === null) {
        return null;
    }
    $id = mysqli_real_escape_string($connexion, (string)$id);
    $requete = "SELECT * FROM utilisateur WHERE id = $id";
    $resultat = mysqli_query($connexion, $requete);
    if ($resultat === false) {
        return null;
    }
    $utilisateur = mysqli_fetch_assoc($resultat);
    mysqli_free_result($resultat);
    return $utilisateur ?: null;
}

function recupérerCategorieParId(?mysqli $connexion, int $id): ?array {
    if ($connexion === null) {
        return null;
    }
    $id = mysqli_real_escape_string($connexion, (string)$id);
    $requete = "SELECT * FROM categorie WHERE id = $id";
    $resultat = mysqli_query($connexion, $requete);
    if ($resultat === false) {
        return null;
    }
    $categorie = mysqli_fetch_assoc($resultat);
    mysqli_free_result($resultat);
    return $categorie ?: null;
}

function ajouterunincident (?mysqli $connexion, string $titre, string $description, string $priorite, int $utilisateur_id, int $categorie_id): bool {
    if ($connexion === null) {
        return false;
    }

    $stmt = mysqli_prepare($connexion, "INSERT INTO incident (titre, description, priorite, utilisateur_id, categorie_id) VALUES (?, ?, ?, ?, ?)");
    if ($stmt === false) {
        return false;
    }

    mysqli_stmt_bind_param($stmt, "sssii", $titre, $description, $priorite, $utilisateur_id, $categorie_id);
    $result = mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);

    return $result;
}