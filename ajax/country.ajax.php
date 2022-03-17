<?php
require_once '../includes/functions.inc.php';
//Showing District according to division 
if ($_POST['action'] == 'district') {
    $division_id = $_POST["division_id"];
    $result = mysqli_query($connection, "SELECT * FROM district where division_id = $division_id");
    echo '<option value="">Select District</option>';

    while ($row = mysqli_fetch_array($result)) {
        echo '<option value="' . $row["id"] . '">' . $row["name"] . '</option>';
    }
} else {
    $district_id = $_POST["district_id"];
    //Showing upazilla according to district.
    $result = mysqli_query($connection, "SELECT * FROM upazila where district_id = $district_id");
    echo '<option value="">Select Upazila</option>';

    while ($row = mysqli_fetch_array($result)) {
        echo '<option value="' . $row["id"] . '">' . $row["name"] . '</option>';
    }
}
