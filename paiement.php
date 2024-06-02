<?php
session_start();
include('config.php');

// Vérifier si l'utilisateur est connecté
if (!isset($_SESSION['id_client'])) {
    header('Location: compte2_connecté.php'); // Redirige vers la page de connexion si non connecté
    exit;
}

$user_id = $_SESSION['id_client'];
?>

<!-- 
<!DOCTYPE html>
<html>
<head>
    <title>Paiement</title>
    <link rel="stylesheet" href="Co.css">
</head>
<body>
    <div class="wrapper">
        <h1>Sportify: <span class="subtitle">Consultation Sportive</span></h1>
        <img src="image.png" alt="Logo Sportify" class="logo">
        <nav>
            <ul>
                <li><a href="Acceuil_Stan.php">Accueil</a></li>
                <li><a href="Parcourir.html">Tout Parcourir</a></li>
                <li><a href="recherche.php">Recherche</a></li>
                <li><a href="Prendre_rendez_vous.html">Rendez-vous</a></li>
                <li><a href="compte2.php">Votre Compte</a></li>
                <li><a href="logout.php">Déconnexion</a></li>
            </ul>
        </nav>
    </div>
    <div class="container">
        <h2>Informations de Paiement</h2>
        <form action="proceder_paiement.php" method="post">
            <h3>Coordonnées Personnelles</h3>
            <label for="name">Nom et Prénom :</label>
            <input type="text" id="name" name="name" required><br><br>

            <label for="address1">Adresse Ligne 1 :</label>
            <input type="text" id="address1" name="address1" required><br><br>

            <label for="address2">Adresse Ligne 2 :</label>
            <input type="text" id="address2" name="address2"><br><br>

            <label for="city">Ville :</label>
            <input type="text" id="city" name="city" required><br><br>

            <label for="postal_code">Code Postal :</label>
            <input type="text" id="postal_code" name="postal_code" required><br><br>

            <label for="country">Pays :</label>
            <input type="text" id="country" name="country" required><br><br>

            <label for="phone">Numéro de téléphone :</label>
            <input type="text" id="phone" name="phone" required><br><br>

            <label for="student_card">Carte Etudiant :</label>
            <input type="text" id="student_card" name="student_card" required><br><br>

            <h3>Informations de la Carte de Paiement</h3>
            <label for="card_type">Type de carte :</label>
            <select id="card_type" name="card_type" required>
                <option value="Visa">Visa</option>
                <option value="MasterCard">MasterCard</option>
                <option value="American Express">American Express</option>
                <option value="PayPal">PayPal</option>
            </select><br><br>

            <label for="card_number">Numéro de la carte :</label>
            <input type="text" id="card_number" name="card_number" required><br><br>

            <label for="card_name">Nom affiché sur la carte :</label>
            <input type="text" id="card_name" name="card_name" required><br><br>

            <label for="expiry_date">Date d'expiration :</label>
            <input type="text" id="expiry_date" name="expiry_date" required><br><br>

            <label for="security_code">Code de sécurité :</label>
            <input type="text" id="security_code" name="security_code" required><br><br>

            <input type="submit" value="Valider le paiement">
        </form>
    </div>
</body>
</html> -->
<!DOCTYPE html>
<html>
<head>
    <title>Paiement</title>
    <link rel="stylesheet" href="Co.css">
</head>
<body>
    <div class="wrapper">
        <h1>Sportify: <span class="subtitle">Consultation Sportive</span></h1>
        <img src="image.png" alt="Logo Sportify" class="logo">
        <nav>
            <ul>
                <li><a href="Acceuil_Stan.php">Accueil</a></li>
                <li><a href="Parcourir.html">Tout Parcourir</a></li>
                <li><a href="recherche.php">Recherche</a></li>
                <li><a href="Prendre_rendez_vous.html">Rendez-vous</a></li>
                <li><a href="compte2.php">Votre Compte</a></li>
                <li><a href="logout.php">Déconnexion</a></li>
            </ul>
        </nav>
    </div>
    <div class="container">
        <h2>Informations de Paiement</h2>
        <form action="proceder_paiement.php" method="post">
            <h3>Coordonnées Personnelles</h3>
            <label for="nom_client">Nom :</label>
            <input type="text" id="nom_client" name="nom_client" required><br><br>

            <label for="prenom_client">Prénom :</label>
            <input type="text" id="prenom_client" name="prenom_client" required><br><br>

            <label for="adresse1">Adresse Ligne 1 :</label>
            <input type="text" id="adresse1" name="adresse1" required><br><br>

            <label for="adresse2">Adresse Ligne 2 :</label>
            <input type="text" id="adresse2" name="adresse2"><br><br>

            <label for="ville">Ville :</label>
            <input type="text" id="ville" name="ville" required><br><br>

            <label for="code_postal">Code Postal :</label>
            <input type="text" id="code_postal" name="code_postal" required><br><br>

            <label for="pays">Pays :</label>
            <input type="text" id="pays" name="pays" required><br><br>

            <label for="num_telephone">Numéro de téléphone :</label>
            <input type="text" id="num_telephone" name="num_telephone" required><br><br>

            <label for="num_etudiant">Carte Etudiant :</label>
            <input type="text" id="num_etudiant" name="num_etudiant" required><br><br>

            <h3>Informations de la Carte de Paiement</h3>
            <label for="method_paiement">Type de carte :</label>
            <select id="method_paiement" name="method_paiement" required>
                <option value="Visa">Visa</option>
                <option value="MasterCard">MasterCard</option>
                <option value="American Express">American Express</option>
                <option value="PayPal">PayPal</option>
            </select><br><br>

            <label for="num_carte">Numéro de la carte :</label>
            <input type="text" id="num_carte" name="num_carte" required><br><br>

            <label for="nom_carte">Nom affiché sur la carte :</label>
            <input type="text" id="nom_carte" name="nom_carte" required><br><br>

            <label for="date_expiration">Date d'expiration :</label>
            <input type="text" id="date_expiration" name="date_expiration" required><br><br>

            <label for="code_securite">Code de sécurité :</label>
            <input type="text" id="code_securite" name="code_securite" required><br><br>

            <input type="submit" value="Valider le paiement">
        </form>
    </div>
</body>
</html>

