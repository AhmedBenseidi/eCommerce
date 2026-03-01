<?php include 'init.php';
    $formErrors = array();
    if($_SERVER['REQUEST_METHOD'] == 'POST'){
    //Checed If user is repted
    $CheckItemExicet = CheckItem('Username','users',$_POST['username']);
    if( $CheckItemExicet > 0){
        $formErrors[] = 'This  Username <strong>'.$_POST['username'].' </strong> is already Reserved ';
    }
        
    if( isset($_POST['username'])){
        $filterUser = filter_var($_POST['username'],FILTER_SANITIZE_STRING);
        if( strlen($filterUser) < 4 ){
            $formErrors[] = 'Sory Username Must Be  Larger Than  4 characters'; 
        }
    }
    if( isset($_POST['email'])){
        $filterEmail = filter_var($_POST['email'],FILTER_SANITIZE_EMAIL);
        if( empty($filterEmail)){
            $formErrors[] = 'Sory Email Cant Be Empty'; 
        }
    }
    if( isset($_POST['password'])){
        if( empty($_POST['password'])){
            $formErrors[] = 'Sory Password cant  Be  Empty'; 
        }else{
            $hachPass = sha1($_POST['password']);
        }
    }
    // ADD new Member
    if(empty($formErrors)){
        // UPDATE REQUEST 
            $stmt   = $connect->prepare("INSERT INTO
                                                     users(Username, Password, Email, RegStatus, Date)
                                         VALUES
                                                    (:user,:pass,:mail, 0, now() )");
            $stmt  -> execute(array(
                                        'user' =>$filterUser,
                                        'pass' =>$hachPass,
                                        'mail' =>$filterEmail
            ));
                // Redirect In Opertin Seccussful
            $errorMasseg = '<div class="alert alert-success" >
            Congratulaions, uour account will be reviewed by <b>management</b>
            </div> ';
            $pageRedirct = 'index.php';
            echo '<div class="container" >';
            redirect($errorMasseg,$pageRedirct,3);
            echo '</div>';
            
        }
    // ADD new Member
}
    // ADD new Member
    
    // ADD new Member
?>
<!-- START PAGE CONTENT -->
<div class="container">

        <?php
        if(!empty($formErrors)){
            echo '<div class="error-box text-bg-danger">';
                foreach($formErrors as $error){
                    echo $error.'<br>';
                }
            echo '</div>';
        }
        ?>
    
    <form class="login" action="<?php echo $_SERVER['PHP_SELF'];?>" method="POST">
    <h4>Creat New Account</h4>
    <div>
        <i class="fa fa-user"></i>
        <input class="form-control" type="text" name="username" placeholder="Username" autocomplete="off" required="required" >
    </div>
    <div>
        <i class="fa fa-mail-bulk"></i>
        <input class="form-control" type="email" name="email" placeholder="Email"  required="required" >
    </div>
    <div>
        <i class="fa fa-key"></i>
        <input class="form-control" type="password" name="password" placeholder="Password" autocomplete="new-password" required="required">
    </div>
    <div >
    <input class="btn btn-success " type="submit" value="Creat new Account">
    </div>
    <h6>If you have Account Please  <a href="login.php">LOGIN</a> </h6>
    </form>
    
</div>
<!-- END PAGE CONTENT -->
<?php include $tpl.'footer.php';?>  