<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Résultat de la Recherche</title>
    <link rel="stylesheet" href="collection.css">
</head>
<body>
    <div class="table-container">
        <h1>Résultat de la Recherche</h1>
        <?php
        $servername = "localhost";
        $username = "root";
        $password = "";
        $dbname = "bibliotheque";

        $conn = new mysqli($servername, $username, $password, $dbname);

        if ($conn->connect_error) {
            die("Connexion échouée : " . $conn->connect_error);
        }

        $utilisateur_id = $_SESSION['utilisateur_id'];
        $recherche = isset($_GET['recherche']) ? $_GET['recherche'] : '';

        $sql = "SELECT livres.id, livres.titre, auteurs.nom AS auteur, livres.annee_edition, livres.date_achat
                FROM livres
                JOIN auteurs ON livres.auteur_id = auteurs.id
                WHERE livres.utilisateur_id = ? AND livres.titre LIKE ?";
        $stmt = $conn->prepare($sql);
        $recherche_param = "%" . $recherche . "%";
        $stmt->bind_param("is", $utilisateur_id, $recherche_param);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            echo "<table>";
            echo "<tr><th>Titre</th><th>Auteur</th><th>Année d'édition</th><th>Date d'achat</th></tr>";

            while ($row = $result->fetch_assoc()) {
                echo "<tr>";
                echo "<td>" . htmlspecialchars($row['titre']) . "</td>";
                echo "<td>" . htmlspecialchars($row['auteur']) . "</td>";
                echo "<td>" . htmlspecialchars($row['annee_edition']) . "</td>";
                echo "<td>" . htmlspecialchars($row['date_achat']) . "</td>";
                echo "</tr>";
            }
            echo "</table>";
        } else {
            echo "<p>Aucun livre trouvé avec ce titre.</p>";
        }

        $stmt->close();
        $conn->close();
        ?>
        <a href="collection.php">Retour à la collection</a>
    </div>
</body>
</html>
