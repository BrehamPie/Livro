<!-- Confirm book collection. -->
<?php
include '../includes/functions.inc.php';    
var_dump($_POST);
    $id = $_POST['id'];
    $sql = "UPDATE collect
            SET status = 1
            WHERE id = $id";
    myquery($sql);
    $colData = getCollectData($id);
    $borrowData = getBorrowData($colData['borrow_id']);
    $pid = $borrowData['product_id'];
    $sql = "UPDATE product
    SET 
        status = 1
    WHERE id = $pid ";
    myquery($sql);
    $prod = getProductDataByProduct($pid);
    sendBookNotification($prod['book_id']);
?>
