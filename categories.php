<?php 
ob_start();
session_start();
include 'init.php';?>
<!-- START PAGE CONTENT -->
<div class="container">
<?php
$items =getItems('Cat_ID',$_GET['pageid']);
$stmtCateName = $connect->prepare("SELECT * FROM categoures WHERE ID = ?");
foreach( $items as $item){
$stmtCateName->execute(array($item['Cat_ID']));
}
$catName = $stmtCateName->fetch();
    echo '<h2 class="text-center">';
    echo $catName['Name'];
    echo '</h2>';
    
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
                                <div><a class="btn btn-info" href="paypage">Bay Now </a></div>
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
<?php include $tpl.'footer.php';
ob_end_flush();
?>  