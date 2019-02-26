<?php
    include ("../db_config.php");
    $thm='include/themes/';//themes
    $css='designe/css/';//css
    //include"auth/EtreAuthentifie.php";
   
    include $thm .'header.php';
    require ("include/functions/functions.php");
    if (!isset($noMenu)){
        include $thm .'menu.php';
    }

?>