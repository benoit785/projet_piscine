<?php
// login.php
include 'config.php';
session_start(); 

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $prenom_admin = $_POST['prenom_admin'];
    $nom_admin = $_POST['nom_admin'];
    $email_admin = $_POST['email_admin'];
    $mdp_admin = $_POST['mdp_admin'];

    $sql = "SELECT * FROM admin WHERE email_admin ='$email_admin'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
         if (password_verify($mdp_admin, $row['mdp_admin'])) {
            $_SESSION['id_admin'] = $row['id_admin'];
            $_SESSION['nom_admin'] = $row['nom_admin'];
            $_SESSION['prenom_admin'] = $row['prenom_admin'];
            $_SESSION['message'] = "Connexion réussie. Bienvenue " . $row['prenom_admin'] . " " . $row['nom_admin'];
        } else {
            $_SESSION['message'] = "Mot de passe incorrect.";
        }
    } else {
        $_SESSION['message'] = "Aucun compte trouvé avec cet email.";
    }
        if (password_verify($mdp_admin, $row['mdp_admin'])) {
            echo "Connexion réussie. Bienvenue " . $row['prenom_admin'] . " " . $row['nom_admin'];
        } else {
            echo "Mot de passe incorrect.";
        }
    } else {
        echo "Aucun compte trouvé avec cet email.";
    }

    $conn->close();

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Redirection après 0.5 secondes</title>
    <script>
        // Fonction pour rediriger vers une nouvelle page après un délai de 0.5 secondes
        function redirect() {
            setTimeout(function() {
                window.location.href = 'Acceuil_Stan.php'; // Remplacez 'newpage.html' par l'URL de votre nouvelle page
            }, 10); // 500 millisecondes = 0.5 secondes
        }
    </script>
</head>
<body onload="redirect()">
    <h1>Vous serez redirigé vers une nouvelle page dans 0.5 secondes...</h1>
</body>
</html>


