List of Users.
<?php
include './includes/header.inc.php';
$totalPage = getSize('user') / 10;
?>
<div class="container text-center" style="display: flex;justify-content:center;flex-direction:column">
    <h1 class="text-center">USERS</h1>
    <div class="text-right m-2">
        <button class='btn btn-primary' style="display:none;" id='apply' onclick="ApplyChange()">Apply</button>
    </div>

    <table class="table table-hover table-bordered">
        <thead class="bg-info">
            <tr>
                <th>#</th>
                <th>Username</th>
                <th>Email Id</th>
                <th>Full Name</th>
                <th>Mobile Number</th>
                <th>Div.ID</th>
                <th>Dis.ID</th>
                <th>Upa.ID</th>
                <th>Local Address</th>
                <th>Role</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $limit = 10;
            if (isset($_GET['page'])) {
                $page = $_GET['page'];
            } else {
                $page = 1;
            }
            $offset = ($page - 1) * $limit;
            $query = "SELECT * from user LIMIT {$offset},{$limit}";
            $result = mysqli_query($connection, $query);
            if (!$result) {
                die('Query failed' . mysqli_error($connection));
            }

            while ($row = mysqli_fetch_assoc($result)) {
                $adsel = '';
                $usel = '';
                if ($row['role'] == 0) $adsel = 'selected';
                else $usel = 'selected';
                echo "<tr class='adminTableTr'><td>" . $row['id'] .
                    "</td><td>" . $row['username'] .
                    "</td><td>" . $row['email'] .
                    "</td><td>" . $row['fullname'] .
                    "</td><td>" . $row['phone'] .
                    "</td><td>" . $row['division'] .
                    "</td><td>" . $row['district'] .
                    "</td><td>" . $row['upazila'] .
                    "</td><td>" . $row['local_address'] .
                    "</td><td> <select name='role' onchange='Change(" . $row['id'] . ")'>
                        <option value='admin'" . $adsel . ">Admin</option>
                        <option value='user'" . $usel . ">User</option>
                    </select></td>
                     </tr>";
            }
            ?>
        </tbody>
    </table>
    <?php
    ?>
</div>

<div class="pagination mt-2">
    <ul id="pagin">
    </ul>
</div>
<script src="./script.js"></script>
<script src="./scripts/users.js"></script>
<script>
    window.totalPages = Math.ceil(<?= $totalPage; ?>);
    console.log(window.totalPages);
    pagination(totalPages, <?= $page; ?>, 'users');
</script>