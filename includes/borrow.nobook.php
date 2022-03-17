<!-- Message shown when there's no available copy for users requested book. -->
<main>
    <div class="container m-5" id='nobook'>
        <h5 class='text-center'>Sorry. No Book is available currently.</h5>
        <div class="text-center">
            <p>Would You Like To Get Notified When the Book is Available?</p>
            <button class="btn btn-success" id='yes'>YES</button> <button class="btn btn-danger">NO</button>
        </div>
    </div>
</main>
<script>
    window.userid = <?=  $userData['id'] ?>;
    window.bookid = <?=$b_id ?>;
</script>
<script src="./scripts/nobook.js"></script>