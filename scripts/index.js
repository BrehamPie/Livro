$(document).ready(function() {
    // handle all carousels in index.php
    $(".trending_owl").owlCarousel({
        items: 8,
        loop: true,
        autoplay: true,
        autoplayTimeout: 2000,
        autoWidth: true,
        autoHeight: true,
        margin: 5,
        dots: true,
        autoplayHoverPause: true
    });

    $(".author_carousel").owlCarousel({
        items: 7,
        loop: true,
        margin: 2,
        nav: true,
        responsive: {
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

    $(".recent").owlCarousel({
        items: 3,
        loop: true,
        autoplay: true,
        autoplayTimeout: 2000,
        autoHeight: true,
        singleItem: true,
        margin: 2,
        dots: true,
        autoplayHoverPause: true
    });
});