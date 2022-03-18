<!-- Reviews Posted By Users. -->
<?php
include './includes/header.inc.php';
$totalPage = getSize('review') / 10;
?>
<div class="container text-center" style="display: flex;justify-content:center;flex-direction:column">
    <h1 class="text-center">User Reviews</h1>
    <table class=" table table-bordered table-hover" id='table'>
        <thead class="bg-info">
            <tr>
                <th>#</th>
                <th>Username</th>
                <th>Book</th>
                <th>Rating</th>
                <th>Review</th>
                <th>Date</th>
                <th>Status</th>
                <th colspan="2">Operation</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $limit = 10;
            if (isset($_GET['page'])) {
                $page = $_GET['page'];
            } else {
                $page = 1;
            }
            $offset = ($page - 1) * $limit;
            $query = "SELECT * from review ORDER BY id DESC LIMIT {$offset},{$limit}";
            $result = myquery($query);
            $rowno = 1;
            while ($row = mysqli_fetch_assoc($result)) {
                $user = getUserData($row['user_id']);
                $book = getBookData($row['book_id']);
                $disabled = 'disabled';
                $sts = 'Pending';
                if ($row['status'] == 1) $sts = "Accepted";
                if ($row['status'] == -1) $sts = "Rejected";
                if ($row['status'] == 0) $disabled = '';
                echo "<tr class='adminTableTr'><td>" . $row['id'] .
                    "</td><td>" . $user['username'] .
                    "</td><td>" . $book['name'] .
                    "</td><td>" . $row['rating'] .
                    "</td><td>" . $row['review'] .
                    "</td><td>" . $row['date'] .
                    "</td><td>" . $sts .
                    "</td><td><button name='edit' " . $disabled . " onclick='accept(" . $row['id'] . ',' . $rowno . ")' class='btn btn-success'>Accept</button> 
                  </td><td><button name='edit' " . $disabled . " onclick='reject(" . $row['id'] . ',' . $rowno . ")' class='btn btn-danger'>Reject</button> 
                  </td></tr>";
                $rowno++;
            }
            ?>
        </tbody>
    </table>
    <?php
    ?>
</div>

<div class="pagination">
    <ul id="pagin">
    </ul>
</div>
<script src="script.js"></script>
<script src="./scripts/review.js"></script>
<script>
    window.totalPages = Math.ceil(<?= $totalPage; ?>);
    pagination(totalPages, <?= $page; ?>, 'reviews');
    var keep = new Map();
</script>