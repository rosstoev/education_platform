$(document).ready(function (){
    let defaultTypeValue = $("input[name='registration[type]']:checked").val();
    const courseNumberField = $('.course-number-js');

    function toggleCourseNumberField(typeValue)
    {
        if (typeValue === '2') {
            courseNumberField.show();
        } else {
            courseNumberField.hide();
        }
    }

    toggleCourseNumberField(defaultTypeValue);

    $('#registration_type').on('change', function (e){
        let typeValue = $("input[name='registration[type]']:checked").val();
        toggleCourseNumberField(typeValue)
    });
})