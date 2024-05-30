<?php
// login.php
session_start();
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Créer un compte</title>
    <link rel="stylesheet" href="Co.css">
</head>
<body>
    <div class="wrapper">
        <h1>Sportify: <span class="subtitle">Consultation Sportive</span></h1>
            <img src="image.png" alt="Logo Sportify" class="logo">
        </header>
        <nav>
            <ul>
                <li><a href="Accueil_Stan.html">Accueil</a></li>
                <li><a href="Parcourir.html">Tout Parcourir</a></li>
                <li><a href="recherche.html">Recherche</a></li>
                <li><a href="Prendre_rendez_vous.html">Rendez-vous</a></li>
                <li><a href="compte.html">Votre Compte</a></li>
            </ul>
        </nav>
    </div>
    <div class="container">
        <h2>Connexion à votre compte sportify</h2>
       

            <label for="accountType">Type de compte :</label>
            <select id="accountType" name="accountType" required>
                <option value="">Sélectionnez un type de compte</option>
                <option value="Client">Client</option>
                <option value="Personnel de sport">Personnel de sport</option>
                <option value="Administrateur">Administrateur</option>
            </select>

             <h2>Connexion</h2>
    <form action="connexion.php" method="post">
        <label for="email">Email:</label>
        <input type="email" id="email" name="email" required><br><br>
        <label for="mdp">Mot de passe:</label>
        <input type="password" id="mdp" name="mdp" required><br><br>
        <button type="submit">Se connecter</button>
    
        </form>
    </div>
</body>
</html>