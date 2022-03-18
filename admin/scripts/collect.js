$(document).ready(function() {});
function Delivered(id, rowIndex) {
    $.ajax({
        url: './ajax/collect.ajax.php',
        type: 'post',
        data: {
            id: id
        },
        success: function(response) {
            document.getElementById('table').rows[rowIndex].cells[7].innerHTML = 'Received';
            document.getElementById('table').rows[rowIndex].cells[8].childNodes[0].disabled = true;
        },
    });
}