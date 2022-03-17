<footer class="myfooter">
    <div class="footer_top">
        <div class="footer_top_left">
            <img src="./assets/img/logos/logo.png" alt="" height="45px" style="display: inline-block;">
            <p><i class="fas fa-phone-alt"></i> +8801234567890</p>
            <p><i class="far fa-envelope"></i> livro@hotmail.com</p>
            <p><i class="fas fa-map-marker-alt"></i> KUET,Teligati,Fulbarigate,Khulna-9400.</p>

            <p style="font-size: medium; margin-bottom: 1px;">Connect with Us</p>
            <a href="https://www.youtube.com"><i class="fab fa-youtube-square" style="color:red"></i></a>
            <a href="https://www.twitter.com"><i class="fab fa-twitter-square" style="color: #55acee;"></i></a>
            <a href="https://www.facebook.com"><i class="fab fa-facebook-square" style="color: #3b5998;"></i></a>
            <a href="https://www.instagram.com"><i class="fab fa-instagram" style=" color: #3f729b;"></i></a>

        </div>
        <div class="footer_top_middle">
            <ul>
                <p style="margin-bottom: 0; font-size: 1em;">Books</p>
                <li><a href="./books.php">Browse All Books</a></li>
                <li><a href="./reviews.php">Book Reviews</a></li>
            </ul>
            <ul>
                <p style="margin-bottom: 0; font-size: 1em;">Account</p>
                <li><?php
                    if (empty($_SESSION['userid']))
                        echo '<a href="./authentication.php">';
                    else {
                        $name = $_SESSION['userid'];
                        echo '<a href="./user.php?id=' . $_SESSION['userid'] . '">';
                    }
                    ?>Account Info</a></li>
                <li><?php
                    if (empty($_SESSION['userid']))
                        echo '<a href="./authentication.php">';
                    else {
                        $name = $_SESSION['userid'];
                        echo '<a href="./setting.php">';
                    }
                    ?>Settings</a> </li>
                <li><a href="./donate.php">Donate a book</a></li>
            </ul>
        </div>
        <div class="footer_top_right">
            <ul>
                <li><a href="./aboutus.php">About Us</a></li>
            </ul>
            <ul>
                <p style="margin-bottom: 0; font-size: 1.1em;">Policies</p>
                <li><a href="./privacy.php">Privacy Policies</a></li>
                <li><a href="./tou.php">Terms of Use</a></li>
                <li><a href="./donationpolicy.php">Donation Policies</a> </li>
                <li><a href="./exchangepolicy.php"> Exchange Policies</a></li>
            </ul>
        </div>
    </div>

    <div class="footer_bottom">
        <p style="text-align: center;">&copy; 2020-2021 Livro Ltd.</p>
    </div>
</footer>
</body>


</html>