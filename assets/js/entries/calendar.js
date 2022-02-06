import bgLocale from "@fullcalendar/core/locales/bg";

const calendarEl = document.getElementById("calendar");
const calendar = new FullCalendar(calendarEl, {
        plugins: [FullCalendarDayGridPlugin, FullCalendarTimeGridPlugin, FullCalendarListPlugin, FullCalendarInteractionPlugin],
        locales: [bgLocale], // english is default and is built-in
        locale: 'bg',
        firstDay: 1,
        initialView: 'dayGridMonth',
        headerToolbar: {
            left: 'prev,next today',
            center: 'title',
            right: 'dayGridMonth,timeGridWeek,dayGridDay'
        },
        views: {
            dayGridMonth: {
                dayMaxEventRows: 3 // adjust to 6 only for timeGridWeek/timeGridDay
            }
        },
        events: calendarEvents
    }
);

calendar.render();