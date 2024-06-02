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

$sql = "SELECT date_rdv FROM prise_de_rendez_vous WHERE statut_rdv = 1";
$result = $conn->query($sql);

//$sql = "SELECT date_rdv FROM prise_de_rendez_vous WHERE statut_rdv = 1";
//$result = $conn->query($sql);
$booked_slots = [];

if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $date_time = new DateTime($row['date_rdv']);
        $day = strtolower($date_time->format('D'));
        $time = str_replace(':', '-', $date_time->format('H:i'));
        $slot = $day . '-' . $time;
        $booked_slots[] = $slot;
    }
}

$conn->close();

header('Content-Type: text/plain');
echo implode(',', $booked_slots);
?>
