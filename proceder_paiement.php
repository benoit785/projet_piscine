<?php
session_start();
include('config.php');

// Vérifier si l'utilisateur est connecté
if (!isset($_SESSION['id_client'])) {
    header('Location: compte2_connecté.php'); // Redirige vers la page de connexion si non connecté
    exit;
}

$id_client = $_SESSION['id_client'];
$nom_client = $_POST['nom_client'];
$prenom_client = $_POST['prenom_client'];
$adresse1 = $_POST['adresse1'];
$adresse2 = $_POST['adresse2'];
$ville = $_POST['ville'];
$code_postal = $_POST['code_postal'];
$pays = $_POST['pays'];
$num_telephone = $_POST['num_telephone'];
$num_etudiant = $_POST['num_etudiant'];

$method_paiement = $_POST['method_paiement'];
$num_carte = $_POST['num_carte'];
$nom_carte = $_POST['nom_carte'];
$date_expiration = $_POST['date_expiration'];
$code_securite = $_POST['code_securite'];

// Simuler la validation du paiement
$montant = 100.00; // Exemple de montant fixe pour la simulation

// Insérer les informations de paiement dans la base de données
$query = "INSERT INTO paiement (id_client, montant, method_paiement) VALUES (?, ?, ?)";
$stmt = $conn->prepare($query);
$stmt->bind_param('ids', $id_client, $montant, $method_paiement);

if ($stmt->execute()) {
    // Insérer un message de confirmation dans la messagerie
    $sujet = "Confirmation de Paiement";
    $message = "Votre paiement de $montant € a été validé.\n";
    $message .= "Détails de paiement :\n";
    $message .= "Nom : $nom_client $prenom_client\n";
    $message .= "Adresse : $adresse1 $adresse2, $ville, $code_postal, $pays\n";
    $message .= "Téléphone : $num_telephone\n";
    $message .= "Carte Etudiant : $num_etudiant\n";
    $message .= "Type de carte : $method_paiement\n";
    $message .= "Numéro de la carte : $num_carte\n";
    $message .= "Nom sur la carte : $nom_carte\n";
    $message .= "Date d'expiration : $date_expiration\n";
    $message .= "Code de sécurité : $code_securite\n";
    $date_envoi = date('Y-m-d H:i:s');

    $insert_message = "INSERT INTO messagerie (id_expediteur, id_destinataire, sujet, message, date_envoi) VALUES (?, ?, ?, ?, ?)";
    $stmt_message = $conn->prepare($insert_message);
    $stmt_message->bind_param('iisss', $id_client, $id_client, $sujet, $message, $date_envoi);

    if ($stmt_message->execute()) {
        echo "Paiement validé. Un message de confirmation a été envoyé dans votre messagerie interne.";
    } else {
        echo "Erreur lors de l'envoi du message de confirmation.";
    }
} else {
    echo "Erreur lors de l'enregistrement du paiement.";
}
?>

if ($stmt->execute()) {
    // Insérer un message de confirmation dans la messagerie
    $sujet = "Confirmation de Paiement";
    $message = "Votre paiement de $montant € a été validé.\n";
    $message .= "Détails de paiement :\n";
    $message .= "Nom : $nom_client $prenom_client\n";
    $message .= "Adresse : $adresse1 $adresse2, $ville, $code_postal, $pays\n";
    $message .= "Téléphone : $num_telephone\n";
    $message .= "Carte Etudiant : $num_etudiant\n";
    $message .= "Type de carte : $method_paiement\n";
    $message .= "Numéro de la carte : $num_carte\n";
    $message .= "Nom sur la carte : $nom_carte\n";
    $message .= "Date d'expiration : $date_expiration\n";
    $message .= "Code de sécurité : $code_securite\n";
    $date_envoi = date('Y-m-d H:i:s');
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
