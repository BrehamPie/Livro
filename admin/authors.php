<!-- Authors List -->
<?php
include './includes/sidebar.inc.php';
$totalPage = getSize('author') / 10;
?>
<div class="container">
    <h1 class="text-center">Authors</h1>
    <table class="adminTable table">
        <colgroup></colgroup>
        <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Name(English)</th>
                <th>About Author</th>
                <th>Image</th>
                <th>Edit</th>

            </tr>
        </thead>
        <tbody>
            <tr>
                <td colspan="7" class="addRow"><a href="author.php">Add+</a></td>
            </tr>
            <?php
            $limit = 30;
            if (isset($_GET['page'])) {
                $page = $_GET['page'];
            } else {
                $page = 1;
            }
            $offset = ($page - 1) * $limit;
            $query = "SELECT * from author LIMIT {$offset},{$limit}";
            $result = mysqli_query($connection, $query);
            if (!$result) {
                die('Query failed' . mysqli_error($connection));
            }

            while ($row = mysqli_fetch_row($result)) {
                $name = $row[1];
                $eng_name = $row[2];
                $imglink = $row[3] ?? '0.png';
                if ($imglink == '') $imglink = '0.png';
                $imglink = '../assets/img/authors/' . $imglink;
                $summary = $row[4];
                if (strlen($summary) > 500) $summary = substr($summary, 0, 495);
                while (strlen($summary) && $summary[-1] != ' ')
                    $summary = rtrim($summary, $summary[-1]);
                $summary .= '...';
                echo "<tr class='adminTableTr'><td>" . $row[0] .
                    "</td><td>" . $name .
                    "</td><td>" . $eng_name .
                    "</td><td>" . $summary .
                    "</td><td><a href='$imglink' id='img'><img src='$imglink' height='100px' width='100px'>" .
                    "</td><td><button name='edit' class='btn btn-primary'><a href='author.php?a_id=$row[0]' style='text-decoration:none;color:white;'>EDIT</a></button> 
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
    console.log(window.totalPages);
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
        pagination(totalPages, <?= $page; ?>, 'authors');
    });
</script>