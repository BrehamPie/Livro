<!-- Reading History of the user. -->
<?php include './includes/header.inc.php';
$uid = $_GET['id'];

$res = getReadList($uid);
$userData = getUserData($uid);
?>
<main>
<div class="container table-responsive">
        <table class="table table-hover">
            <caption>Reading History of of <?=$userData['username'];?></caption>
            <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col"></th>
                    <th scope="col">Book</th>
                    <th scope="col">Author</th>
                    <th scope="col">Rating</th>
                    <th scope="col">Borrow Date</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $serial = 1;
                while ($row = mysqli_fetch_assoc($res)) {
                    $prod = getProductDataByProduct($row['product_id']);
                    $bookData = getBookData($prod['book_id']);
                    $author = getAuthorListWithLink($bookData['id']);
                    $imglink = './assets/img/books/' . $bookData['img'];
                    $rating = getRating($bookData['id'],$uid);
                ?>
                    <tr>
                   
                        <th scope="row"><?= $serial; ?></th>
                        <td><img src="<?= $imglink; ?>" alt="" height="100px"></td>
                        <td><a href="./book.php?book=<?=$b_id;?>"><?= $bookData['name']; ?></a> </td>
                        <td><?= $author; ?></td>
                        <td><?=$rating;?></td>
                        <td><?=$row['delivery_date'];?></td>
                    </tr>

                <?php
                    $serial++;
                }
                ?>
            </tbody>
        </table>
    </div>
</main>   



