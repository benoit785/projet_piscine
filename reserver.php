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

    // Convertir le jour en date réelle (ex: 'mon' -> '2024-06-01')
    $day_map = [
        'mon' => '2024-06-01',
        'tue' => '2024-06-02',
        'wed' => '2024-06-03',
        'thu' => '2024-06-04',
        'fri' => '2024-06-05',
        'sat' => '2024-06-06',
        'sun' => '2024-06-07',
    ];
    $date_rdv = $day_map[$day] . " $time:00";

    // Vérifier si le créneau est déjà réservé
    $check_sql = "SELECT * FROM prise_de_rendez_vous WHERE date_rdv = ? AND id_coach = ?";
    $check_stmt = $conn->prepare($check_sql);
    $check_stmt->bind_param("si", $date_rdv, $coachId);
    $check_stmt->execute();
    $result = $check_stmt->get_result();

    if ($result->num_rows > 0) {
        echo "Ce créneau est déjà réservé.";
    } else {
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
    }

    $check_stmt->close();
    $conn->close();
} else {
    echo "Méthode de requête non supportée";
}
?>
