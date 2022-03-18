<!-- Add income/expense -->
<?php
require '../includes/functions.inc.php';
$date = date("Y-m-d", $_POST['id']);
$income = getIncomeOfMonth($date);
$expend = getExpenditureOfMonth($date);
?>
<div class="col-6">
    <table class="table table-bordered table-hover">
        <caption>Income</caption>
        <thead class="bg-success">
            <tr>
                <th>#</th>
                <th>Account</th>
                <th>Amount</th>
                <th>Date</th>
            </tr>
        </thead>
        <tbody id='incomebody'>
            <?php
            $rowNo = 1;
            while ($row = mysqli_fetch_assoc($income)) {
                $acnt = $row['account'];
                $amnt = $row['amount'];
                $date = $row['date'];
            ?>
                <tr>
                    <td><?= $rowNo; ?></td>
                    <td><?= $acnt; ?></td>
                    <td><?= $amnt; ?></td>
                    <td><?= $date; ?></td>
                </tr>
            <?php
                $rowNo++;
            }
            ?>
        </tbody>
    </table>
</div>
<div class="col-6">
    <table class="table table-bordered table-hover">
        <caption>Expenditure</caption>
        <thead class="bg-danger">
            <tr>
                <th>#</th>
                <th>Account</th>
                <th>Amount</th>
                <th>Date</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $rowNo = 1;
            while ($row = mysqli_fetch_assoc($expend)) {
                $acnt = $row['account'];
                $amnt = $row['amount'];
                $date = $row['date'];
            ?>
                <tr>
                    <td><?= $rowNo; ?></td>
                    <td><?= $acnt; ?></td>
                    <td><?= $amnt; ?></td>
                    <td><?= $date; ?></td>
                </tr>
            <?php
                $rowNo++;
            }
            ?>
        </tbody>
    </table>
</div>