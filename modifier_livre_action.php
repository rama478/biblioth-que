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

$id = $_GET['id']; // Récupérer l'ID du livre depuis l'URL
$titre = $_POST['titre'];
$auteur = $_POST['auteur'];
$annee_edition = $_POST['annee_edition'];
$date_achat = $_POST['date_achat'];
$utilisateur_id = $_SESSION['utilisateur_id']; // Récupérer l'ID de l'utilisateur connecté

// Vérifier si le livre appartient à l'utilisateur connecté
$sql_check = "SELECT id FROM livres WHERE id = ? AND utilisateur_id = ?";
$stmt_check = $conn->prepare($sql_check);
$stmt_check->bind_param("ii", $id, $utilisateur_id);
$stmt_check->execute();
$result_check = $stmt_check->get_result();

if ($result_check->num_rows > 0) {
    // Mise à jour du livre
    $sql = "UPDATE livres SET titre = ?, auteur_id = (SELECT id FROM auteurs WHERE nom = ?), annee_edition = ?, date_achat = ? WHERE id = ? AND utilisateur_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssisis", $titre, $auteur, $annee_edition, $date_achat, $id, $utilisateur_id);

    if ($stmt->execute()) {
        echo "Livre modifié avec succès.";
    } else {
        echo "Erreur lors de la modification du livre : " . $stmt->error;
    }
} else {
    echo "Erreur : Vous n'avez pas l'autorisation de modifier ce livre.";
}

$stmt_check->close();
$stmt->close();
$conn->close();
?>
<a href="accueil.php">Retour à l'accueil</a>
