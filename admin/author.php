<!-- Author Edit Insert Page -->
<?php include './includes/header.inc.php';
$row = null;
$name = null;
$engName = null;
$image = null;
$author_id = null;
$summary = null;
$action = 'add';
$id = -1;
if (isset($_GET['a_id'])) {
    $id = $_GET['a_id'];
    $authorData = getAuthorData($id);
    $name = $authorData['name'];
    $engName = $authorData['name_eng'];
    $image = '../assets/img/authors/' . $authorData['img'];
    $summary = $authorData['about'];
    $action = 'edit';
}

?>
<body>
    <div class="container mt-5" id='author_edit_page'>
        <h4 class='text-center'>Author Edit/Insert Form</h4>
        <form action="" id='editauthor'>
            <div class="row">
                <div class="col-4 border author_edit_img_col">
                    <img src="<?= $image; ?>" alt="" id='output' class="author_edit_img">
                    <div class="mt-3 ml-5">
                        <input type="file" name='filetoupload' onchange="loadFile(event)" accept="image/*">
                    </div>
                </div>
                <div class="col-8 pt-2 border">
                    <div class="form-group row ml-0">
                        <div class="col-3">
                            <div class="input-group-text">Name</div>
                        </div>
                        <input type="text" name="name" id="name" value="<?= $name; ?>" class="form-control col-5 ml-3">
                    </div>
                    <div class="form-group row ml-0">
                        <div class="col-3">
                            <div class="input-group-text">Name(English)</div>
                        </div>
                        <input type="text" name="name_eng" id="name_eng" value="<?= $engName; ?>" class="form-control col-5 ml-3 ">
                    </div>
                    <div class="form-group row ml-0">
                        <div class="col-3">
                            <div class="input-group-text">Summary</div>
                        </div>
                        <textarea name="summary" id="summary" cols="30" rows="5" class="form-control col-5 ml-3"><?= $summary; ?></textarea>
                    </div>
                </div>
            </div>
            <div style="display: flex;justify-content: center;"><button type="" class='btn btn-success mt-5 text-center' id='submit'>Confirm</button></div>

        </form>
    </div>
</body>

<script>
    var action = '<?= $action; ?>';
    $(document).ready(function() {
        $("#submit").click(function(event) {
            var form = document.getElementById('editauthor');
            var formData = new FormData(form);
            var action = '<?= $action; ?>';
            var id = '<?= $id; ?>';
            console.log(formData);
            formData.append('action', action);
            formData.append('a_id', id);
            event.preventDefault();
            $.ajax({
                url: './ajax/author.ajax.php',
                type: 'post',
                data: formData,
                contentType: false,
                processData: false,
                success: function(response) {
                    $('#author_edit_page').html(response);
                    window.setTimeout(function() {
                        window.location.href = "./author.php";
                    }, 2000);
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