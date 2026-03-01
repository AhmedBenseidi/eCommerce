<?php
/*
==============================================
==  Pge       Categories                    ==
== You Can Add | Edit |Delete               ==
==============================================
*/
ob_start("ob_gzhandler");
session_start();
$pageTitle = 'Categories';
if(!isset($_SESSION['Username'])){
    header("Location: index.php"); //Redairect to Home Page
    exit();
}else{
    include 'init.php';
    //START CONTENT
    $do = isset($_GET['do']) ? $_GET['do'] : 'Manage';
    if ($do == 'Manage'){ 
        //MANGER
        // START CATEGORE CONTENT
        $sort = 'ASC';
        $sort_arrey = array('ASC','DESC');
        if(isset($_GET['sort']) &&  in_array($_GET['sort'] ,$sort_arrey)){
            $sort = $_GET['sort'] ;
        }
    $stmt =  $connect->prepare("SELECT * FROM categoures ORDER BY Ordering $sort");
    $stmt -> execute();
    $rows = $stmt -> fetchAll();
    ?>
        <h2 class="page-header text-center">Manage Categories</h2>
            <div class="container">
                <!-- START Page Content  -->
                <section class="latest" >
            <div class="container">
                <div class="row">
                    <div class="col-md-12">
                        <div class="panel panel-default">
                            <div class="main-panel">
                            <div class="panel-heading">
                                <i class="fa fa-tag"></i>
                                Categories
                                <div class="order fa-pull-right">
                                     <i class="fa fa-sort"></i> Ordering :[  
                                    <a <?php if($sort == 'ASC'){echo 'class="active"';}?> href="?sort=ASC">Asc</a> | 
                                    <a <?php if($sort == 'DESC'){echo 'class="active"';}?> href="?sort=DESC">Desc</a>
                                    ]
                                    <i class="fa fa-eye"></i> View : 
                                        [
                                            <span class="active">Full</span> | 
                                            <span  data-view="classic" >Classic</span>  
                                        ]
                                </div>
                            </div>
                            <div class="panel-body cat-view">
                                
                                <?php
                                   foreach($rows as $row){
                                    echo '<div class="cat cat-clule">';
                                    echo '<h4>'  .$row['Name'].       '</h4>';
                                    echo'<div class="full-view" >';
                                    echo empty($row['Description']) ? '<p>No Descrptin Foundet !</p>': '<p>'.$row['Description'].'</p>';
                                    echo $row['Visibility']    != 0 ? '  <span class="btn btn-danger" ><i class="fa  fa-eye-low-vision" ></i> Hidden</span>':'';
                                    echo $row['Allow_Comment'] != 0 ? '  <span class="btn btn-dark" ><i class="fa fa-lock" > </i> Comment Diseble</span>' : '';
                                    echo $row['Allow_Ads']     != 0 ? '<span class="btn btn-warning" ><i class="fa fa-lock" > </i> Ads Diseble</span>' : '';
                                    echo'<div class="hidden-btn">
                                    <a href="?do=Edit&CatID='.$row['ID'].'" class="btn btn-success"> <i class="fa fa-edit"></i> Edit</a>
                                    <a href="?do=Delete&CatID='.$row['ID'].'" class="confirm btn btn-danger"> <i class="fa-solid fa-user-minus"></i> Delete</a>
    
                                    </div>';

                                    echo '</div> ';
                                    echo '<hr>';
                                    echo ' </div>';

                                    
                                }
                                ?> 
                                
                               
                            </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </section>

                <a class=" btn btn-primary offset-10  fa-pull-left  " href="?do=Add"><i class="fa fa-plus"></i> Add New Categoury</a>
                <!--  END  Page Content  -->
            </div>
        
   <?php 
        //  END  CATEGORE CONTENT

    
    }
    elseif ($do == 'Add'){ 
        //ADD
        // START CATEGORE CONTENT
        ?>
<h2 class="text-center">Add New Categories</h2>
            <div class="container">
                <form class="form-horizontal" action="?do=Insert" method="POST" >
                    <div class="row">

                        <div class="asckrisk-form col-sm-6">
                            <label class="col-form-label" for="cat-name">Name</label>
                            <input class="form-control" type="text" name="name"  placeholder="Name Of Categorie" required="required" id="cat-name">
                        </div>
                        
                        <div class="col-sm-6">
                            <label class="col-form-label" for="cat-ord">Ordering</label>
                            <input class="form-control" type="number" min="1" name="ordering"  placeholder="Number Of Ordering"  id="cat-ord">
                        </div>

                    </div>
                    <div class="row">
                        <div class="col-sm-6">
                            <label class="col-form-label"  for="cat-desc">Description</label>
                            <textarea class="form-control" name="description" id="cat-desc" rows="10"  placeholder="Add a Description For your Categorie"></textarea>
                        </div>
                        <div class="check-from col-sm-6">
                        <div >
                            <label class="col-form-label"  >Visibility</label>
                            <div>
                                <label for="vis-on">  On  </label>
                                <input type="radio" name="visibility" value="0" id="vis-on" checked>
                            </div>
                            <div>
                                <label for="vis-off">Off</label>
                                <input type="radio" name="visibility" value="1" id="vis-off" >
                            </div>
                        </div>

                        <div>
                            <label class="col-form-label" >Comments</label>
                            <div>
                                <label for="com-on">  On  </label>
                                <input type="radio" name="comment" value="0" id="com-on" checked>
                            </div>
                            <div>
                                <label for="com-off">Off</label>
                                <input type="radio" name="comment" value="1" id="com-off" >
                            </div>
                        </div>
                        <div >
                            <label class="col-form-label" >Ads</label>
                            
                            <div>
                                <label for="ads-on">  On  </label>
                                <input type="radio" name="ads" value="0" id="ads-on" checked>
                            </div>
                            <div>
                                <label for="ads-off">Off</label>
                                <input type="radio" name="ads" value="1" id="com-off" >
                            </div>
                        </div>
                        </div>
                    </div>
                    
                    <!-- START SUBMIT -->
                    <div class="mb-3 row">
                            <div class="col-sm-10">
                                <input type="submit" value="Add New"   class="cat-btn btn btn-primary fa-pull-right">
                            </div>
                        </div>
                    <!--  END  SUBMIT -->
                    </div>
                </form>    
            </div>
            
<?php
        //  END  CATEGORE CONTENT

    }elseif($do == 'Insert'){
        //INSERT
        // START CATEGORE CONTENT
        
       if($_SERVER['REQUEST_METHOD'] == 'POST'){
        //TItle
        echo '<h2 class="text-center">Insert Page</h2>';
        //Get input values
        $name        =  $_POST['name'];
        $ordering    =  $_POST['ordering'];
        $description =  $_POST['description'];
        $visibility  =  $_POST['visibility'];
        $comment     =  $_POST['comment'];
        $ads         =  $_POST['ads'];

        //Checed If name Of Categoures is repted
        $CheckItemExicet = CheckItem('Name','categoures',$name);
        //Chek form values
        $formErrors = array();
        
        if( $CheckItemExicet > 0){$formErrors[] = 'This  Name Of Categoury  <strong>'.$name.' </strong> is already Reserved ';}
        if( strlen($name) < 3 ){$formErrors[] = 'Name Cant Be Less Than <strong> 3 Characters </strong>';}
        if( strlen($name) > 50 ){$formErrors[] = 'Name Cant Be Less Than <strong> 50 Characters </strong>';}
        if(empty($name)){$formErrors[] = 'Name Can be <strong> Empty </strong>';}
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
            // UPDATE REQUEST 
                $stmt   = $connect->prepare("INSERT INTO
                                                         categoures( Name, Ordering, Description, visibility, Allow_Comment, Allow_Ads)
                                             VALUES
                                                        (:name,:order,:descr,:visi, :comment, :ads )");
                $stmt  -> execute(array(
                                            'name'    => $name       ,
                                            'order'   => $ordering   ,
                                            'descr'   => $description,
                                            'visi'    => $visibility ,
                                            'comment' => $comment    ,
                                            'ads'     => $ads        
                ));
                    // Redirect In Opertin Seccussful
                $errorMasseg = '<div class="alert alert-success" >'.$stmt -> rowCount().' : Reqourd Is  Inserted ! </div> ';
                $pageRedirct = 'categories.php';
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
        //  END  CATEGORE CONTENT
    }

    elseif ($do == 'Edit'){ 
        //EDITE
        // START CATEGORE CONTENT
        $catid = isset($_GET['CatID']) && is_numeric($_GET['CatID']) ? intval($_GET['CatID']) : 0 ;
        $stmt   = $connect->prepare("SELECT * FROM categoures WHERE ID = ? LIMIT 1");
        $stmt  -> execute(array($catid));
        $row    = $stmt -> fetch();
        $count  = $stmt -> rowCount();
        if($count > 0){
            ?>    
            <!-- START HTML     -->
            <h2 class="text-center">Edit Categories</h2>
            <div class="container">
                <form class="form-horizontal" action="?do=Update" method="POST" >
                    <div class="row">
                    <input type="hidden" name="CatID" value="<?php echo $row['ID'] ?>">
                        <div class="asckrisk-form col-sm-6">
                            <label class="col-form-label" for="cat-name">Name</label>
                            <input class="form-control" type="text" value="<?php echo $row['Name']?>"  name="name"  placeholder="Name Of Categorie" required="required" id="cat-name">
                        </div>
                        
                        <div class="col-sm-6">
                            <label class="col-form-label" for="cat-ord">Ordering</label>
                            <input class="form-control" type="number" min="1" name="ordering" value="<?php echo $row['Ordering']?>"  placeholder="Number Of Ordering"  id="cat-ord">
                        </div>

                    </div>
                    <div class="row">
                        <div class="col-sm-6">
                            <label class="col-form-label"  for="cat-desc">Description</label>
                            <textarea class="form-control" name="description"  id="cat-desc" rows="10"  placeholder="Add a Description For your Categorie"><?php echo $row['Description']?></textarea>
                        </div>
                        <div class="check-from col-sm-6">
                        <div >
                            <label class="col-form-label"  >Visibility</label>
                            <div>
                                <label for="vis-on">  On  </label>
                                <input type="radio" name="visibility" value="0" id="vis-on" <?php if($row['Visibility'] == '0'){echo 'checked';} ?> >
                            </div>
                            <div>
                                <label for="vis-off">Off</label>
                                <input type="radio" name="visibility" value="1" id="vis-off" <?php if($row['Visibility'] != '0'){echo 'checked';} ?> >
                            </div>
                        </div>

                        <div>
                            <label class="col-form-label" >Comments</label>
                            <div>
                                <label for="com-on">  On  </label>
                                <input type="radio" name="comment" value="0" id="com-on" <?php if($row['Allow_Comment'] == '0'){echo 'checked';} ?>>
                            </div>
                            <div>
                                <label for="com-off">Off</label>
                                <input type="radio" name="comment" value="1" id="com-off" <?php if($row['Allow_Comment'] != '0'){echo 'checked';} ?> >
                            </div>
                        </div>
                        <div >
                            <label class="col-form-label" >Ads</label>
                            
                            <div>
                                <label for="ads-on">  On  </label>
                                <input type="radio" name="ads" value="0" id="ads-on" <?php if($row['Allow_Ads'] == '0'){echo 'checked';} ?>>
                            </div>
                            <div>
                                <label for="ads-off">Off</label>
                                <input type="radio" name="ads" value="1" id="com-off" <?php if($row['Allow_Ads'] != '0'){echo 'checked';} ?>>
                            </div>
                        </div>
                        </div>
                    </div>
                    
                    <!-- START SUBMIT -->
                    <div class="mb-3 row">
                            <div class="col-sm-10">
                                <input type="submit" value="Save"   class="cat-btn btn btn-primary fa-pull-right">
                            </div>
                        </div>
                    <!--  END  SUBMIT -->
                    </div>
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

        //  END  CATEGORE CONTENT
    }
    
    elseif ($do == 'Update'){ 
        //Update
        // START CATEGORE CONTENT
        echo '<h2 class="page-header text-center">Update Mebers</h2>';
        echo '<div class="container">';

        // GET FORM REQUEST 
        if($_SERVER['REQUEST_METHOD'] == 'POST'){
            $id      =  $_POST['CatID'];
            $name    =  $_POST['name'];
            $desc    =  $_POST['description'];
            $Order   =  $_POST['ordering'];
            $visible =  $_POST['visibility'];
            $comment =  $_POST['comment'];
            $ads     =  $_POST['ads'];
            //Chek form values
            $formErrors = array();
            
            if( strlen($name) < 3 ){$formErrors[] = 'Name Cant Be Less Than <strong> 3 Characters </strong>';}
            if( strlen($name) > 50 ){$formErrors[] = 'Name Cant Be Less Than <strong> 50 Characters </strong>';}
        if(empty($name)){$formErrors[] = 'Name Can be <strong> Empty </strong>';}

            foreach($formErrors as $error){
                echo '<div class="alert alert-danger">'.$error . '</div>';
            }
            // if checked is donn 
            if(empty($formErrors)){
            // UPDATE REQUEST 
                $stmt   = $connect->prepare("UPDATE
                                                    categoures
                                            SET
                 Name  = ?, Description = ?, Ordering = ?, Visibility = ?, Allow_Comment = ?, Allow_Ads = ?
                                            WHERE ID = ? ");
                $stmt  -> execute(array($name,$desc,$Order,$visible,$comment,$ads, $id));
                
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
        //  END  CATEGORE CONTENT
    }elseif ($do == 'Delete'){
        //Delete
        // START CATEGORE CONTENT
        echo '<h2 class="page-header text-center">Delete Categoury</h2>';
        echo '<div class="container">';
            // START Page Content
            $catid = isset($_GET['CatID']) && is_numeric($_GET['CatID']) ? intval($_GET['CatID']) : 0 ;
            $Check = CheckItem('ID','categoures', $catid);
            if($Check > 0){
                $stmt =  $connect->prepare("DELETE FROM categoures WHERE ID = :id");
                $stmt -> bindParam(':id',$catid);
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
        //  END  CATEGORE CONTENT
    }
    elseif ($do == 'Activate'){
        //ACTIVE
        // START CATEGORE CONTENT
        echo 'WELCOME TO / Activet';
        //  END  CATEGORE CONTENT
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