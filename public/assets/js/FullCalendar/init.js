document.addEventListener("DOMContentLoaded", () => {
    const calendarElement = document.getElementById("calendar");

    const calendar = new FullCalendar.Calendar(calendarElement, {
        initialView: "dayGridMonth",
        height: 630,
        selectable: true,
        dateClick: function (info) {
            console.log("clicked " + info.dateStr);
        },
        select: function (info) {
            console.log("selected " + info.startStr + " to " + info.endStr);
        },
        headerToolbar: {
            left: "prev,next today",
            center: "title",
            right: "dayGridMonth,timeGridWeek",
        },
        firstDay: 1,
        businessHours: {
            // days of week. an array of zero-based day of week integers (0=Sunday)
            daysOfWeek: [1, 2, 3, 4, 5, 6], // Lundi à Samedi

            startTime: "8:30", // a start time (10am in this example)
            endTime: "20:00", // an end time (6pm in this example)
        },
        dayHeaderFormat: {
            weekday: "long",
        },
        buttonText: {
            today: "aujourd'hui",
            month: "mois",
            week: "semaine",
            day: "jour",
            list: "liste",
        },
        events: {
            url: "/meet/json",
            failure: function () {
                alert(
                    "Il y a eu une erreur lors du chargement des évènements !"
                );
            },
        },
        eventClick: (info) => {
            console.log(info);
        },
        locale: "fr",
    });
    calendar.render();
});
