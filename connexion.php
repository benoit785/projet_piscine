<?php
// login.php
include 'config.php';
session_start(); 

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $mdp = $_POST['mdp'];
    $photo_client = $_POST['photo_client'];

    $sql = "SELECT * FROM client WHERE email_client='$email'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
         if (password_verify($mdp, $row['mdp_client'])) {
            $_SESSION['id_client'] = $row['id_client'];
            $_SESSION['nom_client'] = $row['nom_client'];
            $_SESSION['prenom_client'] = $row['prenom_client'];
            $_SESSION['photo_client'] = $row['photo_client'];
            $_SESSION['message'] = "Connexion réussie. Bienvenue " . $row['prenom_client'] . " " . $row['nom_client'];
        } else {
            $_SESSION['message'] = "Mot de passe incorrect.";
        }
    } else {
        $_SESSION['message'] = "Aucun compte trouvé avec cet email.";
    }
        if (password_verify($mdp, $row['mdp_client'])) {
            echo "Connexion réussie. Bienvenue " . $row['prenom_client'] . " " . $row['nom_client'];
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
            }, 500); // 500 millisecondes = 0.5 secondes
        }
    </script>
</head>
<body onload="redirect()">
    <h1>Vous serez redirigé vers une nouvelle page dans 0.5 secondes...</h1>
</body>
</html>


