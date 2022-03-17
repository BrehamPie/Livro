<?php
// Handle Searching of Book
require_once '../includes/functions.inc.php';
$name = $_POST['bookName'];

if (isset($_POST['author'])) {
    $temp_author = array($_POST['author']);
    $author = '(';
    foreach ($temp_author as $b) {
        foreach ($b as $a) { {
                $a = (int) $a;
                $author .= $a;
                $author .= ',';
            }
        }
    }
    $author[strlen($author) - 1] = ')';
} else {
    $size = getLastID('author');
    $author = '(';
    for ($a = 1; $a <= $size; $a++) {
        $author .= $a;
        $author .= ',';
    }
    $author[strlen($author) - 1] = ')';
}
if (isset($_POST['genre'])) {
    $temp_genre = array($_POST['genre']);
    $genre = '(';
    foreach ($temp_genre as $b) {
        foreach ($b as $a) { {
                $a = (int) $a;
                $genre .= $a;
                $genre .= ',';
            }
        }
    }
    $genre[strlen($genre) - 1] = ')';
} else {
    $size = getLastID('genre');
    $genre = '(';
    for ($a = 1; $a <= $size; $a++) {
        $genre .= $a;
        $genre .= ',';
    }
    $genre[strlen($genre) - 1] = ')';
}
if (isset($_POST['rating'])) {
    $rating = array($_POST['rating']);
    $lo = 5;
    foreach ($rating as $b) {
        foreach ($b as $a) { {
                $a = (int) $a;
                $lo = min($lo, $a);
            }
        }
    }
} else {
    $lo = 0;
}
$sql1 = "SELECT id FROM book WHERE name LIKE '$name' OR name_eng LIKE '$name'";
$sql2 = "SELECT book_id FROM book_author WHERE book_id IN($sql1) AND author_id IN $author";
$sql3 = "SELECT book_id FROM book_genre WHERE book_id IN ($sql2) AND genre_id IN $genre";
$sql4 = "SELECT sub.*, AVG(review.rating) as rating FROM ($sql3) as sub LEFT JOIN review
        ON sub.book_id = review.book_id GROUP BY sub.book_id";
$sql5 = "SELECT * FROM ($sql4) as sub WHERE sub.rating>=$lo OR sub.rating IS NULL";
$result = myquery($sql5);
while ($row = mysqli_fetch_assoc($result)) {
    $bookData = getBookData($row['book_id']);
    $img = $bookData['img'];
    if ($img == null || $img == '') $img = '0.jpg';
    $img = './assets/img/books/' . $img;
    $book = $bookData['name'];
    $author = getAuthorListWithoutLink($bookData['id']);
    $bid = $bookData['id'];
?>

    <div class="book-card">
        <div class="book-card-img">
            <img src="<?= $img; ?>" alt="<?= $img ?>" class="fit-img">
        </div>
        <div class="book-card-content">
            <p class="mb-0"><?= $book; ?></p>
            <small><?= $author; ?></small>
        </div>
        <div class="book-card-overlay" id="book-card-exchange-btn">
            <button class="btn btn-primary btn-lg" onclick="location.href='./borrow.php?id=<?= $bid; ?>'"><i class="fas fa-exchange-alt"></i>Borrow</button>
        </div>
        <div class="book-card-overlay" id="book-card-details-btn">
            <button class="btn btn-dark btn-block" onclick="location.href='./book.php?id=<?= $bid; ?>'">Details</button>
        </div>
    </div>
<?php
}
?>