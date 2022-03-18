<!-- Homepage of admin showing different updates. -->
<?php
    include './includes/header.inc.php';
?>
<div class="full_banner heading-banner mt-2">
    <h2>Thinking is the hardest work there is, which is probably the reason so few engage in it.</h2>
    <h3>~ Henry Ford</h3>
</div>
<div class="container">
    <h4 class='text-center text-info'>RECENT UPDATES </h4>
    <div class="subscrption-block">
        <h5 class='text-center text-info'>New Subscriptions</h5>
    </div>
    <?php
    //..............SUBSCRIPTION..............//
    $query = "SELECT * FROM subscription ORDER BY date DESC LIMIT 5";
    $result = mysqli_query($connection, $query);
    while ($row = mysqli_fetch_assoc($result)) {
        $userData = getUserData($row['user_id']);
        $name = $userData['username'];
        $books = $row['amount_of_books'];
        $color = 'text-success';$stmt = 'Accepted';
        if ($row['status'] == 0) { $color = 'text-primary';$stmt = 'Pending';}
        if ($row['status'] == -1){ $color = 'text-danger';$stmt = 'Rejected';}
    ?>
        <div class='border p-2'>
            <p><strong><?= $name; ?>(id: <?= $row['user_id']; ?>)</strong> Subscribed for <?= $books; ?> books with Transaction ID: <strong> <?= $row['tnx_id']; ?></strong> </p>
            <p>Status :
                <strong class="<?= $color; ?>"><?= $stmt; ?> </strong>
            </p>
        </div>

    <?php
    }
    echo "<a class='paginationLink3' href='./subscriptions.php'>Check all and Update...</a>";
    ?>

    <div class="react-block mt-5">
        <h5 class='text-center text-info'>New Reacts</h5>
    </div>
    <?php
    //..................RATING..............//
    $query = "SELECT * FROM review ORDER BY date DESC LIMIT 5";
    $result = mysqli_query($connection, $query);
    while ($row = mysqli_fetch_assoc($result)) {
        $userData = getUserData($row['user_id']);
        $bookData = getBookData($row['book_id']);
        $name = $userData['username'];
        $book = $bookData['name'];
        $what = 'review';
        if ($row['review'] != NULL) $what = 'rating';
        $color = 'text-success';$stmt = 'Accepted';
        if ($row['status'] == 0) { $color = 'text-primary';$stmt = 'Pending';}
        if ($row['status'] == -1){ $color = 'text-danger';$stmt = 'Rejected';}
    ?>
        <div class='border p-2'>
            <p><strong><?= $name; ?>(id: <?= $row['user_id']; ?>)</strong> Submitted a <?= $what; ?> for
                <strong class="text-primary"> <?= $book; ?></strong>
            </p>
            <p>Status :
                <strong class="<?= $color; ?>"><?= $stmt; ?> </strong>
            </p>
        </div>

    <?php
    }
    echo "<a class='paginationLink3' href='./reviews.php'>Check all and Update...</a>";

    //......................DONATION...........................//
    ?>

    <div class="react-block mt-5 ">
        <h5 class='text-center text-info'>New Donations</h5>
    </div>
    <?php
    $query = "SELECT * FROM donation ORDER BY donation_date DESC LIMIT 5";
    $result = mysqli_query($connection, $query);
    while ($row = mysqli_fetch_assoc($result)) {
        $userData = getUserData($row['user_id']);
        $name = $userData['username'];
        $book = $row['book_name'];
        $author = $row['authors_name'];
        $color = 'text-success';$stmt = 'Accepted';
        if ($row['status'] == 0) { $color = 'text-primary';$stmt = 'Pending';}
        if ($row['status'] == -1){ $color = 'text-danger';$stmt = 'Rejected';}

    ?>
        <div class='border p-2'>
            <p><strong><?= $name; ?>(id: <?= $row['user_id']; ?>)</strong> Donated a new book:
                <br>
                Name: <strong class="text-secondary"> <?= $book; ?></strong>

                <br>
                Author: <strong class="text-secondary"> <?= $author; ?></strong>

                <br>
                Status: <strong class="<?=$color;?>"> <?= $stmt; ?></strong>

        </div>

    <?php
    }
    echo "<a class='paginationLink3' href='./donations.php'>Check all and Update...</a>";

    ?>
</div>
<?php
    include './includes/footer.inc.php';
?>
