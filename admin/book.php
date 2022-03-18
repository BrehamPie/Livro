<!-- Author edit/insert page -->
<?php include './includes/header.inc.php';
$row = null;
$name = null;
$engName = null;
$image = null;
$author_id = null;
$summary = null;
$action = 'add';
$id = -1;
$d_id = -1;
$allAuthors = array();
$allGenres = array();
if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $allAuthors = getAuthors($id);
    $bookData = getBookData($id);
    $allGenres = getGenres($id);
    $name = $bookData['name'];
    $engName = $bookData['name_eng'];
    $image = '../assets/img/books/' . $bookData['img'];
    $summary = $bookData['summary'];
    $action = 'edit';
}
if (isset($_GET['d_id'])) {
    $d_id = $_GET['d_id'];
    $donationData = getDonationData($d_id);
    $userData = getUserData($donationData['user_id']);
    $userName = $userData['username'];
    $name = $donationData['book_name'];
    $authors = explode(",", $donationData['authors_name']);
    $allAuthors = getAuthorsByName($authors);
    $img = $donationData['book_image'];
    $d_date = $donationData['donation_date'];
    $image = '../assets/img/donations/' . $img;
    $action = 'addfromdonation';
}

?>

<body>
    <div class="container mt-5" id='book_edit_page' style="z-index: 9999990;">
        <h4 class='text-center'>Book Edit/Insert Form</h4>
        <form action="" id='editbook' class="mt-2">
            <div class="row">
                <div class="col-4 border book_edit_img_col">
                    <img src="<?= $image; ?>" alt="" id='output' class="book_edit_img">
                    <div class="mt-3 ml-5">
                        <input type="file" name='filetoupload' onchange="loadFile(event)">
                    </div>
                </div>
                <div class="col-8 pt-2 border">
                    <div class="form-group row ml-0">
                        <div class="col-3">
                            <div class="input-group-text">Book Title</div>
                        </div>
                        <input type="text" name="title" id="title" value="<?= $name; ?>" class="form-control col-5 ml-3">
                    </div>
                    <div class="form-group row ml-0">
                        <div class="col-3">
                            <div class="input-group-text">Book Title(English)</div>
                        </div>
                        <input type="text" name="eng_title" id="eng_title" value="<?= $engName; ?>" class="form-control col-5 ml-3 ">
                    </div>
                    <div class="form-group row ml-0">
                        <div class="col-3">
                            <div class="input-group-text">Author</div>
                        </div>
                        <div class="col-6" onclick="changeZ('author')">
                            <select id="author-multiple-remove-button" placeholder="Select upto 3 Authors" multiple class=>
                                <?php
                                $query = myquery("SELECT * FROM author");
                                while ($row = mysqli_fetch_assoc($query)) {
                                    $a_id = $row['id'];
                                    $a_name = $row['name'];
                                    $a_name_eng = $row['name_eng'];
                                    $authorName = $a_name . '(' . $a_name_eng . ')';
                                    $selected = '';
                                    if (in_array($a_id, $allAuthors)) $selected = 'selected';
                                ?>
                                    <option value="<?= $a_id; ?>" <?= $selected; ?>><?= $authorName; ?></option>
                                <?php
                                }
                                ?>
                            </select>
                        </div>
                        <div>
                            <button class="btn btn-primary" onclick='window.open("./author.php");return false'>Add Author</button>
                        </div>
                    </div>
                    <div class="form-group row ml-0">
                        <div class="col-3">
                            <div class="input-group-text">Genre</div>
                        </div>
                        <div class="col-6" onclick="changeZ('genre')" id='gendiv'>
                            <select id="genre-multiple-remove-button" placeholder="Select upto 5 Genres" multiple class=>
                                <?php
                                $query = myquery("SELECT * FROM genre");
                                while ($row = mysqli_fetch_assoc($query)) {
                                    $g_id = $row['id'];
                                    $g_name = $row['name'];
                                    $g_name_eng = $row['name_eng'];
                                    $genreName = $g_name . '(' . $g_name_eng . ')';
                                    $selected = '';

                                    if (in_array($g_id, $allGenres)) $selected = 'selected';
                                ?>
                                    <option value="<?= $g_id; ?>" <?= $selected; ?>><?= $genreName; ?></option>
                                <?php
                                }
                                ?>
                            </select>
                        </div>
                    </div>
                    <div class="form-group row ml-0">
                        <div class="col-3">
                            <div class="input-group-text">Summary</div>
                        </div>
                        <textarea name="summary" id="summary" cols="30" rows="5" class="form-control col-5 ml-3"></textarea>
                    </div>
                </div>
            </div>
            <div style="display: flex;justify-content: center;"><button class='btn btn-success mt-5 text-center' id='submit'>Confirm</button></div>

        </form>
    </div>
</body>

<script>
    var action = '<?= $action; ?>';
    function changeZ(id) {
        var x = document.getElementById('gendiv');
        if (id == 'genre') x.style.zIndex = 100000000;
        else x.style.zIndex = 0;
    }
    $(document).ready(function() {
        var genre_id = $('#genre-multiple-remove-button');
        var author_id = $('#author-multiple-remove-button');
        var multipleCancelButton = new Choices('#genre-multiple-remove-button', {
            removeItemButton: true,
            maxItemCount: 5,
            searchResultLimit: 5,
            renderChoiceLimit: -1,
            searchEnabled: true,
            searchChoices: true,
            itemSelectText: '',
            paste: false
        });
        var multipleCancelButton = new Choices('#author-multiple-remove-button', {
            removeItemButton: true,
            maxItemCount: 5,
            searchResultLimit: 5,
            renderChoiceLimit: -1,
            searchEnabled: true,
            searchChoices: true,
            itemSelectText: '',
            paste: false
        });
        $("#submit").click(function(event) {

            var form = document.getElementById('editbook');
            var formData = new FormData(form);
            var action = '<?= $action; ?>';
            var id = '<?= $id; ?>';
            var did = '<?= $d_id; ?>'
            formData.append('author', author_id.val());
            formData.append('genre', genre_id.val());
            formData.append('action', action);
            formData.append('b_id', id);
            formData.append('d_id', did);
            event.preventDefault();
            $.ajax({
                url: './ajax/book.ajax.php',
                type: 'post',
                data: formData,
                contentType: false,
                processData: false,
                success: function(response) {
                    $('#book_edit_page').html(response);
                    window.setTimeout(function() {
                        window.location.href = "./books.php";
                    }, 1500);
                },
            });

        });

    });
    var loadFile = function(event) {
        var output = document.getElementById('output');
        output.src = URL.createObjectURL(event.target.files[0]);
        output.onload = function() {
            URL.revokeObjectURL(output.src) // free memory
        }
    };
</script>