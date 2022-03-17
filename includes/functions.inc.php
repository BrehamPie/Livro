<?php
include 'db.inc.php';

function myquery($sql)
{
    $connection = $GLOBALS['connection'];
    $result = mysqli_query($connection, $sql);
    if (!$result) {
        print_r(mysqli_error($connection));
    }
    return $result;
}
function getSize($tableName)
{
    $sql = "SELECT COUNT(*) as size FROM $tableName";
    $res = myquery($sql);
    $row = mysqli_fetch_assoc($res);
    return $row['size'];
}
function getCount($table, $column, $value)
{
    $sql = "SELECT COUNT(*) as tableSize from $table WHERE $column = $value ";
    $query = myquery($sql);
    $res = mysqli_fetch_assoc($query);
    return $res['tableSize'];
}
function getLastID($tableName)
{
    $sql = "SELECT id FROM $tableName ORDER BY id DESC";
    $res = myquery($sql);
    $row = mysqli_fetch_assoc($res);
    if ($row == null || $row == '') return 0;
    $id = $row['id'];
    return $id;
}
function getLoginData($username)
{

    $sql = "SELECT * FROM user WHERE username = '$username'";
    $query = myquery($sql);
    $res = mysqli_fetch_assoc($query);
    return $res;
}
function insertUser($username, $email, $password)
{
    $sql = "INSERT INTO user(username,email,password) VALUES('$username','$email','$password')";
    myquery($sql);
}
function updateUser($uid, $curFullName, $curPhone, $curdiv, $curdis, $curUpa, $curLoc, $curAbt, $img)
{
    $sql = "UPDATE user
    SET 
        fullname = '$curFullName',
        phone = '$curPhone',
        division = $curdiv,
        district = $curdis ,
        upazila = $curUpa,
        local_address = '$curLoc',
        about = '$curAbt',
        img = '$img'
    WHERE id = $uid";
    myquery($sql);
}
function insertActivity($type, $typeid, $userid)
{
    $sql = "INSERT INTO activity(type,type_id,user_id) VALUES($type,$typeid,$userid)";
    myquery($sql);
}
function insertDonation($userid, $book_name, $authors_name, $book_image)
{
    $sql = "INSERT into donation(user_id,book_name,authors_name,book_image) VALUES ($userid,'$book_name','$authors_name','$book_image')";
    myquery($sql);
}
function getNotifications($userid)
{
    $sql = "SELECT * FROM activity WHERE user_id = $userid ORDER BY id DESC";
    return myquery($sql);
}

function getAuthorData($authorid)
{
    $sql = "SELECT * FROM author WHERE id = $authorid";
    $res = myquery($sql);
    $row = mysqli_fetch_assoc($res);
    return $row;
}

function getBookData($bookid)
{
    $sql = "SELECT * FROM book WHERE id = $bookid";
    $res = myquery($sql);
    $row = mysqli_fetch_assoc($res);
    return $row;
}
function getProductDataByProduct($pid)
{
    $sql = "SELECT *
            FROM product
             WHERE id = $pid";
    $query = myquery($sql);
    $res = mysqli_fetch_assoc($query);
    return $res;
}
function getAuthors($bookid)
{
    $sql = "SELECT author_id FROM book_author WHERE book_id = $bookid";
    $query = myquery($sql);
    $array = array();
    while ($res = mysqli_fetch_assoc($query)) {
        array_push($array, $res['author_id']);
    }
    return $array;
}
function getAuthorListWithoutLink($bookid)
{
    $authors = getAuthors($bookid);
    $author = '';
    foreach ($authors as $aid) {
        $authorData = getAuthorData($aid);
        $author .= $authorData['name'];
        $author .= ',';
    }
    $author = substr($author, 0, -1);
    return $author;
}
function getAuthorListWithLink($bookid)
{
    $authors = getAuthors($bookid);
    $author = '';
    foreach ($authors as $aid) {
        $authorData = getAuthorData($aid);
        $author .=  '<a href="./author.php?id=' . $aid . '">' . $authorData['name'] . '</a>';
        $author .= ',';
    }
    $author = substr($author, 0, -1);
    return $author;
}
function getGenres($bookid)
{
    $sql = "SELECT genre_id FROM book_genre WHERE book_id = $bookid";
    $query = myquery($sql);
    $array = array();
    while ($res = mysqli_fetch_assoc($query)) {
        array_push($array, $res['genre_id']);
    }
    return $array;
}
function getGenreData($genreid)
{
    $sql = "SELECT * FROM genre WHERE id = $genreid";
    $query = myquery($sql);
    $res = mysqli_fetch_assoc($query);
    return $res;
}
function getGenreListWithoutLink($bookid)
{
    $genres = getGenres($bookid);
    $genre = '';
    foreach ($genres as $gid) {
        $genreData = getgenreData($gid);
        $genre .= $genreData['name'];
        $genre .= ',';
    }
    $genre = substr($genre, 0, -1);
    return $genre;
}
function getGenreListWithLink($bookid)
{
    $genres = getgenres($bookid);
    $genre = '';
    foreach ($genres as $gid) {
        $genreData = getgenreData($gid);
        $genre .=  '<a href="./genre.php?id=' . $gid . '">' . $genreData['name'] . '</a>';
        $genre .= ',';
    }
    $genre = substr($genre, 0, -1);
    return $genre;
}

function insertAuthor($name, $name_eng, $about)
{
    $sql = "INSERT INTO author(name,name_eng,about) VALUES('$name','$name_eng','$about')";
    myquery($sql);
}

function getUserData($userid)
{
    $sql = "SELECT * FROM user WHERE id = $userid";
    $query = myquery($sql);
    $res = mysqli_fetch_assoc($query);
    return $res;
}

function getTrendingBooks()
{
    $sql1 = "SELECT product_id,COUNT(product_id) as product_cnt FROM borrow GROUP BY product_id";
    $sql = "SELECT product.book_id as book_id,SUM(sub.product_cnt) as total_read FROM product INNER JOIN 
    ($sql1) as sub ON product.id = sub.product_id GROUP BY product.book_id ORDER BY total_read DESC LIMIT 10";
    $query = myquery($sql);
    return $query;
}
function getTrendingAuthors()
{
    $sql1 = "SELECT product_id,COUNT(product_id) as product_cnt FROM borrow GROUP BY product_id";
    $sql2 = "SELECT product.book_id as book_id,COUNT(sub.product_cnt) as total_read FROM product INNER JOIN 
    ($sql1) as sub ON product.id = sub.product_id GROUP BY product.book_id ORDER BY total_read LIMIT 10";
    $sql = "SELECT author_id,SUM(total_read) as author_total FROM book_author INNER JOIN ($sql2) as sub ON book_author.book_id = sub.book_id 
            GROUP by book_author.author_id ORDER BY author_total DESC LIMIT 10 ";
    $query = myquery($sql);
    return $query;
}
function getDonationData($id)
{
    $sql = "SELECT * FROM donation WHERE id = $id";
    $query = myquery($sql);
    $res = mysqli_fetch_assoc($query);
    return $res;
}
function getTopReader()
{
    $sql1 = "SELECT subscription_id,COUNT(id)as book_cnt FROM  borrow GROUP BY borrow.subscription_id";
    $sql = "SELECT subscription.user_id as user_id,SUM(sub.book_cnt) as total_read FROM subscription INNER JOIN 
            ($sql1) as sub ON subscription.id = sub.subscription_id  GROUP BY subscription.user_id ORDER BY total_read DESC";
    $query = myquery($sql);
    return $query;
}

function getTopReviewer()
{

    $sql = "SELECT user_id,COUNT(user_id) as rev_cnt from review WHERE review IS NOT NULL  GROUP BY user_id ORDER BY rev_cnt DESC";
    $query = myquery($sql);
    return $query;
}

function getTopDonators()
{
    $sql = "SELECT user_id ,COUNT(user_id) as don_cnt from donation WHERE status = 1 GROUP BY user_id ORDER BY don_cnt DESC";
    $query = myquery($sql);
    return $query;
}

function insertSubscription($userid, $tnxid, $books, $date)
{
    $sql = "INSERT INTO subscription(user_id,tnx_id,amount_of_books,date) VALUES($userid,'$tnxid',$books,'$date')";
    myquery($sql);
    insertActivity(3, getLastID('subscription'), 1);
}
function getBorrowData($borrowid)
{
    $sql = "SELECT * FROM borrow WHERE id = $borrowid";
    $query = myquery($sql);
    $res = mysqli_fetch_assoc($query);
    return $res;
}
function insertReview($userid, $bookid, $rating, $review)
{
    $sql = "SELECT * FROM review WHERE book_id = $bookid AND user_id = $userid";
    $res = myquery($sql);
    if (mysqli_num_rows($res) == 0) {
        $sql = "INSERT INTO review(book_id,user_id,rating,review)
        VALUES($bookid,$userid,$rating,'$review')";
        $id = getLastID('review');
    } else {
        $row = mysqli_fetch_assoc($res);
        $id = $row['id'];
        $sql = "UPDATE review
        SET
            rating = $rating,
            review = '$review'
            status = 0
        WHERE id = $id";
    }
    myquery($sql);
    insertActivity(5, $id, 1);
}


function getMostReadedWeek()
{
    $date = date("Y-m-d");
    $date = date("Y-m-d", strtotime($date . ' - 7 days'));

    $sql1 = "SELECT product_id,COUNT(product_id) as prod_cnt FROM borrow WHERE request_date>='$date' GROUP BY product_id";
    $sql2 = "SELECT book_id,SUM(prod_cnt) FROM ($sql1) as sub INNER JOIN product ON sub.product_id=product.id
        GROUP BY book_id ORDER BY SUM(prod_cnt)DESC";
    $res = myquery($sql2);
    return $res;
}
function getMostReadedMonth()
{
    $date = date("Y-m-d");
    $date = date("Y-m-d", strtotime($date . ' - 30 days'));
    $sql1 = "SELECT product_id,COUNT(product_id) as prod_cnt FROM borrow WHERE request_date>='$date' GROUP BY product_id";
    $sql2 = "SELECT book_id,SUM(prod_cnt) FROM ($sql1) as sub INNER JOIN product ON sub.product_id=product.id
        GROUP BY book_id ORDER BY SUM(prod_cnt)DESC";
    $res = myquery($sql2);
    return $res;
}
function getMostReaded()
{
    $sql1 = "SELECT product_id,COUNT(product_id) as prod_cnt FROM borrow GROUP BY product_id";
    $sql2 = "SELECT book_id,SUM(prod_cnt) FROM ($sql1) as sub INNER JOIN product ON sub.product_id=product.id
        GROUP BY book_id ORDER BY SUM(prod_cnt)DESC";
    $res = myquery($sql2);
    return $res;
}

function getMostRated()
{
    $sql = "SELECT book_id,AVG(rating) as arating FROM review GROUP BY book_id ORDER BY arating DESC";
    $res = myquery($sql);
    return $res;
}

function getDonateCount($userid)
{
    $sql = "SELECT COUNT(*) as cnt FROM donation WHERE user_id = $userid AND status = 1";
    $res = myquery($sql);
    $row = mysqli_fetch_assoc($res);
    return $row['cnt'];
}
function getDonateList($userid)
{
    $sql = "SELECT product.book_id,product.receive_date  FROM product INNER JOIN donation
            ON product.donation_id = donation.id WHERE donation.user_id = $userid";
    return myquery($sql);
}

function getReadCount($userid)
{
    $sql = "SELECT COUNT(*) as readCnt FROM borrow INNER JOIN subscription ON subscription.id = borrow.subscription_id WHERE 
    borrow.status = 1 AND subscription.user_id = $userid";
    $query = myquery($sql);
    $res = mysqli_fetch_assoc($query);
    return $res['readCnt'];
}
function getReadList($userid)
{
    $sql = "SELECT borrow.product_id,borrow.delivery_date FROM borrow INNER JOIN subscription ON subscription.id = borrow.subscription_id WHERE 
    borrow.status = 1 AND subscription.user_id = $userid";
    return myquery($sql);
}

function getRating($bookid, $userid)
{
    $sql = "SELECT * FROM review WHERE book_id = $bookid AND user_id = $userid";
    $res = myquery($sql);
    if (mysqli_num_rows($res) == 0) return -1;
    $row = mysqli_fetch_assoc($res);
    if ($row['rating'] == '') return -1;
    return $row['rating'];
}

function validateUser($userid)
{
    $userData = getUserData($userid);
    $div = $userData['division'];
    $dis = $userData['district'];
    $upa = $userData['upazila'];
    $loc = $userData['local_address'];
    $phone = $userData['phone'];
    $name = $userData['fullname'];
    $ok = 1;
    foreach (array($div, $dis, $upa, $loc, $phone, $name) as $check) {
        if (is_null($check) || $check == 0 || strlen($check) < 1) $ok = 0;
    }
    return $ok;
}

function getSubscriptionData($uid)
{
    $sql = "SELECT * FROM subscription WHERE user_id = $uid AND status = 1 ORDER BY date DESC";
    $query = myquery($sql);
    $res = mysqli_fetch_assoc($query);
    return $res;
}
function getProductData($bid)
{
    $sql = "SELECT *
            FROM product
             WHERE book_id = $bid AND status = 1";
    $query = myquery($sql);
    $res = mysqli_fetch_assoc($query);
    return $res;
}
function bookDelivered($id)
{
    $sql = "SELECT COUNT(*) as cnt
            FROM borrow WHERE subscription_id = $id AND status = 1";
    $query = myquery($sql);
    $res = mysqli_fetch_assoc($query);
    return $res['cnt'];
}
function getLastDelivery($id)
{
    $sql = "SELECT delivery_date
            FROM borrow WHERE subscription_id = $id  ORDER BY delivery_date DESC";
    $query = myquery($sql);
    if (mysqli_num_rows($query) == 0) return null;
    $res = mysqli_fetch_assoc($query);
    return $res['delivery_date'];
}

function insertBookNotification($userid, $bookid)
{
    $sql = "INSERT INTO book_notification(user_id,book_id) VALUES($userid,$bookid)";
    myquery($sql);
}

function insertRequest($pid, $sid, $ord_date, $req_date)
{
    $connection = $GLOBALS['connection'];
    $sql = "UPDATE product SET status = 0 WHERE id = $pid ";
    myquery($sql);

    $sql = "INSERT INTO borrow (subscription_id,product_id,request_date,delivery_date)
            VALUES($sid,$pid,'$ord_date','$req_date')";
    //echo $ord_date.'.'.$req_date;
    //echo $sql;
    $query = myquery($sql);
    insertActivity(7, getLastID('borrow'), 1);
}
function getSubscriptionDataBySub($sid)
{

    $sql = "SELECT * FROM subscription WHERE id = $sid";
    $query = myquery($sql);
    $res = mysqli_fetch_assoc($query);
    return $res;
}
function getReviewData($id)
{
    $sql = "SELECT * FROM review WHERE id = $id";
    $res = myquery($sql);
    return mysqli_fetch_assoc($res);
}
function searchBook($name)
{
    $sql = "SELECT * FROM book
          WHERE name LIKE '%$name%' OR name_eng LIKE '%$name%'
          LIMIT 10";
    //echo $query;
    $query = myquery($sql);
    return $query;
}
function unseenNoti($userid)
{
    $sql = "SELECT COUNT(*) as cnt FROM activity WHERE user_id = $userid AND status = 0";
    $res = myquery($sql);
    $row = mysqli_fetch_assoc($res);
    return $row['cnt'];
}
function seenNoti($userid)
{
    $sql = "UPDATE activity SET status = 1 WHERE user_id = $userid AND status = 0";
    $res = myquery($sql);
}
function insertHistory($userid, $bookid)
{
    $date = date("Y-m-d");
    $sql = "SELECT * FROM search WHERE user_id = $userid AND book_id = $bookid";
    $res = myquery($sql);
    if (mysqli_num_rows($res) == 0) {
        $sql = "INSERT INTO search(user_id,book_id,total,last_search_date)
                VALUES($userid,$bookid,1,'$date')";
        myquery($sql);
    } else {
        $sql = "UPDATE search SET total = total+1,last_search_date = '$date' WHERE user_id = $userid AND book_id = $bookid";
        myquery($sql);
    }
}

function getSearchedBooks($uid)
{
    $sql = "SELECT book_id FROM search WHERE user_id = $uid ORDER BY last_search_date";
    return myquery($sql);
}
function prepareNotifications($userid)
{
    $res = getNotifications($userid);
    $array = array();
    while ($row = mysqli_fetch_assoc($res)) {
        $type = $row['type'];
        if ($type == 0) {
            $userData = getUserData($row['type_id']);
            $username = $userData['username'];
            $stmt = "User" . $username . " Joined Livro";
        }
        if ($type == 1) {
            $dontationData = getDonationData($row['type_id']);
            $userData = getUserData($dontationData['user_id']);
            $username = $userData['username'];
            $stmt = $username . "Donated a book named:" . $dontationData['book_name'];
        }
        if ($type == 2) {
            $dontationData = getDonationData($row['type_id']);
            $userData = getUserData($dontationData['user_id']);
            $username = $userData['username'];
            if ($dontationData['status'] == 1)
                $stmt = 'Your Book: <strong>' . $dontationData['book_name'] . " </strong> has been accepted.";
            else $stmt = 'Your Book: <strong>' . $dontationData['book_name'] . "</strong> did not meet our criteria.Your book will be returned to you soon.";
        }
        if ($type == 3) {
            $subscriptionData = getSubscriptionDataBySub($row['type_id']);
            $userData = getUserData($subscriptionData['user_id']);
            $username = $userData['username'];
            $books = $subscriptionData['amount_of_books'];
            $stmt  = $username . "Subscribed for " . $books . " books";
        }
        if ($type == 4) {
            $subscriptionData = getSubscriptionDataBySub($row['type_id']);
            $userData = getUserData($subscriptionData['user_id']);
            $username = $userData['username'];
            if ($subscriptionData['status'] == 1)
                $stmt = "Your <b>subscription</b> was successful";
            else $stmt = "Your subscription could not be verified.";
        }
        if ($type == 5) {
            $reviewData = getReviewData($row['type_id']);
            $userData = getUserData($reviewData['user_id']);
            $username = $userData['username'];
            $bookData = getBookData($reviewData['book_id']);
            $stmt = $username . " Posted a new review about" . $bookData['name'];
        }
        if ($type == 6) {
            $reviewData = getReviewData($row['type_id']);
            $userData = getUserData($reviewData['user_id']);
            $username = $userData['username'];
            $bookData = getBookData($reviewData['book_id']);
            if ($reviewData['status'] == 1) {
                $stmt = "Your review about " . $bookData['name'] . " has been accepted";
            } else {
                $stmt = "Your review about " . $bookData['name'] . " was not published.";
            }
        }
        if ($type == 7) {
            $borrowData = getBorrowData($row['type_id']);
            $subData = getSubscriptionDataBySub($borrowData['subscription_id']);
            $userData  = getUserData($subData['user_id']);
            $proData = getProductDataByProduct($borrowData['product_id']);
            $bookData = getBookData($proData['book_id']);
            $stmt = "A new borrow request came for " . $bookData['name'];
        }
        if ($type == 8) {
            $borrowData = getBorrowData($row['type_id']);
            $subData = getSubscriptionDataBySub($borrowData['subscription_id']);
            $userData  = getUserData($subData['user_id']);
            $proData = getProductDataByProduct($borrowData['product_id']);
            $bookData = getBookData($proData['book_id']);
            $stmt = "Your requested book " . $bookData['name'] . " has been delivered.";
        }
        if ($type == 9) {
            $id = $row['type_id'];
            $bookNoti = "SELECT * FROM book_notification WHERE id = $id";
            $res = myquery($bookNoti);
            $nerow = mysqli_fetch_assoc($res);
            $bookData = getBookData($nerow['book_id']);
            $stmt  = $bookData['name'] . " is available now.";
        }

        array_push($array, $stmt);
    }
    return $array;
}
function getActivity($userid)
{
    $res = getNotifications($userid);
    $array = array();
    while ($row = mysqli_fetch_assoc($res)) {
        $type = $row['type'];
        if ($type == 2) {
            $dontationData = getDonationData($row['type_id']);
            $userData = getUserData($dontationData['user_id']);
            $username = $userData['username'];
            $did = $dontationData['id'];
            $proData = "SELECT book_id FROM product where donation_id = $did";
            $proData = myquery($proData);
            $proData = mysqli_fetch_assoc($proData);
            $bookdata = getBookData($proData['book_id']);
            if ($dontationData['status'] == 1) {
                $stmt = $username . " Donated " . $bookdata['name'];
                array_push($array, $stmt);
            }
        }
        if ($type == 6) {
            $reviewData = getReviewData($row['type_id']);
            $userData = getUserData($reviewData['user_id']);
            $username = $userData['username'];
            $bookData = getBookData($reviewData['book_id']);
            if ($reviewData['status'] == 1) {
                $stmt = $username . " Posted a new review about " . $bookData['name'];
                array_push($array, $stmt);
            }
        }
        if ($type == 8) {
            $borrowData = getBorrowData($row['type_id']);
            $subData = getSubscriptionDataBySub($borrowData['subscription_id']);
            $userData  = getUserData($subData['user_id']);
            $proData = getProductDataByProduct($borrowData['product_id']);
            $bookData = getBookData($proData['book_id']);
            $username = $userData['username'];
            $stmt = $username . " is reading " . $bookData['name'];
            array_push($array, $stmt);
        }
    }
    return $array;
}
