<!-- A table that shows all the books donated by a certain user. -->
<?php include './includes/header.inc.php';
if(!isset($_GET['id'])){
    header("Location: ./forbidden.php");
}
$uid = $_GET['id'];

$res = getDonateList($uid);
$userData = getUserData($uid);
?>
<main>
<div class="container table-responsive">
        <table class="table table-hover">
            <caption>Donation History of of <?=$userData['username'];?></caption>
            <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col"></th>
                    <th scope="col">Book</th>
                    <th scope="col">Author</th>
                    <th scope="col">Donation Date</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $serial = 1;
                while ($row = mysqli_fetch_assoc($res)) {
                    $bookData = getBookData($row['book_id']);
                    $authors = getAuthors($bookData['id']);
                    $author = getAuthorListWithLink($bookData['id']);
                    $imglink = './assets/img/books/' . $bookData['img'];
                ?>
                    <tr>
                   
                        <th scope="row"><?= $serial; ?></th>
                        <td><img src="<?= $imglink; ?>" alt="" height="100px"></td>
                        <td><a href="./book.php?id=<?=$bookData['id'];?>"><?= $bookData['name']; ?></a> </td>
                        <td><?= $author; ?></td>
                        <td><?=$row['receive_date'];?></td>
                    </tr>

                <?php
                    $serial++;
                }
                ?>
            </tbody>
        </table>
    </div>
</main>   



