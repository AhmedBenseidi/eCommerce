<?php
ob_start();
session_start();
if(isset($_SESSION['User'])){
$pageTitle= $_SESSION['User'].' Profile';

include 'init.php';
$stmtGetUser  = $connect->prepare("SELECT * FROM users WHERE Username = ?");
$stmtGetUser -> execute(array($sessionUser));
$userInfo = $stmtGetUser ->fetch();
if($_SERVER['REQUEST_METHOD'] == 'POST'){
    //Get input values
    $avaterName = $_FILES['avater']['name'];
    $avaterSize = $_FILES['avater']['size'];
    $avaterTemp = $_FILES['avater']['tmp_name'];
    $avaterType = $_FILES['avater']['type'];
    $avaterAllowedExtention = array("jpeg","jpg","png","gif"); //image Extntion Posibel
    $avaterExtention = strtolower(end( explode('.',$avaterName))); // get extention of image
    $id       = $_SESSION['uid'];
    $username = $sessionUser;
    $email    = $_POST['email'];
    $fullname = $_POST['fullname'];
    // Cack if Update password
    $pass     = empty($_POST['newpassword']) ? $pass = $userInfo['Password'] : $pass = sha1($_POST['newpassword']);
    // Chack && Validait FORM
    $formErrors = array();
    if(!empty($avaterName) && !in_array($avaterExtention,$avaterAllowedExtention)){$formErrors[] = 'Sory This File Not Suported';}
    if(empty($email)){$formErrors[] = 'Email Can be <strong> Empty </strong>';}
    if(empty($fullname)){$formErrors[] = 'Full Name Can be <strong> Empty </strong>';}
    foreach($formErrors as $error){
        echo '<div class="alert alert-danger">'.$error . '</div>';
    }
    // if checked is donn 
    if(empty($formErrors)){
        if(empty($avaterName)){
            $avater = $userInfo['Avater'];
        }else{
        $avater = rand(0,100000000000).'_'.$avaterName;
            $uploudesUrl = "admin/uploades/itemsImages/".$avater;
            move_uploaded_file($avaterTemp,$uploudesUrl);
        }
    // UPDATE REQUEST 
        $stmt   = $connect->prepare("UPDATE
                                            users
                                    SET
                                            Email = ?, Fullname = ?, Password = ?, Avater = ?
                                    WHERE UserID = ? ");
        $stmt  -> execute(array($email,$fullname,$pass,$avater,$id));
        
        // Redirect In the Succesful Opertin
        $errorMasseg = '<div class="alert alert-success" > '.$stmt -> rowCount().' : Reqourd Is  Upadeted ! </div> ';
        $pageRedirct = 'back';
        echo '<div class="container" >';
        redirect($errorMasseg,$pageRedirct,5);
        echo '</div>';
    }
    
}

?>
<!-- START PAGE CONTENT -->
<h2 class="text-center" >Welcome  <?php echo $sessionUser ?></h2>
<section class="my-info block " >
    <div class="container">

        <div class=" main-panel  col-sm-12 ">
            <div class="panel-heading bg-primary">Edite Information</div>
            <div class="panel-body bg-body ">
            
            <?php 
            $userid = $_SESSION['uid'];
                $stmt   = $connect->prepare("SELECT * FROM users WHERE UserID = ? LIMIT 1");
                $stmt  -> execute(array($userid));
                $row    = $stmt -> fetch();
                $count  = $stmt -> rowCount();
                if($count > 0){
                    ?>
                    <div class="row">
                        <div class="col-md-3">
                            <img class="img-thumbnail" src="admin/uploades/itemsImages/<?php echo $row['Avater'] ?>" alt="">
                        </div>
                        <div class="col-md-8">
                    <form action="<?php echo $_SERVER['PHP_SELF'] ?>" method="POST" enctype="multipart/form-data" >
                        <!-- START Username -->
                        <label for="user" class=" col-form-label">Username</label>
                        <div class="asckrisk-form col-sm-10 col-md-8">
                            <input type="text" readonly value="<?php echo $row['Username']?> "   class="form-control" id="user">
                        </div>
                    <!--  END  Username -->
                    <!-- START  Password -->
                        <label for="Pass" class="col-sm-2 col-form-label">Password</label>
                        <div class="col-sm-10 col-md-8">
                            <input type="password" name="newpassword" autocomplete="new-password" class="form-control" placeholder="Leave Blank If You Dont Want To Changet " id="Pass">
                        </div>
                <!--  END  Password -->
                <!-- START FULLNAME -->
                
                        <label for="full" class="col-sm-2 col-form-label">Full Name</label>
                        <div class=" asckrisk-form col-sm-10 col-md-8">
                            <input type="text" name="fullname" value="<?php echo $row['Fullname']?> " required="required" autocomplete="off"  class="form-control" id="full">
                        </div>
                    
                <!--  END  FULLNAME -->
                <!-- START EMAIL -->
                        <label for="mail" class="col-sm-2 col-form-label">Email</label>
                        <div class="asckrisk-form col-sm-10 col-md-8">
                            <input type="email" name="email" value="<?php echo $row['Email']?> " required="required" autocomplete="off"  class="form-control" id="mail">
                        </div>
                <!--  END  EMAIL -->
                <!-- START AVATER -->
                        <label for="avt" class="col-sm-2 col-form-label">Avater</label>
                        <div class="asckrisk-form col-sm-10 col-md-8">
                            <input type="file" name="avater"    class="form-control" id="avt">
                        </div>
                <!--  END  AVATER -->
                <!-- START SUBMIT -->
                        <div class="offset-sm-7 col-sm-2 ">
                            <input type="submit" value="Save"   class="btn btn-primary btn-lg">
                        </div>
                <!--  END  SUBMIT -->
                    </form>
                    <?php
                }
            ?>
                </div>
            </div>
            </div>
    </div>
    </div>
</section>


<!-- END PAGE CONTENT -->
<?php include $tpl.'footer.php';
}else{
    header("Location: index.php"); //Redirect to Profil  Page
        exit();
}
ob_end_flush();
?>  