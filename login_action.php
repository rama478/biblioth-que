<link rel="stylesheet" href="style_pop_up_login.css">

<?php
session_start();

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "bibliotheque";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connexion échouée : ". $conn->connect_error);
}

$login = $_POST['login'];
$mot_de_passe = $_POST['mot_de_passe'];

// Vérifier les identifiants de l'utilisateur
$sql = "SELECT id FROM utilisateurs WHERE login =? AND mot_de_passe =?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ss", $login, $mot_de_passe);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $_SESSION['utilisateur_id'] = $row['id'];
    $_SESSION['login'] = $login;
    header("Location: accueil.php");
} else {
    $error_message = "Erreur : Login ou mot de passe incorrect.";
   ?>
    <div class="alert alert-danger">
        <strong>Erreur :</strong> <?= $error_message?>
    </div>
    <?php
}

$stmt->close();
$conn->close();
?>