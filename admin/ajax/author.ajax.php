<!-- Insert Author Data into Database. -->
<?php
include '../includes/functions.inc.php';
$a_id = $_POST['a_id'];
$name = mysqli_real_escape_string($connection,$_POST['name']);
$name_eng = mysqli_real_escape_string($connection,$_POST['name_eng']);
$summary = mysqli_real_escape_string($connection,$_POST['summary']);
$filename = $a_id;
if($_POST['action']=='edit'){
        $sql = "UPDATE author SET
                name = '$name',
                name_eng = '$name_eng',
                about = '$summary'
                WHERE id = $a_id";
        myquery($sql); 
}
else{
    insertAuthor($name,$name_eng,$summary);
    $author_id = getLastID('author');
    $filename = $author_id;
    $a_id = $filename;
}
if (!file_exists($_FILES['filetoupload']['tmp_name']) || !is_uploaded_file($_FILES['filetoupload']['tmp_name'])) {
    //echo 'No upload';
} else {
    $target_dir = "../../assets/img/authors/";
    $uploadOk = 1;
    $target_file = $target_dir . basename($_FILES["filetoupload"]["name"]);
    $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
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
    if ($_FILES["filetoupload"]["size"] > 5000000) {
        echo "Sorry, your file is too large.";
        $uploadOk = 0;
    }
    // Allow certain file formats
    if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "webp") {
        echo "Sorry, only JPG, JPEG & PNG files are allowed.";
        $uploadOk = 0;
    }

    // Check if $uploadOk is set to 0 by an error
    if ($uploadOk == 0) {
        echo "Sorry, your file was not uploaded.";
        // if everything is ok, try to upload file
    } else {
        move_uploaded_file($source, $destination);
        $sql1 = "UPDATE author SET
                    img = '$basename'
                WHERE id = $a_id";
        myquery($sql1); 
    }
}
?>

<div class="text-center text-success mt-5">
    <p>Operation Successful.</p>
    <p>Going Back to Author Table.</p>
</div>