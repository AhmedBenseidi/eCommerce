<?php
/*
==============================================
==  Pge                         ==
== You Can Add | Edit |Delete               ==
==============================================
*/
ob_start("ob_gzhandler");
session_start();
$pageTitle = 'Mebers';
if(!isset($_SESSION['Username'])){
    header("Location: index.php"); //Redairect to Home Page
    exit();
}else{
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
    $stmt =  $connect->prepare("SELECT * FROM users WHERE Username =?");
    $stmt -> execute(array($searchword));
    $rows = $stmt -> fetchAll();
    ?>
        <h2 class="page-header text-center">Mebers Withe Name <?php echo $searchword?></h2>
            <div class="container">
                <!-- START Page Content  -->
                <div class="table-responsive">
                <table class="table table-bordered border-primary text-center">
                    <thead class="table-dark">
                    <tr>
                        <th class="table-dark">#ID</th>
                        <th class="table-dark">Username</th>
                        <th class="table-dark">Email</th>
                        <th class="table-dark">Full Name</th>
                        <th class="table-dark">Regitred Date</th>
                        <th class="table-dark">Control
                        </th>
                    </tr>
                    </thead>
                    <tbody>
                        <?php
                            foreach($rows as $row){
                                ?>
                                <tr>
                        <td class="table-info"><?php echo $row['UserID']?></td>
                        <td class="table-info"><?php echo $row['Username']?></td>
                        <td class="table-info"><?php echo $row['Email']?></td>
                        <td class="table-info"><?php echo $row['Fullname']?></td>
                        <td class="table-info"><?php echo $row['Date']?></td>
                        <td class="table-info">
                            <a href="mebers.php?do=Edit&UserID=<?php echo $row['UserID']?>" class="btn btn-success"> <i class="fa fa-edit"></i> Edit</a>
                            <a href="mebers.php?do=Delete&UserID=<?php echo $row['UserID']?>" class="confirm btn btn-danger"> <i class="fa-solid fa-user-minus"></i> Delete</a>
                            <?php
                            if($row['RegStatus'] == 0){
                                ?>
                            <a href="mebers.php?do=Activate&UserID=<?php echo $row['UserID']?>" class="btn btn-info"> <i class="fa fa-user-plus"></i> Activte </a>
                                <?php
                            }
                            ?>
                        </td>
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
    $stmt =  $connect->prepare("SELECT * FROM categoures WHERE Name = ?");
    $stmt -> execute(array($searchword));
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
                                    echo '<h4>'  .$row['Name'].       '</h4>';
                                    echo'<div class="full-view" >';
                                    echo empty($row['Description']) ? '<p>No Descrptin Foundet !</p>': '<p>'.$row['Description'].'</p>';
                                    echo $row['Visibility']    != 0 ? '  <span class="btn btn-danger" ><i class="fa  fa-eye-low-vision" ></i> Hidden</span>':'';
                                    echo $row['Allow_Comment'] != 0 ? '  <span class="btn btn-dark" ><i class="fa fa-lock" > </i> Comment Diseble</span>' : '';
                                    echo $row['Allow_Ads']     != 0 ? '<span class="btn btn-warning" ><i class="fa fa-lock" > </i> Ads Diseble</span>' : '';
                                    echo'<div class="hidden-btn">
                                    <a href="?do=Edit&CatID='.$row['ID'].'" class="btn btn-success"> <i class="fa fa-edit"></i> Edit</a>
                                    <a href="?do=Delete&CatID='.$row['ID'].'" class="confirm btn btn-danger"> <i class="fa-solid fa-user-minus"></i> Delete</a>
    
                                    </div>';

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
                $stmt =  $connect->prepare("SELECT
                                                *
                                            FROM 
                                                    items
                                                    WHERE Name = ?
                                        ");
        $stmt -> execute(array($searchword));
        $rows = $stmt -> fetchAll();
        ?>
        <h2 class="page-header text-center"> Items Withe Name <?php echo $searchword?></h2>
        <div class="container">
        <!-- START Page Content  -->
        <div class="table-responsive">
        <table class="table table-bordered border-primary text-center">
        <thead class="table-dark">
        <tr>
        <th class="table-dark">#ID</th>
        <th class="table-dark">Name</th>
        <th class="table-dark">Description</th>
        <th class="table-dark">Price</th>
        <th class="table-dark">Add Date </th>
        <th class="table-dark">Control</th>
        </tr>
        </thead>
        <tbody>
        <?php
        foreach($rows as $row){
        ?>
        <tr>
        <td class="table-info"><?php echo $row['Item_ID']?></td>
        <td class="table-info"><?php echo $row['Name']?></td>
        <td class="table-info"><?php echo $row['Description']?></td>
        <td class="table-info"><?php echo $row['Price']?></td>
        <td class="table-info"><?php echo $row['Add_Date']?></td>
        <td class="table-info">
        <a href="items.php?do=Edit&itemid=<?php echo $row['Item_ID']?>" class="btn btn-success"> <i class="fa fa-edit"></i> Edit</a>
        <a href="items.php?do=Delete&itemid=<?php echo $row['Item_ID']?>" class="confirm btn btn-danger"> <i class="fa-solid fa-user-minus"></i> Delete</a>
        <?php 
        if($row['Approve'] == 0){
        ?>
        <a href="items.php?do=Approve&itemid=<?php echo $row['Item_ID']?>" class="btn btn-info"> <i class="fa-solid fa-check"></i> Approve</a>
        <?php
        } ?>

        <?php

        ?>
        </td>
        </tr>
        <?php
        }
        ?>

        </tbody>
        </table>
        </div>

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

        }
        ob_end_flush();
        ?>