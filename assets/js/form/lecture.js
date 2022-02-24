$(document).ready(function (){
    const disciplineGroupAddress = '/teacher/ajax/lecture/discipline-group';

    $(document).on('change', '#lecture_discipline', function (){
        let form = $('form').serialize();

        $.ajax({
            method: "POST",
            url: disciplineGroupAddress,
            data: form,
            timeout: 2000,
            success: function (data) {
                $('#discipline-groups-area').html(data.output);
            }
        });
    });
})