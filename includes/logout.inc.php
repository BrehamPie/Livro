<!-- Destroy Session if user logs out -->
<?php
session_start();
session_destroy();
header("Location: ../index.php");
?>