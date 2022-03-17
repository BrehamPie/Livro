<!-- Handle Donation Data -->
<?php
require_once '../includes/functions.inc.php';
$user_id = $_POST['user_id'];
$lastID = getLastID('donation');

$target_dir = "../assets/img/donations/";
$uploadOk = 1;
$target_file = $target_dir . basename($_FILES["filetoupload"]["name"]);
$imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
$filename   = ++$lastID;
$basename   = $filename . "." . $imageFileType;
$source       = $_FILES["filetoupload"]["tmp_name"];
$destination  = "{$target_dir}/{$basename}";
$check = getimagesize($_FILES["filetoupload"]["tmp_name"]);
if ($check !== false) {
    $uploadOk = 1;
} else {
    echo "File is not an image.";
    $uploadOk = 0;
}
// Check file size
if ($_FILES["filetoupload"]["size"] > 500000) {
    echo "Sorry, your file is too large.";
    $uploadOk = 0;
}
// Allow certain file formats
if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "webp") {
    echo "Sorry, only JPG, JPEG,WEBP & PNG files are allowed.";
    $uploadOk = 0;
}

// Check if $uploadOk is set to 0 by an error
if ($uploadOk == 0) {
    echo "Sorry, your file was not uploaded.";
} else {
    $u_id = $user_id;
    $b_name = $_POST['bookname'];
    $a_name = $_POST['authorname'];
    $image = $basename;
    move_uploaded_file($source, $destination);
    insertDonation($user_id, $b_name, $a_name, $image);
    echo "<h4 class='text-center text-success mt-5'>Thanks For Your Donation.</h4>
   <p>We received your data. Our employee soon will contact with you to collect the book.You will be notified once we complete the verification and put the book in our library.</p>
   <h5 class='text-right'>Livro Team</h5>";
}
