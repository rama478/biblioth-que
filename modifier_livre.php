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

$sql = "SELECT livres.titre, auteurs.nom AS auteur, livres.annee_edition, livres.date_achat
        FROM livres
        JOIN auteurs ON livres.auteur_id = auteurs.id
        WHERE livres.id = ? AND livres.utilisateur_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ii", $id, $_SESSION['utilisateur_id']);
$stmt->execute();
$result = $stmt->get_result();

if ($row = $result->fetch_assoc()) {
    $titre = $row['titre'];
    $auteur = $row['auteur'];
    $annee_edition = $row['annee_edition'];
    $date_achat = $row['date_achat'];
} else {
    echo "Livre non trouvé ou vous n'avez pas l'autorisation de le modifier.";
    exit();
}

$stmt->close();
$conn->close();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Modifier un Livre</title>
    <link rel="stylesheet" type="text/css" href="modifier_livre.css">
</head>
<body>
    <h1>Modifier un Livre</h1>
    <form action="modifier_livre_action.php?id=<?php echo $id; ?>" method="POST">
        <label for="titre">Titre :</label>
        <input type="text" id="titre" name="titre" value="<?php echo htmlspecialchars($titre); ?>" required><br><br>
        
        <label for="auteur">Auteur :</label>
        <input type="text" id="auteur" name="auteur" value="<?php echo htmlspecialchars($auteur); ?>" required><br><br>
        
        <label for="annee_edition">Année d'édition :</label>
        <input type="number" id="annee_edition" name="annee_edition" value="<?php echo htmlspecialchars($annee_edition); ?>" required><br><br>
        
        <label for="date_achat">Date d'achat :</label>
        <input type="date" id="date_achat" name="date_achat" value="<?php echo htmlspecialchars($date_achat); ?>"><br><br>
        
        <input type="submit" value="Modifier">
    </form>
</body>
</html>
