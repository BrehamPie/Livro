<!-- Homepage -->
<?php
include './includes/header.inc.php';
if (!isset($_SESSION['userid']))
    $style = "style='display:none;'";
else $style = '';
?>
<!-- Banner -->
<div class="full_banner heading-banner mt-2">
    <h3>Welcome To Livro. A unique Book Sharing Service.</h3>
    <h6><a href="./aboutus.php">Learn More</a></h6>
</div>
<div class="home_container my-2  mb-0">
    <div class="trending">
        <h4>Trending Now</h4>
        <hr>
        <!-- Trending Now Owl Carousel -->
        <div class="trending_owl owl-carousel owl-theme mb-0">
            <?php
            $query = getTrendingBooks();
            while ($row = mysqli_fetch_assoc($query)) {
                $bookData = getBookData($row['book_id']);
                $img = $bookData['img'];
                $bookname = $bookData['name'];
                $author = getAuthorListWithoutLink($bookData['id']);
                $book_id = $bookData['id'];
            ?>
                <div class="book-card">
                    <div class="book-card-img">
                        <img src="./assets/img/books/<?= $img; ?>" alt="">
                    </div>
                    <div class="book-card-content mt-2">
                        <p class="mb-0"><?= $bookname; ?></p>
                        <small><?= $author; ?></small>
                    </div>
                    <div class="book-card-overlay" id="book-card-exchange-btn">
                        <button class="btn btn-primary btn-lg" onclick="location.href='./borrow.php?id=<?= $book_id; ?>'"><i class="fas fa-exchange-alt"></i>Borrow</button>
                    </div>
                    <div class="book-card-overlay" id="book-card-details-btn">
                        <button class="btn btn-dark btn-block" onclick="location.href='./book.php?id=<?= $book_id; ?>'">Details</button>
                    </div>
                </div>
            <?php
            }
            ?>

        </div>
        <div class="text-right mt-0">
            <p><a href="./mostread.php?dur=weekly"> See All>></a></p>
        </div>
    </div>
    <!-- Genre Boxes shows 10 genres randomly -->
    <h4 class="mt-5">Browse by Genre</h4>
    <hr>
    <div class="genre">
        <?php
        $sql = "SELECT * FROM genre ORDER BY RAND() LIMIT 10 ";
        $res = myquery($sql);
        while ($row = mysqli_fetch_assoc($res)) {
            $name = $row['name'];
            $id = $row['id'];
        ?>
            <div onclick="location.href='./genre.php?id=<?= $id; ?>'" style="cursor: pointer;">
                <p><?= $name; ?></p>
            </div>
        <?php
        }
        ?>
    </div>
    <div style="display: flex;flex-direction:row-reverse;">
        <a href="./genres.php" style="align-self:flex-end;">View All>>></a>
    </div>
    <!-- Add banners -->
    <div class="ada-banner full_banner mt-5">
    </div>
    <!-- Popular Authors Carousel -->
    <div class="mt-5">
        <h3>Most Popular Authors</h3>
        <div class="owl-carousel author_carousel owl-theme">
            <?php
            $query = getTrendingAuthors();
            while ($row = mysqli_fetch_assoc($query)) {
                $authorData = getAuthorData($row['author_id']);
                $author = $authorData['name'];
                $a_id = $authorData['id'];
                $img = $authorData['img'];
            ?>
                <div class="author-card text-center">
                    <div class="ratio authorimg-responsive authorimg-circle" style="background-image: url(./assets/img/authors/<?= $img; ?>);" onclick="location.href='./author.php?id=<?= $a_id; ?>'"></div>
                    <div class="author-card-name">
                        <p><?= $author; ?></p>
                    </div>
                </div>
            <?php
            }
            ?>
        </div>
    </div>
    <div style="display: flex;flex-direction:row-reverse;">
        <a href="./authors.php" style="align-self:flex-end;">View All>>></a>
    </div>
    <!-- Recently Donated Books -->
    <h4 class="mt-5">Recently Added </h4>
    <hr>
    <div class="recentad">

        <div id="owl-demo" class="owl-carousel recent owl-theme ">
            <?php
            $sql = "SELECT * FROM product ORDER BY  product.receive_date DESC LIMIT 10";
            $query = mysqli_query($connection, $sql);
            while ($row = mysqli_fetch_assoc($query)) {
                $bookData = getBookData($row['book_id']);
                $img = $bookData['img'];
                $bookname = $bookData['name'];
                /*  $author = $row['a_name'];*/
                $donationData = getDonationData($row['donation_id']);
                $userData = getUserData($donationData['user_id']);
                $donator = $userData['username'];
                $uid = $userData['id'];
                $book_id = $bookData['id'];
                $authors = getAuthorListWithLink($book_id);
            ?>
                <div class="recent-ad-items">
                    <div class="recent-ad-image">
                        <img src="./assets/img/books/<?= $img; ?>" alt="" class="" onclick="location.href='./book.php?id=<?= $book_id; ?>'">
                    </div>
                    <div class="recent-ad-details">
                        <div class="auth">
                            <h5><?= $bookname; ?></h5>
                            <h6> <small>by<?= $authors; ?></small> </h6>
                        </div>
                        <div class="don">
                            <p><small>added by</small> <a href="./user.php?id=<?= $uid; ?>"><?= $donator; ?></a></p>
                        </div>
                        <div class="recent-ad-button">
                            <button class="btn btn-primary" onclick="location.href='./borrow.php?id=<?= $book_id; ?>'">Borrow</button>
                        </div>
                    </div>
                </div>
            <?php
            }
            ?>
        </div>
    </div>
    <div class="trending mt-5" <?= $style; ?>>
            <!-- Shows books searched by user -->
        <h4>Based On Your Recent Search</h4>
        <hr>

        <div class="trending_owl owl-carousel owl-theme bg-dark mb-0">
            <?php
            $id = -1;
            if (!empty($_SESSION['userid'])) $id = $_SESSION['userid'];
            $query = getSearchedBooks($id);
            while ($row = mysqli_fetch_assoc($query)) {
                $bookData = getBookData($row['book_id']);
                $img = $bookData['img'];
                $bookname = $bookData['name'];
                $author = getAuthorListWithoutLink($bookData['id']);
                $book_id = $bookData['id'];
            ?>
                <div class="book-card">
                    <div class="book-card-img">
                        <img src="./assets/img/books/<?= $img; ?>" alt="">
                    </div>
                    <div class="book-card-content mt-2">
                        <p class="mb-0"><?= $bookname; ?></p>
                        <small><?= $author; ?></small>
                    </div>
                    <div class="book-card-overlay" id="book-card-exchange-btn">
                        <button class="btn btn-primary btn-lg" onclick="location.href='./borrow.php?id=<?= $book_id; ?>'"><i class="fas fa-exchange-alt"></i>Borrow</button>
                    </div>
                    <div class="book-card-overlay" id="book-card-details-btn">
                        <button class="btn btn-dark btn-block" onclick="location.href='./book.php?id=<?= $book_id; ?>'">Details</button>
                    </div>
                </div>
            <?php
            }
            ?>

        </div>
    </div>
    <div class="container mt-3" style="display: flex;justify-content:space-between;align-items:center;">
        <img src="./assets/img/banner/bookshopbd.png" alt="" height="200px" width="50%">
        <img src="./assets/img/banner/boibazar.png" alt="" height="200px">
    </div>
    <!-- Short Summary of Hall of Fames -->
    <div class="mt-3 ">
        <h4 class="text-center bg-dark text-white p-5">Hall Of Fame</h4>
    </div>
    <div class="ranker mt-5">
        <div class="topreader">
            <table class="table table-responsive table-dark">
                <caption>Top Readers</caption>
                <thead>
                    <tr>
                        <th>User</th>
                        <th>Book read</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $readers = getTopReader();
                    for ($i = 0; $i < 5; $i++) {
                        $row = mysqli_fetch_assoc($readers);
                        if ($row == null) break;
                        $userData = getUserData($row['user_id']);
                        $username = $userData['username'];
                        $read = $row['total_read'];
                    ?>
                        <tr>
                            <td><?= $username; ?></td>
                            <td><?= $read; ?></td>
                        </tr>
                    <?php
                    }
                    ?>

                </tbody>

            </table>
            <a class='vall' href="./halloffame.php">View All <i class="fas fa-angle-double-right"></i></a>
        </div>
        <div class="topreview">
            <table class="table table-responsive table-dark">
                <caption>Top Reviewers</caption>
                <thead>
                    <tr>
                        <th>User</th>
                        <th>Total Reviews</th>
                    </tr>
                </thead>
                <?php
                $readers = getTopReviewer();
                for ($i = 0; $i < 5; $i++) {
                    $row = mysqli_fetch_assoc($readers);
                    if ($row == null) break;
                    $userData = getUserData($row['user_id']);
                    $username = $userData['username'];
                    $review = $row['rev_cnt'];
                ?>
                    <tr>
                        <td><?= $username; ?></td>
                        <td><?= $review; ?></td>
                    </tr>
                <?php
                }
                ?>

            </table>
            <a class='vall' href="./halloffame.php">View All <i class="fas fa-angle-double-right"></i></a>
        </div>
        <div class="topdonate">
            <table class="table table-responsive table-dark">
                <caption>Top Donators</caption>
                <thead>
                    <tr>
                        <th>User</th>
                        <th>Book Donated</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $readers = getTopDonators();
                    for ($i = 0; $i < 5; $i++) {
                        $row = mysqli_fetch_assoc($readers);
                        if ($row == null) break;
                        $userData = getUserData($row['user_id']);
                        $username = $userData['username'];
                        $donated = $row['don_cnt'];
                    ?>
                        <tr>
                            <td><?= $username; ?></td>
                            <td><?= $donated; ?></td>
                        </tr>
                    <?php
                    }
                    ?>
                </tbody>

            </table>
            <a class='vall' href="./halloffame.php">View All <i class="fas fa-angle-double-right"></i></a>
        </div>
    </div>
</div>


<script src="./scripts/index.js"></script>

<?php
include './includes/footer.inc.php';
