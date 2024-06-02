






<?php
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
                <li><a href="Acceuil_stan.php">Accueil</a></li>
                <li><a href="Parcourir.html">Tout Parcourir</a></li>
                <li><a href="recherche.html">Recherche</a></li>
                <li><a href="rendez_vous.html">Rendez-vous</a></li>
                <li><a href="compte2.php">Votre Compte</a></li>
            </ul>
        </nav>
    </div>
    <div class="container">
        <h2>Créer votre compte Sportify</h2>
        <form action="inscription.php" method="post">
         
            <label for="profession">Type de compte :</label>
            <select id="profession" name="profession" required>
                <option value="">Sélectionnez un type de compte</option>
                <option value="Client">Client</option>
                <option value="Personnel de sport">Personnel de sport</option>
                <option value="Administrateur">Administrateur</option>
            </select> 





            <label for="prenom">Prénom :</label>
            <input type="text" id="prenom" name="prenom" required>

            <label for="nom">Nom :</label>
            <input type="text" id="nom" name="nom" required>

            <label for="adresse">Adresse :</label>
            <input type="text" id="adresse" name="adresse" required>

            <label for="num_etudiant">Numéro carte étudiante (4 chiffres) :</label>
            <input type="number" id="num_etudiant" name="num_etudiant" required>

            <label for="email">Email :</label>
            <input type="email" id="email" name="email" required>

            <label for="mdp">Mot de passe :</label>
            <input type="password" id="mdp" name="mdp" required>

            <input type="hidden" id="photo_client" name="photo_client" value="">

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

            <button type="submit">Créer mon compte</button>
        </form>
        <p>J'ai déjà un compte : <a href="connexion2.php">Connexion</a></p>
          <p> <a href="connexion_admin.php">Admin</a></p>

    </div>
    <script src="camera.js"></script>
</body>
</html>


