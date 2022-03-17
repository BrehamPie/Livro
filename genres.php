<!-- Show All genres -->
<?php
include './includes/header.inc.php';
?>
<main>
    <div class="container mt-5">
        <div class="searchbook bg-light">
            <div>
                <h4 style="font-size: 2vw;">Find Your Desired Genre</h4>
            </div>
            <form class="input-group form-container" style="width: 60%;" action="genreSearch.ajax.php" method="POST">
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
        <hr>
        <div class="genre">
            <?php
            $sql = "SELECT * FROM genre";
            $res = myquery($sql);
            while ($row = mysqli_fetch_assoc($res)) {
                $name = $row['name'];
            ?>
                <div>
                    <a href="./genre.php?id=<?= $row['id'];?>" style="text-decoration:none;color:black;">
                        <p><?= $name; ?></p>
                    </a>
                </div>
            <?php
            }
            ?>
        </div>
    </div>

    </div>
</main>
<script src="./scripts/genres.js">
</script>
<?php
include './includes/footer.inc.php';
?>

