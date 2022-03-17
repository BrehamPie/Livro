<!-- Users select their desired plan from shown options. -->
<?php
include './includes/header.inc.php';
$redirect = '';
// Check if user is redirected from somewhere.
if (isset($_SESSION['redirected'])) {
    $redirect = "Please Subscribe ";
    $reason = $_SESSION['redirected'];
    if ($reason == 'borrow') {
        $redirect .= "to Borrow a Book";
    }
    unset($_SESSION['redirected']);
}

?>


<body>
    <h4 class="text-center text-danger"><?= $redirect; ?></h4>
    <section class="price-table">
        <div class="container">
            <h1>SUBSCRIPTION PLANS</h1>
            <div class="row" style="justify-content: center;">
                <div class="col-3">
                    <div class="single-price">
                        <div class="price-head">
                            <h2>4 books</h2>
                            <p>100 &#2547;</p>
                        </div>
                        <div class="price-content">
                            <ul>
                                <li><i class="fa fa-check-circle"></i>1 month duration.</li>
                                <li><i class="fa fa-times-circle"></i>You Save &#2547;0.</li>
                                <li><i class="fa fa-times-circle"></i>No Order Postpone.</li>
                            </ul>
                        </div>
                        <div class="price-bottom">
                            <a href="payment.php?plan=monthly" class="buy-btn">Subscribe</a>
                        </div>
                    </div>
                </div>
                <div class="col-3">
                    <div class="single-price">
                        <div class="price-head">
                            <h2>25 books</h2>
                            <p>550 &#2547;</p>
                        </div>
                        <div class="price-content">
                            <ul>
                                <li><i class="fa fa-check-circle"></i>Apporx. 6 months</li>
                                <li><i class="fa fa-check-circle"></i>You save &#2547;50.</li>
                                <li><i class="fa fa-times-circle"></i>
                                    Limited Order Postpone.
                                </li>
                            </ul>
                        </div>
                        <div class="price-bottom">
                            <a href="payment.php?plan=halfyearly" class="buy-btn">Subscribe</a>
                        </div>
                    </div>
                </div>
                <div class="col-3">
                    <div class="single-price">
                        <div class="price-head">
                            <h2>50 BOOKS</h2>
                            <p>1100 &#2547;</span>
                            </p>
                        </div>
                        <div class="price-content">
                            <ul>
                                <li><i class="fa fa-check-circle"></i>Approx. 1 year.</li>
                                <li><i class="fa fa-check-circle"></i>You save &#2547;100.</li>
                                <li><i class="fa fa-check-circle"></i>Unlimited Order Postpone.</li>
                            </ul>
                        </div>
                        <div class="price-bottom">
                            <a href="payment.php?plan=yearly" class="buy-btn">Subscribe</a>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </section>

    <?php
    include './includes/footer.inc.php';
    ?>