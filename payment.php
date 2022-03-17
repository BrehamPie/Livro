<!-- Make payment for the selected plan. -->
<?php
include './includes/header.inc.php';
// check if user signed in first.
if (!isset($_SESSION['userid'])) { 
    $_SESSION['redirected'] = 'subscribe';
    header("Location:./authentication.php");
}
$plan = $_GET['plan'];
$id = $_SESSION['userid'];
if ($plan == 'monthly') {
    $money = 100;
}
if ($plan == 'halfyearly') {
    $money = 550;
}
if ($plan == 'yearly') {
    $money = 1100;
}
?>

<main>
    <div class="container text-center mt-5 " id='payment'>
        <div class="container h-100">
            <div class="row h-100 justify-content-center align-items-center">
                <div class="col-10 col-md-8 col-lg-6">
                    <p>Please choose your starting date.You will receive your books from that day.</p>
                    <div class="container">
                        <div class="form-group">
                            <div class="input-group date" id="datetimepicker1" data-target-input="nearest">
                                <input type="text" class="form-control datetimepicker-input" data-target="#datetimepicker1" />
                                <div class="input-group-append" data-target="#datetimepicker1" data-toggle="datetimepicker">
                                    <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <h6>Currently we only support <span><img src="./assets/img/logos/bkash.png" alt="" height="50px"></span> for payment.</h6>
                    <p>Please pay &#2547; <?= $money; ?> to this number <strong>01712-345678</strong> and enter your TnxID.</p>
                    <div class="form-group">
                        <label for="tnxid">TnxID</label>
                        <input type="text" class="form-control tnxid" id="tnxid" name="tnxid" required>
                    </div>
                    <button class="btn btn-primary btn-customized" id=pay>Submit</button>
                </div>
            </div>
        </div>
    </div>
</main>
<?php
include './includes/footer.inc.php';
?>
<script>
    window.user_id = <?= $id; ?>;
    window.plan = '<?= $plan; ?>';
</script>
<script src="./scripts/payment.js"></script>