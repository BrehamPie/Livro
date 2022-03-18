<!-- Subscription Payment Verification. -->
<?php
include './includes/sidebar.inc.php';

$totalPage = getSize('subscription') / 10;
?>

<div class="container text-center" style="display: flex;justify-content:center;flex-direction:column">
    <h1 class="text-center">SUBSCRIPTION</h1>
    <table class=" table table-bordered table-hover" id='table'>
        <thead class="bg-info">
            <tr>
                <th>#</th>
                <th>User Id</th>
                <th>Start Date</th>
                <th>Total Books</th>
                <th>Transaction Id</th>
                <th>Payment Status</th>
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

            $query = "SELECT * from subscription ORDER BY id DESC LIMIT {$offset},{$limit} ";
            $result = myquery($query);
            $rowno = 1;
            while ($row = mysqli_fetch_row($result)) {
                $status = $row[5];
                $disabled = '';
                if ($status != 0) $disabled = 'disabled';
                if ($status == '0') $status = 'Pending';
                if ($status == '1') $status = 'Approved';
                if ($status == '-1') $status = 'Rejected';
                echo "<tr class='adminTableTr'><td>" . $row[0] .
                    "</td><td>" . $row[1] .
                    "</td><td>" . $row[4] .
                    "</td><td>" . $row[3] .
                    "</td><td>" . $row[2] .
                    "</td><td>" . $status .
                    "</td><td><button name='edit' " . $disabled . " onclick='accept(" . $row[0] . ',' . $rowno . ")' class='btn btn-success'>Accept</button> 
                  </td><td><button name='edit' " . $disabled . " onclick='reject(" . $row[0] . ',' . $rowno . ")' class='btn btn-danger'>Reject</button> 
                  </td></tr>";
                $rowno++;
            }
            ?>
        </tbody>
    </table>
    <div class="pagination mt-2">
        <ul id="pagin">
        </ul>
    </div>
</div>

<script src="script.js"></script>
<script src="./scripts/subscriptions.js"></script>
<script>
    window.totalPages = Math.ceil(<?= $totalPage; ?>);
    pagination(totalPages, <?= $page; ?>, 'subscriptions');
</script>