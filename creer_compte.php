<?php
// Démarrer une session
session_start();

// Détails de la connexion à la base de données
$user_name = "root";
$password = "";
$database = "sportify"; // Utilisez le nom correct de votre base de données
$server = "127.0.0.1";
$port = 3306;

// Connexion à la base de données
$conn = mysqli_connect($server, $user_name, $password, $database, $port);

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Vérifier si le formulaire a été soumis
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $accountType = $_POST['accountType'];
    $name = $_POST['name'];
    $lastname = $_POST['lastname'];
    $username = $_POST['username'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT); // Hacher le mot de passe

    if ($accountType == "Client") {
        $sql = "INSERT INTO client (prenom_client, nom_client, mdp_client, email_client) VALUES (?, ?, ?, ?)";
    } elseif ($accountType == "Personnel de sport") {
        $sql = "INSERT INTO coach (prenom_coach, nom_coach, mdp_coach, email_coach) VALUES (?, ?, ?, ?)";
    } elseif ($accountType == "Administrateur") {
        $sql = "INSERT INTO admin (prenom_admin, nom_admin, mdp_admin, email_admin) VALUES (?, ?, ?, ?)";
    } else {
        echo "Type de compte invalide.";
        exit();
    }

    $stmt = mysqli_prepare($conn, $sql);
    if ($stmt) {
        mysqli_stmt_bind_param($stmt, "ssss", $name, $lastname, $password, $username);
        if (mysqli_stmt_execute($stmt)) {
            echo "Compte créé avec succès !";
            header("Location: Connexion.html");
        } else {
            echo "Erreur lors de la création du compte: " . mysqli_stmt_error($stmt);
        }
        mysqli_stmt_close($stmt);
    } else {
        echo "Erreur de préparation de la requête: " . mysqli_error($conn);
    }
}

// Fermer la connexion à la base de données
mysqli_close($conn);
?>
