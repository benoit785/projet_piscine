<?php
// register.php
session_start();
include 'config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nom = $_POST['nom'];
    $prenom = $_POST['prenom'];
    $email = $_POST['email'];
    $mdp = password_hash($_POST['mdp'], PASSWORD_BCRYPT);

    $sql = "INSERT INTO client (nom_client, prenom_client, email_client, mdp_client) VALUES ('$nom', '$prenom', '$email', '$mdp')";

    if ($conn->query($sql) === TRUE) {
        $_SESSION['message'] = "Nouvel utilisateur créé avec succès.";
    } else {
        $_SESSION['message'] = "Erreur : " . $sql . "<br>" . $conn->error;
    }

    $conn->close();
    header("Location: index.php");
    exit();
}
?>
