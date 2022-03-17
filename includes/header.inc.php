<?php
require_once './includes/db.inc.php';
require_once './includes/functions.inc.php';
ob_start();
session_start();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">


    <link rel="stylesheet" href="./assets/bootstrap/css/bootstrap.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" integrity="sha512-iBBXm8fW90+nuLcSKlbmrPcLa0OT92xO1BIsZ+ywDWZCvqsWgccV3gFoRBv0z+8dLJgyAHIhR35VZc2oM/gI1w==" crossorigin="anonymous" />
    <link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/font-awesome/4.2.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="./assets/fontawesome-5.15.3/css/all.css">
    <link rel="stylesheet" href="./assets/OwlCarousel2-2.3.4/dist/assets/owl.carousel.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/tempusdominus-bootstrap-4/5.0.1/css/tempusdominus-bootstrap-4.min.css" />
    <link rel="stylesheet" href="./style.css">
    <script src="./assets/js/popper.min.js"></script>
    <script src="./assets/js/jquery-3.6.0.min.js"></script>
    <script src="./assets/bootstrap/js/bootstrap.js"></script>
    <script src='./assets/OwlCarousel2-2.3.4/dist/owl.carousel.js'></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.22.2/moment.min.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/tempusdominus-bootstrap-4/5.0.1/js/tempusdominus-bootstrap-4.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.11.2/js/all.js" integrity="sha256-2JRzNxMJiS0aHOJjG+liqsEOuBb6++9cY4dSOyiijX4=" crossorigin="anonymous"></script>


    <title>Document</title>
</head>

<body>

    <header>
        <div class="navbar_container">
            <!-- This checkbox is used for hamburger -->
            <input type="checkbox" name="" id="check">
            <!-- Livro Logo -->
            <div class="logo_container">
                <a href="index.php"><img src="./assets/img/logos/logo.png" alt=""></a>
            </div>

            <div class="navbar_search">
                <form class="searchbar" action="books.php" method="GET">
                    <input type="text" placeholder="Find Your favorite book" name="query" id='navbarsearch' oninput=allSearch(this.value) required style="color:white">
                    <button type="submit"><i class="fa fa-search"></i></button>
                </form>
                <div class='livesearchbar' id='searchResultNav'>

                </div>
            </div>
            <!-- Navigation buttons -->
            <div class="nav-btn">
                <div class="nav-links">
                    <ul>
                        <li class="nav-link" style="--i: .6s">
                            <a href="./donate.php">Donate Books</a>
                        </li>
                        <li class="nav-link" style="--i: .85s">
                            <a href="./books.php" id="browse_book">Browse Books<i class="fas fa-caret-down"></i></a>
                            <div class="dropdown">
                                <ul>
                                    <li class="dropdown-link">
                                        <a href="./books.php" style="display:none;" id="showAllBook">All books</a>
                                    </li>
                                    <li class="dropdown-link">
                                        <a href="authors.php">Authors</a>
                                    </li>
                                    <li class="dropdown-link">
                                        <a href="./genres.php">Genres</a>
                                    </li>
                                    <li class="dropdown-link">
                                        <a style="cursor: default;" id='mread'>Most Read<i class=" fas fa-caret-right"></i></a>
                                        <div class="dropdown second">
                                            <ul>
                                                <li class="dropdown-link">
                                                    <a href="./mostread.php?dur=weekly">This Week</a>
                                                </li>
                                                <li class="dropdown-link">
                                                    <a href="./mostread.php?dur=monthly">This Month</a>
                                                </li>
                                                <li class="dropdown-link">
                                                    <a href="./mostread.php?dur=alltime">All time</a>
                                                </li>
                                                <div class="arrow"></div>
                                            </ul>
                                        </div>
                                    </li>
                                    <li class="dropdown-link">
                                        <a href="./mostrated.php">Highest Rated</a>
                                    </li>
                                    <div class="arrow"></div>
                                </ul>
                            </div>
                        </li>
                        <li class="nav-link" style="--i: 1.0s">
                            <a href="./reviews.php">Reviews</a>
                        </li>
                        <li class="nav-link" style="--i: 1.0s">
                            <a href="pricing.php">Subscribe</a>
                        </li>
                        <li class="nav-link" style="--i: 1.0s" id='notiword'>
                            <a href="notifications.php">Notifications</a>
                        </li>
                        <li class="nav-link" style="--i: 1.1s;display:<?php
                                                                        if (empty($_SESSION['userid'])) echo "none";
                                                                        else echo "inline"; ?>">
                            <a href="user.php?id=<?= $_SESSION['userid']; ?>">Account<i class="fas fa-caret-down"></i></a>
                            <div class="dropdown">
                                <ul>
                                    <li class="dropdown-link">
                                        <a href="./readinghistory.php?id=<?= $_SESSION['userid']; ?>">Reading History</a>
                                    </li>
                                    <li class="dropdown-link">
                                        <a href="./donationhistory.php?id=<?= $_SESSION['userid']; ?>">Donation History</a>
                                    </li>
                                    <li class="dropdown-link">
                                        <a href="./setting.php">Setting</a>
                                    </li>

                                </ul>
                            </div>
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
                    <img src="./assets/img/logos/bell.png" alt=""> <span><i class="fas fa-circle" style="color:red; display:<?= $display; ?>"></i></span>
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
                        echo '<a href="./authentication.php" class="login-btn transparent">Log in</a>';
                    else {
                        $name = $_SESSION['userid'];
                        echo '<a href="./includes/logout.inc.php" class="login-btn transparent">Log Out</a>';
                    }
                    ?>
                </div>
            </div>
            <div class="hamburger-menu-container">
                <div class="hamburger-menu">
                    <div></div>
                </div>
            </div>
        </div>
    </header>
    <script src="./scripts/header.js"></script>