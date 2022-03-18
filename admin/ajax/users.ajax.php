<?php
include '../includes/functions.inc.php';
$toChange = $_POST['keep'];
foreach ($toChange as $id) {
    $user = getUserData($id);
    $newrole = ($user['role'] == 0 ? 1 : 0);
    $sql = "UPDATE user SET
        role = $newrole
        WHERE id = $id";
    myquery($sql);
    echo $id . $user['role'] . $newrole;
}
