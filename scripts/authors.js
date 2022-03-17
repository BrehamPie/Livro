$(".author_carousel").owlCarousel({
    items: 7,
    loop: true,
    margin: 2,
    autoplay: true,
    autoplayTimeout: 900,
    responsive: { /* number of items shown*/
        0: {
            items: 1
        },
        300: {
            items: 2
        },
        600: {
            items: 3
        },
        800: {
            items: 4
        },
        1000: {
            items: 6
        },
        1200: {
            items: 7
        }
    }

});
// Search author by the input from searchbox.
function authorSearch() {
    var authorName = $('#author-search').val();
    var x = authorName.split('');
    x = '%' + x.join('%') + '%';
    authorName = x;
    $.ajax({
        url: './ajax/authorSearch.ajax.php',
        type: 'post',
        data: {
            author: authorName,
        },
        success: function (response) {
            $('.author-container').html(response);
        }
    });
}