<!-- Basic User Info -->
<?php
    include './includes/header.inc.php';
    if(!isset($_GET['id'])){
        header("Location: ./forbidden.php");
    }
    $uid = $_GET['id'];
    $userData = getUserData($uid);
    $username = $userData['username'];
    $profile_pic = $userData['img'] ?? '0.png';
    if($profile_pic=='') $profile_pic = '0.png';
    $join_date = $userData['join_date'];
    $newDateString = date("d/m/Y",strtotime($join_date));
    $deta = $userData['about'];
    $read_cnt = getReadCount($uid);
    $donate_cnt = getDonateCount($uid);
    $sql = "SELECT COUNT(*) as cnt FROM review WHERE user_id = $uid AND review IS NOT NULL";
    $res = mysqli_query($connection, $sql);
    print_r(mysqli_error($connection));
    $row = mysqli_fetch_assoc($res);
    $review_cnt = $row['cnt'];
    $display = '';            
    if (!isset($_SESSION['userid']) || $_SESSION['userid'] != $uid) 
        $display = 'none';

    ?>

 <main class="container">
     <div style="display: flex;align-items: center;margin-bottom: 0;" class="mt-2">
         <h4><?= $username; ?>'s Profile</h4>
         <a href="./setting.php" style="align-self: flex-end;margin:auto;display:<?=$display;?>"><i class="fas fa-cogs"></i>
             Edit Profile
         </a>
     </div>
     <hr style="margin-top: 0px;">
     <div class="row" style="height: 100vh;">
         <div class="col-2 bg-light ">
             <div class="userdp mt-5">
                 <img src="./assets/img/users/<?= $profile_pic; ?>" alt="" width="100%">
             </div>
             <div class="sum text-center">
                 <p>Joined:<?= $newDateString; ?></p>
                 <p>Books read:<?= $read_cnt; ?></p>
                 <p>Reviews: <?= $review_cnt; ?></p>
                 <p>Donation:<?= $donate_cnt; ?></p>
                 <div>
                     <a href="./readinghistory.php?id=<?= $uid; ?>"><button class="btn btn-primary btn-block">Reading History</button></a>
                 </div>
                 <div>
                     <a href="./donationhistory.php?id=<?= $uid; ?>"><button class="btn btn-primary btn-block mt-2">Donation History</button></a>
                 </div>

             </div>
         </div>
         <div class="col-9 bg-light">
             <h6 class="mt-2">About <?= $username; ?></h6>
             <div class="bio" style="height: 40vh;position: relative;">
                 <textarea name="" id="abme" cols="30" rows="9" style="width: 100%;resize: none;border: none;background:transparent;" disabled><?= $deta; ?></textarea>
             </div>
             <div class="recentupdate">
                 <h6>Recent Updates</h6>
                 <hr>
                 <?php
                 $activities = getActivity($uid);
                 foreach($activities as $event){
                    ?><p><?=$event;?></p>
                 <?php }
                 ?>
                 <!-- <button class="btn btn-secondary">View All....</button> -->
             </div>
         </div>
     </div>
 </main>

 <?php
    include './includes/footer.inc.php';
    ?>