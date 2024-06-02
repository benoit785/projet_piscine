<?php
session_start();
if (!isset($_SESSION['id_client']) || $_SESSION['profession'] !== 'Personnel de sport') {
    header('Location: cv.php');
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
$xml_file = "cv_$current_user_id.xml";

// Charger le fichier XML
$xml = new SimpleXMLElement(file_exists($xml_file) ? file_get_contents($xml_file) : '<cv></cv>');

// Mettre à jour le fichier XML
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['competences'], $_POST['experience'], $_POST['formation'])) {
    $xml->competences = $_POST['competences'];
    $xml->experience = $_POST['experience'];
    $xml->formation = $_POST['formation'];
    $xml->asXML($xml_file);
    $success_message = "CV mis à jour avec succès.";
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modifier CV</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            display: flex;
            flex-direction: column;
            align-items: center;
            margin: 0;
            padding: 20px;
            background-color: #f7f7f7;
        }
        .container {
            width: 80%;
            max-width: 800px;
            background-color: #fff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            margin-top: 20px;
        }
        .form-group {
            width: 100%;
            margin-bottom: 20px;
        }
        .form-group label {
            display: block;
            margin-bottom: 5px;
        }
        .form-group textarea {
            width: 100%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
            resize: vertical;
        }
        .form-group button {
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            background-color: #007bff;
            color: white;
            cursor: pointer;
            transition: background-color 0.3s;
        }
        .form-group button:hover {
            background-color: #0056b3;
        }
        .success-message {
            color: green;
            margin-bottom: 20px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Modifier CV</h1>
        <?php if (isset($success_message)): ?>
            <p class="success-message"><?= $success_message ?></p>
        <?php endif; ?>
        <form method="POST" action="changementcv.php">
            <div class="form-group">
                <label for="competences">Compétences</label>
                <textarea name="competences" id="competences" rows="5" required><?= htmlspecialchars($xml->competences) ?></textarea>
            </div>
            <div class="form-group">
                <label for="experience">Expérience</label>
                <textarea name="experience" id="experience" rows="5" required><?= htmlspecialchars($xml->experience) ?></textarea>
            </div>
            <div class="form-group">
                <label for="formation">Formation</label>
                <textarea name="formation" id="formation" rows="5" required><?= htmlspecialchars($xml->formation) ?></textarea>
            </div>
            <div class="form-group">
                <button type="submit">Mettre à jour</button>
            </div>
        </form>
    </div>
</body>
</html>
