<!-- List of Borrowed Books That Needs to be collected. -->
<?php
include './includes/header.inc.php';
$totalPage = getSize('subscription') / 10;
?>
<div class="container text-center" style="display: flex;justify-content:center;flex-direction:column">
    <h1 class="text-center">Books To Collect</h1>
    <table class=" table table-bordered table-hover" id='table'>
        <thead class="bg-info">
            <tr>
                <th>#</th>
                <th>Borrow ID</th>
                <th>User ID</th>
                <th>User Name</th>
                <th>Book Name</th>
                <th>Product ID</th>
                <th>Receive Date</th>
                <th>Status</th>
                <th>Operation</th>
            </tr>
        </thead>
        <tbody>
            <?php

            $query = "SELECT * from collect ORDER BY id DESC";
            $result = myquery($query);
            if (!$result) {
                die('Query failed' . mysqli_error($connection));
            }
            $rowno = 1;
            while ($row = mysqli_fetch_row($result)) {
                $reqData = getBorrowData($row[1]);
                $subData = getSubscriptionDataBySub($reqData['subscription_id']);
                $userData  = getUserData($subData['user_id']);
                $proData = getProductDataByProduct($reqData['product_id']);
                $bookData = getBookData($proData['book_id']);
                $selected = '';
                $sts = 'To Collect';
                if ($row[3] == 1) {
                    $selected = 'disabled';
                    $sts = "Collected";
                }
                echo "<tr class='adminTableTr'><td>" . $row[0] .
                    "</td><td>" . $row[1] .
                    "</td><td>" . $userData['id'] .
                    "</td><td>" . $userData['username'] .
                    "</td><td>" . $bookData['name'] .
                    "</td><td>" . $proData['id'] .
                    "</td><td>" . $row[2] .
                    "</td><td>" . $sts .
                    "</td><td><button class='btn btn-success'" . $selected . " onclick='Delivered(" . $row[0] . ',' . $rowno . ")'>Received</button>
                    </td></tr>";
                $rowno++;
            }
            ?>
        </tbody>
    </table>
    <?php
    ?>
</div>


</body>
<script src="./scripts/collect.js">

</script>