<!-- All the reviews posted by the users. -->
<?php
include './includes/header.inc.php';
$sql = "SELECT COUNT(*) as size FROM review WHERE review IS NOT NULL AND length(review)>0";
$allReview = myquery($sql);
$res = mysqli_fetch_assoc($allReview);
$totalPage = $res['size'] / 10;
?>
<div class="searchbook bg-light">
    <div>
        <h4 style="font-size: 2vw;">Read Review of Your Favorite Books</h4>
    </div>
    <form class="input-group form-container" style="width: 60%;" action="bookSearch.ajax.php" method="POST">
        <input type="text" class="form-control search-input" placeholder="Find review of your desired book." autofocus="autofocus" name="name" id='searchbox'>
        <span class="input-group-btn">
            <button class="btn btn-search" id="genre-search-button">
                <i class="fas fa-search"></i>
            </button>
        </span>
    </form>
    <ul class='list-group' style="width:60%;border:none;" id='dataViewer'>
    </ul>
    <hr>
</div>
<div class="container mt-5 rev-container">
    <?php
    $limit = 10;
    if (isset($_GET['page'])) {
        $page = $_GET['page'];
    } else {
        $page = 1;
    }
    $offset = ($page - 1) * $limit;
    $sql = "SELECT * FROM review WHERE review IS NOT NULL AND LENGTH(review)>0 LIMIT {$offset},{$limit}";
    $allReview = myquery($sql);
    $rowId = 0;
    while ($row = mysqli_fetch_assoc($allReview)) {
        // print_r($row);
        $data = $row['review'];
        $uid = $row['user_id'];
        $bid = $row['book_id'];
        $bookData = getBookData($bid);
        $userData = getUserData($uid);
        $bname = $bookData['name'];
        $uname = $userData['username'];
        $reviewData = $row['review'];
        $img = $bookData['img'];
        $rain = $row['rating'];
        $date = $row['date'];
        $newDate = date("d F,Y", strtotime($date));
        $authors = getAuthorListWithoutLink($bid);
        $rowId++;
    ?>
        <div class="row border mb-3">
            <div class="col-6 mb-0 mt-2">
                <p class="mb-0"><a href="./book.php?book=<?= $bookData['id']; ?>"> <?= $bname; ?></a>- <small><?= $authors; ?></small></p>
                <p class="mt-0"> Review by: <a href="./user.php?uid=<?= $uid; ?>"><?= $uname; ?></a></p>
            </div>
            <div class="col-6 text-right mb-0 mt-2">
                <p class="mb-0"><?= $newDate; ?></p>
                <div class="stars-outer">
                    <div class="stars-inner" id='<?= $rowId; ?>'>
                        <script type="text/javascript">
                            var starTotal = 5;
                            var starPercentage = (<?= $rain; ?> / starTotal) * 100;
                            var starPercentageRounded = `${(Math.round(starPercentage / 10) * 10)}%`;
                            document.getElementById('<?= $rowId; ?>').style.width = starPercentageRounded;
                        </script>
                    </div>
                </div>
            </div>
            <hr class='reviewdiv'>
            <div class="col-1 " style="display: flex;justify-content: center;align-items: center;height:18vh;">
                <img src="./assets/img/books/<?= $img; ?>" alt="" class="img img-responsive" style="height: 15vh;">
            </div>

            <div class="col-11">
                <?php
                $dots = '';
                $rest = '';
                $less = '';
                // echo strlen($reviewData);
                if (strlen($reviewData) < 1200) $short = $reviewData;
                else {
                    $short = substr($reviewData, 0, 1200);
                    $last = 1200;
                    while (strlen($short) && $short[-1] != ' ')
                        $short = rtrim($short, $short[-1]);
                    $dots = '...See More';
                    $rest = substr($reviewData, strlen($short));
                    $less = ' See less';
                }
                ?>
                <span id='short'><?= $short; ?></span><a id='more-<?= $rowId; ?>' style="color: steelblue;cursor:pointer;"><span><?= $dots; ?></span></a><span id='rest-<?= $rowId; ?>' style="display: none;"><?= $rest; ?></span><a onclick="" id='less-<?= $rowId; ?>' style="display: none;color: steelblue;cursor:pointer;"><span><?= $less; ?></span></a></span>
                <script>
                    document.getElementById('more-<?= $rowId; ?>').onclick = function() {
                        $('#rest-<?= $rowId; ?>').show();
                        $('#more-<?= $rowId; ?>').hide();
                        $('#less-<?= $rowId; ?>').show();
                    };
                    document.getElementById('less-<?= $rowId; ?>').onclick = function() {
                        $('#rest-<?= $rowId; ?>').hide();
                        $('#more-<?= $rowId; ?>').show();
                        $('#less-<?= $rowId; ?>').hide();
                    };
                </script>
            </div>
        </div>
    <?php
    }
    ?>
</div>

<div class="pagination">
    <ul id="pagin">
    </ul>
</div>
<?php
include './includes/footer.inc.php';
?>
<script src="./script.js"></script>
<script src="./scripts/reviews.js"></script>
<script>
    window.totalPages = Math.ceil(<?= $totalPage; ?>);
    pagination(totalPages, <?= $page; ?>, 'reviews');
</script>
<script>
  
</script>