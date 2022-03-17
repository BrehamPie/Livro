$(document).ready(function () {
    $('#searchbox').on('input', function () {
        bookSearch();
    });
    //Show Review of a particular book.
    function bookSearch() {
        var bookName = $('#searchbox').val();
        var x = bookName.split('');
        x = '%' + x.join('%') + '%';
        bookName = x;
        $.ajax({
            url: './ajax/reviews.ajax.php',
            type: 'post',
            data: {
                bookName: bookName
            },
            success: function (response) {
                $('.rev-container').html(response);
            }
        });
    }

    function get_checked_data(id) {
        var filterData = [];
        $('#' + id + ':checked').each(function () {
            filterData.push($(this).val());
        })
        return filterData;
    }

});