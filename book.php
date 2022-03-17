<?php
include './includes/header.inc.php';
if (isset($_GET['id'])) {
    $b_id = $_GET['id'];
} else {
    header("Location:./noaccess.php");
}
$uid = -1;
$disable = 'disabled';
if (!empty($_SESSION['userid'])) {
    $uid = $_SESSION['userid'];
    $disable = '';
    // Insert History stores the books visited by the user.
    insertHistory($uid, $b_id);
}

$bookData = getBookData($b_id);
$name = $bookData['name'];
$img = $bookData['img'];
// default image.
if ($img == null || $img == '') $img = '0.jpg';
$src = './assets/img/books/' . $img;
$b_det = $bookData['summary'];
$a_det = '';
$authors = getAuthors($b_id);
$author = ' ';
foreach ($authors as $aid) {
    $authorData = getAuthorData($aid);
    $a_det .= $authorData['name'] . '<br>' . $authorData['about'] . '<br>';
    $author .= ',';
}

$authors = getAuthorListWithLink($b_id);
$genres = getGenreListWithLink($b_id);
/*Availability*/
$sql = "SELECT COUNT(*) as avail FROM product WHERE book_id = $b_id AND status=1";
$res = myquery($sql);
if ($res == null) $book_count = 0;
else {
    $row = mysqli_fetch_assoc($res);
    $book_count = $row['avail'];
}

/*Rating-Review*/
$sql = "SELECT COUNT(rating) AS cnt_rating ,COUNT(review) AS cnt_review ,AVG(rating) as rating_avg FROM review WHERE book_id = $b_id";
$res = myquery($sql);
$row = mysqli_fetch_assoc($res);
$rating_cnt = $row['cnt_rating'];
$sql = "SELECT COUNT(*) as size FROM review WHERE review IS NOT NULL AND length(review)>0 AND book_id = $b_id";
$allReview = myquery($sql);
$res = mysqli_fetch_assoc($allReview);
$review_cnt = $res['size'];
$rating_avg = round($row['rating_avg'], 2);
?>
<main>
    <div class="container mt-5">
        <div class="book-page-pic">
            <div class="book-page-img">
                <img src="<?= $src; ?>" alt="" class="img-fluid ">
            </div>
            <div class="book-page-namedet">
                <div class="book-page-name">
                    <p><?= $name; ?></p>
                    <p><span>by: </span><?= $authors; ?></p>
                </div>
                <div class="book-page-cat">
                    <p>Category:<?= $genres; ?>
                    </p>

                </div>
                <div class="book-page-btn">
                    <a href="./borrow.php?id=<?= $b_id; ?>"><button class="btn btn-primary">Borrow</button></a>
                </div>
            </div>
            <div class="book-page-ratingreview">
                <div class="book-page-rating">
                    <div class="stars-outer">
                        <div class="stars-inner"></div>
                    </div>
                    <p><?= $rating_avg; ?>/5.0 (<?= $rating_cnt; ?>Ratings)</p>
                </div>
                <div class="book-page-review">
                    <p><?= $review_cnt; ?> Reviews</p>
                </div>
            </div>
            <div class="book-page-copy">
                <p class="book-page-copies"><?= $book_count; ?></p>
                <p>Copies Available to Borrow</p>
            </div>
        </div>
        <div class="book-page-tab mt-5">
            <div class="book-page-tab-btn">
                <button onclick="showPanel(0)">Summary</button>
                <button onclick="showPanel(1)">Author</button>
            </div>
            <div class="book-page-tabpanel" id="content1">
                <?= $b_det; ?>
            </div>
            <div class="book-page-tabpanel" id="content2">
                <?= $a_det; ?>
            </div>
        </div>
    </div>
    <hr>
    <div class="container rating-cont mb-5">

        <div class="row">
            <div class="col-7 border">
                <h4>Review</h4>
                <textarea name="" id="rating-text" rows="7" style="width: 100%;  resize: none; padding:5px;" class="form-control mb-3" placeholder="Please Write Your Honest Opinion"></textarea>

                <ul class="stars">
                    <li class="star"><i class="fa fa-star "></i></li>
                    <li class="star"><i class="fa fa-star "></i></li>
                    <li class="star"><i class="fa fa-star "></i></li>
                    <li class="star"><i class="fa fa-star "></i></li>
                    <li class="star"><i class="fa fa-star "></i></li>
                    <button class='btn btn-primary' style="margin-left: auto;" id='review-submit' <?= $disable; ?>>Submit</button>
                </ul>
                <p class='text-success' id='review-accepted' style="display: none;">Thanks for your Review.</p>
            </div>
        </div>
        <div class='text-center mt-3'><a href="./reviews.php?id=<?= $b_id; ?>">See All Reviews</a> </div>
    </div>
</main>
<script>
    window.avg_rating = <?= $rating_avg; ?>;
    window.book_id = <?= $b_id; ?>;
    window.user_id = <?= $uid; ?>;
</script>
<script src="./scripts/book.js"></script>
<?php
include './includes/footer.inc.php';
?>