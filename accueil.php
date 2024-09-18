<!DOCTYPE html>
<html>

<head>
    <title>Accueil</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style_accueil.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">

</head>

<body>
    <header>

        <div class="titre">
            <h1>MyBookStore </h1>
        </div>

        <div class="logout-container">
            <a href="login.php"><button class="logout-button">logout</button></a>
        </div>
    </header>

    <main>
        <section class="section1">
            <h1>Bienvenue dans MyBookStore</h1>
        </section>
        <section class="descrip">
            <p>Bienvenue à MyBookStore, votre bibliothèque de confiance. Nous proposons une vaste collection de livres
                couvrant divers genres pour satisfaire tous les goûts. Notre équipe dédiée est toujours prête à vous
                aider à trouver le livre parfait. Avec des services de prêt efficaces, nous facilitons l'accès à la
                lecture pour tous. Rejoignez-nous pour explorer un monde de connaissances et d'aventures littéraires.
                Chez MyBookStore, chaque livre est une porte ouverte vers de nouveaux horizons.</p>
            <img src="bibli1.jpeg" alt="">
        </section>
        <section class="menu">

            <h2>Menu: Gére ton bibliothèque</h2>
            <div class="button-container">
                <div>
                    <a href="ajouter_livre.php"><i class="fa-solid fa-folder-plus"></i></a>
                    <p>Ajouter un livre </p>
                </div>
                <div>
                    <a href="collection.php"><i class="fa-solid fa-list-check"></i></a>
                    <p>Voir la Collection</p>
                </div>
                <div>
                    <a href="enregistrer_pret.php"><i class="fa-solid fa-cash-register"></i></a>
                    <p>Enregistrer un Prêt</p>
                </div>
                <div>
                    <a href="livre_pretes.php"><i class="fa-brands fa-leanpub"></i></a>
                    <p>Livres prêtés </p>
                </div>
                <div>
                    <i class="fa-solid fa-eraser"></i>
                    <p>Supprimer un Livre</p>
                </div>

                <!--                 
                <a href="collection.php" class="button">Voir la Collection</a>
                <a href="enregistrer_pret.php" class="button">Enregistrer un Prêt</a>
                <a href="modifier_livre.php" class="button">Modifier un Livre</a>
                <a href="supprimer_livre.php" class="button">Supprimer un Livre</a> -->
            </div>
        </section>

    </main>

    <footer>
        <p>&copy; 2024 Bibliothèque. Tous droits réservés.</p>
    </footer>
</body>

</html>