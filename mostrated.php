<!-- List of Highest Rated books. -->
<?php include './includes/header.inc.php';
?>
<main>
    <div class="container">
        <table class="table table-hover table-bordered">
            <caption>Highest Rated Books of Our Library</caption>
            <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col"></th>
                    <th scope="col">Book</th>
                    <th scope="col">Author</th>
                    <th scope="col">Genre</th>
                    <th scope="col">Rating</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $res = getMostRated();
                $serial = 1;
                while ($row = mysqli_fetch_assoc($res)) {
                    $b_id = $row['book_id'];
                    $bookData = getBookData($b_id);
                    $authors = getAuthors($b_id);
                    $rating = round($row['arating'], 2);
                    $author = getAuthorListWithLink($b_id);
                    $imglink = './assets/img/books/' . $bookData['img'];
                    $genre = getGenreListWithLink($b_id);
                ?>
                    <tr>
                        <th scope="row"><?= $serial; ?></th>
                        <td><img src="<?= $imglink; ?>" alt="" height="100px"></td>
                        <td><a href="./book.php?id=<?= $b_id; ?>"><?= $bookData['name']; ?></a> </td>
                        <td><?= $author; ?></td>
                        <td><?= $genre; ?></td>
                        <td><?= $rating; ?></td>
                    </tr>

                <?php
                    $serial++;
                    if ($serial == 51) break;
                }
                ?>
            </tbody>
        </table>
    </div>
</main>
<?php include './includes/footer.inc.php';
?>