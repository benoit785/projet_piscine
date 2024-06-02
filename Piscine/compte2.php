<?php
 // Démarre ou reprend une session existante
session_start(); 
// Vérifier si l'utilisateur est connecté
if (!isset($_SESSION['id_client'])) {
    header('Location: compte2_connecté.php'); // Redirige vers la page de connexion si non connecté
    exit;
}

// Variables de session contenant les informations de l'utilisateur
$nom = $_SESSION['nom_client'] ?? 'Non spécifié';
$prenom = $_SESSION['prenom_client'] ?? 'Non spécifié';
$email = $_SESSION['email_client'] ?? 'Non spécifié';
$profession = $_SESSION['profession'] ?? 'Non spécifié';
$photo = $_SESSION['photo_client'] ?? '';

?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mon Compte</title>
    <link rel="stylesheet" href="Co.css">
</head>
<body>
    <div class="wrapper">
        <header>
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
                <li><a href="logout.php">Déconnexion</a></li>
            </ul>
        </nav>
    </div>
    <div class="container">
        <h2>Mon Compte</h2>
        <div class="account-info">
            <p><strong>Nom :</strong> <?php echo htmlspecialchars($nom); ?></p>
            <p><strong>Prénom :</strong> <?php echo htmlspecialchars($prenom); ?></p>
            <p><strong>Email :</strong> <?php echo htmlspecialchars($email); ?></p>
            <p><strong>Profession :</strong> <?php echo htmlspecialchars($profession); ?></p>
            <?php if ($photo): ?>
                <p><strong>Photo :</strong><br><img src="<?php echo htmlspecialchars($photo); ?>" alt="Photo de profil" class="profile-photo"></p>
            <?php endif; ?>
            
            <?php if ($profession === 'Administrateur'): ?>
                <p><a href="admin_dashboard.php" class="admin-button">Accéder au tableau de bord administrateur</a></p>
            <?php endif; ?>
        </div>
    </div>
</body>
</html>
