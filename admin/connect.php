<?php
$dns      = 'mysql:host=localhost;dbname=market';
$username = 'root';
$password = '';
$option   = array(
    PDO::MYSQL_ATTR_INIT_COMMAND =>'SET NAMES utf8'
);
try{
    $connect = new PDO($dns,$username,$password,$option);
    $connect->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
}
catch(PDOException $error){
    echo 'Filid connect '.$error;
}
?>