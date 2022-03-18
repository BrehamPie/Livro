<!-- Current Status of all Available Products. -->
<?php
include './includes/sidebar.inc.php';
$totalPage = getSize('book') / 20;
?>
<div class="container text-center" style="display: flex;justify-content:center;flex-direction:column">
    <h1 class="text-center">Products</h1>
    <table class=" table table-bordered table-hover" id='table'>
        <thead class="bg-info">
            <tr>
                <th>#</th>
                <th>Book</th>
                <th>Donator</th>
                <th>Donation Date</th>
                <th>Current Status</th>

            </tr>
        </thead>
        <tbody>
            <?php
            $limit = 20;
            if (isset($_GET['page'])) {
                $page = $_GET['page'];
            } else {
                $page = 1;
            }
            $offset = ($page - 1) * $limit;
            $query = "SELECT * from product LIMIT {$offset},{$limit}";
            $result = mysqli_query($connection, $query);

            if (!$result) {
                die('Query failed' . mysqli_error($connection));
            }

            while ($row = mysqli_fetch_row($result)) {
                $book = getBookData($row[2]);
                $user = getDonator($row[0]);
                $stat = 'Available';
                if ($row[4] == 0) $stat = 'Borrowed';
                echo "<tr class='adminTableTr'><td>" . $row[0] .
                    "</td><td><a href='bookedit.php?b_id=" . $row[1] . "'>" . $book['name'] .
                    "</a></td><td>" . $user['username'] .
                    "</td><td>" . $row[3] .
                    "</td><td>" . $stat .
                    "</tr>";
            }
            ?>
        </tbody>
    </table>

    <?php
    ?>
</div>
<div class="pagination">
    <ul id="pagin">
    </ul>
</div>
<script src="script.js"></script>
<script>
    window.totalPages = Math.ceil(<?= $totalPage; ?>);
    pagination(totalPages,<?=$page;?>,'products');
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
    });
</script>