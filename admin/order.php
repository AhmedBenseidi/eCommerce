<?php
/*
==============================================
== Show Order Pge                           ==
== You Can Add | Edit |Delete               ==
==============================================
*/
session_start();
$pageTitle = 'Ordres';
if(isset($_SESSION['Username'])){
    include 'init.php';
    //START CONTENT
  // mange page
    $stmt =  $connect->prepare("SELECT * FROM users WHERE GroupID != 1  ORDER BY UserID ");
    $stmt -> execute();
    $rows = $stmt -> fetchAll();
    ?>
        <h2 class="page-header text-center">Show Ordres</h2>
            <div class="container">
                <!-- START Page Content  -->
                <div class="table-responsive">
                <table class="table table-bordered border-primary text-center">
                    <thead class="table-dark">
                    <tr>
                        <th class="table-dark">#ID</th>
                        <th class="table-dark">Username</th>
                        <th class="table-dark">Email</th>
                        <th class="table-dark">Product name</th>
                        <th class="table-dark">Order Add Date</th>
                    </tr>
                    </thead>
                    <tbody>
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
                        foreach($Orders as $order){
                            ?>
                            <tr>
                            <td class="table-info"><?php echo $order['Order_ID'] ?></td>
                            <td class="table-info"><?php echo $order['Username'] ?></td>
                            <td class="table-info"><?php echo $order['Email'] ?></td>
                            <td class="table-info"><?php echo $order['Name'] ?></td>
                            <td class="table-info"><?php echo $order['AddDate'] ?></td>
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
    
    else{
                // Redirect In the Error is Hapen
                $errorMasseg = '<div class="alert alert-danger" > erorr your Page   Note Fondet </div> ';
                $pageRedirct = 'back';
                echo '<div class="container" >';
                redirect($errorMasseg,$pageRedirct,5);
                echo '</div>';
    }
    
    //END CONTENT
    include $tpl.'footer.php';

