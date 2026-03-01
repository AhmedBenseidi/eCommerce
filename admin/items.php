<?php
/*
==============================================
==  Pge       OF ITEMS                      ==
== You Can Add | Edit |Delete               ==
==============================================
*/
ob_start("ob_gzhandler");
session_start();
$pageTitle = 'Items';
if(!isset($_SESSION['Username'])){
    header("Location: index.php"); //Redairect to Home Page
    exit();
}else{
    include 'init.php';
    //START CONTENT
    $do = isset($_GET['do']) ? $_GET['do'] : 'Manage';
    if ($do == 'Manage'){
        // mange page
            $stmt =  $connect->prepare("SELECT
                                                items.* ,categoures.Name AS Cat_Name,users.Username 
                                        FROM 
                                                items
                                        INNER JOIN 
                                            categoures
                                        ON
                                            categoures.ID = items.Cat_ID
                                        INNER JOIN
                                            users
                                        ON 
                                            users.UserID = items.Member_ID");
            $stmt -> execute();
            $rows = $stmt -> fetchAll();
      ?>
        <h2 class="page-header text-center">Manage Items</h2>
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
                        <th class="table-dark">Categoury</th>
                        <th class="table-dark">Username</th>
                        <th class="table-dark">Control</th>
                    </tr>
                    </thead>
                    <tbody>
                        <?php
                            foreach($rows as $row){
                                ?>
                                <tr>
                        <td class="table-info"><?php echo $row['Item_ID']?></td>
                        <td class="table-info">
                            <img class="img-thumbnail Avater-img " src="uploades/itemsImages/<?php echo $row['Image']?>" alt="">
                            <div class="">
                            <?php echo $row['Name']?>
                            </div>
                        </td>
                        <td class="table-info desc-box" ><?php echo $row['Description']?></td>
                        <td class="table-info"><?php echo $row['Price']?></td>
                        <td class="table-info"><?php echo $row['Add_Date']?></td>
                        <td class="table-info"><?php echo $row['Cat_Name']?></td>
                        <td class="table-info"><?php echo $row['Username']?></td>
                        <td class="table-info desc-box">
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

                <a class=" offset-sm-10 btn btn-primary" href="?do=Add"><i class="fa fa-plus"></i> Add New Item</a>
                <!--  END  Page Content  -->
            </div>
        
   <?php
    }
    elseif ($do == 'Add'){ 
        //ADD
        // START CATEGORE CONTENT
        ?>
<h2 class="text-center">Add New Item</h2>
            <div class="container">
                <form class="form-horizontal" action="?do=Insert" method="POST"  enctype="multipart/form-data" >
                    <div class="row">
                        <div class=" col-sm-6">

                            <!--START UserNAME FILDE -->
                            <div class="asckrisk-form search-select-box">
                                <label class="col-form-label" for="sl-user">Username</label>
                                <select name="userid" id="sl-user" >
                                    <option value="0">Chose Username</option>
                                    <?php
                                    $stmt = $connect-> prepare("SELECT * FROM users ");
                                    $stmt    -> execute();
                                    $users = $stmt ->fetchAll();
                                    foreach($users as $user){
                                        echo '<option value="'.$user['UserID'].'">'.$user['Username'].'</option>';
                                    }
                                    ?>
                                </select>
                            </div>
                            <!-- END UserNAME FILDE -->
                            <!--START Categours FILDE -->
                            <div class="asckrisk-form search-select-box">
                                <label class="col-form-label" for="sl-user">Categoures</label>
                                <select name="catid" id="sl-user" >
                                    <option value="0">Chose Categoury</option>
                                    <?php
                                    $Catstmt = $connect-> prepare("SELECT * FROM categoures ");
                                    $Catstmt    -> execute();
                                    $cats = $Catstmt ->fetchAll();
                                    foreach($cats as $cat){
                                        echo '<option value="'.$cat['ID'].'">'.$cat['Name'].'</option>';
                                    }
                                    ?>
                                </select>
                            </div>
                            <!-- END Categours FILDE -->
                            <!--START NAME FILDE -->
                            <div class="asckrisk-form">
                            <label class="col-form-label" for="it-name">Name</label>
                            <input class="form-control" type="text" name="name"  placeholder="Name Of Item" required="required" id="it-name">
                            </div>
                            <!-- END NAME FILDE -->
                            <!--START Price FILDE -->
                            <div class="asckrisk-form">
                            <label class="col-form-label" for="it-price">Price</label>
                            <input class="form-control" type="text" name="price"  placeholder="Price Of Item" required="required" id="it-price">
                            </div>
                            <!-- END Price FILDE -->
                            <!--START Country FILDE -->
                            <div class="asckrisk-form">
                            <label class="col-form-label" for="it-country">Country</label>
                            <input class="form-control" type="text" name="country"  placeholder="Country Of Made" required="required" id="it-country">
                            </div>
                            <!-- END Country FILDE -->
                            <!--START Status FILDE -->
                            <div class="asckrisk-form">
                            <label class="col-form-label" for="it-status">Status</label>
                            <input class="form-control" type="text" name="status"  placeholder="Status of Item" required="required" id="it-status">
                            </div>
                            <!-- END Status FILDE -->
                        </div>
                         <!-- START Description FILDE -->
                         <div class="asckrisk-form col-sm-6">
                            <label class="col-form-label"  for="cat-desc">Description</label>
                            <textarea class="form-control"  name="description" id="cat-desc" rows="10" required="required"  placeholder="Add a Description For your Item"></textarea>
                        
                         <!--  END Description FILDE -->
                         <!-- START Image FILDE -->
                         
                            <label class="col-form-label"  for="cat-img">Image</label>
                            <input type="file" class="form-control"  name="image" id="cat-img" >
                        </div>
                         <!--  END Image FILDE -->
                       
                      </div>

                    <!-- START SUBMIT -->
                    <div class="mb-3 row">
                            <div class="col-sm-10">
                                <input type="submit" value="Add New Itme"   class="cat-btn btn btn-primary fa-pull-right">
                            </div>
                        </div>
                    <!--  END  SUBMIT -->
                    </div>
                </form>    
            </div>
            
<?php
        //  END  Item CONTENT

    }elseif($do == 'Insert'){
        //INSERT
        // START Item CONTENT
        
       if($_SERVER['REQUEST_METHOD'] == 'POST'){
        //TItle
        echo '<h2 class="text-center">Insert Page</h2>';
        //Get input values
        $imageName = $_FILES['image']['name'];
        $imageSize = $_FILES['image']['size'];
        $imageTemp = $_FILES['image']['tmp_name'];
        $imageType = $_FILES['image']['type'];
        $imageAllowedExtention = array("jpeg","jpg","png","gif"); //image Extntion Posibel
        $imageExtention = strtolower(end( explode('.',$imageName))); // get extention of image
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
            // Redirect In Error Hapened
            $errorMasseg = '<div class="alert alert-danger" > '.$error.' </div> ';
            $pageRedirct = 'back';
            echo '<div class="container" >';
            redirect($errorMasseg,$pageRedirct,5);
            echo '</div>';
        }
        // if checked is donn 
        if(empty($formErrors)){
            $image = rand(0,100000000000).'_'.$imageName;
            $uploudesUrl = "uploades/itemsImages/".$image;
            move_uploaded_file($imageTemp,$uploudesUrl);
            // UPDATE REQUEST 
                $stmt   = $connect->prepare("INSERT INTO
                 items ( Name, Description, Price,  Country_Made , Status, Add_Date, Cat_ID, Member_ID, image)
                                 VALUES
                    (:name,:des,:price,:cont, :stat, NOW(),:catid, :userid, :zimage )");
                $stmt  -> execute(array(
                                            'name'    =>  $name,
                                            'des'     =>  $des,
                                            'price'   =>  $price,
                                            'cont'    =>  $country,
                                            'stat'    =>  $status,
                                            'catid'    =>  $catid,
                                            'userid'  =>  $userid,   
                                            'zimage'  =>  $image   
                ));
                    // Redirect In Opertin Seccussful
                $errorMasseg = '<div class="alert alert-success" >'.$stmt -> rowCount().' : Reqourd Is  Inserted ! </div> ';
                $pageRedirct = 'items.php';
                echo '<div class="container" >';
                redirect($errorMasseg,$pageRedirct,5);
                echo '</div>';
                
            }
    }else{
        
         // Redirect In the Erorr is Hapened
         $errorMasseg = '<div class="alert alert-danger" > ERROR  THIS ID IS NOT FONDET </div> ';
         $pageRedirct = 'back';
         echo '<div class="container" >';
         redirect($errorMasseg,$pageRedirct,5);
         echo '</div>';  

    }
        //  END  Item CONTENT
    }

    elseif ($do == 'Edit'){ 
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

                            <!--START UserNAME FILDE -->
                            <div class="asckrisk-form search-select-box">
                                <label class="col-form-label" for="sl-user">Username</label>
                                <select name="userid" id="sl-user" >
                                    <?php
                                    $stmt = $connect-> prepare("SELECT * FROM users ");
                                    $stmt    -> execute();
                                    $users = $stmt ->fetchAll();
                                    foreach($users as $user){
                                        ?>
                                        <option  value="<?php echo $user['UserID']?>"
                                        <?php
                                        if($user['UserID'] == $item['Member_ID']){
                                            echo 'selected';
                                        }
                                        ?>
                                        ><?php echo $user['Username']?></option>
                                        <?php
                                    }
                                    ?>
                                </select>
                            </div>
                            <!-- END UserNAME FILDE -->
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
                            <input type="file" class="form-control"  name="image" id="cat-img" >
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
                $stmt =  $connect->prepare("SELECT comments.*,users.Username AS Member_Username 
                                FROM comments
                                
                                INNER JOIN users
                                ON users.UserID = comments.user_id
                                WHERE item_id = ?");
                $stmt -> execute(array($itemid));
                $rows = $stmt -> fetchAll();
                ?>
            <h2 class="page-header text-center">Manage [<?php echo  $item['Name']?>] Comments</h2>
                <div class="container">
                <!-- START Page Content  -->
                <div class="table-responsive">
                <table class="table table-bordered border-primary text-center">
                    <thead class="table-dark">
                    <tr>
                        <th class="table-dark">Comment</th>
                        <th class="table-dark">User Name</th>
                        <th class="table-dark">Add Date</th>
                        <th class="table-dark">Control</th>
                    </tr>
                    </thead>
                    <tbody>
                        <?php
                            foreach($rows as $row){
                                ?>
                                <tr>
                        <td class="table-info"><?php echo $row['comment']?></td>
                        <td class="table-info"><?php echo $row['Member_Username']?></td>
                        <td class="table-info"><?php echo $row['comment_date']?></td>
                        <td class="table-info">
                            <a href="commenter.php?do=Edit&comid=<?php echo $row['c_id']?>" class="btn btn-success"> <i class="fa fa-edit"></i> Edit</a>
                            <a href="commenter.php?do=Delete&comid=<?php echo $row['c_id']?>" class="confirm btn btn-danger"> <i class="fa-solid fa-user-minus"></i> Delete</a>
                            <?php
                            if($row['status'] == 0){
                                ?>
                            <a href="commenter.php?do=Approve&comid=<?php echo $row['c_id']?>" class="btn btn-info"> <i class="fa fa-user-plus"></i> Activte </a>
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
         echo '<h2 class="page-header text-center">Update Mebers</h2>';
         echo '<div class="container">';
 
         // GET FORM REQUEST 
         if($_SERVER['REQUEST_METHOD'] == 'POST'){
            $imageName = $_FILES['image']['name'];
            $imageSize = $_FILES['image']['size'];
            $imageTemp = $_FILES['image']['tmp_name'];
            $imageType = $_FILES['image']['type'];
            $imageAllowedExtention = array("jpeg","jpg","png","gif"); //image Extntion Posibel
            $imageExtention = strtolower(end( explode('.',$imageName))); // get extention of image
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
                $image = rand(0,100000000000).'_'.$imageName;
                $uploudesUrl = "uploades/itemsImages/".$image;
                move_uploaded_file($imageTemp,$uploudesUrl);
             // UPDATE REQUEST 
                 $stmt   = $connect->prepare("UPDATE
                                                     items
                                             SET
                 Name=?, Description=?, Price=?, Country_Made=? , Status=?,  Cat_ID=?, Member_ID =?,Image = ?
                                             WHERE Item_ID = ? ");
                 $stmt  -> execute(array($name, $des, $price, $country, $status, $catid, $userid, $image, $itemid));
                 
                 // Redirect In the Succesful Opertin
                 $errorMasseg = '<div class="alert alert-success" > '.$stmt -> rowCount().' : Reqourd Is  Upadeted ! </div> ';
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
    }
    elseif ($do == 'Delete'){
        echo '<h2 class="page-header text-center">Delete Mebers</h2>';
        echo '<div class="container">';
            // START Page Content
            $itemid= isset($_GET['itemid']) && is_numeric($_GET['itemid']) ? intval($_GET['itemid']) : 0 ;
            $Check = CheckItem('Item_ID','items', $itemid);
            if($Check > 0){
                $stmt =  $connect->prepare("DELETE FROM items WHERE Item_ID = :id");
                $stmt -> bindParam(':id',$itemid);
                $stmt -> execute();
                // Redirect In the Succesful Opertin
                $errorMasseg = '<div class="alert alert-success" > '.$stmt -> rowCount().' : Reqourd Is  Deleted ! </div> ';
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
    elseif ($do == 'Approve'){
        echo '<h2 class="page-header text-center">Approve Item</h2>';
        echo '<div class="container">';
            // START Page Content
            $itemid = isset($_GET['itemid']) && is_numeric($_GET['itemid']) ? intval($_GET['itemid']) : 0 ;
            $Check = CheckItem('Item_ID','items', $itemid);
            if($Check > 0){
                $stmt =  $connect->prepare("UPDATE items SET Approve = 1 WHERE Item_ID =:id");
                $stmt -> bindParam(':id',$itemid);
                $stmt -> execute();
                // Redirect In the Succesful Opertin
                $errorMasseg = '<div class="alert alert-success" > '.$stmt -> rowCount().' : Reqourd Is  Approved ! </div> ';
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
    else{
                // Redirect In the Error is Hapen
                $errorMasseg = '<div class="alert alert-danger" > erorr your Page /<strong>'.$do.'</strong>  Note Fondet </div> ';
                $pageRedirct = 'back';
                echo '<div class="container" >';
                redirect($errorMasseg,$pageRedirct,5);
                echo '</div>';
    }
    
    //END CONTENT
    include $tpl.'footer.php';

}
ob_end_flush();
?>