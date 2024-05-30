


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
$sexe = $_SESSION['sexe_client'] ?? 'Non spécifié';
$email = $_SESSION['email_client'] ?? 'Non spécifié';
$telephone = $_SESSION['telephone_client'] ?? 'Non spécifié';
$profession = $_SESSION['profession_client'] ?? 'Non spécifié';
$date_naissance = $_SESSION['date_naissance_client'] ?? 'Non spécifié';
$photo = $_SESSION['photo_client'] ?? '';

?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mon Compte</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
        <h2>Mon Compte</h2>
        <div class="account-info">
            <p><strong>Nom :</strong> <?php echo htmlspecialchars($nom); ?></p>
            <p><strong>Prénom :</strong> <?php echo htmlspecialchars($prenom); ?></p>
            <p><strong>Sexe :</strong> <?php echo htmlspecialchars($sexe); ?></p>
            <p><strong>Email :</strong> <?php echo htmlspecialchars($email); ?></p>
            <p><strong>Téléphone :</strong> <?php echo htmlspecialchars($telephone); ?></p>
            <p><strong>Profession :</strong> <?php echo htmlspecialchars($profession); ?></p>
            <p><strong>Date de naissance :</strong> <?php echo htmlspecialchars($date_naissance); ?></p>
            <?php if ($photo): ?>
                <p><strong>Photo :</strong><br><img src="<?php echo htmlspecialchars($photo); ?>" alt="Photo de profil" style="max-width: 150px; max-height: 150px;"></p>
            <?php endif; ?>
        </div>
    </div>
</body>
</html>
