<?php
// compte2.php
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
        <?php
    if (isset($_SESSION['message'])) {
        echo "<p>" . $_SESSION['message'] . "</p>";
        unset($_SESSION['message']);
    }
    ?>
     <div class="wrapper">
        <header>
            <h1>Sportify: <span class="subtitle">Consultation Sportive</span></h1>
            <img src="image.png" alt="Logo Sportify" class="logo">
        </header>
        <nav>
            <ul>
                <li><a href="Acceuil_Stan.html">Accueil</a></li>
                <li><a href="Parcourir.html">Tout Parcourir</a></li>
                <li><a href="recherche.html">Recherche</a></li>
                <li><a href="Prendre_rendez_vous.html">Rendez-vous</a></li>
                <li><a href="compte.html">Votre Compte</a></li>
            </ul>
        </nav>
    </div>
    <!-- <div class="container">
        <h2>Créer votre compte Sportify</h2>
        <form action="/submit" method="post">
            <label for="accountType">Type de compte :</label>
            <select id="accountType" name="accountType" required>
                <option value="">Sélectionnez un type de compte</option>
                <option value="Client">Client</option>
                <option value="Personnel de sport">Personnel de sport</option>
                <option value="Administrateur">Administrateur</option>
            </select>  -->

            <!-- <label for="name">Prénom :</label>
            <input type="text" id="name" name="name" required>

            <label for="lastname">Nom :</label>
            <input type="text" id="lastname" name="lastname" required>

            <label for="username">Identifiant :</label>
            <input type="text" id="username" name="username" required>

            <label for="password">Mot de passe :</label>
            <input type="password" id="password" name="password" required>
             -->
           
                <h2>Inscription</h2>
    <form action="inscription.php" method="post">
        <label for="profession">Type de compte :</label>
            <select id="profession" name="profession" required>
                <option value="">Sélectionnez un type de compte</option>
                <option value="Client">Client</option>
                <option value="Personnel de sport">Personnel de sport</option>
                <option value="Administrateur">Administrateur</option>
            </select>
         
         <label for="nom">Nom:</label>
        <input type="text" id="nom" name="nom" required><br><br>
        <label for="prenom">Prénom:</label>
        <input type="text" id="prenom" name="prenom" required><br><br>
        <label for="email">Email:</label>
        <input type="email" id="email" name="email" required><br><br>
        <label for="mdp">Mot de passe:</label>
        <input type="password" id="mdp" name="mdp" required><br><br>
        <input type="hidden" id="photo_client" name="photo_client" value="">

        <br>
       
        <button type="submit">S'inscrire</button> 
        
    </form>


             <div class="photo-section">
                <h3>Prendre une photo</h3>
                <button type="button" id="startCamera">Démarrer la caméra</button>
                <video id="video" width="320" height="240" autoplay style="display:none;"></video>
                <canvas id="canvas" width="320" height="240" style="display:none;"></canvas>
                <div class="output"></div>
                <button type="button" id="takePhoto" disabled>Prendre la photo</button>
                <button type="button" id="retakePhoto" style="display:none;">Reprendre la photo</button>
                <button type="button" id="savePhoto" style="display:none;">Sauvegarder la photo</button>
            </div>

        </form>
        <p>J'ai déjà un compte : <a href="connexion2.php">Connexion</a></p>
    </div>
    <script src="camera.js"></script>
</body>
</html>