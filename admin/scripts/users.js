var keep = new Map();

function Change(id) {
    var x = $('#apply');
    if (keep.has(id)) keep.delete(id);
    else keep.set(id, 1);
    x.css({
        'display': 'inline'
    });
}

function ApplyChange() {
    var x = [];
    for (let key of keep.keys()) {
        x.push(key);
    }
    $.ajax({
        url: './ajax/users.ajax.php',
        type: 'post',
        data: {
            keep: x
        },
        success: function(response) {
            $('#apply').css({
                'display': 'none'
            });
            keep.clear();
        },
    });
}