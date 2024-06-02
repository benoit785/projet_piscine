<?php
session_start();

// Connexion à la base de données
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "sportifydb";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connexion échouée: " . $conn->connect_error);
}

// Récupérer les salles depuis la base de données
$salles_sql = "SELECT id_salle, nom_salle, adresse_salle, capacite FROM salle";
$salles_result = $conn->query($salles_sql);
$salles = [];
while ($row = $salles_result->fetch_assoc()) {
    $salles[$row['id_salle']] = $row;
}

$salle_id = isset($_GET['salle_id']) ? (int)$_GET['salle_id'] : null;

// Récupérer les services depuis la base de données
$services_sql = "SELECT id_service, nom_service FROM service";
$services_result = $conn->query($services_sql);
$services = [];
while ($row = $services_result->fetch_assoc()) {
    $services[$row['id_service']] = $row['nom_service'];
}

$service_id = isset($_GET['service_id']) ? (int)$_GET['service_id'] : null;
$service_details = "";

if ($service_id) {
    $details_sql = "SELECT description FROM service WHERE id_service = $service_id";
    $details_result = $conn->query($details_sql);
    if ($details_result->num_rows > 0) {
        $service_details = $details_result->fetch_assoc()['description'];
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['service_id'], $_POST['rdv_date'], $_POST['rdv_time'])) {
    // Traitement de la prise de rendez-vous (stockage dans une base de données, envoi d'email, etc.)
    $rdv_service_id = (int)$_POST['service_id'];
    $rdv_date = $_POST['rdv_date'];
    $rdv_time = $_POST['rdv_time'];
    $client_id = $_SESSION['id_client'];

    // Insérer le rendez-vous dans la base de données
    $insert_rdv_sql = "INSERT INTO prise_de_rendez_vous (id_client, id_service, id_salle, date_rdv, type_communication, statut_rdv) 
                       VALUES ($client_id, $rdv_service_id, $salle_id, '$rdv_date $rdv_time:00', 'In-person', 1)";
    if ($conn->query($insert_rdv_sql) === TRUE) {
        $rdv_message = "Rendez-vous pris pour le service " . $services[$rdv_service_id] . " le " . $rdv_date . " à " . $rdv_time . ".";
    } else {
        $rdv_message = "Erreur lors de la prise de rendez-vous : " . $conn->error;
    }
}

$conn->close();
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Salle des sports Omnes</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f7f7f7;
        }
        .container {
            width: 80%;
            max-width: 1000px;
            margin: 0 auto;
            padding: 20px;
            background-color: #fff;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        h1, h2, h3 {
            color: #007bff;
        }
        .coordonnees, .services, .service-details, .rdv-form, .salles {
            margin-bottom: 20px;
        }
        .salle-item, .service-item {
            cursor: pointer;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 5px;
            margin-bottom: 10px;
            transition: background-color 0.3s;
        }
        .salle-item:hover, .service-item:hover {
            background-color: #e9ecef;
        }
        .rdv-form select, .rdv-form input, .rdv-form button {
            padding: 10px;
            margin: 5px 0;
            width: 100%;
            max-width: 300px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Salle des sports Omnes</h1>

        <div class="salles">
            <h2>Choisissez une Salle</h2>
            <?php foreach ($salles as $id => $salle): ?>
                <div class="salle-item" onclick="window.location.href='salle_sport_omnes.php?salle_id=<?= $id ?>'">
                    <?= htmlspecialchars($salle['nom_salle']) ?>
                </div>
            <?php endforeach; ?>
        </div>

        <?php if ($salle_id && isset($salles[$salle_id])): ?>
            <div class="coordonnees">
                <h2>Coordonnées de la Salle: <?= htmlspecialchars($salles[$salle_id]['nom_salle']) ?></h2>
                <p><strong>Adresse :</strong> <?= htmlspecialchars($salles[$salle_id]['adresse_salle']) ?></p>
                <p><strong>Capacité :</strong> <?= htmlspecialchars($salles[$salle_id]['capacite']) ?></p>
            </div>

            <div class="services">
                <h2>Nos Services</h2>
                <?php foreach ($services as $id => $service): ?>
                    <div class="service-item" onclick="window.location.href='salle_sport_omnes.php?salle_id=<?= $salle_id ?>&service_id=<?= $id ?>'">
                        <?= htmlspecialchars($service) ?>
                    </div>
                <?php endforeach; ?>
            </div>

            <?php if ($service_id && isset($services[$service_id])): ?>
                <div class="service-details">
                    <h2>Détails du Service: <?= htmlspecialchars($services[$service_id]) ?></h2>
                    <p><?= htmlspecialchars($service_details) ?></p>
                </div>

                <div class="rdv-form">
                    <h3>Prendre un Rendez-vous</h3>
                    <?php if (isset($rdv_message)): ?>
                        <p style="color: green;"><?= htmlspecialchars($rdv_message) ?></p>
                    <?php endif; ?>
                    <form method="POST" action="salle_sport_omnes.php?salle_id=<?= $salle_id ?>&service_id=<?= $service_id ?>">
                        <input type="hidden" name="service_id" value="<?= $service_id ?>">
                        <label for="rdv_date">Date:</label>
                        <input type="date" name="rdv_date" id="rdv_date" required>
                        <label for="rdv_time">Heure:</label>
                        <select name="rdv_time" id="rdv_time" required>
                            <option value="08:00">08:00</option>
                            <option value="10:00">10:00</option>
                            <option value="12:00">12:00</option>
                            <option value="14:00">14:00</option>
                            <option value="16:00">16:00</option>
                        </select>
                        <button type="submit">Prendre Rendez-vous</button>
                    </form>
                </div>
            <?php endif; ?>
        <?php endif; ?>
    </div>
</body>
</html>