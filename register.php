<!DOCTYPE html>
<html>

<head>
    <title>Connexion</title>
    <link rel="stylesheet" href="style_login.css">
</head>

<body>
    <header>
        <div class="titre">
            <h1>MyBookStore</h1>
        </div>
    </header>
    <main>
        <div class="login-container">
            <h1>Inscription </h1>
            <form action="register_action.php" method="POST">

                <label for="login">Nom d'utilisateur :</label>
                <input type="text" id="login" name="login" required>
                <label for="mot_de_passe">Mot de passe :</label>
                <input type="password" id="mot_de_passe" name="mot_de_passe" required>

                <div class="button-container">
                    <button type="submit" class="login-button">S'incrire</button>
                </div>
            </form>
        </div>

        <div class="new_account_container">
            <p>Vous avez déja un compte?</p>
            <a href="login.php" class="new_account"> Connectez vous </a>

        </div>
    </main>
</body>