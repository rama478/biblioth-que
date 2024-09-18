




<!DOCTYPE html>
<html>

<head>
    <title>Livres Prêtés</title>
    <link rel="stylesheet" href="livre_pretes.css">
</head>

<body>
    <header>
        <h1>Livres Prêtés</h1>
    </header>

    <main>
        <table>
            <thead>
                <tr>
                   
                    <th>Titre du Livre</th>
                    <th>Nom de la Personne</th>
                    <th>Date du Prêt</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $servername = "localhost";
                $username = "root";
                $password = "";
                $dbname = "bibliotheque";

                $conn = new mysqli($servername, $username, $password, $dbname);

                if ($conn->connect_error) {
                    die("Connexion échouée : " . $conn->connect_error);
                }

                // Définir la requête SQL avec jointure pour obtenir le titre des livres
                $sql = "SELECT prets.id, livres.titre, prets.nom_personne, prets.date_pret 
                        FROM prets 
                        JOIN livres ON prets.livre_id = livres.id";

                // Exécuter la requête
                $result = $conn->query($sql);

                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo "<tr>";
                        
                        echo "<td>" . htmlspecialchars($row['titre']) . "</td>";
                        echo "<td>" . htmlspecialchars($row['nom_personne']) . "</td>";
                        echo "<td>" . htmlspecialchars($row['date_pret']) . "</td>";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='4'>Aucun prêt enregistré.</td></tr>";
                }

                $conn->close();
                ?>
            </tbody>
        </table>
    </main>

    <div class="boutoncontainer">
        <a href="accueil.php"><button class="buttonback">Retour à la page d'accueil</button></a>
    </div>

    <footer>
        <p>&copy; 2024 Bibliothèque. Tous droits réservés.</p>
    </footer>
</body>

</html> 


