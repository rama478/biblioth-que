
<!DOCTYPE html>
<html>
<head>
    <title>Confirmer la Suppression</title>
    <link rel="stylesheet" type="text/css" href="confirmer_suppression.css">
</head>
<body>
    <h1>Confirmer la Suppression</h1>
    <?php
    $id = intval($_GET['id']);

    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "bibliotheque";

    $conn = new mysqli($servername, $username, $password, $dbname);

    if ($conn->connect_error) {
        die("Connexion échouée : " . $conn->connect_error);
    }

    $sql = "SELECT titre, auteur_id FROM livres WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($row = $result->fetch_assoc()) {
        $titre = htmlspecialchars($row['titre']);

        // Récupérer l'auteur
        $auteur_id = $row['auteur_id'];
        $sql_author = "SELECT nom FROM auteurs WHERE id = ?";
        $stmt_author = $conn->prepare($sql_author);
        $stmt_author->bind_param("i", $auteur_id);
        $stmt_author->execute();
        $result_author = $stmt_author->get_result();
        if ($author_row = $result_author->fetch_assoc()) {
            $auteur = htmlspecialchars($author_row['nom']);
        }

        echo "<p>Êtes-vous sûr de vouloir supprimer le livre \"$titre\" de \"$auteur\" ?</p>";
    } else {
        echo "<p>Erreur : Livre non trouvé.</p>";
    }

    $stmt->close();
    $conn->close();
    ?>
    <form action="supprimer_livre_action.php" method="POST">
        <input type="hidden" name="id" value="<?php echo $id; ?>">
        <button type="submit">Oui, supprimer</button>
        <a href="collection.php">Annuler</a>
    </form>
</body>
</html>
