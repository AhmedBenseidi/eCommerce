<?php
    ob_start("ob_gzhandler"); //start Outpet Beffuring And Press Data
    session_start();
    if(!isset($_SESSION['Username'])){
        header("Location: index.php"); //Redairect to Home Page
        exit();
    }else{
        $pageTitle = 'HOME';
        include 'init.php';
        //START CONTENT
        $numLastUsers = 5;
        $latestUsers = getLatest('*','users','UserID',$numLastUsers);
        $numLastcommenter = 5;
?>
            <section class="home-header" >
            <div class="container text-center">
                <h2>DashBoard</h2>
                <div class="row">

                    <div class="col-md-3">
                        <div class="stat st-meber">
                            <i class="fa fa-users"></i>
                          <div class="info">
                          Totle Mebers
                            <div>
                            <span><a title="Go To Mebers Manage" href="mebers.php">
                            <?php
                                echo countItems('UserID','users');
                            ?>
                            </a></span>
                          </div>
                            </div>
                            
                        </div>
                    </div>

                    <div class="col-md-3">
                        <div class="stat st-pending">
                            <i class="fa fa-user-plus"></i>
                           <div class="info">
                           Pending Mebers
                            <span>
                            <a title="Go To Mebers Manage" href="mebers.php?do=Manage&Page=Panding">
                                <?php
                                
                                    echo countItems('RegStatus','users WHERE RegStatus = 0');

                                ?>
                                </a>
                            </span>
                           </div>
                        </div>
                    </div>

                    <div class="col-md-3">
                        <div class="stat st-items">
                            <i class="fa fa-tag"></i>
                            <div class="info">
                            Totle Items
                            <span>
                            <a title="Go To Mebers Manage" href="items.php">
                            <?php
                                
                                echo countItems('Item_ID','items');

                            ?>
                            </a>
                            </span>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-3">
                        <div class="stat st-comments">
                            <i class="fa fa-comments"></i>
                            <div class="info">
                            Totle Commentes
                            <span>
                            <a title="Go To Mebers Manage" href="commenter.php">
                            <?php
                                
                                echo countItems('c_id','comments');

                            ?>
                            </a>
                            </span>
                            </div>
                        </div>
                    </div>

                </div>
            </div> 
            </section>       
        <section class="latest" >
            <div class="container">
                <div class="row">
                    <div class="col-md-6">
                        <div class="panel panel-default">
                            <div class="main-panel">
                            <div class="panel-heading">
                                <i class="fa fa-users"></i>
                                Laset <?php echo $numLastUsers?> users Regested
                                <span class="toggle-info fa-pull-right" >
                                    <i class="fa fa-plus" ></i>
                                </span>
                            </div>
                            <div class="panel-body">
                                <?php
                                foreach($latestUsers as $userInfo){
                                    echo '<ul class=" list-style list-unstyled" > <li > ';
                                    echo $userInfo['Username'];
                                    echo '<a href="mebers.php?do=Edit&UserID='.$userInfo['UserID'].'" class="btn btn-success fa-pull-right" ><i class="fa fa-edit"></i> Edit </a>';
                                    if($userInfo['RegStatus'] == 0){
                                        ?>
                                    <a href="mebers.php?do=Activate&UserID=<?php echo $userInfo['UserID']?>" class="btn btn-info fa-pull-right"> <i class="fa fa-user-plus"></i> Activte </a>
                                        <?php
                                    }
                                    echo '</li></ul>';
                                }
                                ?>
                            </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="panel panel-default">
                            <div class="main-panel">
                            <div class="panel-heading">
                                <i class="fa fa-tag"></i>
                                Laset Items
                                <span class="toggle-info fa-pull-right" >
                                    <i class="fa fa-plus" ></i>
                                </span>
                            </div>
                            <div class="panel-body">
                                <?php
                                $lastItems = getLatest('*','items','Item_ID');
                                foreach($lastItems as $item){
                                    echo '<ul class=" list-style list-unstyled" > <li > ';
                                    echo $item['Name'];
                                    echo '<a href="items.php?do=Edit&itemid='.$item['Item_ID'].'" class="btn btn-success fa-pull-right" ><i class="fa fa-edit"></i> Edit </a>';
                                    if($item['Approve'] == 0){
                                        ?>
                                        <a href="items.php?do=Approve&itemid=<?php echo $item['Item_ID']?>" class="btn btn-info fa-pull-right "> <i class="fa-solid fa-check"></i> Approve</a>
                                        <?php
                                       } 
                                    echo '</li></ul>';
                                }
                                ?> 
                            </div>
                            </div>
                        </div>
                    </div>

                </div>
                <!-- Start letst comments -->
                <div class="row">
                    <div class="col-md-6">
                        <div class="panel panel-default">
                            <div class="main-panel">
                            <div class="panel-heading">
                                <i class="fa fa-comment-dots"></i>
                                Laset <?php echo $numLastcommenter?> Comments
                                <span class="toggle-info fa-pull-right" >
                                    <i class="fa fa-plus" ></i>
                                </span>
                            </div>
                            <div class="panel-body">
                                <?php
                                $stmt =  $connect->prepare("SELECT comments.*,users.Username AS Member_Username 
                                                FROM comments
                                                
                                                INNER JOIN users
                                                ON users.UserID = comments.user_id
                                               ORDER BY c_id DESC
                                               LIMIT $numLastcommenter
                                                ");
                                $stmt -> execute();
                                $comments = $stmt -> fetchAll();
                                foreach($comments as $comment){
                                ?>
                                <div class="comment-box">
                                    <span class="member-n">
                                        <a href="mebers.php?do=Edit&UserID=<?php echo $comment['user_id'] ?>">    
                                        <?php echo $comment['Member_Username']?>
                                        </a>
                                    </span>
                                    <p class="member-c"><?php echo $comment['comment']?></p>
                                </div>
                                <?php }?>
                            </div>
                            </div>
                        </div>
                    </div>
                    

                
                <!--  END  letst comments -->
                <!-- Start letst Order -->
                
                    <div class="col-md-6">
                        <div class="panel panel-default">
                            <div class="main-panel">
                            <div class="panel-heading">
                                <i class="fa fa-comment-dots"></i>
                                Laset <?php echo $numLastcommenter?> Order
                                <span class="toggle-info fa-pull-right" >
                                    <i class="fa fa-plus" ></i>
                                </span>
                            </div>
                            <div class="panel-body">
                                <?php
                                $OrderStmt = $connect->prepare("SELECT 
                                orders.*,users.Username,items.Name
                                                                FROM orders 
                                                                INNER JOIN users 
                                                                ON users.UserID = orders.user
                                                                INNER JOIN items 
                                                                ON items.Item_ID = orders.Item
                                                                ORDER BY  Order_ID DESC;
                                                                     ");
                                $OrderStmt -> execute();
                                $Orders    = $OrderStmt -> fetchAll();
                                echo '<ul class=" list-style list-unstyled" >';
                                foreach($Orders as $order){
                                    ?>
                                        <li>
                                            <a href="showprofile.php?userid=<?php echo $order['User']?>"> <?php echo $order['Username']?></a>
                                            Buy <?php echo $order['Quantity']?> Prodect
                                            Of Name <a title="<?php echo $order['Name']?>" style="  display: inline-block;
                                                                max-width: 50%;
                                                                overflow: hidden;
                                                                height: 25px;"  
                                             href="../item.php?itemid=<?php echo $order['Item']?>" ><?php echo $order['Name']?></a>
                                        </li>
                                    <?php
                                }
                                echo '</ul>';
                                ?>
                            </div>
                            </div>
                        </div>
                    </div>
                    

                </div>
                <!--  END  letst Odrer -->
            </div>
        </section>
<?php   //END CONTENT
        include $tpl.'footer.php';

    }
    ob_end_flush(); // flush Beffuring
    ?>