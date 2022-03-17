<?php
include '../includes/functions.inc.php';
session_start();
//Confirm Borrow Request.
$book_id = $_POST['bookid'];
$sub_id = $_POST['subid'];
$rec_date = date("Y-m-d", $_POST['deliverydate']);
$ord_date = date("Y-m-d", $_POST['reqdate']);
$product = getProductData($book_id);
$userData = getUserData($_SESSION['userid']);
$name = $userData['username'];
insertRequest($product['id'], $sub_id, $ord_date, $rec_date);
?>
<p>Thanks for confirming your request.You will receive your book on due date.Please keep your contact number on so that we can reach to you.Don't forget to return your book if you have taken any previously.Your cooperation is much appreciate.</p>
<p class='text-right fw-bolder font-weight-bold'>Livro Team</p>