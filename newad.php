<?php
session_start();
if(isset($_SESSION['User'])){
$pageTitle= 'Creat New Ad';

include 'init.php';

    
        if( $_SERVER['REQUEST_METHOD'] =='POST' ){
            $imageName = $_FILES['image']['name'];
            $imageSize = $_FILES['image']['size'];
            $imageTemp = $_FILES['image']['tmp_name'];
            $imageType = $_FILES['image']['type'];
            //image Extntion Posibel
            $imageAllowedExtention = array("jpeg","jpg","png","gif");
            // get extention of image 
            $imageExtention = strtolower(end( explode('.', $imageName))); 
            
            $name     =  filter_var( $_POST['name'],FILTER_SANITIZE_STRING ); 
            $catid    =  filter_var( $_POST['catid'],FILTER_SANITIZE_NUMBER_INT ); 
            $price    =  filter_var( $_POST['price'],FILTER_SANITIZE_NUMBER_FLOAT ); 
            $country  =  filter_var( $_POST['country'],FILTER_SANITIZE_STRING); 
            $status   =  filter_var( $_POST['status'],FILTER_SANITIZE_STRING ); 
            $des      =  filter_var( $_POST['description'],FILTER_SANITIZE_STRING ); 
            $userid   =  filter_var( $_SESSION['uid'],FILTER_SANITIZE_NUMBER_INT ); 
            $formErrors = array();
            if(!empty($imageName) && !in_array($imageExtention,$imageAllowedExtention)){$formErrors[] = 'Sory This File Not Suported';}
            if(strlen($name) <4){
                $formErrors[]='Name Cant be Must To 4 Character';
            }
            if($catid == 0){
                $formErrors[]='Pleas Chose You Categoury Name';
            }
            if(empty($price)){
                $formErrors[]='Price Cant Be Empty';
            }
            if(empty($country)){
                $formErrors[]='Chose County Of Made';
            }
            if(empty($status)){
                $formErrors[]='Plese Isert Status Of Your prodect ';
            }
            if( strlen($des) < 20 ){
                $formErrors[]='Description Cant be Must To 20 Character';
            }
            if(empty($formErrors)){
                $image = rand(0,100000000000).'_'.$imageName;
                $uploudesUrl = "admin/uploades/itemsImages/".$image;
                move_uploaded_file($imageTemp,$uploudesUrl);
                // UPDATE REQUEST 
                    $stmt   = $connect->prepare("INSERT INTO
                     items ( Name, Description, Price,  Country_Made , Status, Add_Date, Cat_ID, Member_ID, Image)
                                     VALUES
                        (:name,:des,:price,:cont, :stat, NOW(),:catid, :userid, :zimage )");
                    $stmt  -> execute(array(
                                                'name'    =>  $name,
                                                'des'     =>  $des,
                                                'price'   =>  $price,
                                                'cont'    =>  $country,
                                                'stat'    =>  $status,
                                                'catid'   =>  $catid,
                                                'userid'  =>  $userid,   
                                                'zimage'  =>  $image   
                    ));
                        // Redirect In Opertin Seccussful
                    $errorMasseg = '<div class="alert alert-success" >
                     An announcement has been added that will be processed by the administration </div> ';
                    $pageRedirct = 'profile.php';
                    echo '<div class="container" >';
                    redirect($errorMasseg,$pageRedirct,3);
                    echo '</div>';
                    
                }
        }

                
?>
<!-- START PAGE CONTENT -->
<h2 class="text-center" >Creat New Ad</h2>
<?php 
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
         }
?>
<section class="new-ad block " >
    <div class="container">

        <div class=" main-panel  col-sm-12 ">
        <div class="panel-heading bg-primary">Creat New Ad</div>
        <div class="panel-body bg-body ">
            <div class="row">
                <div class="col-md-8">
                <!-- START FORM  -->
                <form action="<?php echo $_SERVER['PHP_SELF'] ?>" method="POST" enctype="multipart/form-data" >
                    <div class="row">
                        <!--START Categours FILDE -->
                        
                        <div class="col-md-10">
                            <div class="asckrisk-form search-select-box">
                                <select name="catid" id="sl-user" >
                                    <option value="0">Chose Categoury</option>
                                    <?php
                                    $Catstmt = $connect-> prepare("SELECT * FROM categoures WHERE Allow_Ads = 0");
                                    $Catstmt    -> execute();
                                    $cats = $Catstmt ->fetchAll();
                                    foreach($cats as $cat){
                                        echo '<option value="'.$cat['ID'].'">'.$cat['Name'].'</option>';
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>
                        <!-- END Categours FILDE -->
                        <div class="col-md-10">
                            <!--START NAME FILDE -->
                            <div class="asckrisk-form">
                            <input class="form-control live-name " type="text" name="name"  placeholder="Name Of Item" required="required" id="it-name">
                            </div>
                            <!-- END NAME FILDE -->
                        </div>
                        <div class="col-md-10">
                            <!--START Price FILDE -->
                            <div class="asckrisk-form">
                            <input class="form-control live-price" type="text" name="price"  placeholder="Price Of Item" required="required" id="it-price">
                            </div>
                            <!-- END Price FILDE -->
                        </div>
                        <div class="col-md-10">
                            <!--START Country FILDE -->
                            <div class="asckrisk-form">
                            <input class="form-control" type="text" name="country"  placeholder="Country Of Made" required="required" id="it-country">
                            </div>
                            <!-- END Country FILDE -->
                        </div>
                        <div class="col-md-10">
                            <!--START Status FILDE -->
                            <div class="asckrisk-form">
                            <input class="form-control" type="text" name="status"  placeholder="Status of Item" required="required" id="it-status">
                            </div>
                            <!-- END Status FILDE -->
                        </div>
                        <div class="col-md-10">
                            <!-- START Description FILDE -->
                         <div class="asckrisk-form">
                            <textarea class="form-control live-desc"  name="description" id="cat-desc" rows="8" required="required"  placeholder="Add a Description For your Item"></textarea>
                        </div>
                    </div>
                        <!--END  Description FILDE -->
                        <!--START Status FILDE -->
                        <div class="col-md-10">
                            <div class="asckrisk-form">
                                <input class="form-control" type="file" name="image" >
                            </div>
                        </div>
                            <!-- END Status FILDE -->
                        <!-- START SUBMIT -->
                    
                        <div class="col-md-10">
                            <input type="submit" value="Add New Itme"   class="cat-btn btn btn-primary fa-pull-right">
                        </div>
                        
                    <!--  END  SUBMIT -->
                    </div>
                </form>
                <!--  END  FORM  -->
                </div>
                <div class=" col-md-4 text-center">
                        <div class="img-thumbnail item-box live-preview">
                            <span class="price-tag">$0</span>
                            <img class="img-responsiv" src="img.png" alt="">
                            <div class="caption">
                                <h3>Item Name</h3>
                                <p> Description </p>
                            </div>
                        </div>
                    </div>
            </div>
        </div>
    </div>
    </div>

<!-- END PAGE CONTENT -->
<?php include $tpl.'footer.php';
}else{
    header("Location: index.php"); //Redirect to Profil  Page
        exit();
}
?>  