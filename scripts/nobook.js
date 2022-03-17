$('#yes').on('click', function() {
    // Handle response when no book is available.
    $.ajax({
        url: './ajax/nobook.ajax.php',
        type: 'post',
        data: {
            id: window.userid,
            bookid: window.bookid
        },
        success: function(response) {
            console.log(response);
            document.getElementById('nobook').innerHTML = response;
            window.setTimeout(function() {
                window.location.href = "./book.php?id=" + window.userid;

            }, 2500);
        },
    });
})