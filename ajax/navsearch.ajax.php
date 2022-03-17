<?php
require_once '../includes/functions.inc.php';


// Handles navigation bar search
$name = $_POST['name'];
if(strlen($name)==0) exit();
$stmt = searchBook($name);
while ($row = mysqli_fetch_assoc($stmt)) {
    $book = $row['name'];
    $author = getAuthorListWithoutLink($row['id']);
    $img = $row['img'];
    $bid = $row['id'];
?>
    <a href="./book.php?id=<?=$bid;?>">
        <li class="list-group-item list-group-item-action" style="border-top:none;border-radius: 0%;display:flex">
            <div class="ml-5">
                <img src="./assets/img/books/<?= $img; ?>" alt="" height="50px">
            </div>
            <div class="" style="display: flex;flex-direction: column;margin-left: 10px;">
                <p class='mb-0'> <?= $book; ?></p>
                <small><?= $author; ?></small>
            </div>
        </li>
    </a>


<?php
}
?>