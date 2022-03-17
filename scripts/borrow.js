$(document).ready(function() {
    $('#cancel').on('click', function() {
        location.href = "./book.php?id=" + window.bookid;
    });
    $('#confirm').on('click', function() {
        // accept a borrow request from user.
        $.ajax({
            url: './ajax/borrow.ajax.php',
            type: 'post',
            data: {
                userid: window.userid,
                bookid: window.bookid,
                deliverydate: window.deliverydate,
                subid: window.subid,
                reqdate: window.reqdate
            },
            success: function(response) {
                $('#main').html(response);
            },
        });
    });
});