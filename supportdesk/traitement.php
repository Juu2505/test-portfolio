<?php

// Si la page est appelée autrement qu'avec le formulaire en POST,
// on refuse le traitement.
if ($_SERVER["REQUEST_METHOD"] !== "POST") {

    // 405 = Method Not Allowed.
    // La page existe, mais la méthode HTTP utilisée n'est pas autorisée.
    http_response_code(405);

    // On arrête immédiatement le script.
    exit("Méthode non autorisée.");
}
// trim() retire les espaces inutiles au début et à la fin.

$titre = trim($_POST["titre"] ?? "");
$description = trim($_POST["description"] ?? "");
$priorite = $_POST["priorite"] ?? "";

// Les identifiants doivent être des entiers.
$utilisateurId = (int) ($_POST["utilisateur_id"] ?? 0);
$categorieId = (int) ($_POST["categorie_id"] ?? 0);

//ajouter une erreur si la priorité ne vaut ni basse ni normale ni haute, utilisez un tableau de valeurs autorisées

$erreurs = [];

$prioritesautorisees = ["basse", "normale", "haute"];


if ($titre === "") {
    $erreurs[] = "Le titre est obligatoire.";
}

if ($priorite === "") {
    $erreurs[] = "La priorité est obligatoire.";
} else if (!in_array($priorite, $prioritesautorisees, true)) {
    $erreurs[] = "La priorité doit être 'basse', 'normale' ou 'haute'.";
}

if ($description === "") {
    $erreurs[] = "La description est obligatoire.";
}
if ($utilisateurId <= 0) {
    $erreurs[] = "Utilisateur invalide.";
}

if ($categorieId <= 0) {
    $erreurs[] = "Catégorie invalide.";
}

if (count($erreurs) > 0) {
    foreach ($erreurs as $erreur) {

    //echo $erreur . "<br>" ;

    
        echo "<p>"
           . htmlspecialchars($erreur, ENT_QUOTES, "UTF-8")
           . "</p>";
    
    }

    // Rien ne doit être enregistré tant qu'il existe une erreur.
    exit;
}



?>