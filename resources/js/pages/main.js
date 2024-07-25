$(document).ready(function () {
    console.log(routes.base)
    const registerEventListeners = () => {
        $('#shortenUrlForm').submit((e) => {
            e.preventDefault()
            submitShortenUrlForm();
        })
    }

    const submitShortenUrlForm = () => {
        $('#submitShortenUrlFormBtn').attr('disabled', 'disabled');
        let data = {
            'link' : $('#linkInput').val()
        }
        const emailInputVal = $('#emailInput').val();
        if (emailInputVal !== '') {
            data.email = emailInputVal;
        }
        console.log(data)
        $.ajax({
            type: 'POST',
            url: routes.shortenUrlRouteName,
            data: data,
            success: (response) => {
                // TODO : Display shortened URL; priority : 1
            },
            // TODO : Improve design; priority : 2
            error : function (xhr, status, error) {
                let errors = JSON.parse(xhr.responseText).errors
                Object.keys(errors).forEach(function (key) {
                    let errorMessage = errors[key][0];
                    let errorSelector = $(`#${key}Input`).next('.error');
                    $(errorSelector).html('');
                    $(errorSelector)
                        .append(errorMessage);
                });
            },
            complete: () => {
                $('#submitShortenUrlFormBtn').removeAttr('disabled');
            }
        });
    }
    
    registerEventListeners();
})