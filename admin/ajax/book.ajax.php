<!-- Insert/Edit Details about book. -->
<?php
include '../includes/functions.inc.php';
$b_id = $_POST['b_id'];
$filename = $b_id;
$title = mysqli_real_escape_string($connection, $_POST['title']);
$eng_title = mysqli_real_escape_string($connection, $_POST['eng_title']);
$authors = explode(',', $_POST['author']);
$genre = explode(',', $_POST['genre']);
$summary = mysqli_real_escape_string($connection, $_POST['summary']);

if ($_POST['action'] == 'edit') {
        $sql = "UPDATE book SET
                name = '$title',
                name_eng = '$eng_title',
                summary = '$summary'
                WHERE id = $b_id";
        myquery($sql);
        $preAuthors = getAuthors($b_id);
        foreach ($preAuthors as $pre) {
                if (!in_array($pre, $authors)) {
                        $sql = "DELETE FROM book_author
                                 WHERE book_id = $b_id AND author_id = $pre";
                        myquery($sql);
                }
        }
        foreach ($authors as $a_id) {
                if (!in_array($a_id, $preAuthors)) {
                        $sql = "INSERT INTO book_author(book_id,author_id) VALUES ($b_id,$a_id)";
                        myquery($sql);
                }
        }
        $preGenre = getGenres($b_id);
        foreach ($preGenre as $pre) {
                if (!in_array($pre, $genre)) {
                        $sql = "DELETE FROM book_genre
                                 WHERE book_id = $b_id AND genre_id = $pre";
                        myquery($sql);
                }
        }
        foreach ($genre as $g_id) {
            if($g_id=='') continue;
                if (!in_array($g_id, $preGenre)) {
                        $sql = "INSERT INTO book_genre(book_id,genre_id) VALUES ($b_id,$g_id)";
                        myquery($sql);
                }
        }
} else {
        $sql = "INSERT INTO book(name,name_eng,summary)
                VALUES('$title','$eng_title','$summary')";
        myquery($sql);
        $b_id = getLastID('book');
        $filename = $b_id;
        foreach ($authors as $a_id) {
                $sql = "INSERT INTO book_author(book_id,author_id) VALUES ($b_id,$a_id)";
                myquery($sql);
        }

        foreach ($genre as $g_id) {
                if($g_id=='') continue;
                $sql = "INSERT INTO book_genre(book_id,genre_id) VALUES ($b_id,$g_id)";
                myquery($sql);
        }
}
if ($_POST['d_id'] != -1) {
        $d_id = $_POST['d_id'];
        $donationData = getDonationData($d_id);
        $img = $donationData['book_image'];
        $image = '../../assets/img/donations/' . $img;
        $imageFileType = strtolower(pathinfo($image, PATHINFO_EXTENSION));
        $basename   = $filename . "." . $imageFileType;
        $target_dir = "../../assets/img/books";
        $destination  = "{$target_dir}/{$basename}";
        $sql1 = "UPDATE book SET
        img = '$basename'
        WHERE id = $b_id";
        mysqli_query($connection, $sql1);
        copy($image, $destination);
}
if (!file_exists($_FILES['filetoupload']['tmp_name']) || !is_uploaded_file($_FILES['filetoupload']['tmp_name'])) {
        //nothing
} else {
        $target_dir = "../../assets/img/books";
        $uploadOk = 1;
        $target_file = $target_dir . basename($_FILES["filetoupload"]["name"]);
        $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
        $basename   = $filename . "." . $imageFileType; // 
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
        if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"  && $imageFileType != "webp") {
                echo "Sorry, only JPG, JPEG & PNG files are allowed.";
                $uploadOk = 0;
        }

        if ($uploadOk == 0) {
                echo "Sorry, your file was not uploaded.";
        } else {
                move_uploaded_file($source, $destination);
                $sql = "UPDATE book SET
                        img = '$basename'
                        WHERE id = $b_id";
                //echo $sql1;
                myquery($sql);
        }
}
?>

<div class="text-center text-success mt-5">
        <p>Operation Successful.</p>
        <p>Going Back to Books Table.</p>
</div>
