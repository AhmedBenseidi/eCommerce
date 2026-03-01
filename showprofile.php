<?php
ob_start();
session_start();
$pageTitle= 'Show Profile';

include 'init.php';
$userid = isset($_GET['userid']) && is_numeric($_GET['userid']) ? intval($_GET['userid']) : 0 ;
$stmtGetUser  = $connect->prepare("SELECT * FROM users WHERE UserID = ?");
$stmtGetUser -> execute(array( $userid ));
$userInfo = $stmtGetUser ->fetch();
$count = $stmtGetUser ->rowCount();
if($count > 0){
?>
<!-- START PAGE CONTENT -->
<h2 class="text-center" >Welcome  <?php echo $sessionUser ?></h2>
<section class="my-info block " >
    <div class="container">

        <div class=" main-panel  col-sm-12 ">
        <div class="panel-heading bg-primary">Information</div>
        <div class="panel-body bg-body ">
            <div class="row">
            <div class="col-md-3">
                <img class="img-thumbnail" src="admin/uploades/itemsImages/<?php echo $userInfo['Avater'] ?>" alt="Avater">
            </div>
            <div class="col-md-6">
            <ul class="list-unstyled" >
            <li><i class="fa fa-unlock-alt "></i>
                <span>Name              :</span> <?php echo $userInfo['Username']  ?>    </li>
            <li> <i class="fa fa-envelope "></i>
                <span>Email             :</span> <?php echo $userInfo['Email'] ?>       </li>
            <li> <i class="fa fa-user-alt "></i>
                <span>Full Name         :</span> <?php echo $userInfo['Fullname'] ?></li>
            <li> <i class="fa fa-calendar-alt "></i>
                <span>Register Date     :</span> <?php echo $userInfo['Date'] ?></li>
                
                    <?php
                    if( $userInfo['TrustStatus'] == 1 ){ 
                        ?>
                        <li> <span>Trust : </span>
                        <i class=" righ-marck fa fa-check-circle "></i>
                        </li>
                        <?php
                    }
                    ?>
                
            </ul>
            </div>
            </div>
        </div>
    </div>
    </div>
</section>
<section class="my-ads block " >
    <div class="container">

        <div class=" main-panel  col-sm-12 ">
        <div class="panel-heading bg-primary">Ads</div>
        <div class="panel-body bg-body ">
            <?php 
           $items =getItems('Member_ID', $userInfo['UserID']);
           if(!empty($items)){
           echo '<div class="row">';
        foreach( $items as $item){
                ?>
                    <div class="col-sm-6 col-md-4 text-center">
                        <div class="img-thumbnail item-box">
                            <span class="price-tag"><?php echo '$'.$item['Price'] ?></span>
                            <?php
                            if($item['Approve'] != 1){
                                ?>
                                <span class=" werning-tag ">White Approveing</span>
                                <?php
                            }
                            ?>
                            <span class="price-tag"></span>
                            <img class="img-responsiv" src="admin/uploades/itemsImages/<?php echo $item['Image']?>" alt="">
                            <div class="caption">
                                <h3> <a href="item.php?itemid=<?php echo $item['Item_ID']?>"> <?php echo $item['Name']?></a></h3>
                                <?php
                                    if( isset($_SESSION['uid']) && $_SESSION['uid'] == $item['Member_ID']){
                                        ?>
                                    <div>
                                        <a class="btn btn-success" href="item.php?do=Edit&itemid=<?php echo $item['Item_ID'] ?>"> 
                                        <i class="fa fa-edit"></i>    
                                        Edite</a>
                                        <a class="confirm btn btn-danger" href="item.php?do=Delete&itemid=<?php echo $item['Item_ID'] ?>"> 
                                        <i class="fa fa-close"></i>    
                                        Deleted</a>
                                </div>
                                    <?php
                                    }else{
                                        ?>
                                        <div><a class="btn btn-info" href="paypage">Bay Now </a></div>
                                        <?php
                                    }
                                ?>
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
<?php
}else{
    // Redirect In the Erorr is Hapened
    $errorMasseg = '<div class="alert alert-danger" > ERROR  THIS ID IS NOT FONDET </div> ';
    $pageRedirct = 'back';
    echo '<div class="container" >';
    redirect($errorMasseg,$pageRedirct,3);
    echo '</div>';
}
?>
<!-- END PAGE CONTENT -->
<?php include $tpl.'footer.php';
ob_end_flush();
?>  