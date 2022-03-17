<!-- Donation Form -->
<?php
$userData = getUserData($_SESSION['userid']);
$userName = $userData['username'];
$userId = $userData['id'];

?>
<script>
    window.userID = <?=$userId;?>
</script>
<main >
    <div class="container" id='donate'>
        <div>
            <h2 class="mt-5 mb-2" style="font-size: 3vw;text-align: center;">Book Donation Form</h2>
        </div>

        <form class="text-responsive" method="POST" enctype="multipart/form-data" id='donation_form' name='donation_form'>
            <div class="form-group row">
                <label class="col-sm-2">Donation by</label>
                <div class="col-sm-6">
                    <input type="text" class="form-control" name='username' value="<?= $userName; ?>" disabled>
                </div>
            </div>
            <div class="form-group row">
                <label class="col-sm-2">Book Title</label>
                <div class="col-sm-6">
                    <input type="text" class="form-control" name='bookname' placeholder="Title">
                    <small id="emailHelp" class="form-text text-muted">Spelling Should be Identical to Book.</small>
                </div>
            </div>
            <div class="form-group row">
                <label class="col-sm-2">Author</label>
                <div class="col-sm-6">
                    <input type="text" class="form-control" name='authorname' placeholder="Author">
                    <small id="emailHelp" class="form-text text-muted">Spelling Should be Identical to Book.</small>
                </div>
            </div>
            <div class="form-group row">
                <label class="col-sm-2">Cover Page of Book</label>
                <input type="file" class="form-control-file col-sm-3" accept='image/*' name='filetoupload' onchange="loadFile(event)" id='coverimg'>

            </div>
            <!-- Image is loaded after user uploads it -->
            <div >
                <img src="" alt="" id='output' height="200px" style="margin-left: 180px;">
            </div>

            <div class="form-check ml-5">
                <input type="checkbox" class="form-check-input" name='agree' id='conid'>
                <label class="form-check-label">I agree to the <a href="donationpolicy.php">Terms and Conditions</a></label>
            </div>
            <div class="mt-2 ml-5">
                <button type="submit" class="btn btn-primary text-center" name="submit" id='submit'>Submit</button>
            </div>
        </form>
    </div>
    </form>
</main>

<script src="./scripts/donation.js"></script>