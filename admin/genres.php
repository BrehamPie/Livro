<!-- Table of Genres -->
<?php
include './includes/sidebar.inc.php';
$totalPage = getSize('genre') / 30;
?>
<div class="container">
    <h1 class="text-center">Genres</h1>
    <table class="adminTable table">
        <colgroup></colgroup>
        <thead>
            <tr>
                <th>ID</th>
                <th>Genre Name</th>
                <th>Genre Name(English)</th>
                <th>Edit</th>

            </tr>
        </thead>
        <tbody>
        <tr>
        <td colspan="7" class="addRow"><a href="genre.php">Add+</a></td>
    </tr>
            <?php
            $limit = 30;
            if (isset($_GET['page'])) {
                $page = $_GET['page'];
            } else {
                $page = 1;
            }
            $offset = ($page - 1) * $limit;
            $query = "SELECT * from genre LIMIT {$offset},{$limit}";
            $result = myquery($query);
            while ($row = mysqli_fetch_row($result)) {
                $name = $row[1];
                $eng_name = $row[2];
                echo "<tr class='adminTableTr'><td>" . $row[0] .
                    "</td><td>" . $name .
                    "</td><td>" . $eng_name .
                    "</td><td><button name='edit' class='btn btn-primary'><a href='genre.php?id=$row[0]' style='text-decoration:none;color:white;'>EDIT</a></button> 
                  </td></tr>";
            }
            ?>
        </tbody>
        
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
    pagination(totalPages,<?=$page;?>,'genres');
</script>