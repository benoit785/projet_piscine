<?php
session_start();
if (!isset($_SESSION['id_client'])) {
    header('Location: login.php');
    exit();
}

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "sportifydb";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connexion échouée: " . $conn->connect_error);
}

$current_user_id = $_SESSION['id_client'];

// Envoyer un message
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['destinataire'], $_POST['sujet'], $_POST['message'])) {
    $id_expediteur = $current_user_id;
    $id_destinataire = $_POST['destinataire'];
    $sujet = $conn->real_escape_string($_POST['sujet']);
    $message = $conn->real_escape_string($_POST['message']);
    
    $insert_sql = "INSERT INTO messagerie (id_expediteur, id_destinataire, sujet, message) VALUES ($id_expediteur, $id_destinataire, '$sujet', '$message')";
    $conn->query($insert_sql);
}

// Récupérer les messages de la boîte de réception
$reception_sql = "SELECT m.*, c.nom_client, c.prenom_client FROM messagerie m JOIN client c ON m.id_expediteur = c.id_client WHERE m.id_destinataire = $current_user_id ORDER BY m.date_envoi DESC";
$reception_result = $conn->query($reception_sql);

// Récupérer les messages envoyés
$envoyes_sql = "SELECT m.*, c.nom_client, c.prenom_client FROM messagerie m JOIN client c ON m.id_destinataire = c.id_client WHERE m.id_expediteur = $current_user_id ORDER BY m.date_envoi DESC";
$envoyes_result = $conn->query($envoyes_sql);

// Récupérer la liste des destinataires possibles
$destinataires_sql = "SELECT id_client, nom_client, prenom_client FROM client WHERE id_client != $current_user_id";
$destinataires_result = $conn->query($destinataires_sql);

$conn->close();
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Messagerie interne</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            display: flex;
            flex-direction: column;
            align-items: center;
            margin: 0;
            padding: 0;
            background-color: #f7f7f7;
        }
        .container {
            width: 80%;
            margin-top: 20px;
        }
        .button-container {
            display: flex;
            justify-content: space-around;
            margin-bottom: 20px;
        }
        .button-container button {
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            background-color: #007bff;
            color: white;
            cursor: pointer;
            transition: background-color 0.3s;
        }
        .button-container button:hover {
            background-color: #0056b3;
        }
        .messages {
            display: none;
            margin-top: 20px;
        }
        .messages.active {
            display: block;
        }
        .message {
            background-color: #fff;
            border: 1px solid #ddd;
            border-radius: 5px;
            padding: 10px;
            margin-bottom: 10px;
        }
        .message h3 {
            margin: 0;
            margin-bottom: 5px;
        }
        .message p {
            margin: 0;
        }
        .new-message-form {
            display: none;
            flex-direction: column;
            align-items: center;
            margin-top: 20px;
            width: 100%;
        }
        .new-message-form.active {
            display: flex;
        }
        .new-message-form input, .new-message-form select, .new-message-form textarea {
            width: 100%;
            padding: 10px;
            margin-bottom: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }
        .new-message-form button {
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            background-color: #007bff;
            color: white;
            cursor: pointer;
            transition: background-color 0.3s;
        }
        .new-message-form button:hover {
            background-color: #0056b3;
        }
    </style>
    <script>
        function showSection(section) {
            document.querySelectorAll('.messages, .new-message-form').forEach(el => el.classList.remove('active'));
            document.querySelector(`.${section}`).classList.add('active');
        }
    </script>
</head>
<body>
    <div class="container">
        <div class="button-container">
            <button onclick="showSection('reception')">Boîte de réception</button>
            <button onclick="showSection('envoyes')">Messages envoyés</button>
            <button onclick="showSection('new-message-form')">Écrire un mail</button>
        </div>

        <div class="messages reception active">
            <h2>Boîte de réception</h2>
            <?php while($message = $reception_result->fetch_assoc()): ?>
                <div class="message">
                    <h3><?= htmlspecialchars($message['sujet']) ?></h3>
                    <p><strong>De: </strong><?= htmlspecialchars($message['prenom_client']) . ' ' . htmlspecialchars($message['nom_client']) ?></p>
                    <p><strong>Date: </strong><?= htmlspecialchars($message['date_envoi']) ?></p>
                    <p><?= nl2br(htmlspecialchars($message['message'])) ?></p>
                </div>
            <?php endwhile; ?>
        </div>

        <div class="messages envoyes">
            <h2>Messages envoyés</h2>
            <?php while($message = $envoyes_result->fetch_assoc()): ?>
                <div class="message">
                    <h3><?= htmlspecialchars($message['sujet']) ?></h3>
                    <p><strong>À: </strong><?= htmlspecialchars($message['prenom_client']) . ' ' . htmlspecialchars($message['nom_client']) ?></p>
                    <p><strong>Date: </strong><?= htmlspecialchars($message['date_envoi']) ?></p>
                    <p><?= nl2br(htmlspecialchars($message['message'])) ?></p>
                </div>
            <?php endwhile; ?>
        </div>

        <div class="new-message-form">
            <h2>Écrire un mail</h2>
            <form method="POST" action="communicationmail.php">
                <select name="destinataire" required>
                    <option value="" disabled selected>Choisir un destinataire</option>
                    <?php while($destinataire = $destinataires_result->fetch_assoc()): ?>
                        <option value="<?= $destinataire['id_client'] ?>"><?= htmlspecialchars($destinataire['prenom_client']) . ' ' . htmlspecialchars($destinataire['nom_client']) ?></option>
                    <?php endwhile; ?>
                </select>
                <input type="text" name="sujet" placeholder="Sujet" required>
                <textarea name="message" placeholder="Message" rows="10" required></textarea>
                <button type="submit">Envoyer</button>
            </form>
        </div>
    </div>
</body>
</html>
