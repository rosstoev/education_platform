$(document).ready(function () {
    const indexRegEx = /_(?<text>\d+?)_/gm;

    function findIndex(elementId) {
        return elementId[elementId.search(indexRegEx) + 1];

    }

    function toggleQuestionType(typeElement) {
        let elementId = typeElement.attr('id');
        let index = findIndex(elementId);
        let checkedType = $('input[name="test_exam[questions][' + index + '][type]"]:checked').val();
        if (checkedType === 'open') {
            $('#open-question-parts-' + index).show();
            $('#choice-question-parts-' + index).hide();
            $(`#choice-card-${index}`).empty();
        } else if (checkedType === 'choices') {
            $('#open-question-parts-' + index).hide();
            $('#choice-question-parts-' + index).show();
            $(`#test_exam_questions_${index}_textLength`).val('');
            $(`#test_exam_questions_${index}_points`).val('');
        } else {
            $('#open-question-parts-' + index).hide();
            $('#choice-question-parts-' + index).hide();
        }
    }

    function addQuestionChoice(questionIndex) {
        console.log(questionIndex);
        let newChoice = $('.question-choice-prototype').clone().html();
        let nextChoiceIndex = 0;
        let lastChoiceIndex = $(`#choice-card-${questionIndex} .choice-block`).last().data('choiceIndex');
        if (lastChoiceIndex !== undefined) {
            nextChoiceIndex = lastChoiceIndex + 1;
        }
        newChoice = newChoice.replaceAll('--question-index--', questionIndex);
        newChoice = newChoice.replaceAll('--choice-index--', nextChoiceIndex);
        $(`#choice-card-${questionIndex}`).append(newChoice);
    }

    function addQuestion() {
        let newQuestion = $('.question-prototype').clone().html();
        let lastQuestionIndex = $(`#question-block .question-card`).last().data('questionIndex');
        let nextQuestionIndex = lastQuestionIndex + 1;
        newQuestion = newQuestion.replaceAll('--question-index--', nextQuestionIndex);
        $('#question-block').append(newQuestion);
    }

    function removeQuestionChoice(questionIndex) {
        $(`#choice-card-${questionIndex} .choice-block`).last().remove();
    }

    function removeQuestion() {
        let questionCard = $('#question-block .question-card');
        let lastQuestionIndex = questionCard.last().data('questionIndex');
        if (lastQuestionIndex > 0) {
            questionCard.last().remove();
        }
    }

    $('.question-type').each(function () {
        toggleQuestionType($(this));
    })

    $(document).on('change', '.question-type', function () {
        toggleQuestionType($(this));
    });

    $(document).on('click', '.button-choice-add', function () {
        let questionIndex = $(this).data('questionIndex');
        addQuestionChoice(questionIndex);
    })

    $(document).on('click', '.button-choice-remove', function () {
        let questionIndex = $(this).data('questionIndex');
        removeQuestionChoice(questionIndex);
    })

    $('.button-add-question').click(function () {
        addQuestion();
    });

    $('.button-remove-question').click(function () {
        removeQuestion();
    });

});