<!-- A simple table that shows the income and expenses. -->
<?php
include './includes/header.inc.php';
?>
<!-- Modal -->
<div class="modal fade" id="exampleModal1" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title text-center" id="exampleModalLabel">Financial Summary</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <table class="table table-bordered table-hover text-center">
                    <thead class="bg-success">
                        <tr>
                            <th>#</th>
                            <th>Month</th>
                            <th>Income</th>
                            <th>Expenditure</th>
                        </tr>
                    </thead>
                    <tbody id='incomebody'>
                        <?php
                        $startDate = "2021-01-01";
                        $curDate = date("Y-m-d");
                        $day = date("d", strtotime($curDate));
                        $date = date("Y-m-d", strtotime($curDate . '-' . $day . ' days'));
                        $date = date("Y-m-d", strtotime($date . '+ 1 days'));
                        while ($date >= $startDate) {
                            $time = strtotime($date);
                            $month = date("m", $time);
                            $year = date("Y", $time);
                            $monyr = date("F,Y", $time);
                            $amountIn = getIncomeOfMonthSummary($date);
                            $amountOut = getExpenditureOfMonthSummary($date);
                        ?>
                            <tr>
                                <td>#</td>
                                <td><?= $monyr; ?></td>
                                <td><?= $amountIn; ?></td>
                                <td><?= $amountOut; ?></td>
                            </tr>
                        <?php
                            $month--;
                            if ($month == 0) $month = 12;
                            $add = cal_days_in_month(CAL_GREGORIAN, $month, $year);
                            $date = date("Y-m-d", strtotime($date . '-' . $add . ' days'));
                        }
                        ?>
                    </tbody>
                </table>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="exampleModal2" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title text-center" id="exampleModalLabel">New Transaction</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="" class="form" id='transactionadd'>
                    <div class="form-group">
                        <label for="tdate">Transaction Date:</label><input type="date" name="tdate" id="tdate" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="ttype">Type of Transaction:</label>
                        <select name="ttype" id="" class="form-control">
                            <option value="income">Income</option>
                            <option value="expend">Expenditure</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="tacnt">Account Name:</label><input type="text" name="tacnt" id="tacnt" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="tamnt">Amount:</label><input type="number" name="tamnt" id="tamnt" class="form-control">
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button class="btn btn-primary" id='newfin'>Submit</button>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
<div class="container">
    <form action="" class="form-inline mt-5 mb-2">
        <div class="form-group">
            <label for="Month">Choose Month:</label>
            <select name="Month" id="financemonth" class="form-control">
                <option value="">Select a Month</option>
                <?php
                $startDate = "2021-01-01";
                $curDate = date("Y-m-d");
                $day = date("d", strtotime($curDate));
                $date = date("Y-m-d", strtotime($curDate . '-' . $day . ' days'));
                $date = date("Y-m-d", strtotime($date . '+ 1 days'));
                while ($date >= $startDate) {
                    $time = strtotime($date);
                    $month = date("m", $time);
                    $year = date("Y", $time);
                    $monyr = date("F,Y", $time);
                ?>
                    <option value="<?= $time; ?>"><?= $monyr; ?></option>
                <?php
                    $month--;
                    if ($month == 0) $month = 12;
                    $add = cal_days_in_month(CAL_GREGORIAN, $month, $year);
                    $date = date("Y-m-d", strtotime($date . '-' . $add . ' days'));
                    echo $monyr . ' ';
                }
                ?>
            </select>
        </div>
    </form>
    <div class="text-right">
        <button class="btn btn-success" data-toggle="modal" data-target="#exampleModal2">Add Transaction</button>
        <button class="btn btn-primary" data-toggle="modal" data-target="#exampleModal1">See Summary</button>
    </div>
    <div class="row" id='financetable'>
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
                </tbody>
            </table>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        $('#financemonth').on('change', function(e) {
            var optionSelected = $("option:selected", this);
            var valueSelected = this.value;
            if (valueSelected == '') return;
            console.log(valueSelected);
            $.ajax({
                url: './ajax/finance.ajax.php',
                type: 'post',
                data: {
                    id: valueSelected
                },
                success: function(response) {
                    $('#financetable').html(response);
                },
            });
        });
        $('#newfin').on('click', function() {
            console.log('clicked');
            var form = document.getElementById('transactionadd');
            var finance = new FormData(form);
            $.ajax({
                url: './ajax/financemodal.ajax.php',
                type: 'post',
                data: finance,
                contentType: false,
                processData: false,
                success: function(response) {
                    console.log(response);
                    $('#exampleModal2').modal('toggle');
                }
            })
        });
    })
</script>