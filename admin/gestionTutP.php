<?php
session_start();
if(isset($_SESSION['Username'])){
    $page_title= "mainPage" ;
   include ("init.php");

/***************************************************************************************
** cette page peut afficher| ajouter (tut/stage) | modifier (tut/stage) |supprimer 
** list de (tut/stage) *****************************************************************
****************************************************************************************/
   //تزبيط كل الجت مع الفونكسيون شك فاليو s
 $do = isset($_GET['do'])? $_GET['do'] : 'Manage';
    ////essayer afficher titre de stage
    if($do == 'Manage'){
        /* l'affichage de list de tuteur (user Non admin) */
        echo "<h1 class='text-center'>Gestion des affectation des tuteurs pedagogiques</h1>";
        $sql="SELECT uid , nom ,prenom , sid , stages.titre FROM users LEFT JOIN stages ON users.uid=stages.tuteurP  WHERE role=?";
        $res=$db->prepare($sql);
        $res->execute(array('user'));
        $rows=$res->fetchALL();
        /* designe de tableau */
    ?>
    <table class="mainTable text-center table table-bordered">
    <thead>
      <tr>
        <th>user ID</th>
        <th>Nom</th>
        <th>Prenom</th>
        <th>Stage ID</th>
        <th>Stage Titre</th>
        <th>Modification</th>
      </tr>
    </thead>
        <?php
        foreach($rows as $row){
        ?>
    <tbody>
      <tr>
        <td><?= $row['uid'] ?></td>
        <td><?= $row['nom'] ?></td>
        <td><?= $row['prenom'] ?></td>
        <td><?= $row['sid'] ?></td>
        <td><?= $row['titre'] ?></td>  
        <td> 
            <!--ajoute button modif | supp -->
            <a href="gestionTutP.php?do=Add&uid=<?= $row['uid'] ?>" class="btn btn-success"><span class="glyphicon glyphicon-plus"></span>Ajouter</a>
            <?php 
            if (!empty($row['sid'])) { ?>
            <a href="gestionTutP.php?do=Edit&uid=<?= $row['uid'] ?>&sid=<?= $row['sid'] ?>" class="btn btn-warning">Changer</a>
            <a href="gestionTutP.php?do=Delet&sid=<?= $row['sid'] ?>" class='btn btn-danger confirm'><span class="glyphicon glyphicon-remove"></span>Supprimer</a>
           <?php  } ?>
          </td>
      </tr>
   <?php } ?>
    </tbody>
  </table>
    <?php
    }
    /****** End manage *******/
    /****** Start Add *******/
    elseif($do == 'Add'){
     if(isset($_GET['uid']) &&is_numeric($_GET['uid']))
     {
         $year=$_SESSION['year'];
         $tutid=$_GET['uid'];
         echo "<h1 class='text-center'>Ajouter stage</h1>";
         $sql="SELECT sid,titre FROM stages WHERE tuteurP is NULL AND YEAR(dateDebut) = ? AND YEAR(dateFin)= ?";
        $res=$db->prepare($sql);
        $res->execute(array($year,$year));
        $rows=$res->fetchALL();
        //designe de tableau
    ?>
    <form action="gestionTutP.php?do=Update&tutid=<?= $tutid ?>" method="post">
    <table class="mainTable table table-bordered table-hover">
    <thead>
      <tr>
        <th>stageID</th>
        <th>Titre</th>
        <th>Choisir</th>
      </tr>
    </thead>
        <?php
        foreach($rows as $row){
        ?>
    <tbody>
      <tr>
        <td><?= $row['sid'] ?></td>
        <td><?= $row['titre'] ?></td>
        <td> 
            <input type="checkbox" name="select[]" value="<?= $row['sid'] ?>" class="form-control"/>  
          </td>
      </tr>
   <?php } ?>
    </tbody>
  </table>
    <div class="form-group">
            <div class="col-sm-10 col-md-6">
            <input type="submit" 
                value="Ajouter" class="btn btn-primary"/>
            </div>  
        </div>
        </form>
    <?php
  }else {
         $msg="<div class='alert alert-danger'>tuteur id non trouvé</div>";
         redirect($msg);
     }
}
   /****** End Add *******/ 
/****** Start Update  *******/ 
    elseif($do == 'Update'){
     echo "<h1 class='text-center'>Mis à jour tuteur/stages</h1>";
        if($_SERVER['REQUEST_METHOD']=='POST')
        {
          if(isset($_GET['tutid']) &&is_numeric($_GET['tutid']))
          {
            $tutP=$_GET['tutid'];
              if(isset($_POST['select'])){
            foreach($_POST['select'] as $valeur){
              $sql="UPDATE stages SET tuteurP=? WHERE sid=?";
              $res = $db-> prepare ($sql);
              $res->execute(array($tutP,$valeur));
              $row=$res->rowCount();
            }     
            if($row == 0){
                 $msg="<div class='alert alert-danger'>Erreur! </div>";
                  redirect($msg,$url='gestionTutP.php');
            }else {
                 $msg="<div class='alert alert-success'>l'ajout efectué</div>";
                  redirect($msg,$url='gestionTutP.php');
            }}else { $msg="<div class='alert alert-danger'>non stage à ajouter</div>";
                   redirect($msg,$url='gestionTutP.php');
                   }
         }else {
                $msg="<div class='alert alert-danger'>tuteur id non trouvé</div>";
                redirect($msg);
              }
     
     }else {
         $msg="<div class='alert alert-danger'>vous ne pouves pas entrer directement dans cette page</div>";
        redirect($msg);
         }
}
    /****** End Update *******/
      /****** Start Edit *******/ 
 elseif($do == 'Edit'){
     $year=$_SESSION['year'];
      echo "<h1 class='text-center'>Choisir un stage</h1>";
   if( (isset($_GET['uid'])&&is_numeric($_GET['uid'])) && (isset($_GET['sid'])&&is_numeric($_GET['sid'])) ){
            $tutp = $_GET['uid'];
            $stid = $_GET['sid'];
            $sql="SELECT `sid`,`titre` FROM `stages` WHERE sid != ? AND YEAR(dateDebut) = ? AND YEAR(dateFin)= ?";
            $res = $db-> prepare ($sql);
            $res->execute(array($stid,$year,$year));
            $rows=$res->fetchALL();
            /* tableua */
         ?>
    <form action="gestionTutP.php?do=UpdateEdit&tutid=<?= $tutp ?>" method="post">
    <table class="mainTable table table-bordered table-hover">
    <thead>
      <tr>
        <th>stageID</th>
        <th>Titre</th>
        <th>Choisir</th>
      </tr>
    </thead>
        <?php
        foreach($rows as $row){
        ?>
    <tbody>
      <tr>
        <td><?= $row['sid'] ?></td>
        <td><?= $row['titre'] ?></td>
        <td> 
            <input type="radio" name="select" value="<?= $row['sid'] ?>" class="form-control"/>  
          </td>
      </tr>
   <?php } ?>
    </tbody>
  </table>
    <div class="form-group">
            <div class="col-sm-10 col-md-6">
            <input type="submit" 
                value="Changer" class="btn btn-primary"/>
            </div>  
        </div>
        </form>
    <?php ///UPDATE `stages` ( SET tuterP = 2 WHERE sid = 6 ) AND ( SET tuteurP = null where sid =5 )
   }else{
      $msg="<div class='alert alert-danger'>tuteur id ou stage id non trouvé</div>";
      redirect($msg,$url='gestionTutP.php'); 
   } 
 }
     /****** End Edit *******/  
    /****** Start UpdateEdit *******/ 
   elseif($do == 'UpdateEdit'){
       if( isset($_GET['tutid'])&&is_numeric($_GET['tutid']) )
       {
         if($_SERVER['REQUEST_METHOD']=='POST')
        {
             $tutp=$_GET['tutid'];
        echo "<h1 class='text-center'>Mis à jour le stage pour le tuteur : $tutp</h1>";
             if(empty($_POST['select'])){
                  $msg="<div class='alert alert-danger'>vous n'avez rien choisi</div>";
                  redirect($msg,$url='gestionTutP.php');
             }else
             {
                 $sid=$_POST['select'];
                 //mettre le tut de stage choisi a null puis ajouter un tut "un stage peut pas avoir qu'un seul tut"
                 $sql="UPDATE stages SET tuteurP = NULL WHERE sid =? ";
                 $res = $db-> prepare ($sql);
                 $res->execute(array($sid));
                 if(!$res){ 
                         $msg="<div class='alert alert-danger'>Erreur</div>";
                           redirect($msg,$url='gestionTutP.php');} 
                 else {
//                   vu que on est dans changer alors on va effacer le stage que notre tut                         en a pius ajoute
                $sql="UPDATE stages SET `tuteurP`= Null WHERE sid= 
                    (SELECT sid WHERE tuteurP = ?)";
                 $res = $db-> prepare ($sql);
                 $res->execute(array($tutp));
                 $sql="UPDATE stages SET tuteurP = ? WHERE sid =? ";
                 $res = $db-> prepare ($sql);
                 $res->execute(array($tutp,$sid));
                 if(!$res){
                     $msg="<div class='alert alert-danger'>Erreur</div>";
                     redirect($msg,$url='gestionTutP.php');}   
                 else {
                  $msg="<div class='alert alert-success'>le stage est bien chengé </div>";
                  redirect($msg,$url='gestionTutP.php');
                 }
             }
             }
         }else {
             $msg="<div class='alert alert-danger'>vous ne pouves pas entrer directement dans cette page</div>";
            redirect($msg,$url='gestionTutP.php');
             }
       }else {
                echo $msg="<div class='alert alert-danger'>tuteur id non trouvé</div>";
                redirect($msg,$url='gestionTutP.php');
              }
       
   } 
    /****** End UpdateEdit *******/ 
    /****** Start Delet *******/  
elseif ($do == 'Delet'){
  if( isset($_GET['sid'])&&is_numeric($_GET['sid']) )
       {
                $sid=$_GET['sid']; 
                $sql="UPDATE stages SET tuteurP = NULL WHERE sid =? ";
                $res = $db-> prepare ($sql);
                $res->execute(array($sid));
                if(!$res){$msg = "<div class='alert alert-danger'>Erreur</div>";
                        redirect($msg,$url='gestionTutP.php');
                        }
                else{
                $msg= "<div class='alert alert-success'> suppresion effectuée</div>";
                redirect($msg,$url='gestionTutP.php');
                }
       }else {
                echo $msg="<div class='alert alert-danger'>tuteur id non trouvé</div>";
                redirect($msg,$url='gestionTutP.php');
              }
    
}
    /****** End Delet *******/ 

    include $thm . 'footer.php';
    }//fin edit
      else {
   header('location: index.php');
      }
?>