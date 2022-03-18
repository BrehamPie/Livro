<?php
include '../includes/functions.inc.php';
$id = $_POST['id'];
$action = $_POST['keep'];
if ($action == 'yes') $action = 1;
else $action = -1;
updateSubscription($id,$action);
