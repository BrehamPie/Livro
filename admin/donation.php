<!-- Add a Donated book to library with appropriate Data. -->
<?php
include './includes/header.inc.php';
$d_id = $_GET['d_id'];
$donationData = getDonationData($d_id);
$userData = getUserData($donationData['user_id']);
$userName = $userData['username'];
$book = $donationData['book_name'];
$author = $donationData['authors_name'];
$img = $donationData['book_image'];
$d_date = $donationData['donation_date'];
$dbBooks = getBookDataByName($book);
?>

<body>
    <main id='donate-full'>
        <h4 class="text-center mt-2">Donation Edit</h4>
        <div class="container mt-3" style="display:flex;align-items: center;justify-content: center;">
            <div class="row bg-light" style="width: 100%;">
                <div class="col-6 border ">
                    <h5 class="text-center">User Donation Data.</h5>
                    <div class="form-group row ml-0">
                        <div class="col-3">
                            <div class="input-group-text">Donation By</div>
                        </div>
                        <input type="text" name="username" id="username" value="<?= $userName; ?>" class="form-control col-5 ml-3">
                    </div>
                    <div class="form-group row ml-0">
                        <div class="col-3">
                            <div class="input-group-text">Book Title</div>
                        </div>
                        <input type="text" name="title" id="title" value="<?= $book; ?>" class="form-control col-5 ml-3">
                    </div>
                    <div class="form-group row ml-0">
                        <div class="col-3">
                            <div class="input-group-text">Author</div>
                        </div>
                        <input type="text" name="author" id="author" value="<?= $author; ?>" class="form-control col-5 ml-3">
                    </div>
                    <div class="book_edit_img_col m-2">
                        <img src="../assets/img/donations/<?= $img; ?>" alt="" id='output' class="book_edit_img">
                    </div>
                    <div class="d-flex justify-content-center flex-column align-items-center mb-2">
                        <small class="text-danger">Book Not Found?</small class="text-danger">
                        <button class="btn btn-primary" id='addtobase'> Add To Database</button>
                    </div>
                </div>
                <div class="col-6 border">
                    <h5 class="text-center">Books Found in Database.</h5>
                    <div class="form-group row ml-0">
                        <div class="col-3">
                            <div class="input-group-text">Book ID</div>
                        </div>
                        <select name="id" id="b_id" class='form-control col-4 ml-3'>
                            <option value="">Choose id</option>
                            <?php
                            foreach ($dbBooks as $dbid) {
                            ?>
                                <option value="<?= $dbid; ?>"><?= $dbid; ?></option>
                            <?php
                            }
                            ?>
                        </select>
                    </div>
                    <div class="form-group row ml-0">
                        <div class="col-3">
                            <div class="input-group-text">Book Title</div>
                        </div>
                        <input type="text" name="title" id="dbtitle" value="" class="form-control col-5 ml-3">
                    </div>
                    <div class="form-group row ml-0">
                        <div class="col-3">
                            <div class="input-group-text">Author</div>
                        </div>
                        <input type="text" name="title" id="dbauthor" value="" class="form-control col-5 ml-3">
                    </div>
                    <div class="book_edit_img_col m-2">
                        <img src="" alt="" id='dbimg' class="book_edit_img">
                    </div>
                    <div class='text-center mb-2'>
                        <button class="btn btn-primary" id='addproduct' disabled>Add Product</button>
                    </div>
                </div>
            </div>
        </div>
    </main>
</body>
<script>
    window.did = <?= $d_id; ?>;
    window.uid = <?= $userData['id']; ?>;
</script>
<script src="./scripts/donation.js">
</script>
<?php
include './includes/footer.inc.php'
?>