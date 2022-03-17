<?php
require_once '../includes/functions.inc.php';
$name = $_POST['author'];
// Return Search Result of Authors.
$sql = "SELECT * FROM author WHERE name LIKE '$name' OR name_eng LIKE '$name'";
$result = myquery($sql);
while ($row = mysqli_fetch_assoc($result)) {
    $name = $row['name'];
    $a_id = $row['id'];
    $img  = $row['img'];
    if ($img == '' || $img == null) $img = '0.png';
    $imgsrc = "./assets/img/authors/" . $img;
?>
    <div class="author-card text-center" onclick="location.href='./author.php?id=<?= $a_id; ?>'">
        <div class="ratio authorimg-responsive authorimg-circle" style="background-image: url(./assets/img/authors/<?= $img; ?>);"></div>
        <div class="author-card-name">
            <p><?= $name; ?></p>
        </div>
    </div>
<?php
}
?>