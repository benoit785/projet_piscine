document.addEventListener('DOMContentLoaded', function () {
    const params = new URLSearchParams(window.location.search);
    const sport = params.get('sport');

    const coaches = {
        musculation: {
            name: 'Guy DUMAIS',
            specialty: 'Coach, Musculation',
            room: 'Salle: G-010',
            phone: '+33 01 23 45 67 89',
            email: 'guy.dumais@omnessports.fr',
            schedule: {
                mon_8_10: 'available',
                tue_8_10: 'unavailable',
                wed_8_10: 'available',
                thu_8_10: 'unavailable',
                fri_8_10: 'available',
                sat_8_10: 'unavailable',
                sun_8_10: 'unavailable',
                mon_10_12: 'unavailable',
                tue_10_12: 'available',
                wed_10_12: 'available',
                thu_10_12: 'available',
                fri_10_12: 'available',
                sat_10_12: 'available',
                sun_10_12: 'unavailable',
                mon_12_14: 'unavailable',
                tue_12_14: 'unavailable',
                wed_12_14: 'unavailable',
                thu_12_14: 'unavailable',
                fri_12_14: 'available',
                sat_12_14: 'unavailable',
                sun_12_14: 'unavailable',
                mon_14_16: 'available',
                tue_14_16: 'available',
                wed_14_16: 'available',
                thu_14_16: 'available',
                fri_14_16: 'available',
                sat_14_16: 'available',
                sun_14_16: 'unavailable',
                mon_16_18: 'available',
                tue_16_18: 'available',
                wed_16_18: 'available',
                thu_16_18: 'available',
                fri_16_18: 'available',
                sat_16_18: 'available',
                sun_16_18: 'unavailable'
            },
            image: 'coach_guy_dumais.png'
        },
        fitness: {
            name: 'John DOE',
            specialty: 'Coach, Fitness',
            room: 'Salle: G-011',
            phone: '+33 01 23 45 67 90',
            email: 'john.doe@omnessports.fr',
            schedule: {
                mon_8_10: 'available',
                tue_8_10: 'available',
                wed_8_10: 'available',
                thu_8_10: 'available',
                fri_8_10: 'available',
                sat_8_10: 'available',
                sun_8_10: 'unavailable',
                mon_10_12: 'available',
                tue_10_12: 'available',
                wed_10_12: 'available',
                thu_10_12: 'available',
                fri_10_12: 'available',
                sat_10_12: 'available',
                sun_10_12: 'unavailable',
                mon_12_14: 'available',
                tue_12_14: 'available',
                wed_12_14: 'available',
                thu_12_14: 'available',
                fri_12_14: 'available',
                sat_12_14: 'available',
                sun_12_14: 'unavailable',
                mon_14_16: 'available',
                tue_14_16: 'available',
                wed_14_16: 'available',
                thu_14_16: 'available',
                fri_14_16: 'available',
                sat_14_16: 'available',
                sun_14_16: 'unavailable',
                mon_16_18: 'available',
                tue_16_18: 'available',
                wed_16_18: 'available',
                thu_16_18: 'available',
                fri_16_18: 'available',
                sat_16_18: 'available',
                sun_16_18: 'unavailable'
            },
            image: 'coach_fitness.png'
        },
        // Ajoutez d'autres coachs ici...
    };

    const coach = coaches[sport];

    if (coach) {
        document.getElementById('coach-name').textContent = coach.name;
        document.getElementById('coach-fullname').textContent = coach.name;
        document.getElementById('coach-specialty').textContent = coach.specialty;
        document.getElementById('coach-room').textContent = coach.room;
        document.getElementById('coach-phone').textContent = coach.phone;
        document.getElementById('coach-email').textContent = coach.email;
        document.getElementById('coach-email').href = 'mailto:' + coach.email;
        document.getElementById('coach-image').src = coach.image;
        document.getElementById('coach-specialty-cell').textContent = coach.specialty;
        document.getElementById('coach-name-cell').textContent = coach.name;

        for (const [key, value] of Object.entries(coach.schedule)) {
            const cell = document.getElementById(`coach-schedule-${key.replace(/_/g, '-')}`);
            if (cell) {
                cell.classList.add(value);
            }
        }
    }
});
