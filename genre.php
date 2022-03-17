<!-- See books of a certain genre -->
<?php
include './includes/header.inc.php';
if (!isset($_GET['id'])) {
    header("Location: ./forbidden.php");
}
$id = $_GET['id'];
$genData = getGenreData($id);
$genre = $genData['name'];
?>
<!-- The sidebar contains all type of filters.For genre page we don't need the genre selection.So we select the genre and hide the filter. -->
<input type="checkbox" class="form-check-input product_check" value="<?= $id; ?>" id="genre" style="display: hidden;" checked>
<main onload="bookSearch()">
    <div class="container-fluid allbook">
        <div class="row m-0">
            <div class="col-3 scc" id="filtering">
                <div class="bg-info text-center" style="position: sticky;top:0px;z-index:50;display: flex;justify-content: center;align-items: center;">
                    <h5><i class="fas fa-filter"></i>Filter Books</h5>
                    <hr>
                </div>
                <!-- Author Filter -->
                <h6 class="text-center">Select Author</h6>
                <ul class="list-group" style="height:30vh;overflow-y: scroll;overflow-x: hidden;">
                    <?php
                    $sql = "SELECT * FROM author ORDER BY 'name'";
                    $result = myquery($sql);
                    while ($row = mysqli_fetch_assoc($result)) {
                        $id = $row['id'];
                        $name = $row['name'];
                    ?>
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            <div class="form-check">
                                <label for="<?= $id; ?>" class="form-check-label">
                                    <input type="checkbox" class="form-check-input product_check" value="<?= $id; ?>" id="author">
                                    <?= $name; ?>
                                </label>
                            </div>
                            <span class="badge badge-primary badge-pill"><?= getCount('book_author', 'author_id', $id); ?></span>
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
            <div class="col-9 ">
                <div class="searchbook bg-light">
                    <div>
                        <h4 style="">Find Your Desired Book in <?= $genre; ?> Category</h4>
                    </div>
                    <form class="input-group form-container" style="width: 60%;" action="bookSearch.ajax.php" method="POST">
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
                    <!-- Data Filled From Ajax Query -->
                </div>

            </div>
        </div>
    </div>
</main>
<script src="./scripts/genre.js"></script>
<?php
include './includes/footer.inc.php';
?>