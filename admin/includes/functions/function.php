<?php
    //GET PAGE TITLE
    function getTitle(){
       global $pageTitle;
       if(isset($pageTitle)){
            echo $pageTitle;
       }else{
           echo lang('DEFULET');
       }
    }
// Redirect to the Home Page v 2.1
function redirect ($Masseg,$pageToRidirectToHim = null,$secand = 3){
    if($pageToRidirectToHim === null){

        $pageToRidirectToHim ='index.php';

    }elseif($pageToRidirectToHim == 'back'){
        $pageToRidirectToHim =isset($_SERVER['HTTP_REFERER']) && !empty($_SERVER['HTTP_REFERER']) ? $pageToRidirectToHim = $_SERVER['HTTP_REFERER'] : $pageToRidirectToHim = 'index.php'; 
    }
    echo '<div class="errorMassage">'.$Masseg.'</div>';
    echo '<div class="errorMassage alert alert-info"> Will Be Re Directed In '.$secand.' Secand !</div>';
    header("refresh:$secand;url=$pageToRidirectToHim");
    exit();

}
// Select for Chked
function CheckItem($selcteur,$table,$value){
        global $connect;
        $CheckStmt  =  $connect->prepare("SELECT $selcteur FROM $table WHERE $selcteur = ?");
        $CheckStmt -> execute(array($value));
        $CheckCount =  $CheckStmt -> rowCount();
        return $CheckCount;
}
// Count Items
function countItems($item,$tabel){
    global $connect;
    $countStmt =  $connect -> prepare("SELECT COUNT($item) FROM  $tabel");
    $countStmt -> execute();
    return  $countStmt -> fetchColumn();
    
}
// Get Latest 
function getLatest($selcteur,$tabel,$order,$limit =5){
    global $connect;
    $getLatestStmt =  $connect -> prepare("SELECT $selcteur FROM $tabel ORDER BY $order DESC  LIMIT $limit");
    $getLatestStmt -> execute();
    $rows = $getLatestStmt -> fetchAll();
    return $rows;
}


?>
