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

$current_user_id = $_SESSION['id_client'];
$current_user_profession = '';

// Vérifier si la profession est définie dans la session
if (isset($_SESSION['profession'])) {
    $current_user_profession = $_SESSION['profession'];
} else {
    // Récupérer les informations de l'utilisateur connecté depuis la base de données
    $user_sql = "SELECT profession FROM client WHERE id_client = $current_user_id";
    $user_result = $conn->query($user_sql);
    if ($user_result->num_rows > 0) {
        $current_user_profession = $user_result->fetch_assoc()['profession'];
        $_SESSION['profession'] = $current_user_profession;
    } else {
        die("Utilisateur non trouvé.");
    }
}

// Charger les informations du CV depuis la base de données
$cv_sql = "SELECT * FROM cv WHERE id_coach = $current_user_id";
$cv_result = $conn->query($cv_sql);
$cv_data = $cv_result->num_rows > 0 ? $cv_result->fetch_assoc() : ['competences' => '', 'experience_file' => "experience_$current_user_id.xml", 'formation_file' => "formation_$current_user_id.xml", 'telephone' => '', 'adresse' => ''];

// Charger les fichiers XML pour l'expérience et la formation
$experience_xml_file = $cv_data['experience_file'];
$formation_xml_file = $cv_data['formation_file'];
$experience_xml = file_exists($experience_xml_file) ? simplexml_load_file($experience_xml_file) : new SimpleXMLElement('<experience></experience>');
$formation_xml = file_exists($formation_xml_file) ? simplexml_load_file($formation_xml_file) : new SimpleXMLElement('<formation></formation>');

// Mettre à jour les informations du CV et les fichiers XML
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['competences'], $_POST['experience'], $_POST['formation'], $_POST['telephone'], $_POST['adresse'])) {
    $competences = $conn->real_escape_string($_POST['competences']);
    $experience = $_POST['experience'];
    $formation = $_POST['formation'];
    $telephone = $conn->real_escape_string($_POST['telephone']);
    $adresse = $conn->real_escape_string($_POST['adresse']);

    // Mettre à jour ou insérer les informations du CV
    if ($cv_result->num_rows > 0) {
        $update_sql = "UPDATE cv SET competences = '$competences', telephone = '$telephone', adresse = '$adresse' WHERE id_coach = $current_user_id";
        $conn->query($update_sql);
    } else {
        $insert_sql = "INSERT INTO cv (id_coach, competences, experience_file, formation_file, telephone, adresse) VALUES ($current_user_id, '$competences', '$experience_xml_file', '$formation_xml_file', '$telephone', '$adresse')";
        $conn->query($insert_sql);
    }

    // Mettre à jour les fichiers XML
    $experience_xml->experience = $experience;
    $formation_xml->formation = $formation;

    $experience_xml->asXML($experience_xml_file);
    $formation_xml->asXML($formation_xml_file);

    $success_message = "CV mis à jour avec succès.";
}

// Récupérer la liste des coachs
$coachs_sql = "SELECT id_client, nom_client, prenom_client FROM client WHERE profession = 'Personnel de sport'";
$coachs_result = $conn->query($coachs_sql);

// Récupérer les informations du coach sélectionné
$coach_info = null;
if (isset($_GET['coach_id'])) {
    $coach_id = $_GET['coach_id'];
    $coach_sql = "SELECT c.*, cv.competences, cv.experience_file, cv.formation_file, cv.telephone, cv.adresse FROM client c LEFT JOIN cv ON c.id_client = cv.id_coach WHERE c.id_client = $coach_id";
    $coach_result = $conn->query($coach_sql);
    if ($coach_result->num_rows > 0) {
        $coach_info = $coach_result->fetch_assoc();

        // Charger les fichiers XML pour l'expérience et la formation du coach sélectionné
        $selected_experience_xml_file = $coach_info['experience_file'];
        $selected_formation_xml_file = $coach_info['formation_file'];
        $selected_experience_xml = file_exists($selected_experience_xml_file) ? simplexml_load_file($selected_experience_xml_file) : new SimpleXMLElement('<experience></experience>');
        $selected_formation_xml = file_exists($selected_formation_xml_file) ? simplexml_load_file($selected_formation_xml_file) : new SimpleXMLElement('<formation></formation>');
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CV Coach</title>
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
        .coach-list {
            width: 100%;
            margin-bottom: 20px;
        }
        .coach-list select {
            width: 100%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }
        .coach-info {
            width: 100%;
        }
        .coach-info h2 {
            margin-top: 0;
        }
        .coach-info p {
            margin: 5px 0;
        }
        .form-group {
            width: 100%;
            margin-bottom: 20px;
        }
        .form-group label {
            display: block;
            margin-bottom: 5px;
        }
        .form-group textarea,
        .form-group input {
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
        <h1>Choisissez un coach</h1>
        <div class="coach-list">
            <form method="GET" action="cv.php">
                <select name="coach_id" onchange="this.form.submit()">
                    <option value="" disabled selected>Sélectionnez un coach</option>
                    <?php while($coach = $coachs_result->fetch_assoc()): ?>
                        <option value="<?= $coach['id_client'] ?>" <?= isset($coach_id) && $coach_id == $coach['id_client'] ? 'selected' : '' ?>>
                            <?= htmlspecialchars($coach['prenom_client']) . ' ' . htmlspecialchars($coach['nom_client']) ?>
                        </option>
                    <?php endwhile; ?>
                </select>
            </form>
        </div>

        <?php if ($coach_info): ?>
            <div class="coach-info">
                <h2><?= htmlspecialchars($coach_info['prenom_client']) . ' ' . htmlspecialchars($coach_info['nom_client']) ?></h2>
                <p><strong>Email : </strong><?= htmlspecialchars($coach_info['email_client']) ?></p>
                <p><strong>Téléphone : </strong><?= htmlspecialchars($coach_info['telephone']) ?></p>
                <p><strong>Adresse : </strong><?= htmlspecialchars($coach_info['adresse']) ?></p>
                <p><strong>Compétences : </strong><?= htmlspecialchars($coach_info['competences']) ?></p>
                <p><strong>Expérience : </strong><?= htmlspecialchars($selected_experience_xml->experience) ?></p>
                <p><strong>Formation : </strong><?= htmlspecialchars($selected_formation_xml->formation) ?></p>
            </div>
        <?php endif; ?>

        <?php if ($current_user_profession == 'Personnel de sport'): ?>
            <div class="coach-info">
                <h2>Modifier votre CV</h2>
                <?php if (isset($success_message)): ?>
                    <p class="success-message"><?= $success_message ?></p>
                <?php endif; ?>
                <form method="POST" action="cv.php">
                    <div class="form-group">
                        <label for="competences">Compétences</label>
                        <textarea name="competences" id="competences" rows="5" required><?= htmlspecialchars($cv_data['competences']) ?></textarea>
                    </div>
                    <div class="form-group">
                        <label for="experience">Expérience</label>
                        <textarea name="experience" id="experience" rows="5" required><?= htmlspecialchars($experience_xml->experience) ?></textarea>
                    </div>
                    <div class="form-group">
                        <label for="formation">Formation</label>
                        <textarea name="formation" id="formation" rows="5" required><?= htmlspecialchars($formation_xml->formation) ?></textarea>
                    </div>
                    <div class="form-group">
                        <label for="telephone">Téléphone</label>
                        <input type="text" name="telephone" id="telephone" value="<?= htmlspecialchars($cv_data['telephone']) ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="adresse">Adresse</label>
                        <input type="text" name="adresse" id="adresse" value="<?= htmlspecialchars($cv_data['adresse']) ?>" required>
                    </div>
                    <div class="form-group">
                        <button type="submit">Mettre à jour</button>
                    </div>
                </form>
            </div>
        <?php endif; ?>
    </div>
</body>
</html>
