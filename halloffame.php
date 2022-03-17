<!-- Tables showing top users based on different criterias -->
<?php
include './includes/header.inc.php';
$totalPage = 1;
?>
<div class="mt-3 ">
    <h4 class="text-center bg-dark text-white p-5">Hall Of Fame</h4>
</div>
<div class="ranker mt-5">
    <div class="topreader">
        <table class="table table-responsive table-dark">
            <!-- Users who read the most books -->
            <caption>Top Readers</caption>
            <thead>
                <tr>
                    <th>User</th>
                    <th>Book read</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $readers = getTopReader();
                $cnt = 0;
                while ($row = mysqli_fetch_assoc($readers)) {
                    $userData = getUserData($row['user_id']);
                    $username = $userData['username'];
                    $read = $row['total_read'];
                    $cnt++;
                    if ($cnt == 30) break;
                ?>
                    <tr>
                        <td><?= $username; ?></td>
                        <td><?= $read; ?></td>
                    </tr>
                <?php
                }
                ?>
            </tbody>

        </table>
    </div>
    <div class="topreview">
        <table class="table table-responsive table-dark">
            <!-- Users who wrote most reviews -->
            <caption>Top Reviewers</caption>
            <thead>
                <tr>
                    <th>User</th>
                    <th>Total Reviews</th>
                </tr>
            </thead>
            <?php
            $readers = getTopReviewer();
            $cnt = 0;
            while ($row = mysqli_fetch_assoc($readers)) {
                $userData = getUserData($row['user_id']);
                $username = $userData['username'];
                $review = $row['rev_cnt'];
                $cnt++;
                if ($cnt == 30) break;
            ?>
                <tr>
                    <td><?= $username; ?></td>
                    <td><?= $review; ?></td>
                </tr>
            <?php
            }
            ?>

        </table>
    </div>
    <div class="topdonate">
        <table class="table table-responsive table-dark">
            <!-- Users who donated the most amount of books, -->
            <caption>Top Donors</caption>
            <thead>
                <tr>
                    <th>User</th>
                    <th>Book Donated</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $readers = getTopDonators();
                $cnt = 0;
                while ($row = mysqli_fetch_assoc($readers)) {
                    $userData = getUserData($row['user_id']);
                    $username = $userData['username'];
                    $donated = $row['don_cnt'];
                    $cnt++;
                    if ($cnt == 30) break;
                ?>
                    <tr>
                        <td><?= $username; ?></td>
                        <td><?= $donated; ?></td>
                    </tr>
                <?php
                }
                ?>
            </tbody>

        </table>
    </div>
</div>
<div class="pagination">
    <ul id="pagin">
    </ul>
</div>
<?php
include './includes/footer.inc.php';
?>
<script src="./scripts/pagination.js"></script>
<script>
    window.totalPages = Math.ceil(<?= $totalPage; ?>);
    pagination(totalPages, 1, 'books');
</script>