<!-- Confirm Donation. -->
<?php
include '../includes/functions.inc.php';
$b_id = $_POST['b_id'];
$book = getBookData($b_id);
$authors = getAuthors($b_id);
$author = array();
foreach ($authors as $aid) {
    $tmp = getAuthorData($aid);
    array_push($author, $tmp['name']);
}
if ($_POST['action'] == 'idchange') {
    $genre = getGenres($b_id);
    $arr = array();
    $arr['name'] = $book['name'];
    $arr['author'] = $author;
    $arr['img'] = $book['img'];
    $ret = json_encode($arr);
    echo $ret;
}

if ($_POST['action'] == 'add') {
    $d_id = $_POST['d_id'];
    $b_id = $_POST['b_id'];
    insertProduct($b_id,$d_id);
    echo 
    '<div class="text-center text-success mt-5">
        <p>Operation Successful.</p>
        <p>Going Back to Donations Table.</p>
    </div>';
}
