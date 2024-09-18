<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ajouter un Livre</title>
    <link rel="stylesheet" href="ajouter_livre.css">
</head>
<body>
    <div class="form-container">
        <h1>Ajouter un Livre</h1>
        
        <?php
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['confirm'])) {
            if ($_POST['confirm'] === 'Oui') {
                // Rediriger avec les données du formulaire encodées dans l'URL
                header('Location: ajouter_livre_action.php?' . http_build_query($_POST));
                exit;
            } else {
                header('Location: accueil.php');
                exit;
            }
        } elseif ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Afficher le formulaire de confirmation
            $titre = htmlspecialchars($_POST['titre']);
            $auteur = htmlspecialchars($_POST['auteur']);
            $annee_edition = htmlspecialchars($_POST['annee_edition']);
            $date_achat = htmlspecialchars($_POST['date_achat']);
        ?>
            <form action="ajouter_livre.php" method="POST">
                <p>Voulez-vous vraiment ajouter ce livre ?</p>
                <input type="hidden" name="titre" value="<?php echo $titre; ?>">
                <input type="hidden" name="auteur" value="<?php echo $auteur; ?>">
                <input type="hidden" name="annee_edition" value="<?php echo $annee_edition; ?>">
                <input type="hidden" name="date_achat" value="<?php echo $date_achat; ?>">
                <input type="submit" name="confirm" value="Oui"><br><br><br>
                <input type="submit" name="confirm" value="Non">
            </form>
        <?php
        } else {
        ?>
            <form action="ajouter_livre.php" method="POST">
                <label for="titre">Titre :</label>
                <input type="text" id="titre" name="titre" required>
                
                <label for="auteur">Auteur :</label>
                <input type="text" id="auteur" name="auteur" required>
                
                <label for="annee_edition">Année d'édition :</label>
                <input type="number" id="annee_edition" name="annee_edition" required>
                
                <label for="date_achat">Date d'achat :</label>
                <input type="date" id="date_achat" name="date_achat">
                
                <input type="submit" value="Ajouter">
            </form>
        <?php
        }
        ?>
    </div>
</body>
</html>
