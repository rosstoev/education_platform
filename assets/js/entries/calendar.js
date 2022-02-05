
$(document).ready(function (){
    const calendarComponent = $("#calendar");

    var calendar = new FullCalendar.Calendar(calendarComponent, {
        initialView: 'dayGridMonth'
    });
    calendar.render();
});