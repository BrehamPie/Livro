// Navbar Search box handler.
function allSearch(name) {
    if (name.length < 1) {
        $('#searchResultNav').html('');
        return;
    }
    var x = name.split('');
    x = '%' + x.join('%') + '%';
    name = x;
    $.ajax({
        url: './ajax/navsearch.ajax.php',
        type: 'post',
        data: {
            name: name
        },
        success: function(response) {
            $('#searchResultNav').html(response);
        }
    });
}
var box = document.getElementById('box');
var down = false;

// Show or hide notifications from notification box.
function toggleNotifi() {
    if (down) {
        $('#box').hide();
        box.style.opacity = 0;
        down = false;
    } else {
        $('#box').show();
        box.style.opacity = 1;
        down = true;
    }
}

function handle(e) {
    if (e.matches) {
        $('#notiword').hide();
    } else $('#notiword').show();
}
const media = window.matchMedia('(min-width: 1250px)');
media.addListener(handle);
handle(media);