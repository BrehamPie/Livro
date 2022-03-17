<?php
require_once './includes/header.inc.php';
//Check if user signed in.
if(!isset($_SESSION['userid'])){ 
    $_SESSION['redirected'] = 'donate';
    header("Location:./authentication.php");
}
else {
    require_once './includes/donateform.inc.php';
}
require_once './includes/footer.inc.php';
?>
