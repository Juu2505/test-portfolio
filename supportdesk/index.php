<?php
require_once __DIR__ . "/fonctions/fonctions.php";
$con = connexion();
if ($con === null) {
    exit("Connexion impossible à la base de données.");
}
$categories = [];
if (function_exists('recupererCategories')) {
    $categories = recupererCategories($con);
}
$utilisateurs = [];
if (function_exists('recupererUtilisateurs')) {
    $utilisateurs = recupererUtilisateurs($con);
}
// Les résultats des SELECT sont maintenant dans des tableaux PHP.
// Aucune autre requête n'est nécessaire pour afficher le formulaire.
deconnexion($con);
?>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SupportDesk - Nouvel incident</title>

    <!-- index.php et le dossier css sont au même niveau -->
    <link rel="stylesheet" href="css/style.css">
</head>

<body>
    <main class="conteneur">
        <nav class="navigation">...</nav>
        <form class="formulaire" action="traitement.php" method="post">

    <div class="champ">
        <label for="titre">Titre</label>
        <input type="text" id="titre" name="titre" required>
    </div>

    <div class="champ">
        <label for="description">Description</label>
        <textarea id="description" name="description" required></textarea>
    </div>

    <div class="champ">
        <label for="priorite">Priorité</label>
        <select id="priorite" name="priorite" required>
            <option value="">Choisir</option>
            <option value="basse">Basse</option>
            <option value="normale">Normale</option>
            <option value="haute">Haute</option>
        </select>
    </div>

    <div class="champ">
    <label for="categorie_id">Utilisateur</label>
    <select id="utilisateur_id" name="utilisateur_id" required>
        <option value="">-- Choisir un utilisateur --</option>
        <?php foreach ($utilisateurs as $utilisateur): ?>
            <option value="<?= (int) $utilisateur["id"] ?>">
                <?= htmlspecialchars($utilisateur["nom"], ENT_QUOTES, "UTF-8") ?>
            </option>
        <?php endforeach; ?>
    </select>
<!-- Même principe pour categorie_id -->

    <button class="bouton" type="submit">Créer</button>
</form>
    </main>
</body>