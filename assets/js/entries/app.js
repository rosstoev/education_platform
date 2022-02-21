import bgSelect2 from 'admin-lte/plugins/select2/js/i18n/bg';
$(document).ready(function (){
    $('.my-select2-js').select2({
        language: bgSelect2
    });
    $('.year-mask').inputmask('yyyy', { 'placeholder': 'yyyy' });
    //Date picker
    $('.datepicker-field').datepicker({
        language: 'bg',
        format: 'dd.mm.yyyy',
        autoclose: true,
    });

    $('.daterange-field').daterangepicker({
        singleDatePicker: true,
        autoClose: true,
        autoApply: true,
        timePicker: true,
        timePicker24Hour: true,
        locale: {
            format: 'DD.MM.YYYY HH:mm',
            daysOfWeek: ["Нед", "Пон", "Вто", "Сря", "Чет", "Пет", "Съб"],
            monthNames: ["Ян", "Фев", "Мар", "Апр", "Май", "Юни", "Юли", "Авг", "Сеп", "Окт", "Ное", "Дек"]
        }
    });

});