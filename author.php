<!-- Page for a single author. -->
<?php
include './includes/header.inc.php'
?>
<?php
if (isset($_GET['id'])) {
    $a_id = $_GET['id'];
}else{
    header("Location: ./forbidden.php");
}
$authorData = getAuthorData($a_id);
$author_name = $authorData['name'];
$img = $authorData['img'];
$a_det = $authorData['about'];
?>
<!-- The sidebar contains all type of filters.For author page we don't need the author selection.So we select the author and hide the filter. -->
<input type="checkbox" class="form-check-input product_check" value="<?= $a_id; ?>" id="author" style="display: hidden;" checked>
<main>
    <div class="container-fluid allbook">
        <div class="row m-0">
            <div class="col-3 scc" id="filtering">
                <div class="bg-info text-center" style="position: sticky;top:0px;z-index:50;display: flex;justify-content: center;align-items: center;">
                    <h5><i class="fas fa-filter"></i>Filter Books</h5>
                    <hr>
                </div>
                <!-- Genre Filter -->
                <h6 class="text-center">Select Genre</h6>
                <ul class="list-group" style="height:30vh;overflow-y: scroll;overflow-x: hidden;">
                    <?php
                    $sql = "SELECT * FROM genre ";
                    $result = mysqli_query($connection, $sql);
                    while ($row = mysqli_fetch_assoc($result)) {
                        $id = $row['id'];
                        $name = $row['name'];
                    ?>
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            <div class="form-check">
                                <label for="<?= $id; ?>" class="form-check-label">
                                    <input type="checkbox" class="form-check-input product_check" value="<?= $id; ?>" id="genre">
                                    <?= $name; ?>
                                </label>
                            </div>
                            <span class="badge badge-primary badge-pill"><?= getCount('book_genre', 'genre_id', $id); ?></span>
                        </li>

                    <?php
                    }
                    ?>
                </ul>
                <hr>
                 <!-- Rating Filter -->
                <h6 class="text-center">Minimum Rating</h6>
                <ul class="list-group">
                    <li class="list-group-item">
                        <div class="form-check">
                            <label for="" class="form-check-label">
                                <input type="radio" name='rating' class="form-check-input product_check" value="1" id="rating">
                                <i class="fa fa-star"></i>
                            </label>
                        </div>
                    </li>
                    <li class="list-group-item">
                        <div class="form-check">
                            <label for="" class="form-check-label">
                                <input type="radio" name='rating' class="form-check-input product_check" value="2'" id="rating">
                                <i class="fa fa-star"></i>
                                <i class="fa fa-star"></i>
                            </label>
                        </div>
                    </li>
                    <li class="list-group-item">
                        <div class="form-check">
                            <label for="" class="form-check-label">
                                <input type="radio" name='rating' class="form-check-input product_check" value="3" id="rating">
                                <i class="fa fa-star"></i>
                                <i class="fa fa-star"></i>
                                <i class="fa fa-star"></i>
                            </label>
                        </div>
                    </li>
                    <li class="list-group-item">
                        <div class="form-check">
                            <label for="" class="form-check-label">
                                <input type="radio" name='rating' class="form-check-input product_check" value="4" id="rating">
                                <i class="fa fa-star"></i>
                                <i class="fa fa-star"></i>
                                <i class="fa fa-star"></i>
                                <i class="fa fa-star"></i>
                            </label>
                        </div>
                    </li>
                    <li class="list-group-item">
                        <div class="form-check">
                            <label for="" class="form-check-label">
                                <input type="radio" name='rating' class="form-check-input product_check" value="5" id="rating">
                                <i class="fa fa-star"></i>
                                <i class="fa fa-star"></i>
                                <i class="fa fa-star"></i>
                                <i class="fa fa-star"></i>
                                <i class="fa fa-star"></i>
                            </label>
                        </div>
                    </li>
                </ul>
            </div>
            <div class="col-9  ">
                <!-- Author's Details Div -->
                <div class="author-details" style="margin:50px;display: flex;">
                    <div class="author-card text-center" style="flex:1;">
                        <div class="ratio authorimg-responsive authorimg-circle" style="background-image: url(./assets/img/authors/<?= $img; ?>);"></div>
                        <div class="author-card-name">
                        </div>
                    </div>
                    <div style="margin-top: 10px;margin-left: 20px;flex: 5;">
                        <h4 te><?= $author_name; ?></h4>
                        <p>
                            <?= $a_det; ?>
                        </p>
                    </div>
                </div>
                <!-- Search Book of the current Author. -->
                <div class="searchbook bg-light">
                    <div>
                        <h4 style="font-size: 2vw;">Find Your Desired Book</h4>
                    </div>
                    <form class="input-group form-container" style="width: 60%;" action="#" method="POST">
                        <input type="text" class="form-control search-input" placeholder="Keyword" autofocus="autofocus" name="name" id='searchbox' oninput=bookSearch(this.value)>
                        <span class="input-group-btn">
                            <button class="btn btn-search" id="genre-search-button">
                                <i class="fas fa-search"></i>
                            </button>
                        </span>
                    </form>
                    <ul class='list-group' style="width:60%;border:none;" id='dataViewer'>
                    </ul>
                    <hr>
                </div>

                <div class="book-container">
                    <?php
                    $sql  = "SELECT * FROM book_author WHERE author_id ={$a_id}";
                    $result = mysqli_query($connection, $sql);
                    while ($row = mysqli_fetch_assoc($result)) {
                        $bookData = getBookData($row['book_id']);
                        $img = './assets/img/books/' . $bookData['img'];
                        $book_name = $bookData['name'];
                        $book_id = $bookData['id'];
                        $author_name = getAuthorListWithoutLink($book_id);
                    ?>

                        <div class="book-card">
                            <div class="book-card-img">
                                <img src="<?= $img; ?>" alt="<?= $img ?>" class="fit-img">
                            </div>
                            <div class="book-card-content">
                                <p class="mb-0"><?= $book_name; ?></p>
                                <small><?= $author_name; ?></small>
                            </div>
                            <div class="book-card-overlay" id="book-card-exchange-btn">
                                <button class="btn btn-primary btn-lg"><i class="fas fa-exchange-alt"></i>Exchange</button>
                            </div>
                            <div class="book-card-overlay" id="book-card-details-btn">
                                <button class="btn btn-dark btn-block" onclick="location.href='./book.php?book=<?= $book_id; ?>'">Details</button>
                            </div>
                        </div>
                    <?php
                    }
                    ?>
                </div>

            </div>
        </div>
    </div>

</main>
<script src="./scripts/author.js"></script>
<?php
include './includes/footer.inc.php';
?>