    <?php
    session_start();
    $noNavbar  = ''; //display off Nave Bar
    $pageTitle = 'LOG IN';
    if(isset($_SESSION['Username'])){
        header("Location: dashboard.php"); //Redirect to Dashboard Page
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
                                    AND
                                     GroupID = 1
                                     LIMIT 1");
        $stmt->execute(array($username,$hechedPss));
        $row   = $stmt->fetch();
        $count = $stmt->rowCount();
         if($count > 0){
           $_SESSION['Username'] = $username; // Register Session
           $_SESSION['ID'] = $row['UserID']; // Register Session ID
           header("Location: dashboard.php"); //Redirect Dashbord
           exit();
         }else{
            ?>
            <div class="container">
                <h4 class="error-box text-bg-danger text-center ">
                Sorry, password or username is wrong Please try again!
                </h4>
            </div>
            <?php
         }
    }
    ?>
    <form class="login" action="<?php echo $_SERVER['PHP_SELF'];?>" method="POST">
    <h4><?php echo lang('ADMIN').' '.lang('LOGIN'); ?></h4>
    <div>
        <i class="fa fa-user"></i>
        <input class="form-control" type="text" name="username" placeholder="Username" autocomplete="off" require>
    </div>
    <div>
        <i class="fa fa-key"></i>
        <input class="form-control" type="password" name="password" placeholder="Password" autocomplete="new-password" require>
    </div>
    <div >
    <input class="btn btn-primary " type="submit" value="<?php echo lang('LOGIN');?>">
    </div>
    </form>
    <?php
    include $tpl.'footer.php';
    ?>  