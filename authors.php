<!-- Page showing all authors. -->
<!-- Known bug: Pagination After Searching Author. -->
<?php
include './includes/header.inc.php';
$totalPage = getSize('author') / 25;
?>

<main>
    <div class="container mt-5">
        <h3>Most Popular Authors</h3>
        <!-- Owl Carousel for slideshow. -->
        <div class="owl-carousel author_carousel owl-theme">
            <?php
            $query = getTrendingAuthors();
            while ($row = mysqli_fetch_assoc($query)) {
                $authorData = getAuthorData($row['author_id']);
                $author = $authorData['name'];
                $a_id = $authorData['id'];
                $img = $authorData['img'];
            ?>
                <div class="author-card text-center" onclick="location.href='./author.php?id=<?= $a_id; ?>'">
                    <div class="ratio authorimg-responsive authorimg-circle" style="background-image: url(./assets/img/authors/<?= $img; ?>);"></div>
                    <div class="author-card-name">
                        <p><?= $author; ?></p>
                    </div>
                </div>
            <?php
            }
            ?>
        </div>
        <hr>
        <!-- Author Search Box -->
        <div class="searchauthor" style="display:flex;align-items: center;justify-content: center; flex-direction: column;">
            <div>
                <h4 style="font-size: 2vw;">Search Your Favorite Author</h4>
            </div>
            <div class="input-group form-container" style="width: 60%;">
                <input type="text" name="search" class="form-control search-input" placeholder="Keyword" autofocus="autofocus" id="author-search" oninput=authorSearch(this.value)>
                <span class="input-group-btn">
                    <button class="btn btn-search" id="author-search-button">
                        <i class="fas fa-search"></i>
                    </button>
                </span>
            </div>
        </div>
        <hr>
        <!-- Authors List -->
        <div class="author-container">
            <?php
            $limit = 25;
            if (isset($_GET['page'])) {
                $page = $_GET['page'];
            } else {
                $page = 1;
            }
            $offset = ($page - 1) * $limit;
            $query = "SELECT * from author LIMIT {$offset},{$limit}";
            $result = myquery($query);
            while ($row = mysqli_fetch_assoc($result)) {
                $name = $row['name'];
                $a_id = $row['id'];
                $img  = $row['img'];
                if ($img == '' || $img == null) $img = '0.png';
                $imgsrc = "./assets/img/authors/" . $img;
            ?>
                <div class="author-card text-center" onclick="location.href='./author.php?id=<?= $a_id; ?>'">
                    <div class="ratio authorimg-responsive authorimg-circle" style="background-image: url(./assets/img/authors/<?= $img; ?>);"></div>
                    <div class="author-card-name">
                        <p><?= $name; ?></p>
                    </div>
                </div>
            <?php
            }
            ?>

        </div>

    </div>
    <div class="pagination">
        <ul id="pagin">
        </ul>
    </div>
</main>
<?php
include './includes/footer.inc.php';
?>
<script src="./script.js"></script>
<script src="./scripts/authors.js"></script>
<script>
    window.totalPages = Math.ceil(<?= $totalPage; ?>);
    pagination(totalPages, <?= $page; ?>, 'authors');
</script>