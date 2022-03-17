<!-- Borrow Books From Library. -->
<?php
include './includes/header.inc.php';
// Check if user signed in first
if (!isset($_SESSION['userid'])) {
    $_SESSION['redirected'] = 'borrow';
    header("Location:./authentication.php");
}
$userData = getUserData($_SESSION['userid']);
$validUser = validateUser($_SESSION['userid']);
// Check If User filled all the data
if (!$validUser) {
    $_SESSION['redirected'] = 'borrow';
    header("Location:./setting.php");
}
// Check if the user is subscribed to borrow books.
$latestSubscription = getSubscriptionData($userData['id']);
if (is_null($latestSubscription)) {
    $_SESSION['redirected'] = 'borrow';
    header("Location:./pricing.php");
}
$sub_id = $latestSubscription['id'];
$bookRead = bookDelivered($sub_id);
$canRead = $latestSubscription['amount_of_books'];
// Check if user all ready completed his Subscription.
if ($bookRead == $canRead) {
    $_SESSION['redirected'] = 'borrow';
    header("Location:./pricing.php");
}
$b_id = $_GET['id'];
$prod = getProductData($b_id);
//Check if book is available to give.
if ($prod == null) {
    include "./includes/borrow.nobook.php";
    exit();
} else {
    $subscriptionDate = $latestSubscription['date'];
    $currentDate = date("Y-m-d");
    $lowerDate = date("Y-m-d", strtotime($currentDate . '+ 3 days'));
    $upperDate = date("Y-m-d", strtotime($lowerDate . '+ 7 days'));
    $nextDeliveryDate = $subscriptionDate;
    //User can request book to borrow only if current time satisfies the conditions.
    while ($nextDeliveryDate <= $currentDate) {
        $nextDeliveryDate = date("Y-m-d", strtotime($nextDeliveryDate . ' + 7 days'));
    }
    $lastReq = getLastDelivery($sub_id) ?? null;
    if ($nextDeliveryDate < $lowerDate || ($lastReq != null && $lastReq == $nextDeliveryDate)) {
        echo 
        '<main>
            <div class="container m-5">
                <h5 class="text-center">You can order againg after '.$nextDeliveryDate.'</h5>
            </div>
        </main>';
    } else
        include './includes/borrow.confirm.php';
}


include './includes/footer.inc.php';
