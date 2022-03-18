<!-- Borrow Requests From Users. -->
<?php
include './includes/sidebar.inc.php';
$totalPage = getSize('subscription') / 10;
?>
<div class="container text-center" style="display: flex;justify-content:center;flex-direction:column">
    <h1 class="text-center">Books To Deliver</h1>
    <table class=" table table-bordered table-hover" id='table'>
        <thead class="bg-info">
            <tr>
                <th>#</th>
                <th>Sub ID</th>
                <th>User ID</th>
                <th>User Name</th>
                <th>Book Name</th>
                <th>Product ID</th>
                <th>Request Date</th>
                <th>Receive Date</th>
                <th>Status</th>
                <th>Operation</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $query = "SELECT * from borrow ORDER BY id DESC";
            $result = myquery($query);
            $rowno = 1;
            while ($row = mysqli_fetch_row($result)) {
                $subData = getSubscriptionDataBySub($row[1]);
                $userData  = getUserData($subData['user_id']);
                $proData = getProductDataByProduct($row[2]);
                $bookData = getBookData($proData['book_id']);
                $selected = '';
                if ($row[5] == 1) $selected = 'disabled';
                $sts = ($row[5]==1?'Delivered':'Yet To Deliver');
                echo "<tr class='adminTableTr'><td>" . $row[0] .
                    "</td><td>" . $row[1] .
                    "</td><td>" . $userData['id'] .
                    "</td><td>" . $userData['username'] .
                    "</td><td>" . $bookData['name'] .
                    "</td><td>" . $row[2] .
                    "</td><td>" . $row[3] .
                    "</td><td>" . $row[4] .
                    "</td><td>" . $sts .
                    "</td><td><button class='btn btn-success'" . $selected . " onclick='Delivered(" . $row[0] . ',' . $rowno . ")'>Deliver</button>
                    </td></tr>";
                $rowno++;
            }
            ?>
        </tbody>
    </table>
    <?php
    ?>
</div>
<script src="./scripts/request.js"></script>