$(document).ready(function() {
    // Similar to books.js
    $('#searchbox').on('input', function() {
        bookSearch();
    });
    $('.product_check').click(function() {
        bookSearch();
    });

    function bookSearch() {
        var genre = $('#searchbox').val();
        var x = genre.split('');
        x = '%' + x.join('%') + '%';
        genre = x;
        $.ajax({
            url: './ajax/genres.ajax.php',
            type: 'post',
            data: {
                genre: genre,
            },
            success: function(response) {
                $('.genre').html(response);
            }
        });
    }

    function get_checked_data(id) {
        var filterData = [];
        $('#' + id + ':checked').each(function() {
            filterData.push($(this).val());
        })
        return filterData;
    }

});