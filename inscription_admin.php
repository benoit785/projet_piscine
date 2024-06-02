<?php
// register.php
include 'config.php';
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nom_admin = $_POST['nom_admin'];
    $prenom_admin = $_POST['prenom_admin'];
    $email_admin = $_POST['email_admin'];
    $mdp_admin = password_hash($_POST['mdp_admin'], PASSWORD_BCRYPT);
    $photo_admin= $_POST['photo_admin'];

    // Décodez l'image
    $photo_admin = str_replace('data:image/png;base64,', '', $photo_admin);
    $photo_admin = str_replace(' ', '+', $photo_admin);
    $data = base64_decode($photo_admin);

    // Nom du fichier où l'image sera sauvegardée
    $file = '' . uniqid() . '.png';
    file_put_contents($file, $data);
    $photo_admin = $file;

    $sql = "INSERT INTO client (nom_admin, prenom_admin, email_admin, mdp_admin, photo_admin) VALUES ( '$nom_admin', '$prenom_admin', '$email_admin', '$mdp_admin', '$photo_admin')";

    if ($conn->query($sql) === TRUE) {
        echo "Nouvel utilisateur créé avec succès";
    } else {
        echo "Erreur : " . $sql . "<br>" . $conn->error;
    }

    $conn->close();
}


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
                window.location.href = 'connexion2.php'; // Remplacez 'newpage.html' par l'URL de votre nouvelle page
            }, 10); // 500 millisecondes = 0.5 secondes
        }
    </script>
</head>
<body onload="redirect()">
    <h1>Vous serez redirigé vers une nouvelle page dans 0.5 secondes...</h1>
</body>
</html>

