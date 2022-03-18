var loadFile = function(event) {
    var output = document.getElementById('output');
    output.src = URL.createObjectURL(event.target.files[0]);
    output.onload = function() {
        URL.revokeObjectURL(output.src) // free memory
    }
};
$(document).ready(function() {
    $('#b_id').on('change', function() {
        var b_id = this.value;
        if (b_id == '') {
            $('#addproduct').prop("disabled", true);
        }
        $.ajax({
            url: "./ajax/donation.ajax.php",
            type: "POST",
            data: {
                b_id: b_id,
                uid: window.uid,
                action: 'idchange'
            },
            cache: false,
            dataType: 'json',
            success: function(result) {
                var name = result['name'];
                var author = '';
                var ara = result['author'];
                ara.forEach(function(entry) {
                    author = author + entry + ',';
                });
                author = author.slice(0, -1);
                var img = '../assets/img/books/' + result['img'];
                $("#dbtitle").val(name);
                $('#dbauthor').val(author);
                $('#dbimg').attr("src", img);
                $('#addproduct').prop("disabled", false);
            }
        });
    });
    $('#addproduct').on('click', function() {
        $.ajax({
            url: "./ajax/donation.ajax.php",
            type: "POST",
            data: {
                d_id: window.did,
                b_id: $('#b_id').val(),
                action: 'add'
            },
            cache: false,
            success: function(result) {
                $('#donate-full').html(result);
                window.setTimeout(function() {
                    window.location.href = "./donations.php";
                }, 2000);
            }
        });
    });
    $('#addtobase').on('click', function() {
        window.open("./book.php?d_id=" + window.did);
    });
});