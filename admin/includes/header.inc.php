<?php
require_once 'functions.inc.php';
ob_start();
session_start();
?>
<?php
if (empty($_SESSION['userid']) || $_SESSION['role'] != '0') {
    header('HTTP/1.0 403 Forbidden', TRUE, 403);
    die(header('location: /error.php'));
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="stylesheet" href="../assets/bootstrap/css/bootstrap.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" integrity="sha512-iBBXm8fW90+nuLcSKlbmrPcLa0OT92xO1BIsZ+ywDWZCvqsWgccV3gFoRBv0z+8dLJgyAHIhR35VZc2oM/gI1w==" crossorigin="anonymous" />
    <link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/font-awesome/4.2.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="../assets/fontawesome-5.15.3/css/all.css">
    <link rel="stylesheet" href="../assets/OwlCarousel2-2.3.4/dist/assets/owl.carousel.css">
    <link rel="stylesheet" href="./style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/magnific-popup.js/1.0.0/magnific-popup.css" integrity="sha512-4a1cMhe/aUH16AEYAveWIJFFyebDjy5LQXr/J/08dc0btKQynlrwcmLrij0Hje8EWF6ToHCEAllhvGYaZqm+OA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <script src="../assets/js/popper.min.js"></script>
    <script src="../assets/js/jquery-3.6.0.min.js"></script>
    <script src="../assets/bootstrap/js/bootstrap.js"></script>
    <script src='../assets/OwlCarousel2-2.3.4/dist/owl.carousel.js'></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.22.2/moment.min.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/tempusdominus-bootstrap-4/5.0.1/js/tempusdominus-bootstrap-4.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/tempusdominus-bootstrap-4/5.0.1/css/tempusdominus-bootstrap-4.min.css" />
    <!-- magnific popup -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/magnific-popup.js/1.0.0/jquery.magnific-popup.js" integrity="sha512-/jeu5pizOsnKAR+vn28EbhN5jDSPTTfRzlHZh8qSqB77ckQd3cOyzCG9zo20+O7ZOywiguSe+0ud+8HQMgHH9A==" crossorigin="anonymous"></script>
    <!-- Choices VanillaJS -->
    <link rel="stylesheet" href="./includes/choices.css">
    <script src="https://cdn.jsdelivr.net/gh/bbbootstrap/libraries@main/choices.min.js"></script>
    <title>Admin</title>
</head>

<body>

    <header>
        <div class="navbar_container">
            <!-- This checkbox is used for hamburger -->
            <input type="checkbox" name="" id="check">
            <!-- Livro Logo -->
            <div class="logo_container">
                <a href="index.php"><img src="../assets/img/logos/logo.png" alt=""></a>
                <p class='text-center text-light'>Admin</p>
            </div>
            <div class="nav-btn">
                <div class="nav-links">
                    <ul>
                        <li class="nav-link" style="--i: .6s">
                            <a href="./donations.php">Donations</a>
                        </li>
                        <li class="nav-link" style="--i: .6s">
                            <a href="./subscriptions.php">Subscriptions</a>
                        </li>
                        <li class="nav-link" style="--i: .6s">
                            <a href="./requests.php">Requests</a>
                        </li>
                        <li class="nav-link" style="--i: .85s">
                            <a href="./database.php" id="browse_book">Add to Database<i class="fas fa-caret-down"></i></a>
                            <div class="dropdown">
                                <ul>
                                    <li class="dropdown-link">
                                        <a href="./book.php">Book</a>
                                    </li>
                                    <li class="dropdown-link">
                                        <a href="./author.php">Author</a>
                                    </li>
                                    <li class="dropdown-link">
                                        <a href="./genre.php">Genre</a>
                                    </li>
                                    <div class="arrow"></div>
                                </ul>
                            </div>
                        </li>
                        <li class="nav-link" style="--i: 1.0s">
                            <a href="./reviews.php">Reviews</a>
                        </li>
                        <li class="nav-link" style="--i: 1.0s">
                            <a href="./database.php">Database</a>
                        </li>
                        <li class="nav-link" style="--i: 1.0s" id='notiword'>
                            <a href="notifications.php">Notifications</a>
                        </li>
                    </ul>
                </div>
                <?php
                $notiCount = 0;
                $display = 'none';
                if (isset($_SESSION['userid'])) {
                    $res = prepareNotifications($_SESSION['userid']);
                    $notiCount = unseenNoti($_SESSION['userid']);
                    if ($notiCount != 0) $display = '';
                } else {
                    $res = array();
                    $notiCount = 0;
                }
                ?>
                <div class="icon" onclick="toggleNotifi()">
                    <img src="../assets/img/logos/bell.png" alt=""> <span><i class="fas fa-circle" style="color:blue; display:<?= $display; ?>"></i></span>
                </div>

                <div class="notifi-box" id="box" style="display: none;">
                    <?php
                    for ($i = 0; $i < min(6, count($res)); $i++) {
                        $row = $res[$i];
                    ?>
                        <div class="notifi-item">
                            <div class="text">
                                <p><?= $row; ?></p>
                            </div>
                        </div>
                    <?php
                    }
                    ?>
                    <a href="./notifications.php" class='mt-2' style="color: #fff;">
                        <p class="text-center">See All</p>
                    </a>

                </div>
                <div class="log-sign" style="--i: 1.8s">
                    <?php
                    if (empty($_SESSION['userid']))
                        echo '<a href="./login_registration.php" class="login-btn transparent">Log in</a>';
                    else {
                        $name = $_SESSION['userid'];
                        echo '<a href="../includes/logout.inc.php" class="login-btn transparent">Log Out</a>';
                    }
                    ?>

                    <!-- <a href="#" class="btn solid">Sign up</a> -->
                </div>
            </div>

            <div class="hamburger-menu-container">
                <div class="hamburger-menu">
                    <div></div>
                </div>
            </div>
        </div>

    </header>


    <script>
        var box = document.getElementById('box');
        var down = false;

        function toggleNotifi() {
            if (down) {
                //box.style.height = '0px';
                $('#box').hide();
                box.style.opacity = 0;
                down = false;
            } else {
                /* box.style.height = '370px';*/
                $('#box').show();
                box.style.opacity = 1;
                down = true;
            }
        }

        function handle(e) {
            if (e.matches) {
                $('#notiword').hide();
            } else $('#notiword').show();
        }
        const media = window.matchMedia('(min-width: 1250px)');
        media.addListener(handle);
        handle(media);
    </script>