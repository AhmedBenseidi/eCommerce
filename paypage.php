<?php
ob_start();
session_start();
$pageTitle = 'Pay Page';
include 'init.php';
if(isset($_SESSION['User'])){
$pageTitle= 'Start  Paying';
if(isset($_GET['itemID'])){
    $itmeid = $_GET['itemID'];
}
if( $_SERVER['REQUEST_METHOD'] =='POST' ){
    $id          =  $_POST['id']; 
    $Email       =  $_POST['Email']; 
    $Address     =  filter_var( $_POST['Address'],FILTER_SANITIZE_STRING ); 
    $Card_Num    =  filter_var( $_POST['Card_Num'],FILTER_SANITIZE_NUMBER_INT ); 
    $Card_CVC    =  filter_var( $_POST['Card_CVC'],FILTER_SANITIZE_NUMBER_INT ); 
    $Quantity    =  filter_var( $_POST['Quantity'],FILTER_SANITIZE_NUMBER_INT ); 
    $mount       =  $_POST['mount'] ;
    $date        =   $_POST['date']; 
    $userid      =  filter_var( $_SESSION['uid'],FILTER_SANITIZE_NUMBER_INT ); 
    $formErrors = array();
    if(strlen($Address) <4){
        $formErrors[]='Address Cant be Must To 4 Character';
    }
    if(empty($Card_Num)){
        $formErrors[]='Card Number Cant Be Empty';
    }
    if(empty($Card_CVC)){
        $formErrors[]='Card CVC Cant be Empty';
    }
    if(empty($Quantity)){
        $formErrors[]='Plese Isert Quantity Of Your prodect ';
    }
    if(empty($date)){
        $formErrors[]='Plese Isert Epirte Date ';
    }
    if(!empty($formErrors)){
        ?>
            
        <div class="container text-center ">
            <div class="error-box text-bg-danger">
        <?php
            foreach($formErrors as $error){
                echo $error.'<br>';
            }
        ?>
        </div>
    
    <?php
     }else{ 
            $stmt   = $connect->prepare("INSERT INTO 
                                                    `orders` 
            (Addrasse, Card_Num, CVC, Email, User, Item, Mount, Quantity, Card_Exp,AddDate) 
                                        VALUES 
            ( :xAddrasse, :xCard_Num, :xCVC,:xEmail,:xUser, :xItem, :xMount, :xQuantity, :xCard_Exp, NOW() );");
            $stmt  -> execute(array(
                                        'xAddrasse'  =>  $_POST['Address'],
                                        'xCard_Num'  =>  $Card_Num,
                                        'xCVC'       =>  $Card_CVC,
                                        'xEmail'     =>  $Email,
                                        'xUser'      =>  $userid,
                                        'xItem'      =>  $id,
                                        'xMount'     =>  $mount,
                                        'xQuantity'  =>  $Quantity,   
                                        'xCard_Exp'  =>  $_POST['date']   
            ));
                // Redirect In Opertin Seccussful
            $errorMasseg = '<div class="alert alert-success" >
            Your purchase has been successfully completed. You will receive an email when the order arrives
              </div> ';
            $pageRedirct = 'index.php';
            echo '<div class="container" >';
            redirect($errorMasseg,$pageRedirct,3);
            echo '</div>';
            
        }
    
}
?>
<!-- START PAGE CONTENT -->
<h2 class="text-center" >Welcome  <?php echo $sessionUser ?> In pay Page</h2>
<section class="my-info block " >
    <div class="container">

        <div class=" main-panel  col-sm-12 ">
            <div class="panel-heading bg-primary"> Start Paying</div>
            <div class="panel-body bg-body ">
            
            <?php 
            
                $stmt   = $connect->prepare("SELECT * FROM Items WHERE Item_ID = ? LIMIT 1");
                $stmt  -> execute(array($itmeid));
                $row    = $stmt -> fetch();
                $count  = $stmt -> rowCount();
                $stmt2   = $connect->prepare("SELECT * FROM users WHERE Username = ? LIMIT 1");
                $stmt2  -> execute(array($sessionUser));
                $row2    = $stmt2 -> fetch();
                if($count > 0){
                    ?>
                    <div class="row">
                        <div class="col-md-3">
                            <img class="img-thumbnail" src="admin/uploades/itemsImages/<?php echo $row['Image'] ?>" alt="item">
                        </div>
                        <div class="col-md-8">
                    <form action="<?php echo $_SERVER['PHP_SELF'] ?>" method="POST" enctype="multipart/form-data" >
                        <!-- START Username -->
                        <input type="hidden" value="<?php echo $itmeid?>" name="id">
                        <input type="hidden" value="<?php echo $row2['Email'] ?>" name="Email">
                        <label for="user" class=" col-form-label">Address</label>
                        <div class="asckrisk-form col-sm-10 col-md-8">
                            <input type="text" name="Address"   class="form-control" id="user">
                        </div>
                    <!--  END  Username -->
                    <!-- START  Password -->
                        <label for="Pass" class="col-sm-2 col-form-label">Card Number</label>
                        <div class="col-sm-10 col-md-8">
                            <input type="text" min="16" max="16" name="Card_Num"class="form-control" placeholder="Card Number" id="Pass">
                        </div>
                <!--  END  Password -->
                    <!-- START  Password -->
                        <label for="cvc" class="col-sm-2 col-form-label">Card CVC</label>
                        <div class="col-sm-10 col-md-8">
                            <input type="txt" name="Card_CVC" autocomplete="new-password" class="form-control" placeholder="CVC " id="cvc">
                        </div>
                <!--  END  Password -->
                    <!-- START  Password -->
                        <label for="date" class="col-sm-2 col-form-label">Expiry Date</label>
                        <div class="col-sm-10 col-md-8">
                            <input type="date" name="date" class="form-control"  id="date">
                        </div>
                <!--  END  Password -->
                  <!-- START  Password -->
                            <label for="Q1" class="col-sm-2 col-form-label ">Quantity</label>
                            <div class="col-sm-10 col-md-8">
                                <input class="form-control" type="text" name="Quantity" id="Q1">

                            </div>
                        <!--  END  Password -->
                        <!-- START  Password -->
                        <label for="live" class="col-sm-2 col-form-label">Total Amount</label>
                        <div class="col-sm-10 col-md-8">

                            <input type="text" name="mount"
                             class="form-control live-mon"  id="live">

                            <input type="hidden" name="price"
                             value="<?php echo $row['Price']  ?>"   id="Q2">

                        </div>
                            <script>
                                var q,live;
                                q = document.getElementById('Q1');
                                q2 = document.getElementById('Q2').value;
                                live = document.getElementById('live');
                                q.onkeyup = function(){
                                    'use strict';
                                    var  ruselta = this.value * q2;
                                    live.value = ruselta ;

                                }
                            </script>
                
                
               
                <!-- START SUBMIT -->
                        <div class="offset-sm-7 col-sm-2 ">
                            <input type="submit" value="Bay"   class="btn btn-primary btn-lg">
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
<?php 
}else{
    ?>
    <div class="container">
        <h4 class="bg-warning pay-wrong">
            Sorry you can't make a purchase Please <a href="login.php"> <strong>login</strong> </a>
            or <a href="singup.php"> <strong>register</strong> </a>
        </h4>
    </div>
        <?php
}
include $tpl.'footer.php';
ob_end_flush();
?>  