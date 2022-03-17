$(document).ready(function () {
    $('#searchbox').on('input', function () {
        bookSearch();
    });
    $('.product_check').click(function () {
        bookSearch();
    });
    //Filter Books according to data
    function bookSearch() {
        var author = get_checked_data('author');
        var genre = get_checked_data('genre');
        var rating = get_checked_data('rating');
        var bookName = $('#searchbox').val();
        var x = bookName.split('');
        x = '%' + x.join('%') + '%';
        bookName = x;
        $.ajax({
            url: './ajax/search.ajax.php',
            type: 'post',
            data: {
                bookName: bookName,
                author: author,
                genre: genre,
                rating: rating
            },
            success: function (response) {
                $('.book-container').html(response);
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
    bookSearch();
});