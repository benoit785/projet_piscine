
document.addEventListener("DOMContentLoaded", function() {
    // Fetch booked slots and mark them as booked
    fetch('reservation.php')
        .then(response => response.text())
        .then(data => {
            const slots = data.split(',');
            slots.forEach(slot => {
                const slotElement = document.getElementById(slot);
                if (slotElement) {
                    slotElement.classList.add('booked');
                    slotElement.innerHTML = 'Réservé';
                }
            });
        })
        .catch(error => {
            console.error('Erreur lors de la récupération des créneaux réservés:', error);
        });
});

function reserveSlot(slotId) {
    const coachId = 1; // Remplacez par l'ID du coach réel
    const clientId = 1; // Remplacez par l'ID du client réel
    const salleId = 1; // Remplacez par l'ID de la salle réelle

    const formData = new FormData();
    formData.append('slot', slotId);
    formData.append('coachId', coachId);
    formData.append('clientId', clientId);
    formData.append('salleId', salleId);

    fetch('reserver.php', {
        method: 'POST',
        body: formData
    })
    .then(response => response.text())
    .then(text => {
        if (text.includes("succès")) {
            const slotElement = document.getElementById(slotId);
            slotElement.classList.add('booked');
            slotElement.innerHTML = 'Réservé';
            alert('Réservation réussie!');
        } else if (text.includes("déjà réservé")) {
            alert('Ce créneau est déjà réservé.');
        } else {
            alert(text);
        }
    })
    .catch(error => {
        console.error('Erreur:', error);
        alert('Erreur de réseau ou autre: ' + error);
    });
}
