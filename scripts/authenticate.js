// Toggle Between signup and login.
function toggler() {
    $('.SorL').animate({
        height: "toggle",
        opacity: "toggle"
    }, "slow");
}

$(document).ready(function() {
    $('.altermessage a').click(toggler);
    $('#login').on('click', function(event) {
        event.preventDefault();
        process('login', 'log_form');
    });

    $('#registration').on('click', function(event) {
        event.preventDefault();
        process('registration', 'reg_form');
    });
    // User Signup Login validation in ajax.
    function process(action, formName) {
        var form = document.getElementById(formName);
        var formData = new FormData(form);
        formData.append('action', action);
        $.ajax({
            url: './ajax/authenticate.ajax.php',
            type: 'post',
            data: formData,
            contentType: false,
            processData: false,
            success: function(response) {
                $('#errorMessage').addClass('text-center');
                var obj = JSON.parse(response);
                if (obj['problem'] == 'ok') {
                    if (obj['role'] == '1') window.location.href = "./index.php";
                    else window.location.href = "./admin";
                } else if (obj['problem'] == 'reg-ok') {
                    $('#errorMessage').removeClass('text-danger');
                    $('#errorMessage').addClass('text-success');
                    $('#errorMessage').html("Registration Successful.Please Login");
                    toggler();
                } else {
                    $('#errorMessage').addClass('text-danger');
                    $('#errorMessage').html(obj['problem']);
                }
            }
        });

    }
});