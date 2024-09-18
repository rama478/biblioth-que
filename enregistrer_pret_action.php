


<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "bibliotheque";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connexion échouée : " . $conn->connect_error);
}

$livre_id = $_POST['livre_id'];
$nom_personne = $_POST['nom_personne'];
$date_pret = $_POST['date_pret'];

// Vérifier si l'ID du livre existe
$sql_check = "SELECT id FROM livres WHERE id = ?";
$stmt_check = $conn->prepare($sql_check);
$stmt_check->bind_param("i", $livre_id);
$stmt_check->execute();
$result_check = $stmt_check->get_result();
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Enregistrement de Prêt</title>
    <link rel="stylesheet" href="style_pop_op.css">
</head>
<body>
    
    <div class="container">
        <?php
        if ($result_check->num_rows > 0) {
            // L'ID du livre existe, on peut enregistrer le prêt
            $sql = "INSERT INTO prets (livre_id, nom_personne, date_pret) VALUES (?, ?, ?)";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("iss", $livre_id, $nom_personne, $date_pret);
            $stmt->execute();

            echo '<div class="message">Prêt enregistré avec succès.</div>';
            echo '<div class="links">';
            echo '<a href="accueil.php">Retour à la page d\'accueil</a>';
            echo '<a href="livre_pretes.php">Voir les livres prêtés</a>';
            echo '</div>';
        } else {
            // L'ID du livre n'existe pas
            echo '<div class="message error">Erreur : Le livre avec cet ID n\'existe pas.</div>';
            echo '<div class="links">';
            echo '<a href="enregistrer_pret.php">Retour à la page d\'enregistrement de prêt</a>';
            echo '<a href="accueil.php">Retour à la page d\'accueil</a>';
            echo '</div>';
        }

        $conn->close();
        ?>
    </div>
</body>
</html>
