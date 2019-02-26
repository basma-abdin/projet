<?php
session_start();
$Menu='';
if(isset($_SESSION['Username'])){
    $page_title= "date" ;
   include ("init.php");
    ?>
<h1 class="text-center">choisir l'année à consulter</h1>
<h2>Notice: par défaut , c'est l'année en cours</h2>
    <form class="form-horizontal" action="goTuteur.php" method="post">
<!--        <input type="hidden" name="uid" value="<?= $Uid ?>" />-->
<!--        <div class="row">-->
<div class="form-group ">
            <label class="col-sm-2 control-label">choisir l'année</label>
            <div class="col-sm-2">
                <select name="year">
                <option value="<?= date("Y") ?>">l'annee en cours</option>
                <option value="2016">2016</option>
                <option value="2015">2015</option>
                <option value="2014">2014</option>
                <option value="2013">2013</option>

                </select>      
            </div>    
        </div>
        <div class="form-group">
            <div class="col-sm-2">
            <input type="submit" 
                value="Ok" class="btn btn-primary"/>
            </div>    
        </div>  
<!--            </div>-->
    </form>

<?php
    include $thm . 'footer.php';
}else {
   header('location: index.php');
    exit();
}