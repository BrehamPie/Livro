function accept(id, rowIndex) {
    $.ajax({
        url: './ajax/review.ajax.php',
        type: 'post',
        data: {
            id: id,
            keep: 'yes'
        },
        success: function(response) {
            document.getElementById('table').rows[rowIndex].cells[6].innerHTML = 'Accepted';
            document.getElementById('table').rows[rowIndex].cells[7].childNodes[0].disabled = true;
            document.getElementById('table').rows[rowIndex].cells[8].childNodes[0].disabled = true;
        },
    });
}

function reject(id, rowIndex) {
    var x = [];
    for (let key of keep.keys()) {
        x.push(key);
    }
    $.ajax({
        url: './ajax/review.ajax.php',
        type: 'post',
        data: {
            id: id,
            keep: 'no'
        },
        success: function(response) {
            document.getElementById('table').rows[rowIndex].cells[6].innerHTML = 'Rejected';
            document.getElementById('table').rows[rowIndex].cells[7].childNodes[0].disabled = true;
            document.getElementById('table').rows[rowIndex].cells[8].childNodes[0].disabled = true;
        },
    });
}