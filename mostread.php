<!-- Shows The List of most Read Books.Time Duration can be selected. -->
<?php
include './includes/header.inc.php';
?>
<style>

</style>
<?php
$dur = $_GET['dur'];
$word = 'All Time';
if ($dur == 'weekly') {
    $res = getMostReadedWeek();
    $word = 'This Week';
} else if ($dur == 'monthly') {
    $res = getMostReadedMonth();
    $word = 'This Month';
} else $res = getMostReaded();
?>
<main>
    <div class="container table-responsive">
        <table class="table table-hover">
            <caption>Most Read Books of <?= $word; ?></caption>
            <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col"></th>
                    <th scope="col">Book</th>
                    <th scope="col">Author</th>
                    <th scope="col">Genre</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $serial = 1;
                while ($row = mysqli_fetch_assoc($res)) {
                    $b_id = $row['book_id'];
                    $bookData = getBookData($b_id);
                    $authors = getAuthors($b_id);
                    $author = getAuthorListWithLink($b_id);
                    $imglink = './assets/img/books/' . $bookData['img'];
                ?>
                    <tr>

                        <th scope="row"><?= $serial; ?></th>
                        <td><img src="<?= $imglink; ?>" alt="" height="100px"></td>
                        <td><a href="./book.php?id=<?= $b_id; ?>"><?= $bookData['name']; ?></a> </td>
                        <td><?= $author; ?></td>
                        <td><?php
                            $gen = getGenres($b_id);
                            foreach ($gen as $g_id) {
                                $gData = getGenreData($g_id);
                                echo '<a href="./genre?id = ' . $gData['id'] . '">' . $gData['name'] . ' </a>';
                            }
                            ?>
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

<?php
include './includes/footer.inc.php';
?>