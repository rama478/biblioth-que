<link rel="stylesheet" href="register_action.css">
<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "bibliotheque";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connexion échouée : " . $conn->connect_error);
}

$login = $_POST['login'];
$mot_de_passe = $_POST['mot_de_passe'];

// Vérifier si le login existe déjà
$sql_check = "SELECT id FROM utilisateurs WHERE login = ?";
$stmt_check = $conn->prepare($sql_check);
$stmt_check->bind_param("s", $login);
$stmt_check->execute();
$result_check = $stmt_check->get_result();

if ($result_check->num_rows > 0) {
    echo "<div class='message error'>Erreur : Ce login est déjà pris.</div>";
} else {
    // Ajouter le nouvel utilisateur
    $sql_insert = "INSERT INTO utilisateurs (login, mot_de_passe) VALUES (?, ?)";
    $stmt_insert = $conn->prepare($sql_insert);
    $stmt_insert->bind_param("ss", $login, $mot_de_passe);
    if ($stmt_insert->execute()) {
        echo "<div class='message success'>Inscription réussie. <a href='login.php'>Cliquez ici pour vous connecter</a>.</div>";
    } else {
        echo "<div class='message error'>Erreur lors de l'inscription : " . $stmt_insert->error . "</div>";
    }
}

// Fermer les statements préparés et la connexion, même si une erreur s'est produite
$stmt_check->close();
if (isset($stmt_insert)) {
    $stmt_insert->close();
}
$conn->close();
?>
