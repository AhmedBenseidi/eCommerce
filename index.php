<?php
session_start();
$pageTitle='Home Page';
include 'init.php';?>
<!-- START PAGE CONTENT -->
<div class="container">
<?php
    $stmtGetAllItems = $connect->prepare("SELECT * FROM `items` WHERE Approve = 1 ORDER BY Item_ID DESC");
    $stmtGetAllItems->execute();
    $items = $stmtGetAllItems->fetchAll();
    if(!empty($items)){
        echo '<div class="row">';
        foreach( $items as $item){
                ?>
                    <div class="col-sm-6 col-md-4 text-center box-demo">
                        <div class="img-thumbnail item-box ">
                            <span class="price-tag">$<?php echo $item['Price'] ?></span>
                            <img class="img-responsiv" src="admin/uploades/itemsImages/<?php echo $item['Image']?>" alt="">
                            <div class="caption">
                                <h3 title="<?php echo $item['Name']?>" ><a href="item.php?itemid=<?php echo $item['Item_ID']?>">
                                <?php echo $item['Name']?></a></h3>
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
                                <div><a class="btn btn-info" href="paypage.php?itemID=<?php echo $item['Item_ID'] ?>">Bay Now </a></div>
                                <?php } ?>
                                <div class="date" ><?php echo $item['Add_Date']?></div>
                            </div>
                        </div>
                    </div>
                <?php
                }
        echo '</div>';
}else{
    echo 'No items Yat ';
}
?>
</div>
<!-- END PAGE CONTENT -->
<?php include $tpl.'footer.php';?>  