var keep = new Map();
function accept(id, rowIndex) {
    $.ajax({
        url: './ajax/subscription.ajax.php',
        type: 'post',
        data: {
            id: id,
            keep: 'yes'
        },
        success: function(response) {
            document.getElementById('table').rows[rowIndex].cells[5].innerHTML = 'Accepted';
            document.getElementById('table').rows[rowIndex].cells[6].childNodes[0].disabled = true;
            document.getElementById('table').rows[rowIndex].cells[7].childNodes[0].disabled = true;
        },
    });
}

function reject(id, rowIndex) {
    var x = [];
    for (let key of keep.keys()) {
        x.push(key);
    }
    $.ajax({
        url: './ajax/subscription.ajax.php',
        type: 'post',
        data: {
            id: id,
            keep: 'no'
        },
        success: function(response) {
            document.getElementById('table').rows[rowIndex].cells[5].innerHTML = 'Rejected';
            document.getElementById('table').rows[rowIndex].cells[6].childNodes[0].disabled = true;
            document.getElementById('table').rows[rowIndex].cells[7].childNodes[0].disabled = true;
        },
    });
}