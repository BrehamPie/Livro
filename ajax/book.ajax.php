<?php
require_once '../includes/functions.inc.php';
// Insert review
$bid = $_POST['book'];
$uid = $_POST['uid'];
$rating = $_POST['rating'];
$review = mysqli_real_escape_string($connection, $_POST['review']);
insertReview($uid, $bid, $rating, $review);
