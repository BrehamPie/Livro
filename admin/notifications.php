<!-- Notifications for Admins. -->
<?php
include './includes/header.inc.php';
$uid = $_SESSION['userid'];
$notis = prepareNotifications($uid);
$date = -1;
?>
<div class="container mt-2">
    <h4 class="text-primary">All Notifications</h4>
    <?php
    foreach($notis as $stmt) {
    ?>
        <div>
            <p><?= $stmt; ?></p>
        </div>
        <hr>
    <?php
    }
    ?>
</div>
<?php 
seenNoti($uid); 
include './includes/footer.inc.php';
?>
?>