$(document).ready(function (){
    $('.my-select2-js').select2();
    $('.year-mask').inputmask('yyyy', { 'placeholder': 'yyyy' });
    //Date picker
    $('.datepicker-field').datepicker({
        language: 'bg',
        format: 'dd/mm/yyyy',
        autoclose: true,
    });
});