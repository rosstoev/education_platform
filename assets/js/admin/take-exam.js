$(document).ready(function (){
    const remainingTime = $('#remaining-time');
    const now = remainingTime.data('now');
    const endAt = remainingTime.data('endAt');
    const executeTimer = $('#execute-timer');

    const diffTime = endAt - now;
    let duration = moment.duration(diffTime * 1000, 'milliseconds');
    const interval = 1000;

    setInterval(() => {
        duration = moment.duration(duration - interval, 'milliseconds');
        executeTimer.html(duration.hours() + ":" + duration.minutes() + ":" + duration.seconds());
    }, interval);
});