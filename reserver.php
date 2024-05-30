<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "sportifydb";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $slotId = $_POST['slot'];
    $coachId = $_POST['coachId'];
    $clientId = $_POST['clientId'];
    $salleId = $_POST['salleId'];

    $date_parts = explode('-', $slotId);
    $day = $date_parts[0];
    $time = str_replace('_', ':', $date_parts[1]);

    $date_rdv = date("Y-m-d") . " $time:00"; // Vous pouvez changer pour la date réelle appropriée

    $sql = "INSERT INTO prise_de_rendez_vous (id_client, id_coach, id_salle, date_rdv, type_communication, statut_rdv) 
            VALUES (?, ?, ?, ?, 'In-person', 1)";

    $stmt = $conn->prepare($sql);
    if ($stmt === false) {
        die("Erreur de préparation: " . $conn->error);
    }

    $stmt->bind_param("iiis", $clientId, $coachId, $salleId, $date_rdv);

    if ($stmt->execute()) {
        echo "Créneau réservé avec succès";
    } else {
        echo "Erreur lors de la réservation: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();
} else {
    echo "Méthode de requête non supportée";
}
?>
