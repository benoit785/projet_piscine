<?php
// login.php
session_start();
include 'config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $mdp = $_POST['mdp'];

    $sql = "SELECT * FROM client WHERE email_client='$email'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        if (password_verify($mdp, $row['mdp_client'])) {
            $_SESSION['message'] = "Connexion réussie. Bienvenue " . $row['prenom_client'] . " " . $row['nom_client'];
        } else {
            $_SESSION['message'] = "Mot de passe incorrect.";
        }
    } else {
        $_SESSION['message'] = "Aucun compte trouvé avec cet email.";
    }

    $conn->close();
    header("Location: index.php");
    exit();
}
?>
