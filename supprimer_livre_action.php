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

if (isset($_POST['id'])) {
    $id = intval($_POST['id']);
    $utilisateur_id = $_SESSION['utilisateur_id']; // Récupérer l'ID de l'utilisateur connecté

    // Vérifier si le livre appartient à l'utilisateur connecté
    $sql_check = "SELECT id FROM livres WHERE id = ? AND utilisateur_id = ?";
    $stmt_check = $conn->prepare($sql_check);

    if ($stmt_check) {
        $stmt_check->bind_param("ii", $id, $utilisateur_id);
        $stmt_check->execute();
        $result_check = $stmt_check->get_result();

        if ($result_check->num_rows > 0) {
            // Supprimer les prêts associés au livre
            $sql_delete_prets = "DELETE FROM prets WHERE livre_id = ?";
            $stmt_delete_prets = $conn->prepare($sql_delete_prets);

            if ($stmt_delete_prets) {
                $stmt_delete_prets->bind_param("i", $id);

                if ($stmt_delete_prets->execute()) {
                    // Supprimer le livre après avoir supprimé les prêts
                    $sql = "DELETE FROM livres WHERE id = ? AND utilisateur_id = ?";
                    $stmt = $conn->prepare($sql);

                    if ($stmt) {
                        $stmt->bind_param("ii", $id, $utilisateur_id);

                        if ($stmt->execute()) {
                            echo "Livre supprimé avec succès.";
                        } else {
                            echo "Erreur lors de la suppression du livre : " . $stmt->error;
                        }
                    } else {
                        echo "Erreur lors de la préparation de la requête de suppression du livre.";
                    }
                } else {
                    echo "Erreur lors de la suppression des prêts associés : " . $stmt_delete_prets->error;
                }
            } else {
                echo "Erreur lors de la préparation de la requête de suppression des prêts.";
            }

            if (isset($stmt_delete_prets)) {
                $stmt_delete_prets->close();
            }
        } else {
            echo "Erreur : Vous n'avez pas l'autorisation de supprimer ce livre.";
        }

        $stmt_check->close();
    } else {
        echo "Erreur lors de la préparation de la requête de vérification.";
    }

    if (isset($stmt)) {
        $stmt->close();
    }
} else {
    echo "ID du livre non spécifié.";
}

$conn->close();
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Suppression de Livre</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }
        .container {
            max-width: 600px;
            margin: 50px auto;
            padding: 20px;
            background-color: #fff;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
        }
        .message {
            font-size: 1.2em;
            margin-bottom: 20px;
            
            color: #339633;
        }
        .links a {
            display: inline-block;
            margin: 10px 0;
            padding: 10px 20px;
            background-color: #339633;
            color: #fff;
            text-decoration: none;
            border-radius: 4px;
        }
        .links a:hover {
            background-color: #0fbcda;
        }
        .error {
            color: red;
            font-weight: bold;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="links">
            <a href="collection.php">Retour à la collection</a>
        </div>
    </div>
</body>
</html>
