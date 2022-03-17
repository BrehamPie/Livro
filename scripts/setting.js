$(document).ready(function () {
    //Vary Drop Down Menu of District Division and Upazilla.
    $('#division-dropdown').on('change', function () {
        var division_id = this.value;
        $.ajax({
            url: "./ajax/country.ajax.php",
            type: "POST",
            data: {
                division_id: division_id,
                action: 'district'
            },
            cache: false,
            success: function (result) {
                console.log(result);
                $("#district-dropdown").html(result);
                $('#upazila-dropdown').html('<option value="">Select District First</option>');
            }
        });
    });
    $('#district-dropdown').on('change', function () {
        var district_id = this.value;
        $.ajax({
            url: "./ajax/country.ajax.php",
            type: "POST",
            data: {
                district_id: district_id,
                action: 'upazila'
            },
            cache: false,
            success: function (result) {
                console.log(result);
                $("#upazila-dropdown").html(result);
            }
        });
    });

    //Update User Data using ajax.
    $("#general_update").click(function (event) {

        var form = document.getElementById('general_data');
        var formData = new FormData(form);
        formData.append('action', 'general');
        event.preventDefault();
        // Check file selected or not
        $.ajax({
            url: './ajax/user.ajax.php',
            type: 'post',
            data: formData,
            contentType: false,
            processData: false,
            success: function (response) {
                $('#info').html("Profile Updated.");
            },
        });

    });
    //Update Password.
    $("#password_update").click(function (event) {

        var form = document.getElementById('pass_form');
        var formData = new FormData(form);
        formData.append('action', 'secure');
        event.preventDefault();
        // Check file selected or not
        $.ajax({
            url: 'user.ajax.php',
            type: 'post',
            data: formData,
            contentType: false,
            processData: false,
            success: function (response) {
                $('#passinfo').html(response);
            },
        });

    });

});