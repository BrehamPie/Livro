<!-- Add or edit genre. -->
<?php include './includes/header.inc.php';
$row = null;
$name = null;
$engName = null;
$image = null;
$genre_id = null;
$summary = null;
$action = 'add';
$id = -1;
if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $genreData = getgenreData($id);
    $name = $genreData['name'];
    $engName = $genreData['name_eng'];
    $action = 'edit';
}
?>

<body>
    <div class="container mt-5" id='genre_edit_page'>
        <h4 class='text-center'>Genre Edit/Insert Form</h4>
        <form action="" id='editgenre'>
            <div class="col-12 pt-2 border">
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
            </div>
            <div style="display: flex;justify-content: center;">
                <button type="" class='btn btn-success mt-5 text-center' id='submit'>Confirm</button>
            </div>
        </form>
    </div>
</body>

<script>
    var action = '<?= $action; ?>';
    $(document).ready(function() {
        $("#submit").click(function(event) {
            var form = document.getElementById('editgenre');
            var formData = new FormData(form);
            var action = '<?= $action; ?>';
            var id = '<?= $id; ?>';
            formData.append('action', action);
            formData.append('id', id);
            event.preventDefault();
            $.ajax({
                url: './ajax/genre.ajax.php',
                type: 'post',
                data: formData,
                contentType: false,
                processData: false,
                success: function(response) {
                    $('#genre_edit_page').html(response);
                    window.setTimeout(function() {
                        window.location.href = "./genres.php";
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