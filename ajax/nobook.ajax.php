<!-- User wants to get notified when book is available. -->
<?php
    require_once '../includes/functions.inc.php';
    insertBookNotification($_POST['id'],$_POST['bookid']);
?>
<h4 class="text-center text-success">You will be Notified Once the Book is Available Again.</h4>