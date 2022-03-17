// load uploaded Image.
var loadFile = function(event) {
    var output = document.getElementById('output');
    output.src = URL.createObjectURL(event.target.files[0]);
    output.onload = function() {
        URL.revokeObjectURL(output.src) // free memory
    }
};

$(document).ready(function() {
    // Validate Donation Form.
    function validateForm() {
        var a = document.forms["donation_form"]["bookname"].value;
        var b = document.forms["donation_form"]["authorname"].value;
        var c = document.getElementById('conid').checked;
        var d = document.getElementById('coverimg').files[0];
        if ((a == null || a == "") || (b == null || b == "") || c == false || (d == null || d == undefined)) {
            alert("Please Fill All Required Field");
            return false;
        } else
            return true;
    }
    $("#submit").click(function(event) {
        event.preventDefault();
        var ok = validateForm();
        if (ok == false) return;
        var form = document.getElementById('donation_form');
        var formData = new FormData(form);
        formData.append('user_id', window.userID);
        $.ajax({
            url: './ajax/donation.ajax.php',
            type: 'post',
            data: formData,
            contentType: false,
            processData: false,
            success: function(response) {
                $('#donate').html(response);
            },
        });

    });
});