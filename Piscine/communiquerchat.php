<?php
session_start();
if (!isset($_SESSION['id_client'])) {
    header('Location: compte2.php');
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

// Récupérer les informations de l'utilisateur connecté
$current_user_id = $_SESSION['id_client'];
$current_user_profession = '';

$user_sql = "SELECT profession FROM client WHERE id_client = $current_user_id";
$user_result = $conn->query($user_sql);
if ($user_result->num_rows > 0) {
    $current_user_profession = $user_result->fetch_assoc()['profession'];
} else {
    die("Utilisateur non trouvé.");
}

// Déterminer le type d'utilisateur à afficher
$target_profession = '';
if (strcasecmp($current_user_profession, 'client') == 0) {
    $target_profession = 'Personnel de sport';
} elseif (strcasecmp($current_user_profession, 'Personnel de sport') == 0) {
    $target_profession = 'client';
} elseif (strcasecmp($current_user_profession, 'administrateur') == 0) {
    $target_profession = '%';
} else {
    die("Profession non reconnue : " . htmlspecialchars($current_user_profession));
}

// Récupérer la liste des utilisateurs à afficher
if ($target_profession == '%') {
    $clients_sql = "SELECT id_client, nom_client, prenom_client FROM client";
} else {
    $clients_sql = "SELECT id_client, nom_client, prenom_client FROM client WHERE profession = '$target_profession'";
}

$clients_result = $conn->query($clients_sql);

$messages = [];
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['message']) && isset($_POST['receiver_id'])) {
    $sender_id = $_SESSION['id_client'];
    $receiver_id = $_POST['receiver_id'];
    $message_text = $conn->real_escape_string($_POST['message']);
    $insert_sql = "INSERT INTO messages (id_client, id_coach, message_text) VALUES ($sender_id, $receiver_id, '$message_text')";
    $conn->query($insert_sql);
}

if (isset($_GET['client_id'])) {
    $client_id = $_GET['client_id'];
    $sender_id = $_SESSION['id_client'];
    $messages_sql = "SELECT * FROM messages WHERE (id_client = $sender_id AND id_coach = $client_id) OR (id_client = $client_id AND id_coach = $sender_id) ORDER BY date_message";
    $messages_result = $conn->query($messages_sql);

    if ($messages_result->num_rows > 0) {
        while($row = $messages_result->fetch_assoc()) {
            $messages[] = $row;
        }
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chatroom</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            display: flex;
            height: 100vh;
            margin: 0;
            overflow: hidden;
        }
        .client-list {
            width: 30%;
            background-color: #f7f7f7;
            border-right: 2px solid #ccc;
            overflow-y: auto;
            padding: 20px;
        }
        .client-item {
            cursor: pointer;
            padding: 15px;
            margin-bottom: 10px;
            background-color: #fff;
            border: 1px solid #ddd;
            border-radius: 5px;
            transition: background-color 0.3s;
        }
        .client-item:hover {
            background-color: #e9ecef;
        }
        .chat-container {
            width: 70%;
            display: flex;
            flex-direction: column;
            background-color: #fff;
        }
        .chat-box {
            flex-grow: 1;
            padding: 20px;
            border-bottom: 2px solid #ccc;
            overflow-y: auto;
        }
        .message {
            padding: 10px;
            margin-bottom: 10px;
            border-radius: 5px;
        }
        .message.you {
            background-color: #dcf8c6;
            align-self: flex-end;
        }
        .message.them {
            background-color: #f1f0f0;
            align-self: flex-start;
        }
        .message-form {
            display: flex;
            padding: 20px;
            background-color: #f7f7f7;
            border-top: 2px solid #ccc;
        }
        .message-form input {
            flex-grow: 1;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
            margin-right: 10px;
        }
        .message-form button {
            padding: 10px 20px;
            border: none;
            background-color: #007bff;
            color: white;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s;
        }
        .message-form button:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>
    <div class="client-list">
        <?php while($client = $clients_result->fetch_assoc()): ?>
            <div class="client-item" onclick="window.location.href='communiquerchat.php?client_id=<?= $client['id_client'] ?>'">
                <?= htmlspecialchars($client['nom_client']) . ' ' . htmlspecialchars($client['prenom_client']) ?>
            </div>
        <?php endwhile; ?>
    </div>
    <div class="chat-container">
        <div class="chat-box">
            <?php if (isset($_GET['client_id'])): ?>
                <?php foreach ($messages as $message): ?>
                    <div class="message <?= $message['id_client'] == $_SESSION['id_client'] ? 'you' : 'them' ?>">
                        <p><strong><?= $message['id_client'] == $_SESSION['id_client'] ? 'Vous' : 'Lui' ?>:</strong> <?= htmlspecialchars($message['message_text']) ?></p>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <p>Sélectionnez un client pour commencer à discuter.</p>
            <?php endif; ?>
        </div>
        <?php if (isset($_GET['client_id'])): ?>
            <form class="message-form" method="POST" action="communiquerchat.php?client_id=<?= $_GET['client_id'] ?>">
                <input type="hidden" name="receiver_id" value="<?= $_GET['client_id'] ?>">
                <input type="text" name="message" placeholder="Entrez votre message" required>
                <button type="submit">Envoyer</button>
            </form>
        <?php endif; ?>
    </div>
</body>
</html>
