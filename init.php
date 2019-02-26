<?php
    include ("db_config.php");
    $thm='include/themes/';//themes
    $css='admin/designe/css/';//css
    //include"auth/EtreAuthentifie.php";
   
    include $thm .'header.php';
    include ("admin/include/functions/functions.php");
    if (isset($Menu)){
       include("menu.php");
    }

?>
