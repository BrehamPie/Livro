<?php
require_once '../includes/functions.inc.php';
$name = $_POST['bookName'];
$sql1 = "SELECT id FROM book WHERE name LIKE '$name' OR name_eng LIKE '$name' ";
$sql = "SELECT * FROM review WHERE review IS NOT NULL AND book_id IN($sql1)";
$allReview = mysqli_query($connection,$sql);
print_r(mysqli_error($connection));
$rowId = 0;
while ($row = mysqli_fetch_assoc($allReview)) {
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
            <!-- Show only few amount of data -->
            <div class="col-11">
                <?php
                $dots = '';
                $rest = '';
                $less = '';
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