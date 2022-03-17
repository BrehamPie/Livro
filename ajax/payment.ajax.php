<!-- Insert Payment Data -->
<?php
require_once '../includes/functions.inc.php';
$uid = $_POST['id'];
$userdata = getUserData($uid);
$sdate = $_POST['date'];
$plan = $_POST['plan'];
if ($plan == 'monthly') $books = 4;
else if ($plan == 'halfyearly') $books = 25;
else $books = 50;
$tnx = $_POST['tnx'];
insertSubscription($uid,$tnx,$books,$sdate);
?>
<p class='text-success'>Thanks For your payment. You will be notified once we verify Your Payment.</p>
<p class='text-success'>Going Back To Homepage....</p>