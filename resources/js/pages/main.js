$(document).ready(function () {

    const registerEventListeners = () => {
        $('#shortenUrlForm').submit((e) => {
            e.preventDefault()
            submitShortenUrlForm();
        })
        $('#displayUrlContainer').submit((e) => {
            e.preventDefault()
            makeAnother();
        })
    }

    // Submit form
    const submitShortenUrlForm = () => {
        $('#submitShortenUrlFormBtn').attr('disabled', 'disabled');
        let data = {
            'link' : $('#linkInput').val()
        }
        const emailInputVal = $('#emailInput').val();
        if (emailInputVal !== '') {
            data.email = emailInputVal;
        }
        $.ajax({
            type: 'POST',
            url: routes.shortenUrlRouteName,
            data: data,
            headers: {
                'X-CSRF-TOKEN': $('input[name="_token"]').val()
            },
            // Populate input fields to display shortened URL
            success: (response) => {
                $('#shortenUrlForm').addClass('hidden');
                $('#originalUrlInput').val(data.link);
                $('#shortenedUrlInput').val(response);
                $('#displayUrlContainer').removeClass('hidden')
                $('#linkInput').val('');
                $('#emailInput').val('');
            },
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

    // Show form to create another shortened URL
    const makeAnother = () => {
        $('#displayUrlContainer').addClass('hidden');
        $('#originalUrlInput').val('');
        $('#shortenedUrlInput').val('');
        $('#shortenUrlForm').removeClass('hidden');
    }
    
    registerEventListeners();
})