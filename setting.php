<!-- Basic User info Setting. -->
<?php
include './includes/header.inc.php';
$uid = $_SESSION['userid'];
$userData = getUserData($uid);

$curFullName = $userData['fullname'];
$curPhone = $userData['phone'];
$curDiv = $userData['division'];
$curDis = $userData['district'];
$curUpa =  $userData['upazila'];
$curLoc =  $userData['local_address'];
$curAbt = $userData['about'];
$basename = $userData['img'];
$redirect = '';
if (isset($_SESSION['redirected'])) {
    $redirect = "Please Complete Your Profile First";
    $reason = $_SESSION['redirected'];
    if ($reason == 'donate') {
        $redirect .= " to Donate a Book";
    }
    if ($reason == 'subscribe') {
        $redirect .= " to Subscribe";
    }
    if ($reason == 'borrow') {
        $redirect .= " to Borrow a Book";
    }
    unset($_SESSION['redirected']);
}

?>


<main class="container">
    <h4 class="text-center text-danger"><?= $redirect; ?></h4>
    <div style="display: flex;align-items: center;margin-bottom: 0;">
        <p>Setting</p>
    </div>
    <hr style="margin-top: 0px;">
    <div class="data">
        <h6>General Info</h6>
        <hr style="color: aqua;">
        <hr>
        <div class="form">

            <form action="#" class="form-group" method="POST" enctype="multipart/form-data" id='general_data'>
                <div class="form-group row ml-0">
                    <div class="col-3">
                        <div class="input-group-text">Full name</div>
                    </div>
                    <input type="text" name="full_name" id="full_name" value="<?= $curFullName; ?>" class="form-control col-5">
                </div>
                <div class="form-group row ml-0">
                    <div class="col-3">
                        <div class="input-group-text">Phone Number</div>
                    </div>
                    <input type="tel" name="phone" id="phone" value='<?= $curPhone; ?>' class="form-control col-5">
                </div>
                <div class="form-group row ml-0">
                    <div class="col-3">
                        <div class="input-group-text">Division</div>
                    </div>
                    <select name="division" id="division-dropdown" class="form-control col-5">
                        <option value="">Select Division</option>
                        <?php
                        $result = mysqli_query($connection, "SELECT * FROM division");
                        while ($row = mysqli_fetch_array($result)) {
                            $selected = ' ';
                            echo $row['id'] . ' ' . $division . '<br>';
                            if ($row['id'] == $curDiv) $selected = 'selected';
                        ?>
                            <option value="<?= $row['id'] ?>" <?= $selected; ?>><?php echo $row["name"]; ?></option>
                        <?php
                        }
                        ?>
                    </select>
                </div>
                <div class="form-group row ml-0">
                    <div class="col-3">
                        <div class="input-group-text">District</div>
                    </div>
                    <select name="district" id="district-dropdown" class="form-control col-5">
                        <?php
                        if (!is_null($curDiv)) {
                            $result = mysqli_query($connection, "SELECT * FROM district where division_id = $curDiv");
                            echo '<option value="">Select District First</option>';
                            while ($row = mysqli_fetch_array($result)) {
                                $selected = '';
                                if ($curDis == $row['id']) $selected = 'selected';
                                echo '<option value="' . $row['id'] . '"' . $selected . '>' . $row["name"] . '</option>';
                            }
                        }
                        ?>
                    </select>
                </div>
                <div class="form-group row ml-0">
                    <div class="col-3">
                        <div class="input-group-text">Upazila</div>
                    </div>
                    <select name="upazila" id="upazila-dropdown" class="form-control col-5">
                        <?php
                        if (!is_null($curDis)) {
                            $result = mysqli_query($connection, "SELECT * FROM upazila where district_id = $curDis");
                            echo '<option value="">Select District First</option>';
                            while ($row = mysqli_fetch_array($result)) {
                                $selected = '';
                                if ($curUpa == $row['id']) $selected = 'selected';
                                echo '<option value="' . $row['id'] . '"' . $selected . '>' . $row["name"] . '</option>';
                            }
                        }
                        ?>
                    </select>
                </div>
                <div class="form-group row ml-0">
                    <div class="col-3">
                        <div class="input-group-text">Local Address</div>
                    </div>
                    <textarea name="local_ad" id="local_ad" cols="30" rows="5" class="form-control col-5"><?= $curLoc; ?></textarea>
                </div>
        </div>
        <div class="form-group row ml-0">
            <div class="col-3">
                <div class="input-group-text">About Yourself</div>
            </div>
            <textarea name="about" id="about" cols="30" rows="5" class="form-control col-5"><?= $curAbt; ?></textarea>
        </div>
        <div class="form-group row ml-0">
            <div class="input-group col-5 mt-2">
                <div class="input-group-prepend">
                    <div class="input-group-text">Profile Picture</div>
                </div>
                <div class="col-7 mt-1">
                    <input type="file" class="form-control-file" name="filetoupload" accept="image/*">
                </div>
            </div>

        </div>
        <div class="input-group col-5 mt-2">
            <button name="update" type="submit" class="btn btn-info" id='general_update'>Update</button>
        </div>
        </form>
        <p id="info" class='text-center text-success'></p>
    </div>
    <hr>
    <h6>Security</h6>
    <hr>
    <hr>
    <p id="passinfo" class='text-center text-info'></p>
    <form action="user.ajax.php" method="POST" id="pass_form">
        <div class="container">
            <p id="res" class=text-center></p>
        </div>
        <div class="form-group">
            <div class="form-group row ml-0">
                <div class="col-3">
                    <div class="input-group-text">Old Password</div>
                </div>
                <input type="password" name="old_pass" id="password" placeholder="" class="form-control col-5">
            </div>
            <div class="form-group row ml-0 ">
                <div class="col-3">
                    <div class="input-group-text">New Password</div>
                </div>
                <input type="password" name="new_pass" id="new_pass" placeholder="" class="form-control col-5">
            </div>
            <div class="form-group row ml-0">
                <div class="col-3">
                    <div class="input-group-text">Confirm New Password</div>
                </div>
                <input type="password" name="new_pass2" id="new_pass2" placeholder="" class="form-control col-5">
            </div>
            <div class="input-group col-5 mt-2">
                <button name="security_update" type="submit" class="btn btn-info" id='password_update'>Update</button>
            </div>
        </div>
    </form>



</main>

<?php
include './includes/footer.inc.php';
?>
<script src="./scripts/setting.js">

</script>