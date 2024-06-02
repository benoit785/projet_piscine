<?php
session_start();
if (!isset($_SESSION['id_client'])) {
    header('Location: compte2.php');
    exit();
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Communiquer</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            height: 100vh;
            margin: 0;
            background-color: #f7f7f7;
        }
        .button-container {
            display: flex;
            flex-direction: column;
            align-items: center;
        }
        .button-container button {
            padding: 15px 30px;
            margin: 10px;
            border: none;
            border-radius: 5px;
            background-color: #007bff;
            color: white;
            font-size: 16px;
            cursor: pointer;
            transition: background-color 0.3s;
        }
        .button-container button:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>
    <div class="button-container">
        <button onclick="window.location.href='Coach_Profil_activites.html'">Retour en arrière</button>
        <button onclick="window.location.href='communiquerchat.php'">Chatroom</button>
        <button onclick="window.location.href='communicationmail.php'">Communication par mail</button>
    </div>
</body>
</html>
