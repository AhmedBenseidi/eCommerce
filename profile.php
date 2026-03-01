<?php
ob_start();
session_start();
if(isset($_SESSION['User'])){
$pageTitle= $_SESSION['User'].' Profile';

include 'init.php';
$stmtGetUser  = $connect->prepare("SELECT * FROM users WHERE Username = ?");
$stmtGetUser -> execute(array($sessionUser));
$userInfo = $stmtGetUser ->fetch();

?>
<!-- START PAGE CONTENT -->
<h2 class="text-center" >Welcome  <?php echo $sessionUser ?></h2>
<section class="my-info block " >
    <div class="container">

        <div class=" main-panel  col-sm-12 ">
        <div class="panel-heading bg-primary">Information</div>
        <div class="panel-body bg-body ">
            <ul class="list-unstyled" >
            <li><i class="fa fa-unlock-alt "></i>
                <span>Name              :</span> <?php echo $userInfo['Username']  ?>    </li>
            <li> <i class="fa fa-envelope "></i>
                <span>Email             :</span> <?php echo $userInfo['Email'] ?>       </li>
            <li> <i class="fa fa-user-alt "></i>
                <span>Full Name         :</span> <?php echo $userInfo['Fullname'] ?></li>
            <li> <i class="fa fa-calendar-alt "></i>
                <span>Register Date     :</span> <?php echo $userInfo['Date'] ?></li>
            </ul>
        </div>
    </div>
    <?php
    if(checkUserStatus($sessionUser) != 1){

    
    ?>
    </div>
</section>
<section class="my-ads block " >
    <div class="container">

        <div class=" main-panel  col-sm-12 ">
        <div class="panel-heading bg-primary">Ads</div>
        <div class="panel-body bg-body ">
            <?php 
           $items =getItems('Member_ID', $userInfo['UserID'],1);
           if(!empty($items)){
           echo '<div class="row">';
        foreach( $items as $item){
                ?>
                    <div class="col-sm-6 col-md-4 text-center box-demo ">
                        <div class="img-thumbnail item-box">
                            <span class="price-tag"><?php echo '$'.$item['Price'] ?></span>
                            <?php
                            if($item['Approve'] != 1){
                                ?>
                                <span class=" werning-tag ">Awaiting approval</span>
                                <?php
                            }
                            ?>
                            <span class="price-tag"></span>
                            <img class="img-responsiv" src="admin/uploades/itemsImages/<?php echo $item['Image']?>" alt="">
                            <div class="caption">
                                <h3 title="<?php echo $item['Name']?>" > <a href="item.php?itemid=<?php echo $item['Item_ID']?>"> <?php echo $item['Name']?></a></h3>
                                <div>
                                    <a class="btn btn-success" href="item.php?do=Edit&itemid=<?php echo $item['Item_ID'] ?>"> 
                                    <i class="fa fa-edit"></i>    
                                    Edite</a>
                                    <a class="confirm btn btn-danger" href="item.php?do=Delete&itemid=<?php echo $item['Item_ID'] ?>"> 
                                    <i class="fa fa-close"></i>    
                                    Deleted</a>
                                </div>
                                <div class="date" ><?php echo $item['Add_Date']?></div>
                            </div>
                        </div>
                    </div>
                <?php
                }
            }else{
                echo 'No Ads to Show <a href="newad.php" > Creat New Ad </a>';
            }
        echo '</div>';
           ?>
        </div>
    </div>
    
    </div>
</section>
<section class="my-comments block " >
    <div class="container">

        <div class=" main-panel  col-sm-12 ">
        <div class="panel-heading bg-primary"> Latest Comments</div>
        <div class="panel-body bg-body ">
            <?php
            $stmtComments  = $connect->prepare("SELECT * FROM `comments` WHERE user_id = ?");
            $stmtComments -> execute(array( $userInfo['UserID'] ));
            $comments = $stmtComments ->fetchAll();
            if(!empty($comments)){
                foreach($comments as $comment){
                    echo '<p>'.$comment['comment'].'</p>';
                }
            }else{
                echo 'No comments exist';
            }
            ?>
        </div>
    </div>
    
    </div>
</section>
<?php } ?>
<!-- END PAGE CONTENT -->
<?php include $tpl.'footer.php';
}else{
    header("Location: index.php"); //Redirect to Profil  Page
        exit();
}
ob_end_flush();
?>  