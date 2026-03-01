<?php
/*
==============================================
==  Pge                         ==
== You Can Add | Edit |Delete               ==
==============================================
*/
ob_start("ob_gzhandler");
session_start();
$pageTitle = 'Search';
    include 'init.php';
    //START CONTENT
    $searchword = $_GET['word'];
    $userCK = CheckItem('Username','users',$searchword);
    // STATR VIEW MEBERS SEARCH
    if($userCK > 0){
        // mange page
        $query ='';
        if( isset($_GET['Page']) and $_GET['Page'] == 'Panding'){
           $query = 'AND RegStatus = 0'; //Select Panding Users 
        }
    $stmt =  $connect->prepare("SELECT * FROM users WHERE Username LIKE '%$searchword%'");
    $stmt -> execute();
    $rows = $stmt -> fetchAll();
    ?>
        <h2 class="page-header text-center">Mebers Withe Name <?php echo $searchword?></h2>
            <div class="container">
                <!-- START Page Content  -->
                <div class="table-responsive">
                <table class="table table-bordered border-primary text-center">
                    <thead class="table-dark">
                    <tr>
                        <th class="table-dark"> Username</th>
                        <th class="table-dark">Email</th>
                        <th class="table-dark">Full Name</th>
                    </tr>
                    </thead>
                    <tbody>
                        <?php
                            foreach($rows as $row){
                                ?>
                                <tr>
                        
                        <td class="table-info"> 
                            <img class="Avater-img img-thumbnail" src="admin/uploades/itemsImages/<?php echo $row['Avater']?>" alt="">
                        <a href="showprofile.php?userid=<?php echo $row['UserID']?>"><?php echo $row['Username']?></a> </td>
                        <td class="table-info"><?php echo $row['Email']?></td>
                        <td class="table-info"><?php echo $row['Fullname']?></td>
                        
                        </tr>
                                <?php
                            }
                            ?>
                    
                    </tbody>
                </table>
                </div>

                <a class=" offset-sm-10 btn btn-primary" href="?do=Add"><i class="fa fa-plus"></i> Add New Maber</a>
                <!--  END  Page Content  -->
            </div>
        
   <?php
    }
    //  END VIEW MEBERS SEARCH
    $CatCK = CheckItem('Name','categoures',$searchword);
    // STATR VIEW MEBERS SEARCH
    if($CatCK > 0){
        //MANGER
        // START CATEGORE CONTENT
    $stmt =  $connect->prepare("SELECT * FROM categoures WHERE Name LIKE '%$searchword%' ");
    $stmt -> execute();
    $rows = $stmt -> fetchAll();
    ?>
        <h2 class="page-header text-center"> Categories Withe Name <?php echo $searchword?></h2>
            <div class="container">
                <!-- START Page Content  -->
                <section class="latest" >
            <div class="container">
                <div class="row">
                    <div class="col-md-12">
                        <div class="panel panel-default">
                            <div class="main-panel">
                            <div class="panel-heading">
                                <i class="fa fa-tag"></i>
                                Categories
                               
                            </div>
                            <div class="panel-body cat-view">
                                
                                <?php
                                   foreach($rows as $row){
                                    echo '<div class="cat cat-clule">';
                                    echo '<h4> <a href="categories.php?pageid='.$row['ID'].'"> '.$row['Name'].'</a></h4>';
                                    echo'<div class="full-view" >';
                                    echo empty($row['Description']) ? '<p>No Descrptin Foundet !</p>': '<p>'.$row['Description'].'</p>';
                                
                                    echo '</div> ';
                                    echo '<hr>';
                                    echo ' </div>';

                                    
                                }
                                ?> 
                                
                               
                            </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </section>

                        <!--  END  Page Content  -->
                    </div>
                
        <?php 
                //  END  CATEGORE CONTENT
            }
            //  END VIEW MEBERS SEARCH
            $itemsCheck = CheckItem('Name','items',$searchword);
            // STATR VIEW MEBERS SEARCH
            if($itemsCheck > 0){
                // mange page
                $stmt =  $connect->prepare("SELECT * FROM `items` WHERE Name LIKE :value ");
        $search_value = '%'.$searchword.'%';
        $stmt->bindParam("value",$search_value);
        $stmt -> execute();
        $rows = $stmt -> fetchAll();
        
        ?>
        <h2 class="page-header text-center"> Items Withe Name <?php echo $searchword?></h2>
        <div class="container">
        <!-- START Page Content  -->
        <?php foreach($rows as $item){?>
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
                                <div><a class="btn btn-info" href="paypage">Bay Now </a></div>
                                <?php } ?>
                                <div class="date" ><?php echo $item['Add_Date']?></div>
                            </div>
                        </div>
                    </div>
                    <?php }?>
        <!--  END  Page Content  -->
        </div>

        <?php
            }
            if(
                $CatCK ==0 && $userCK ==0 && $itemsCheck ==0
            ){
                ?>
                <h2 class="text-center alert alert-info" >No Reuslta !</h2>
                <?php
            }
            //END CONTENT
            include $tpl.'footer.php';
        ob_end_flush();
        ?>