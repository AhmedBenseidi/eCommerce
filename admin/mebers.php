<?php
/*
==============================================
== Mange Mabers Pge                         ==
== You Can Add | Edit |Delete               ==
==============================================
*/
session_start();
$pageTitle = 'Members';
if(!isset($_SESSION['Username'])){
    header("Location: index.php"); //Redairect to Home Page
    exit();
}else{
    include 'init.php';
    //START CONTENT
    $do = isset($_GET['do']) ? $_GET['do'] : 'Manage';
    if ($do == 'Manage'){ // mange page
        $query ='';
        if( isset($_GET['Page']) and $_GET['Page'] == 'Panding'){
           $query = 'AND RegStatus = 0'; //Select Panding Users 
        }
        $sort = 'ASC';
        $sort_arrey = array('ASC','DESC');
        if(isset($_GET['sort']) &&  in_array($_GET['sort'] ,$sort_arrey)){
            $sort = $_GET['sort'] ;
        }
    $stmt =  $connect->prepare("SELECT * FROM users WHERE GroupID != 1 $query ORDER BY UserID $sort");
    $stmt -> execute();
    $rows = $stmt -> fetchAll();
    ?>
        <h2 class="page-header text-center">Manage Members</h2>
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
                        <div class="order fa-pull-right">
                                    Ordering :  
                                    <a <?php if($sort == 'ASC'){echo 'class="active"';}?> href="?sort=ASC">Asc</a> | 
                                    <a <?php if($sort == 'DESC'){echo 'class="active"';}?> href="?sort=DESC">Desc</a>
                                </div>
                        </th>
                    </tr>
                    </thead>
                    <tbody>
                        <?php
                            foreach($rows as $row){
                                ?>
                                <tr>
                        <td class="table-info"><?php echo $row['UserID']?></td>
                        <td class="table-info">
                            <img class="img-thumbnail Avater-img" src="uploades/itemsImages/<?php echo $row['Avater'] ?>" alt="">
                            <?php echo $row['Username']?></td>
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
        
   <?php }
    elseif ($do == 'Add'){ //Add Meber?> 
        <!-- START HTML     -->
        <h2 class="page-header text-center">Add New Mebers</h2>
            <div class="container">
                <form class="form-horizontal" action="?do=Insert" method="POST" enctype="multipart/form-data" >
                <!-- START Username -->
                <div class="mb-3 row">
                        <label for="user" class="col-sm-2 col-form-label">Username</label>
                        <div class="asckrisk-form col-sm-10 col-md-5">
                            <input type="text" name="username" placeholder="Username" required="required" minlength="3" maxlength="30" autocomplete="off"  class="form-control" id="user">
                        </div>
                    </div>
                <!--  END  Username -->
                <!-- START  Password -->
                <div class="mb-3 row">
                        <label for="Pass" class="col-sm-2 col-form-label">Password</label>
                        <div class="asckrisk-form col-sm-10 col-md-5">
                            <input type="password" name="password" required="required" autocomplete="new-password"   class="password form-control" placeholder="Password " id="Pass">
                            <i class="show-pass fa fa-eye"></i>
                        </div>
                    </div>
                <!--  END  Password -->
                <!-- START FULLNAME -->
                <div class="mb-3 row">
                        <label for="full" class="col-sm-2 col-form-label">Full Name</label>
                        <div class=" asckrisk-form col-sm-10 col-md-5">
                            <input type="text" name="fullname"  placeholder="Full Name" required="required" autocomplete="off"  class="form-control" id="full">
                        </div>
                    </div>
                <!--  END  FULLNAME -->
                <!-- START AVATER -->
                <div class="mb-3 row">
                        <label for="avt" class="col-sm-2 col-form-label">Profail Avater</label>
                        <div class=" asckrisk-form col-sm-10 col-md-5">
                            <input type="file" name="avater"    autocomplete="off"  class="form-control" id="avt">
                        </div>
                    </div>
                <!--  END  AVATER -->
                <!-- START EMAIL -->
                <div class="mb-3 row">
                        <label for="mail" class="col-sm-2 col-form-label">Email</label>
                        <div class="asckrisk-form col-sm-10 col-md-5">
                            <input type="email" name="email" placeholder="Email" required="required" autocomplete="off"  class="form-control" id="mail">
                        </div>
                    </div>
                <!--  END  EMAIL -->
                <!-- START SUBMIT -->
                <div class="mb-3 row">
                        <div class="offset-sm-2 col-sm-10 ">
                            <input type="submit" value="Add"   class="btn btn-primary btn-lg">
                        </div>
                    </div>
                <!--  END  SUBMIT -->
                
                    
                </form>
            </div>
            <!--  END  HTML     -->    
       
<?php   }elseif($do == 'Insert'){

       if($_SERVER['REQUEST_METHOD'] == 'POST'){
        //TItle
        echo '<h2 class="text-center">Insert Page</h2>';
        //Get input values
        $avaterName = $_FILES['avater']['name'];
        $avaterSize = $_FILES['avater']['size'];
        $avaterTemp = $_FILES['avater']['tmp_name'];
        $avaterType = $_FILES['avater']['type'];
        $avaterAllowedExtention = array("jpeg","jpg","png","gif"); //image Extntion Posibel
        $avaterExtention = strtolower(end( explode('.',$avaterName))); // get extention of image
        $username = $_POST['username'];
        $password = $_POST['password'];
        $email    = $_POST['email'];
        $fullname = $_POST['fullname'];
        // Crypeted the password
        $hachpass = sha1($password);
        //Checed If user is repted
        $CheckItemExicet = CheckItem('Username','users',$username);
        //Chek form values
        $formErrors = array();
        if(!empty($avaterName) && !in_array($avaterExtention,$avaterAllowedExtention)){$formErrors[] = 'Sory This File Not Suported';}
        if( $CheckItemExicet > 0){$formErrors[] = 'This  Username <strong>'.$username.' </strong> is already Reserved ';}
        if( strlen($username) < 3 ){$formErrors[] = 'Username Cant Be Less Than <strong> 3 Characters </strong>';}
        if( strlen($username) > 30 ){$formErrors[] = 'Username Cant Be Less Than <strong> 30 Characters </strong>';}
        if(empty($username)){$formErrors[] = 'Username Can be <strong> Empty </strong>';}
        if(empty($email)){$formErrors[] = 'Email Can be <strong> Empty </strong>';}
        if(empty($fullname)){$formErrors[] = 'Full Name Can be <strong> Empty </strong>';}
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
            $avater = rand(0,100000000000).'_'.$avaterName;
            $uploudesUrl = "uploades/avaters/".$avater;
            move_uploaded_file($avaterTemp,$uploudesUrl);

            // UPDATE REQUEST 
            
                $stmt   = $connect->prepare("INSERT INTO
                                users(Username, Password, Email, Fullname, RegStatus, Date, Avater)
                                             VALUES
                                                        (:user,:pass,:mail,:name, 1, now(), :avat )");
                $stmt  -> execute(array(
                                            'user' =>$username,
                                            'pass' =>$hachpass,
                                            'mail' =>$email,
                                            'name' =>$fullname,
                                            'avat' =>$avater
                ));
                    // Redirect In Opertin Seccussful
                $errorMasseg = '<div class="alert alert-success" >'.$stmt -> rowCount().' : Reqourd Is  Inserted ! </div> ';
                $pageRedirct = 'mebers.php';
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
}

    elseif ($do == 'Edit'){ // Edit fil Mebers 
        $userid = isset($_GET['UserID']) && is_numeric($_GET['UserID']) ? intval($_GET['UserID']) : 0 ;
        $stmt   = $connect->prepare("SELECT * FROM users WHERE UserID = ? LIMIT 1");
        $stmt  -> execute(array($userid));
        $row    = $stmt -> fetch();
        $count  = $stmt -> rowCount();
        if($count > 0){
            ?>    
            <!-- START HTML     -->
            <h2 class="page-header text-center">Edit Mebers</h2>
            <div class="container">
                <form class="form-horizontal" action="?do=Update" method="POST" >
                    <input type="hidden" name="userid" value="<?php echo $userid ?>">
                <!-- START Username -->
                <div class="mb-3 row">
                        <label for="user" class="col-sm-2 col-form-label">Username</label>
                        <div class="asckrisk-form col-sm-10 col-md-6">
                            <input type="text" name="username" value="<?php echo $row['Username']?> " required="required" minlength="3" maxlength="30" autocomplete="off"  class="form-control" id="user">
                        </div>
                    </div>
                <!--  END  Username -->
                <!-- START  Password -->
                <div class="mb-3 row">
                        <label for="Pass" class="col-sm-2 col-form-label">Password</label>
                        <div class="col-sm-10 col-md-6">
                            <input type="password" name="newpassword" autocomplete="new-password" class="form-control" placeholder="Leave Blank If You Dont Want To Changet " id="Pass">
                            <input type="hidden" name="oledpassword" value="<?php echo $row['Password']?>">
                        </div>
                    </div>
                <!--  END  Password -->
                <!-- START FULLNAME -->
                <div class="mb-3 row">
                        <label for="full" class="col-sm-2 col-form-label">Full Name</label>
                        <div class=" asckrisk-form col-sm-10 col-md-6">
                            <input type="text" name="fullname" value="<?php echo $row['Fullname']?> " required="required" autocomplete="off"  class="form-control" id="full">
                        </div>
                    </div>
                <!--  END  FULLNAME -->
                <!-- START EMAIL -->
                <div class="mb-3 row">
                        <label for="mail" class="col-sm-2 col-form-label">Email</label>
                        <div class="asckrisk-form col-sm-10 col-md-6">
                            <input type="email" name="email" value="<?php echo $row['Email']?> " required="required" autocomplete="off"  class="form-control" id="mail">
                        </div>
                    </div>
                <!--  END  EMAIL -->
                <!-- START SUBMIT -->
                <div class="mb-3 row">
                        <div class="offset-sm-2 col-sm-10 ">
                            <input type="submit" value="Save"   class="btn btn-primary btn-lg">
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
        echo '<h2 class="page-header text-center">Update Mebers</h2>';
        echo '<div class="container">';

        // GET FORM REQUEST 
        if($_SERVER['REQUEST_METHOD'] == 'POST'){
            $id       = $_POST['userid'];
            $username = $_POST['username'];
            $email    = $_POST['email'];
            $fullname = $_POST['fullname'];
            // Cack if Update password
            $pass     = empty($_POST['newpassword']) ? $pass = $_POST['oledpassword'] : $pass = sha1($_POST['newpassword']);
            // Chack && Validait FORM
            $formErrors = array();
            if( strlen($username) < 3 ){$formErrors[] = 'Username Cant Be Less Than <strong> 3 Characters </strong>';}
            if( strlen($username) > 30 ){$formErrors[] = 'Username Cant Be Less Than <strong> 30 Characters </strong>';}
            if(empty($username)){$formErrors[] = 'Username Can be <strong> Empty </strong>';}
            if(empty($email)){$formErrors[] = 'Email Can be <strong> Empty </strong>';}
            if(empty($fullname)){$formErrors[] = 'Full Name Can be <strong> Empty </strong>';}
            foreach($formErrors as $error){
                echo '<div class="alert alert-danger">'.$error . '</div>';
            }
            // if checked is donn 
            if(empty($formErrors)){
            // UPDATE REQUEST 
                $stmt   = $connect->prepare("UPDATE
                                                    users
                                            SET
                                                    Username  = ?, Email = ?, Fullname = ?, Password = ?
                                            WHERE UserID = ? ");
                $stmt  -> execute(array($username,$email,$fullname,$pass,$id));
                
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
            $userid = isset($_GET['UserID']) && is_numeric($_GET['UserID']) ? intval($_GET['UserID']) : 0 ;
            $Check = CheckItem('UserID','users', $userid);
            if($Check > 0){
                $stmt =  $connect->prepare("DELETE FROM users WHERE UserID = :id");
                $stmt -> bindParam(':id',$userid);
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
    elseif ($do == 'Activate'){
        echo '<h2 class="page-header text-center">Activate Mebers</h2>';
        echo '<div class="container">';
            // START Page Content
            $userid = isset($_GET['UserID']) && is_numeric($_GET['UserID']) ? intval($_GET['UserID']) : 0 ;
            $Check = CheckItem('UserID','users', $userid);
            if($Check > 0){
                $stmt =  $connect->prepare(" UPDATE users SET RegStatus = 1 WHERE UserID =:id");
                $stmt -> bindParam(':id',$userid);
                $stmt -> execute();
                // Redirect In the Succesful Opertin
                $errorMasseg = '<div class="alert alert-success" > '.$stmt -> rowCount().' : Reqourd Is  Activated ! </div> ';
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
