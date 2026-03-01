<?php
include 'connect.php';
//Routs Dirctoury
$tpl   = 'includes/templates/';
$func   = 'includes/functions';
$css   = 'layout/css/';
$js    = 'layout/js/';
$lang  = 'includes/languages/';
//Include Fails
include 'includes/functions/function.php';
include $lang.'english.php';
include $tpl.'header.php';
// Include NavBar On all Pages Expte Page We have >>$noNavbar<< varible
if(!isset($noNavbar)){include $tpl.'navbar.php';}

?>