







<?php
session_start();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Enregistrer un Prêt</title>
    <link rel="stylesheet" type="text/css" href="enregistrer_pret.css">
</head>
<body>
    <h1>Enregistrer un Prêt</h1>
    <form action="enregistrer_pret_action.php" method="post">
        <label for="livre_id">Sélectionnez le Livre :</label>
        <select id="livre_id" name="livre_id" required>
            <?php
            // Connexion à la base de données
            $servername = "localhost";
            $username = "root";
            $password = "";
            $dbname = "bibliotheque";

            $conn = new mysqli($servername, $username, $password, $dbname);

            if ($conn->connect_error) {
                die("Connexion échouée : " . $conn->connect_error);
            }

            // Récupérer l'ID de l'utilisateur connecté
            $utilisateur_id = $_SESSION['utilisateur_id'];

            // Récupérer les livres appartenant à cet utilisateur
            $sql = "SELECT id, titre FROM livres WHERE utilisateur_id = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("i", $utilisateur_id);
            $stmt->execute();
            $result = $stmt->get_result();

            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo '<option value="' . $row['id'] . '">' . htmlspecialchars($row['titre']) . '</option>';
                }
            } else {
                echo '<option value="">Aucun livre disponible</option>';
            }

            $stmt->close();
            $conn->close();
            ?>
        </select><br><br>
        
        <label for="nom_personne">Nom de la personne :</label>
        <input type="text" id="nom_personne" name="nom_personne" required><br><br>
        
        <label for="date_pret">Date du prêt :</label>
        <input type="date" id="date_pret" name="date_pret" required><br><br>
        
        <input type="submit" value="Enregistrer">
    </form>
</body>
</html>
