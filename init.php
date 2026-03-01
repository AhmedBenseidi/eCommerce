<?php
include 'admin/connect.php';
//Routs Dirctoury
$tpl   = 'includes/templates/';
$func   = 'includes/functions';
$css   = 'layout/css/';
$js    = 'layout/js/';
$lang  = 'includes/languages/';
$sessionUser = '';
//Include Fails
include 'includes/functions/function.php';
include $lang.'english.php';
include $tpl.'header.php';
if(isset($_SESSION['User'])){
    $sessionUser = $_SESSION['User'];
    }
?>