<?php
    session_start();
    $noNavbar  = ''; //display off Nave Bar
    $pageTitle = 'LOG IN';
    if(isset($_SESSION['User'])){
        header("Location: profile.php"); //Redirect to Profil  Page
        exit();
    }
 
    include 'init.php';
    if($_SERVER['REQUEST_METHOD'] == 'POST'){ //Checked if caming bu HTTP REQUEST
        $username  = $_POST['username'];
        $password  = $_POST['password'];
        $hechedPss = sha1($password);
        // Check if User Execte in Data Base
        $stmt = $connect->prepare("SELECT 
                                            UserID, Username, Password 
                                    FROM 
                                        users 
                                    WHERE 
                                        Username = ? 
                                    AND
                                        Password = ? 
                                    ");
        $stmt->execute(array($username,$hechedPss));
        $row   = $stmt->fetch();
        $count = $stmt->rowCount();
         if($count > 0){
           $_SESSION['User'] = $username; // Register Session
           $_SESSION['uid']  = $row['UserID']; // Register Session
           header("Location: profile.php"); //Redirect Profile
           exit();
         }else{
             ?>
             <div class="container">
                 <div class="error-box text-bg-danger">
                 Sorry, password or username is wrong Please try again!
                 </div>
             </div>
             <?php
             
         }
    }
?>
<!-- START PAGE CONTENT -->
<div class="container">
    <form class="login" action="<?php echo $_SERVER['PHP_SELF'];?>" method="POST">
    <h4><?php echo lang('LOGIN'); ?></h4>
    <div>
        <i class="fa fa-user"></i>
        <input class="form-control" type="text" name="username" placeholder="Username" autocomplete="off" required="required" >
    </div>
    <div>
        <i class="fa fa-key"></i>
        <input class="form-control" type="password" name="password" placeholder="Password" autocomplete="new-password" required="required">
    </div>
    <div >
    <input class="btn btn-primary " type="submit" value="<?php echo lang('LOGIN');?>">
    </div>
    <h6>If you Dont have Account Please  <a href="singup.php">Create new Account</a> </h6>
    </form>
</div>
<!-- END PAGE CONTENT -->
<?php include $tpl.'footer.php';?>  