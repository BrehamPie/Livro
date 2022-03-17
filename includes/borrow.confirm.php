<!-- Confirmation for borrowing Book. -->
<?php
$b_id = $_GET['id'];
$bookData = getBookData($b_id);
$authors = getAuthors($b_id);
$author = getAuthorListWithoutLink($bookData['id']);
$deliverTime = strtotime($nextDeliveryDate);
$reqTime = strtotime($currentDate);

?>
<div class="container m-5 text-center" id='main'>
    <h4 class="mb-3">Book Request by <?= $userData['username']; ?></h4>
    <p>Book Name: <?= $bookData['name']; ?></p>
    <p>Writer: <?= $author; ?></p>
    <p>Receive Date: <?= $nextDeliveryDate; ?></p>
    <p>Please confirm if that's what you want.<br>Once you confirm you can't change it.</p>
    <button type="submit" class=" btn btn-success" name="confirm" id='confirm'>Confirm</button>
    <button type="submit" class=" btn btn-danger" name='cancel' id='cancel'>Cancel</button>
</div>
<script>
    window.userid = <?= $userData['id']; ?>;
    window.bookid = <?= $b_id; ?>;
    window.deliverydate = <?= $deliverTime; ?>;
    window.subid = <?= $sub_id; ?>;
    window.reqdate = <?= $reqTime; ?>;
</script>
<script src="./scripts/borrow.js">
</script>