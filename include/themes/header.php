<!DOCTYPE html>
<html>
    <head>
    <meta charset="UTF-8"/>
        <link rel="stylesheet" href="<?= $css; ?>bootstrap.min.css"/>
        <link rel="stylesheet" href="<?= $css; ?>bootstrap.css"/>
         <link rel="stylesheet" href="<?= $css; ?>backend.css"/>
        <link rel="stylesheet" href="<?= $css; ?>frontend.css"/>
       <title>
        <?php
        echo $page_title;
        ?>
           </title>
        
       

    </head>
    <body>
<div class="container">
    <nav class="navbar navbar-inverse">
  <div class="container-fluid">
    <div class="navbar-header">
   <!--   <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar">
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>                        
      </button> -->
    </div>
    <div class="collapse navbar-collapse" id="myNavbar">
      <ul class="nav navbar-nav">
        <li class="active"><a href="index.php">Accueil</a></li>
      </ul>
        <ul class="nav navbar-nav navbar-right">
            <?php if(!isset($Menu)) { ?>
         <li class="active"><a href="logout.php"><span class="glyphicon glyphicon-log-out"></span> Logout</a></li>
        <?php    } ?>
      </ul>
    </div>
  </div>
</nav>
