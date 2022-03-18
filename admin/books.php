<!-- Books List -->
<?php
include './includes/sidebar.inc.php';
$totalPage = getSize('book') / 30;
?>
<div class="container">
    <h1 class="text-center">Books</h1>
    <table class="table table-bordered table-hover">
        <thead class="bg-info">
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Name(English)</th>
                <th>Author Name</th>
                <th>Summary</th>
                <th>Image</th>
                <th>Edit</th>

            </tr>
        </thead>
        <tbody>
            <td colspan="7" class="addRow"><a href="book.php">Add+</a></td>
            </tr>
            <?php
            $limit = 30;
            if (isset($_GET['page'])) {
                $page = $_GET['page'];
            } else {
                $page = 1;
            }
            $offset = ($page - 1) * $limit;
            $query = "SELECT * from book LIMIT {$offset},{$limit}";
            $result = mysqli_query($connection, $query);
            if (!$result) {
                die('Query failed' . mysqli_error($connection));
            }
            while ($row = mysqli_fetch_row($result)) {
                $summary = $row[4];
                $authors = getAuthors($row[0]);
                $author = '';
                foreach ($authors as $aid) {
                    $authorData = getAuthorData($aid);
                    $author .= $authorData['name'];
                    $author .= ',';
                }
                $author = substr($author, 0, -1);
                $imglink = '../assets/img/books/' . $row[3];
                if (is_null($row[3]) || $row[3] == '') $imglink = '../assets/img/books/0.jpg';
                if (strlen($summary) > 500) $summary = substr($summary, 0, 495);
                while (strlen($summary) && $summary[-1] != ' ')
                    $summary = rtrim($summary, $summary[-1]);
                $summary .= '...';
                echo "<tr class='adminTableTr'><td>" . $row[0] .
                    "</td><td>" . $row[1] .
                    "</td><td>" . $row[2] .
                    "</td><td>" . $author .
                    "</td><td>" . $summary .
                    "</td><td><a href='$imglink' id='img'><img src='$imglink' height='100px'>" .
                    "</td><td><button name='edit' class='btn btn-primary'><a href='book.php?id=$row[0]' style='text-decoration:none;color:white;'>EDIT</a></button> 
                  </td></tr>";
            }
            ?>
        </tbody>
    </table>

</div>
<div class="pagination">
    <ul id="pagin">
    </ul>
</div>
<script src="script.js"></script>
<script>
    window.totalPages = Math.ceil(<?= $totalPage; ?>);
    $(document).ready(function() {
        $('.adminTableTr').magnificPopup({
            type: 'image',
            delegate: 'a#img',
            mainClass: 'mfp-with-zoom', // this class is for CSS animation below
            zoom: {
                enabled: true, // By default it's false, so don't forget to enable it

                duration: 300, // duration of the effect, in milliseconds
                easing: 'ease-in-out', // CSS transition easing function
            }
        });
        pagination(totalPages, <?= $page; ?>, 'books');
    });
</script>