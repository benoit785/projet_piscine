document.addEventListener('DOMContentLoaded', function () {
    const availableSlots = document.querySelectorAll('.available');

    availableSlots.forEach(slot => {
        slot.addEventListener('click', function () {
            if (confirm('Voulez-vous réserver ce créneau ?')) {
                const slotId = this.id;
                const coachId = 1; // Remplacez par l'ID du coach réel
                const clientId = 1; // Remplacez par l'ID du client réel
                const salleId = 1; // Remplacez par l'ID de la salle réelle
                reserveSlot(slotId, coachId, clientId, salleId);
            }
        });
    });

    function reserveSlot(slotId, coachId, clientId, salleId) {
        const date = slotId.split('-');
        const day = date[0];
        const time = date[1].replace('_', ':');

        console.log(`Réservation du créneau : ${slotId}, Coach: ${coachId}, Client: ${clientId}, Salle: ${salleId}`);

        fetch('/piscine/reserve_slot.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({
                slotId: slotId,
                coachId: coachId,
                clientId: clientId,
                salleId: salleId,
                day: day,
                time: time
            })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                alert('Créneau réservé avec succès');
                document.getElementById(slotId).classList.remove('available');
                document.getElementById(slotId).classList.add('booked');
            } else {
                console.error('Erreur lors de la réservation :', data.error);
                alert('Erreur lors de la réservation : ' + data.error);
            }
        })
        .catch(error => {
            console.error('Erreur de réseau ou autre :', error);
            alert('Erreur de réseau ou autre : ' + error);
        });
    }
});
