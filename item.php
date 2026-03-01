<?php
ob_start();
session_start();
$pageTitle= 'Show Books';

include 'init.php';
//START CONTENT
$do = isset($_GET['do']) ? $_GET['do'] : 'Manage';
if ($do == 'Manage'){
$itemid = isset($_GET['itemid']) && is_numeric($_GET['itemid']) ? intval($_GET['itemid']) : 0 ;
        $stmt   = $connect->prepare("SELECT items.*,categoures.Name AS Cat_Name,users.Username,categoures.Allow_Comment 
                                    FROM 
                                        items 
                                    INNER JOIN
                                        categoures
                                    ON 
                                        items.Cat_ID = categoures.ID
                                    INNER JOIN 
                                        users 
                                    ON 
                                        items.Member_ID = users.UserID
                                    WHERE
                                        Item_ID = ?
                                    AND
                                        Approve = 1");
        $stmt  -> execute(array($itemid));
        $count  = $stmt -> rowCount();
        if($count >0){
            $item    = $stmt -> fetch();
            ?>
            <!-- START PAGE CONTENT -->
            <h2 class="text-center" ><?php echo $item['Name'] ?></h2>
            <div class="container">
                <div class="row">
                    <div class="col-md-3">
                    <img class="img-responsiv img-thumbnail " src="admin/uploades/itemsImages/<?php echo $item['Image'] ?>" alt="">
                    </div>
                    <div class="col-md-9 info-item ">
                        <ul class="list-unstyled" >
                            <li> 
                                <h3><i class="fa fa-box-open "></i> <?php echo $item['Name'] ?></h3></li>
                            <li> 
                                <p> <i class="fa fa-newspaper "></i> <?php echo $item['Description'] ?></p></li>
                            <li> <i class="fa fa-money-bill "></i>
                                <span>Price : </span>$<?php echo $item['Price'] ?></li>
                            <li><i class="fa fa-calendar "></i>
                                <span>Add Dtae : </span><?php echo $item['Add_Date'] ?></li>
                            <li><i class="fa fa-building "></i>
                                <span>Made In :</span><?php echo $item['Country_Made'] ?></li>
                            <li><i class="fa fa-star "></i>
                                <span> Status  : </span><?php echo $item['Status'] ?></li>
                            <li><i class="fa fa-tags "></i>
                                <span>Categoury :</span>
                                 <a href="categories.php?pageid=<?php echo $item['Cat_ID'] ?>">
                                <?php echo $item['Cat_Name'] ?></a></li>
                            <li><i class="fa fa-user " title="Trusted seller" ></i>
                                <span>Advertiser :</span> <a href="showprofile.php?userid=<?php echo $item['Member_ID'] ?>"><?php echo $item['Username'] ?></a></li>
                        </ul>    
                    </div>
                </div>
                <hr>
                <!-- Start Add Comment Form -->
                <?php
                if(isset($_SESSION['User'])){
                    if($item['Allow_Comment']==0){
                    ?>

                    <div class="row">
                        <div class=" offset-3 col-md-6">
                        <form action="<?php echo $_SERVER['PHP_SELF'] ?>?itemid=<?php echo $item['Item_ID'] ?>" method="post">
                        <textarea class="form-control"  name="comment" id="" placeholder="Add Comment" required ></textarea>
                        <input class="btn btn-primary fa-pull-right " type="submit" value="Add Comment">
                    </form>
                    <?php 
                    
                        if($_SERVER['REQUEST_METHOD'] == 'POST'){
                            $comment = filter_var($_POST['comment'],FILTER_SANITIZE_STRING);
                            $itemid =  $item['Item_ID'];
                            $userid =  $_SESSION['uid'];
                            if( empty($comment) ){
                                ?>
                                <div class="text-bg-danger">
                                    Sory Comment Cant Be Empty
                                </div>
                                <?php
                            }else{
                                $stmtAddComment = $connect->prepare("INSERT INTO
                                comments(comment, status, comment_date, item_id, user_id)
                                                                    VALUES
                                                    (:zcomment, 0, NOW(), :zitemid, :zuserid)         
                                ");
                                $stmtAddComment->execute(array(
                                    'zcomment' => $comment,
                                    'zitemid'  => $itemid,
                                    'zuserid'  => $userid
                                ));
                                if( $stmtAddComment){
                                    echo '<div class="text-bg-success">
                                    Comment Added
                                    </div>';
                                }

                            }

                        }
                    ?>
                        </div>
                    </div>
                    <?php
                    }else{
                        echo'<div class="alert alert-warning" >Sory Comments feature is not available</div>';
                    }
                }else{
                    ?>
                    <div> Please 
                        <a href="login.php">LOGIN</a>
                        Or 
                        <a href="singup.php">SINGUP</a>
                        To Add New Comment
                    </div>
                    <?php
                }
                ?>
                <!--  END  Add Comment Form -->
                <?php

                    $stmt =  $connect->prepare("SELECT
                     comments.* ,users.Username AS Member_Username,users.Avater 
                        FROM comments
                        INNER JOIN users
                        ON users.UserID = comments.user_id
                        WHERE item_id = ?
                        AND status = 1 
                        ORDER BY c_id DESC
                    ");
                    $stmt -> execute(array($itemid));
                    $rows = $stmt -> fetchAll();
                ?>
                <hr>
                <div class="comment-box"></div>
                <?php
                foreach($rows as $row){
                    ?>
                <div class="row">
                    <div class="comment-box">
                        <div class="col-md-2 user-info ">
                        <img class="img-responsiv img-thumbnail" src="admin/uploades/itemsImages/<?php echo $row['Avater'] ?>" alt="">
                            <span class="username"><?php echo $row['Member_Username']?></span>
                        </div>
                        <div class="col-md-9">
                            <p><?php echo $row['comment']?></p>
                        </div>
                    </div>
                </div>
                    <?php
                }
                ?>
                
            </div>
            <!--  END  PAGE CONTENT -->
            <?php
        }else{
            // Redirect In the Erorr is Hapened
            $errorMasseg = '<div class="alert alert-danger" >
            ERROR  THIS ID IS NOT FONDET 
            Or Item Not Approveal
            </div> ';
            $pageRedirct = 'back';
            echo '<div class="container" >';
            redirect($errorMasseg,$pageRedirct,3);
            echo '</div>';  
        }
} elseif ($do == 'Edit'){ 
    $itemid = isset($_GET['itemid']) && is_numeric($_GET['itemid']) ? intval($_GET['itemid']) : 0 ;
    $stmt   = $connect->prepare("SELECT * FROM items WHERE Item_ID = ? ");
    $stmt  -> execute(array($itemid));
    $item    = $stmt -> fetch();
    $count  = $stmt -> rowCount();
    if($count > 0){
        ?>    
        <!-- START HTML     -->
        <div class="container">
            <form class="form-horizontal" action="?do=Update" method="POST" enctype="multipart/form-data" >
                <input type="hidden" name="itemid" value="<?php echo $itemid?>">
                <div class="row">
                    <div class=" col-sm-6">

                        <!--START Categours FILDE -->
                        <div class="asckrisk-form search-select-box">
                            <label class="col-form-label" for="sl-user">Categoures</label>
                            <select name="catid" id="sl-user" >
                                <?php
                                $Catstmt = $connect-> prepare("SELECT * FROM categoures ");
                                $Catstmt    -> execute();
                                $cats = $Catstmt ->fetchAll();
                                foreach($cats as $cat){
                                    ?>
                                    <option  value="<?php echo $cat['ID']?>"
                                    <?php
                                    if($cat['ID'] == $item['Cat_ID']){
                                        echo 'selected';
                                    }
                                    ?>
                                    ><?php echo $cat['Name']?></option>'
                                    <?php
                                }
                                ?>
                            </select>
                        </div>
                        <!-- END Categours FILDE -->
                        <!--START NAME FILDE -->
                        <div class="asckrisk-form">
                        <label class="col-form-label" for="it-name">Name</label>
                        <input class="form-control" type="text" name="name" value="<?php echo $item['Name']?>"  placeholder="Name Of Item" required="required" id="it-name">
                        </div>
                        <!-- END NAME FILDE -->
                        <!--START Price FILDE -->
                        <div class="asckrisk-form">
                        <label class="col-form-label" for="it-price">Price</label>
                        <input class="form-control" type="text" name="price" value="<?php echo $item['Price']?>"  placeholder="Price Of Item" required="required" id="it-price">
                        </div>
                        <!-- END Price FILDE -->
                        <!--START Country FILDE -->
                        <div class="asckrisk-form">
                        <label class="col-form-label" for="it-country">Country</label>
                        <input class="form-control" type="text" name="country" value="<?php echo $item['Country_Made']?>" placeholder="Country Of Made" required="required" id="it-country">
                        </div>
                        <!-- END Country FILDE -->
                        <!--START Status FILDE -->
                        <div class="asckrisk-form">
                        <label class="col-form-label" for="it-status">Status</label>
                        <input class="form-control" type="text" name="status" value="<?php echo $item['Status']?>"  placeholder="Status of Item" required="required" id="it-status">
                        </div>
                        <!-- END Status FILDE -->
                    </div>
                     <!-- START Description FILDE -->
                     <div class="asckrisk-form col-sm-6">
                        <label class="col-form-label"  for="cat-desc">Description</label>
                        <textarea class="form-control"  name="description" id="cat-desc" rows="10" required="required"  placeholder="Add a Description For your Item"><?php echo $item['Description']?></textarea>
                    
                     <!--  END Description FILDE -->
                   <!-- START Image FILDE -->
                     
                   <label class="col-form-label"  for="cat-img">Image</label>
                        <input type="file"  class="form-control"  name="image" id="cat-img" >
                        <input type="hidden" value="<?php echo $item['Image']?>"  name="Oledimage">
                    </div>
                     <!--  END Image FILDE -->
                  </div>

                <!-- START SUBMIT -->
                <div class="mb-3 row">
                        <div class="col-sm-10">
                            <input type="submit" value="Save Itme"   class="cat-btn btn btn-primary fa-pull-right">
                        </div>
                    </div>
                <!--  END  SUBMIT -->
                </div>
            </form>  
            <?php
            $stmt =  $connect->prepare("SELECT comments.*,users.Username AS Member_Username,users.Avater 
                            FROM comments
                            
                            INNER JOIN users
                            ON users.UserID = comments.user_id
                            WHERE item_id = ?");
            $stmt -> execute(array($itemid));
            $rows = $stmt -> fetchAll();
            $commentCount = $stmt ->rowCount();
            if($commentCount > 0){
                foreach($rows as $row){
            ?>
        <h2 class="page-header text-center"> <?php echo "People's opinions about ".$item['Name']?> </h2>
            <div class="container">
            <!-- START Page Content  -->
                    
                <div class="row">
                    <div class="comment-box">
                        <div class="col-md-2 user-info ">
                        <img class="img-responsiv img-thumbnail" src="admin/uploades/itemsImages/<?php echo $row['Avater'] ?>" alt="">
                            <span class="username"><?php echo $row['Member_Username']?></span>
                        </div>
                        <div class="col-md-9">
                            <p><?php echo $row['comment']?></p>
                        </div>
                    </div>
                </div>
                    <?php
                }
            }
                ?>
            <!--  END  Page Content  -->
        </div>
      
        </div>
        <!--  END  HTML     -->
        
        <?php
          
        
    }else{
        // Redirect In the Erorr is Hapened
        $errorMasseg = '<div class="alert alert-danger" > ERROR  THIS ID IS NOT FONDET </div> ';
        $pageRedirct = 'back';
        echo '<div class="container" >';
        redirect($errorMasseg,$pageRedirct,5);
        echo '</div>';  
    }

}

elseif ($do == 'Update'){ // Update page
     // Update page
     echo '<h2 class="page-header text-center">Update Book</h2>';
     echo '<div class="container">';

     // GET FORM REQUEST 
     if($_SERVER['REQUEST_METHOD'] == 'POST'){
        $imageName = $_FILES['image']['name'];
        $imageSize = $_FILES['image']['size'];
        $imageTemp = $_FILES['image']['tmp_name'];
        $imageType = $_FILES['image']['type'];
        $imageAllowedExtention = array("jpeg","jpg","png","gif"); //image Extntion Posibel
        $imageExtention = strtolower(end( explode('.',$imageName))); // get extention of image
        $Oledimage   =  $_POST['Oledimage'];
        $itemid      =  $_POST['itemid'];
        $name        =  $_POST['name'];
        $des         =  $_POST['description'];
        $price       =  $_POST['price'];
        $country     =  $_POST['country'];
        $status      =  $_POST['status'];
        $catid       =  $_POST['catid'];
        $userid      =  $_POST['userid'];     
        //Chek form values
            $formErrors = array();
            if(!empty($imageName) && !in_array($imageExtention,$imageAllowedExtention)){$formErrors[] = 'Sory This File Not Suported';}
            if(empty($name)){   $formErrors[] = 'Name Can be <strong> Empty </strong>';}
            if(empty($des)){    $formErrors[] = 'Description Can be <strong> Empty </strong>';}
            if(empty($price)){  $formErrors[] = 'Price Can be <strong> Empty </strong>';}
            if(empty($country)){$formErrors[] = 'Country Can be <strong> Empty </strong>';}
            if(empty($status)){ $formErrors[] = 'Status Can be <strong> Empty </strong>';}
        
         foreach($formErrors as $error){
             echo '<div class="alert alert-danger">'.$error . '</div>';
         }
         // if checked is donn 
         if(empty($formErrors)){
            if(empty($imageName)){
                 $image = $Oledimage;
             }else{
                $image = rand(0,100000000000).'_'.$imageName;
                $uploudesUrl = "admin/uploades/itemsImages/".$image;
                move_uploaded_file($imageTemp,$uploudesUrl);
            }
            
         // UPDATE REQUEST 
             $stmt   = $connect->prepare("UPDATE
                                                 items
                                         SET
             Name=?, Description=?, Price=?, Country_Made=? , Status=?,  Cat_ID=?,Image = ?,Approve = 0
                                         WHERE Item_ID = ? ");
             $stmt  -> execute(array($name, $des, $price, $country, $status, $catid, $image, $itemid));
             
             // Redirect In the Succesful Opertin
             $errorMasseg = '<div class="alert alert-success" > An amendament request will be reviewed by the adminstration </div> ';
             $pageRedirct = 'back';
             echo '<div class="container" >';
             redirect($errorMasseg,$pageRedirct,5);
             echo '</div>';
         }
         
     }else{
          // Redirect In the Erorr is Hapened
          $errorMasseg = '<div class="alert alert-danger" > This Page Not Acsses For You ! </div> ';
          $pageRedirct = 'back';
          echo '<div class="container" >';
          redirect($errorMasseg,$pageRedirct,5);
          echo '</div>';           
     }
     echo '</div>';
}elseif ($do == 'Delete'){
    echo '<h2 class="page-header text-center">Delete Book</h2>';
    echo '<div class="container">';
        // START Page Content
        $itemid= isset($_GET['itemid']) && is_numeric($_GET['itemid']) ? intval($_GET['itemid']) : 0 ;
        $Check = CheckItem('Item_ID','items', $itemid);
        if($Check > 0){
            $stmt =  $connect->prepare("DELETE FROM items WHERE Item_ID = :id");
            $stmt -> bindParam(':id',$itemid);
            $stmt -> execute();
            // Redirect In the Succesful Opertin
            $errorMasseg = '<div class="alert alert-success" > Hase been Deleted ! </div> ';
            $pageRedirct = 'back';
            echo '<div class="container" >';
            redirect($errorMasseg,$pageRedirct,5);
            echo '</div>';
        }else{
            // Redirect In the Error is Hapen
            $errorMasseg = '<div class="alert alert-danger" > ERROR  THIS ID IS NOT FONDET</div> ';
            $pageRedirct = 'back';
            echo '<div class="container" >';
            redirect($errorMasseg,$pageRedirct,5);
            echo '</div>';
        }
        
        //  End  Page Content
    echo '</div>';
}

 include $tpl.'footer.php';

ob_end_flush();
?>  