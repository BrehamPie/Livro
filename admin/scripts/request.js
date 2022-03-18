$(document).ready(function() {});

function Delivered(id, rowIndex) {
    $.ajax({
        url: './ajax/requests.ajax.php',
        type: 'post',
        data: {
            id: id
        },
        success: function(response) {
            document.getElementById('table').rows[rowIndex].cells[8].innerHTML = 'Delivered';
            document.getElementById('table').rows[rowIndex].cells[9].childNodes[0].disabled = true;
        },
    });
}