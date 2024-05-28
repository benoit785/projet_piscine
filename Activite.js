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
                mon: 'AM',
                tue: 'PM',
                wed: 'AM',
                thu: 'AM',
                fri: 'PM',
                sat: 'AM'
            },
            image: 'coach_guy_dumais.png'
        },
        fitness: {
            name: 'Fitness Coach',
            specialty: 'Coach, Fitness',
            room: 'Salle: G-011',
            phone: '+33 01 23 45 67 90',
            email: 'fitness.coach@omnessports.fr',
            schedule: {
                mon: 'PM',
                tue: 'AM',
                wed: 'PM',
                thu: 'PM',
                fri: 'AM',
                sat: 'PM'
            },
            image: 'coach_fitness.png'
        }
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
        document.getElementById('coach-schedule-mon').textContent = coach.schedule.mon;
        document.getElementById('coach-schedule-tue').textContent = coach.schedule.tue;
        document.getElementById('coach-schedule-wed').textContent = coach.schedule.wed;
        document.getElementById('coach-schedule-thu').textContent = coach.schedule.thu;
        document.getElementById('coach-schedule-fri').textContent = coach.schedule.fri;
        document.getElementById('coach-schedule-sat').textContent = coach.schedule.sat;
    }
});

