<?php
// login.php
session_start();
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connexion Admin</title>
    <link rel="stylesheet" href="Co.css">
</head>
<body>
    <div class="wrapper">
        <h1>Sportify: <span class="subtitle">Consultation Sportive</span></h1>
            <img src="image.png" alt="Logo Sportify" class="logo">
        </header>
        <nav>
            <ul>
                <li><a href="Acceuil_Stan.php">Accueil</a></li>
                <li><a href="Parcourir.html">Tout Parcourir</a></li>
                <li><a href="recherche.php">Recherche</a></li>
                <li><a href="Prendre_rendez_vous.html">Rendez-vous</a></li>
                <li><a href="compte2.php">Votre Compte</a></li>
            </ul>
        </nav>
    </div>
    <div class="container">
      
       
<!-- 
            <label for="accountType">Type de compte :</label>
            <select id="accountType" name="accountType" required>
                <option value="">Sélectionnez un type de compte</option>
                <option value="Client">Client</option>
                <option value="Personnel de sport">Personnel de sport</option>
                <option value="Administrateur">Administrateur</option>
            </select> -->

             <h2>Connexion - Administrateur</h2>
    <form action="connexion2_admin.php" method="post">
        <label for="prenom_admin">Prénom:</label>
        <input type="text" id="prenom_admin" name="prenom_admin" required><br><br>
        <label for="nom_admin">Nom:</label>
        <input type="text" id="nom_admin" name="nom_admin" required><br><br>
        <label for="email_admin">Email:</label>
        <input type="email" id="emai_adminl" name="email_admin" required><br><br>
        <label for="mdp_admin">Mot de passe:</label>
        <input type="password" id="mdp_admin" name="mdp_admin" required><br><br>
        <button type="submit">Se connecter</button>
    
        </form>
    </div>
</body>
</html>