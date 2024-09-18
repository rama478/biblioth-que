



<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Collection de Livres</title>
    <link rel="stylesheet" href="collection.css">
</head>
<body>
    <header>
        <div class="search-container">
            <form method="GET" action="rechercher_livre_action.php">
                <label for="recherche">Rechercher un livre :</label>
                <input type="text" id="recherche" name="recherche" placeholder="Entrez le titre du livre" required>
                <input type="submit" value="Rechercher">
            </form>
        </div>
    </header>
    <div class="table-container">
        <h1>Collection de Livres</h1>
        <?php
        // Connection and fetch user's book collection
        $servername = "localhost";
        $username = "root";
        $password = "";
        $dbname = "bibliotheque";

        $conn = new mysqli($servername, $username, $password, $dbname);

        if ($conn->connect_error) {
            die("Connexion échouée : " . $conn->connect_error);
        }

        $utilisateur_id = $_SESSION['utilisateur_id']; // Récupérer l'ID de l'utilisateur connecté

        $sql = "SELECT livres.id, livres.titre, auteurs.nom AS auteur, livres.annee_edition, livres.date_achat
                FROM livres
                JOIN auteurs ON livres.auteur_id = auteurs.id
                WHERE livres.utilisateur_id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $utilisateur_id);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            echo "<table>";
            echo "<tr><th>Titre</th><th>Auteur</th><th>Année d'édition</th><th>Date d'achat</th><th>Modifier</th><th>Supprimer</th></tr>";

            while ($row = $result->fetch_assoc()) {
                echo "<tr>";
                echo "<td>" . htmlspecialchars($row['titre']) . "</td>";
                echo "<td>" . htmlspecialchars($row['auteur']) . "</td>";
                echo "<td>" . htmlspecialchars($row['annee_edition']) . "</td>";
                echo "<td>" . htmlspecialchars($row['date_achat']) . "</td>";
                echo "<td><a href='modifier_livre.php?id=" . $row['id'] . "'><img src='bouton-modifier.png'></a></td>";
                echo "<td><a href='confirmer_suppression.php?id=" . $row['id'] . "'><img src='supprimer.png'></a></td>";
                echo "</tr>";
            }
            echo "</table>";
        } else {
            echo "<p>Vous n'avez aucun livre dans votre collection.</p>";
        }

        $stmt->close();
        $conn->close();
        ?>
 

    </div>
    <div class="boutoncontainer">
        <a href="accueil.php"><button class="buttonback">Retour à la page d'accueil</button></a>
    </div>

</body>
</html>
