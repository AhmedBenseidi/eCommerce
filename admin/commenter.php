<?php
/*
==============================================
== Mange Comments Pge                         ==
== You Can Approve | Edit |Delete               ==
==============================================
*/
session_start();
$pageTitle = 'Comments';
if(!isset($_SESSION['Username'])){
    header("Location: index.php"); //Redairect to Home Page
    exit();
}else{
    include 'init.php';
    //START CONTENT
    $do = isset($_GET['do']) ? $_GET['do'] : 'Manage';
    if ($do == 'Manage'){ // mange page

    $stmt =  $connect->prepare("SELECT comments.*,items.Name AS item_Name ,users.Username AS Member_Username 
                                FROM comments
                                INNER JOIN items
                                ON items.Item_ID = comments.item_id
                                INNER JOIN users
                                ON users.UserID = comments.user_id
                                ");
    $stmt -> execute();
    $rows = $stmt -> fetchAll();
    ?>
        <h2 class="page-header text-center">Manage Comments</h2>
            <div class="container">
                <!-- START Page Content  -->
                <div class="table-responsive">
                <table class="table table-bordered border-primary text-center">
                    <thead class="table-dark">
                    <tr>
                        <th class="table-dark">#ID</th>
                        <th class="table-dark">Comment</th>
                        <th class="table-dark">Item Name</th>
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
                        <td class="table-info"><?php echo $row['c_id']?></td>
                        <td class="table-info"><?php echo $row['comment']?></td>
                        <td class="table-info"><?php echo $row['item_Name']?></td>
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
        
   <?php }
   
    elseif ($do == 'Edit'){ // Edit  
        $comid = isset($_GET['comid']) && is_numeric($_GET['comid']) ? intval($_GET['comid']) : 0 ;
        $stmt   = $connect->prepare("SELECT * FROM comments WHERE c_id = ? ");
        $stmt  -> execute(array($comid));
        $row    = $stmt -> fetch();
        $count  = $stmt -> rowCount();
        if($count > 0){
            ?>    
            <!-- START HTML     -->
            <h2 class="page-header text-center">Edit Comment</h2>
            <div class="container">
                <form class="form-horizontal" action="?do=Update" method="POST" >
                    <input type="hidden" name="comid" value="<?php echo $comid ?>">
                <!-- START Username -->
                <div class="mb-3 row">
                        <!--START UserNAME FILDE -->
                        <div class="col-sm-6 asckrisk-form search-select-box">
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
                                        if($user['UserID'] == $row['user_id']){
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
                </div>
                <div class="mb-3 row">        
                        <!--START Items FILDE -->
                        <div class=" col-sm-6 asckrisk-form search-select-box">
                                <label class="col-form-label" for="sl-item">Items</label>
                                <select name="itemid" id="sl-item" >
                                    <?php
                                    $stmt2 = $connect-> prepare("SELECT * FROM items ");
                                    $stmt2    -> execute();
                                    $items = $stmt2 ->fetchAll();
                                    foreach($items as $item){
                                        ?>
                                        <option  value="<?php echo $item['Item_ID']?>"
                                        <?php
                                        if($row['item_id'] == $item['Item_ID']){
                                            echo 'selected';
                                        }
                                        ?>
                                        ><?php echo $item['Name']?></option>
                                        <?php
                                    }
                                    ?>
                                </select>
                            </div>
                            <!-- END Items FILDE -->
                    </div>
                <!--  END  Username -->
                
                
                <!-- START EMAIL -->
                <div class="mb-3 row">
                        <div class="col-sm-6">
                            <label class="col-form-label"  for="com">Comment</label>
                            <textarea class="form-control" name="comment"  id="com" rows="5"  ><?php echo $row['comment']?></textarea>
                        </div>
                    </div>
                <!--  END  EMAIL -->
                <!-- START SUBMIT -->
                <div class="mb-3 row">
                        <div class="offset-sm-2 col-sm-10 ">
                            <input type="submit" value="Save Changes"   class="btn btn-primary btn-lg">
                        </div>
                    </div>
                <!--  END  SUBMIT -->
                
                    
                </form>
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
        echo '<h2 class="page-header text-center">Update Commenter</h2>';
        echo '<div class="container">';

        // GET FORM REQUEST 
        if($_SERVER['REQUEST_METHOD'] == 'POST'){
            $comid    = $_POST['comid'];
            $userid   = $_POST['userid'];
            $itemid   = $_POST['itemid'];
            $comment  = $_POST['comment'];
            
            
        // if checked is donn 
            if($_SERVER['REQUEST_METHOD'] == 'POST'){
            // UPDATE REQUEST 
                $stmt   = $connect->prepare("UPDATE
                                                    comments
                                            SET
                                                    comment  = ?, item_id = ?, user_id = ?
                                            WHERE c_id = ? ");
                $stmt  -> execute(array($comment,$itemid,$userid,$comid));
                
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
        echo '<h2 class="page-header text-center">Delete Commenter</h2>';
        echo '<div class="container">';
            // START Page Content
            $comid = isset($_GET['comid']) && is_numeric($_GET['comid']) ? intval($_GET['comid']) : 0 ;
            $Check = CheckItem('c_id','comments', $comid);
            if($Check > 0){
                $stmt =  $connect->prepare("DELETE FROM comments WHERE c_id = :id");
                $stmt -> bindParam(':id',$comid);
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
        echo '<h2 class="page-header text-center">Approve Commenter</h2>';
        echo '<div class="container">';
            // START Page Content
            $comid = isset($_GET['comid']) && is_numeric($_GET['comid']) ? intval($_GET['comid']) : 0 ;
            $Check = CheckItem('c_id','comments', $comid);
            if($Check > 0){
                $stmt =  $connect->prepare(" UPDATE comments SET Status = 1 WHERE c_id =:id");
                $stmt -> bindParam(':id',$comid);
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
