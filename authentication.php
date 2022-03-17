<!-- User Signup Login Page -->
<?php
include './includes/header.inc.php';
$redirect = ''; // takes the message if we are redirected from some page.
if(isset($_SESSION['redirected'])){
 $redirect = "Please Login First";
 $reason = $_SESSION['redirected'];
 if($reason == 'donate'){
     $redirect.=" to Donate a Book"; // User tried to donate book without logging in.
 }
 if($reason == 'subscribe'){
     $redirect.=" to Subscribe"; // User tried to Subscribe to a plan without logging in.
 }
 if($reason == 'borrow'){
     $redirect.=" to Borrow a Book"; // User tried to borrow a book without logging in.
 }
 unset($_SESSION['redirected']);
}

?>

<div class="login-div" id='both_table'>
    <h4 class="text-center text-danger"><?=$redirect;?></h4>
    <p id='errorMessage'>  </p>
    <h4 class="text-center SorL reg" style="display: none;">Join Us Today.</h4>
    <h4 class="text-center SorL sign">Log In</h4>
    <!-- Registration Form Design -->
    <div class="reg-form" >
        <form action="login.ajax.php" class="register-form SorL reg" method="post" id='reg_form' style="display: none;">
            <input type="text" name="username" placeholder="Enter Username" required style="margin-bottom:0px ;"><br>
            <small style="margin-top: 0px;">Username can contain letters, numbers and periods only.</small>
            <input type="text" name="emailId" placeholder="Enter Email" required><br>
            <input type="password" name="password" placeholder="Enter Password" required style="margin-bottom:0px ;"><br>
            <small style="margin-top: 0px;">Password must be at least 6 character long.</small>
            <input type="password" name="password2" placeholder="Confirm Password" required><br>
            <button name="create" type="submit" id='registration'>Create</button>
            <p class="altermessage">Already Registered? <a href="#">Login</a> </p>
        </form>
        <!-- Login Form Design -->
        <form action="" method="post" class="login-form SorL sign" id='log_form'>
            <input type="text" name="username" placeholder="Username" required><br>
            <input type="password" name="password" placeholder="Enter Password" required><br>
            <button name="login" type="submit" id='login'>Login</button>
            <p class="altermessage">Don't have an account? <a href="#">Register</a> </p>
        </form>
    </div>
</div>
<?php
include './includes/footer.inc.php';
?>
<script src="scripts/authenticate.js"></script>
