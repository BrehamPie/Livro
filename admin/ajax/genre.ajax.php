<!-- Insert/Edit Genre Description. -->
<?php
include '../includes/functions.inc.php';

$g_id = $_POST['id'];
$name = mysqli_real_escape_string($connection,$_POST['name']);
$name_eng = mysqli_real_escape_string($connection,$_POST['name_eng']);

$filename = $g_id;
if($_POST['action']=='edit'){
        $sql = "UPDATE genre SET
                name = '$name',
                name_eng = '$name_eng'
                WHERE id = $g_id";
        myquery($sql);
}
else{
    $sql = "INSERT INTO genre(name,name_eng) VALUES('$name','$name_eng')";
    myquery($sql);
}
?>
<div class="text-center">
    <p>Operation Successful.</p>
    <p>Going Back to Genre Table.</p>

</div>