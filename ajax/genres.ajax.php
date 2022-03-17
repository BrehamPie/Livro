<?php
require_once '../includes/functions.inc.php';
$name = $_POST['genre'];
$sql1 = "SELECT * FROM genre WHERE name LIKE '$name' OR name_eng LIKE '$name'";
$result = mysqli_query($connection, $sql1);
print_r(mysqli_error($connection));
while ($row = mysqli_fetch_assoc($result)) {
$name = $row['name'];
?>
    <div>
        <a href="./genre.php?g_id=<?=$row['id'];?>" style="text-decoration:none;color:black;"><p><?= $name; ?></p></a>
    </div>
<?php
}
?>