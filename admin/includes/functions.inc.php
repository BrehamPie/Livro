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
function getLastID($tableName)
{
    $sql = "SELECT id FROM $tableName ORDER BY id DESC";
    $res = myquery($sql);
    $row = mysqli_fetch_assoc($res);
    $id = $row['id'];
    return $id;
}
function getUserData($userid)
{
    $sql = "SELECT * FROM user WHERE id = $userid";
    $query = myquery($sql);
    $res = mysqli_fetch_assoc($query);
    return $res;
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
function getBookDataByName($book)
{
    $sql = "SELECT * FROM book WHERE name LIKE '%$book%' OR name_eng LIKE '%$book%'";
    $query = myquery($sql);
    $arr = array();
    while ($res = mysqli_fetch_assoc($query)) {
        $id = $res['id'];
        array_push($arr, $id);
    }
    return $arr;
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
function getDonationData($id)
{
    $sql = "SELECT * FROM donation WHERE id = $id";
    $query = myquery($sql);
    $res = mysqli_fetch_assoc($query);
    return $res;
}
function insertAuthor($name, $name_eng, $about)
{
    $sql = "INSERT INTO author(name,name_eng,about) VALUES('$name','$name_eng','$about')";
    myquery($sql);
}
function insertActivity($type, $typeid, $userid)
{
    $sql = "INSERT INTO activity(type,type_id,user_id) VALUES($type,$typeid,$userid)";
    myquery($sql);
}
function insertProduct($bookid, $donationid)
{
    $sql = "INSERT INTO product(donation_id,book_id) VALUES($donationid,$bookid)";
    myquery($sql);
    $sql = "UPDATE donation SET status = 1 WHERE id = $donationid";
    myquery($sql);
    $donationData = getDonationData($donationid);
    insertActivity(2, $donationid, $donationData['user_id']);
    sendBookNotification($bookid);
}
function getSubscriptionData($uid)
{
    $sql = "SELECT * FROM subscription WHERE user_id = $uid AND status = 1 ORDER BY date DESC";
    $query = myquery($sql);
    $res = mysqli_fetch_assoc($query);
    return $res;
}
function getSubscriptionDataBySub($sid)
{
    $sql = "SELECT * FROM subscription WHERE id = $sid";
    $query = myquery($sql);
    $res = mysqli_fetch_assoc($query);
    return $res;
}
function insertIncome($account, $amount, $date)
{
    $sql = "INSERT INTO income(account,amount,date) VALUES('$account',$amount,'$date')";
    myquery($sql);
}
function insertExpenditure($account, $amount, $date)
{
    $sql = "INSERT INTO expenditure(account,amount,date) VALUES('$account',$amount,'$date')";
    myquery($sql);
}
function updateSubscription($subid, $action)
{
    $sql = "UPDATE subscription 
    SET
        status = $action
        WHERE id = $subid";
    myquery($sql);
    $subData = getSubscriptionDataBySub($subid);
    $book = $subData['amount_of_books'];
    if ($book == 4) $amount = 100;
    else if ($book == 25) $amount = 550;
    else $amount = 1100;
    $date = date("Y-m-d");
    if ($action == 1) insertIncome('subscription', $amount, $date);
    insertActivity(4, $subid, $subData['user_id']);
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
function getBorrowData($borrowid)
{
    $sql = "SELECT * FROM borrow WHERE id = $borrowid";
    $query = myquery($sql);
    $res = mysqli_fetch_assoc($query);
    return $res;
}
function getCollectData($cid)
{
    $sql = "SELECT * FROM collect WHERE id = $cid";
    $query = myquery($sql);
    $res = mysqli_fetch_assoc($query);
    return $res;
}
function bookDelivered($borrowid)
{
    $id = $borrowid;
    $sql = "UPDATE borrow SET status = 1 WHERE id = $id";
    myquery($sql);
    $res = getBorrowData($borrowid);
    $subData = getSubscriptionDataBySub($res['subscription_id']);
    insertActivity(8, $borrowid, $subData['user_id']);
    $date = $res['delivery_date'];
    $date = date("Y-m-d", strtotime($date . ' + 7 days'));
    $sql = "INSERT INTO collect(borrow_id,date) VALUES($borrowid,'$date')";
    myquery($sql);
}
function sendBookNotification($bookid)
{
    $sql = "SELECT * FROM book_notification WHERE book_id = $bookid and status = 0";
    $res = myquery($sql);
    while ($row = mysqli_fetch_assoc($res)) {
        $userid = $row['user_id'];
        $id = $row['id'];
        print_r($row);
        insertActivity(9, $id, $userid);
        $sql = "UPDATE book_notification SET status = 1 WHERE id = $id";
        myquery($sql);
    }
}

function getDonator($id)
{
    $donationData = getDonationData($id);
    return getUserData($donationData['user_id']);
}

function getAuthorsByName($authors)
{
    $arr = array();
    foreach ($authors as $name) {
        $sql = "SELECT * FROM author WHERE name LIKE '%$name%' ";
        $query = myquery($sql);
        while ($res = mysqli_fetch_assoc($query)) {
            $id = $res['id'];
            array_push($arr, $id);
        }
    }
    return $arr;
}
function getReviewData($id)
{
    $sql = "SELECT * FROM review WHERE id = $id";
    $res = myquery($sql);
    return mysqli_fetch_assoc($res);
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
            $stmt = "User " . $username . " Joined Livro";
        }
        if ($type == 1) {
            $dontationData = getDonationData($row['type_id']);
            $userData = getUserData($dontationData['user_id']);
            $username = $userData['username'];
            $stmt = $username . "Donated a book named: " . $dontationData['book_name'];
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
            $stmt  = $username . " Subscribed for " . $books . " books";
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
            $stmt = $username . " Posted a new review about " . $bookData['name'];
        }
        if ($type == 6) {
            $reviewData = getReviewData($row['type_id']);
            $userData = getUserData($reviewData['user_id']);
            $username = $userData['username'];
            $bookData = getBookData($reviewData['book_id']);
            if ($reviewData['status'] == 1) {
                $stmt = "Your review about " . $bookData['name'] . "has been accepted";
            } else {
                $stmt = "Your review about " . $bookData['name'] . "was not published.";
            }
        }
        if ($type == 7) {
            $borrowData = getBorrowData($row['type_id']);
            if (is_null($borrowData))  print_r($row);
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
            $proData = getProductDataByProduct($row[2]);
            $bookData = getBookData($proData['book_id']);
            $stmt = "Your requested book " . $bookData['name'] . " has been delivered.";
        }
        if ($type == 9) {
            $id = $row['type_id'];
            $bookNoti = "SELECT * FROM book_notification WHERE id = $id";
            $res = myquery($bookNoti);
            $nerow = mysqli_fetch_assoc($res);
            $bookData = getBookData($nerow['book_id']);
            $stmt  = $bookData['name'] . "is available now.";
        }
        array_push($array, $stmt);
    }
    return $array;
}

function updateReview($id, $action)
{
    $sql = "UPDATE review 
    SET
        status = $action
    WHERE id = $id";
    myquery($sql);
    $reviewData = getReviewData($id);
    insertActivity(6, $id, $reviewData['user_id']);
}
function getIncomeOfMonth($month)
{
    $from = $month;
    $month = date("m", strtotime($month));
    $year  = date("Y", strtotime($month));
    $add = cal_days_in_month(CAL_GREGORIAN, $month, $year);
    $date = date("Y-m-d", strtotime($from . '+' . $add . ' days'));
    $sql = "SELECT * FROM income WHERE date>='$from' AND date<'$date'";
    return myquery($sql);
}
function getIncomeOfMonthSummary($month)
{
    $from = $month;
    $month = date("m", strtotime($month));
    $year  = date("Y", strtotime($month));
    $add = cal_days_in_month(CAL_GREGORIAN, $month, $year);
    $date = date("Y-m-d", strtotime($from . '+' . $add . ' days'));
    $sql = "SELECT SUM(amount) as total FROM income WHERE date>='$from' AND date<'$date'";
    $query =  myquery($sql);
    $res = mysqli_fetch_assoc($query);
    if ($res == null) return 0;
    return $res['total'];
}
function getExpenditureOfMonth($month)
{
    $from = $month;
    $month = date("m", strtotime($month));
    $year  = date("Y", strtotime($month));
    $add = cal_days_in_month(CAL_GREGORIAN, $month, $year);
    $date = date("Y-m-d", strtotime($from . '+' . $add . ' days'));
    $sql = "SELECT * FROM expenditure WHERE date>='$from' AND date<'$date'";
    return myquery($sql);
}
function getExpenditureOfMonthSummary($month)
{
    $from = $month;
    $month = date("m", strtotime($month));
    $year  = date("Y", strtotime($month));
    $add = cal_days_in_month(CAL_GREGORIAN, $month, $year);
    $date = date("Y-m-d", strtotime($from . '+' . $add . ' days'));
    $sql = "SELECT SUM(amount) as total FROM expenditure WHERE date>='$from' AND date<'$date'";
    $query =  myquery($sql);
    $res = mysqli_fetch_assoc($query);
    if ($res == null) return 0;
    return $res['total'];
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
