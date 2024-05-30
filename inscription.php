<?php
// register.php
include 'config.php';
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $profession = $_POST['profession'];
    $nom = $_POST['nom'];
    $prenom = $_POST['prenom'];
    $email = $_POST['email'];
    $mdp = password_hash($_POST['mdp'], PASSWORD_BCRYPT);
    $photo_client = $_POST['photo_client'];

    // Décodez l'image
    $photo_client = str_replace('data:image/png;base64,', '', $photo_client);
    $photo_client = str_replace(' ', '+', $photo_client);
    $data = base64_decode($photo_client);

    // Nom du fichier où l'image sera sauvegardée
    $file = '' . uniqid() . '.png';
    file_put_contents($file, $data);
    $photo_client = $file;

    $sql = "INSERT INTO client (profession, nom_client, prenom_client, email_client, mdp_client, photo_client) VALUES ('$profession', '$nom', '$prenom', '$email', '$mdp', '$photo_client')";

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
            }, 100); // 500 millisecondes = 0.5 secondes
        }
    </script>
</head>
<body onload="redirect()">
    <h1>Vous serez redirigé vers une nouvelle page dans 0.5 secondes...</h1>
</body>
</html>

