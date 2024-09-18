

<?php
session_start();

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "bibliotheque";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connexion échouée : " . $conn->connect_error);
}

$titre = isset($_GET['titre']) ? $_GET['titre'] : null;
$auteur = isset($_GET['auteur']) ? $_GET['auteur'] : null;
$annee_edition = isset($_GET['annee_edition']) ? intval($_GET['annee_edition']) : null;
$date_achat = isset($_GET['date_achat']) ? $_GET['date_achat'] : null;
$utilisateur_id = isset($_SESSION['utilisateur_id']) ? $_SESSION['utilisateur_id'] : null;

$message = "";

if ($titre && $auteur && $annee_edition && $date_achat && $utilisateur_id) {
    // Vérifier si le livre existe déjà pour cet utilisateur
    $sql_check = "SELECT id FROM livres WHERE titre = ? AND utilisateur_id = ?";
    $stmt_check = $conn->prepare($sql_check);
    $stmt_check->bind_param("si", $titre, $utilisateur_id);
    $stmt_check->execute();
    $result_check = $stmt_check->get_result();

    if ($result_check->num_rows > 0) {
        $message = "<div class='error'>Erreur : Ce livre existe déjà dans la base de données pour cet utilisateur.</div>";
    } else {
        // Vérifier si l'auteur existe déjà
        $sql_author_check = "SELECT id FROM auteurs WHERE nom = ?";
        $stmt_author_check = $conn->prepare($sql_author_check);
        $stmt_author_check->bind_param("s", $auteur);
        $stmt_author_check->execute();
        $result_author_check = $stmt_author_check->get_result();

        if ($result_author_check->num_rows > 0) {
            // Si l'auteur existe, récupérer son ID
            $row = $result_author_check->fetch_assoc();
            $auteur_id = $row['id'];
        } else {
            // Sinon, ajouter l'auteur à la base de données
            $sql_insert_author = "INSERT INTO auteurs (nom) VALUES (?)";
            $stmt_insert_author = $conn->prepare($sql_insert_author);
            $stmt_insert_author->bind_param("s", $auteur);
            $stmt_insert_author->execute();
            $auteur_id = $stmt_insert_author->insert_id;
        }

        // Ajouter le livre
        $sql = "INSERT INTO livres (titre, auteur_id, annee_edition, date_achat, utilisateur_id) VALUES (?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("siisi", $titre, $auteur_id, $annee_edition, $date_achat, $utilisateur_id);

        if ($stmt->execute()) {
            $message = "<div class='success'>Livre ajouté avec succès.</div>";
        } else {
            $message = "<div class='error'>Erreur lors de l'ajout du livre : " . $stmt->error . "</div>";
        }

        // Fermer les déclarations préparées
        $stmt_check->close();
        $stmt_author_check->close();
        if (isset($stmt_insert_author)) {
            $stmt_insert_author->close();
        }
        $stmt->close();
    }
} else {
    $message = "<div class='error'>Erreur : Tous les champs doivent être remplis.</div>";
}

$conn->close();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Ajouter un Livre</title>
    <link rel="stylesheet" href="style_pop_up.css">
</head>
<body>
    <?php echo $message; ?>
    <a href="accueil.php"><button class="bouton_retour">Retour à la page d'accueil</button></a>
</body>
</html>
