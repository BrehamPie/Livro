var tabButtons = document.querySelectorAll(".book-page-tab .book-page-tab-btn button");
var tabPanels = document.querySelectorAll(".book-page-tab  .book-page-tabpanel");
// 2 tabs showing book summary and author summary.
function showPanel(panelIndex) {
    tabButtons.forEach(function(node) {
        node.style.backgroundColor = "";
        node.style.color = "";
    });
    tabButtons[panelIndex].style.color = "white";
    tabButtons[panelIndex].style.backgroundColor = "#55acee";
    tabPanels.forEach(function(node) {
        node.style.display = "none";
    });
    tabPanels[panelIndex].style.display = "flex";
}
showPanel(0);
// fill start according to book rating.
const starTotal = 5;
const starPercentage = (window.avg_rating / starTotal) * 100;
const starPercentageRounded = `${(Math.round(starPercentage / 10) * 10)}%`;
document.querySelector(`.book-page-rating .stars-inner`).style.width = starPercentageRounded;
const stars = document.querySelectorAll('.star');
const output = document.querySelector('.output');
const textReview = document.querySelector('.textReview');
var st = 0;
var rv = "";
//fill stars by hovering mouse.
for (x = 0; x < stars.length; x++) {
    stars[x].starValue = (x + 1);
    ["click", "mouseover", "mouseout"].forEach(function(e) {
        stars[x].addEventListener(e, showRating);
    })

}

function showRating(e) {
    let type = e.type;
    let starValue = this.starValue;
    if (type === 'click') {
        if (starValue >= 1) {
            st = starValue;
        }
    }
    stars.forEach(function(element, index) {
        if (type === 'click') {
            if (index < starValue) {
                element.classList.add("blue");
            } else {
                element.classList.remove("blue");
            }
        }
        if (type === 'mouseover') {
            if (index < starValue) {
                element.classList.add("aqua");
            } else {
                element.classList.remove("aqua");
            }
        }
        if (type === 'mouseout') {
            element.classList.remove("aqua");
        }
    })
}
$(document).ready(function() {
    // Save user review using ajax.
    $('#review-submit').on('click', function() {
        $.ajax({
            url: './ajax/book.ajax.php',
            type: 'post',
            data: {
                book: window.book_id,
                uid: window.user_id,
                rating: st,
                review: $('#rating-text').val()
            },
            success: function(response) {
                console.log(response);
                $("#review-accepted").fadeIn().delay(2000).fadeOut();
            }

        })
    });
});