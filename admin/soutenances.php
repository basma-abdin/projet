<?php
session_start();
if(isset($_SESSION['Username'])){
    $page_title= "sontenances page" ;
   include ("init.php");

///cette page gere les soutenances | afficher | ajouter | modifier | supprimer
 $do = isset($_GET['do'])? $_GET['do'] : 'Manage';
    /****** Start Manage *******/  
  if($do == 'Manage'){
      $year=$_SESSION['year'];
     //l'affichage de list de soutenances avac option 
        echo "<h1 class='text-center'>Gestion des sotenances</h1>";
        $sql=" SELECT stid, soutenances.sid , stages.titre , tuteur1 , u.nom as tut1 , tuteur2 , u2.nom as tut2 , date , salle FROM soutenances
JOIN stages on stages.sid=soutenances.sid 
JOIN users as u on soutenances.tuteur1=u.uid
JOIN users as u2 ON soutenances.tuteur2=u2.uid
WHERE YEAR(date) = ?
ORDER BY date , tut1 , tut2";
        $res=$db->prepare($sql);
        $res->execute(array($year));
        $rows=$res->fetchALL();
        //designe de tableau
    ?>
    <table class="mainTable text-center table table-bordered table-hover">
    <thead>
      <tr>
        <th>SoutenanceID</th> 
        <th>StageID</th>
        <th>Titre de stage</th>
        <th>Tuteut1</th>
        <th>Nom</th>
        <th>Tuteur2</th>
        <th>Nom</th>
        <th>Date</th>
        <th>Salle</th>
        <th> </th>
      </tr>
    </thead>
        <?php
        foreach($rows as $row){
        ?>
    <tbody>
      <tr>
        <td><?= $row['stid'] ?></td>
        <td><?= $row['sid'] ?></td>
        <td><?= $row['titre'] ?></td>
        <td><?= $row['tuteur1'] ?></td>
        <td><?= $row['tut1'] ?></td>
        <td><?= $row['tuteur2'] ?></td>
        <td><?= $row['tut2'] ?></td>
        <td><?= $row['date'] ?></td>
        <td><?= $row['salle'] ?></td>
        <td> 
            <a href="soutenances.php?do=Edit&stid=<?= $row['stid'] ?>" class='btn btn-success '> <span class="glyphicon glyphicon-edit"></span>Modifier</a>
            <a href="soutenances.php?do=Delet&stid=<?= $row['stid'] ?>" class='btn btn-danger confirm'><span class="glyphicon glyphicon-remove"></span>Supprimer</a>
          </td>
      </tr>
   <?php 
        }
        ?>
    </tbody>
  </table>
     <a href="soutenances.php?do=Add" class="btn btn-primary"><span class="glyphicon glyphicon-plus"></span>Ajouter soutenances</a>
        
    <?php

  }    
/****** End Manage *******/ 
 /****** Start Add *******/  
  elseif($do == 'Add'){
        echo "<h1 class='text-center'>Ajouter une soutenance</h1>";
        include("addSoutenance_form.php");
  }
/****** End Add *******/
/****** Start Insert *******/  
 elseif($do == 'Insert'){
        if($_SERVER['REQUEST_METHOD']=='POST')
        {
            $formsError=array();
                /* si un entree vide rempli le tab $formsError */
            if(empty($_POST['sid'])){$formsError[]= "stage id ne doit pas être vide";}
            if(empty($_POST['tut1'])){$formsError[]= "tuteur1 ne doit pas être vide";}
            if(empty($_POST['tut2'])){$formsError[]= "tuteur2 ne doit pas être vide";}
            if(empty($_POST['date'])){$formsError[]= "date ne doit pas être vide";}
            if(empty($_POST['salle'])){$formsError[]= "salle ne doit pas être vide";}
                /* parcourir et afficher les erreurs */
            foreach($formsError as $error ){
                $msg="<div class='alert alert-danger'> $error </div>" ;
                redirect($msg,$url="soutenances.php?do=Add");
            }
            
            /* si y a pas errors on pass a la requete */
            if (empty($formsError)){
                $sid=$_POST['sid'];
                $tut1=$_POST['tut1'];
                $tut2=$_POST['tut2'];
                $date=$_POST['date'];
                $salle=$_POST['salle'];
                $sql="INSERT INTO soutenances (sid , tuteur1 , tuteur2 , date , salle ) VALUES ( ? , ? , ? , ? , ? )";
                $res=$db->prepare($sql);
                $res->execute(array($sid,$tut1,$tut2,$date,$salle));
                $count=$res->rowCount();
                 if($count< 0 )
                 {  $msg = "<div class='alert alert-danger'>Erreur</div>";
                        redirect($msg,$url='soutenances.php');
                        }
                else{
                $msg= "<div class='alert alert-success'> l'ajout effectuée</div>";
                redirect($msg,$url='soutenances.php');
                }
            }
  
  }else {
         $msg="<div class='alert alert-danger'>vous ne pouves pas entrer directement dans cette page</div>";
        redirect($msg);
         }
 }
/****** End Insert *******/    
/****** Start Edit *******/
 elseif($do == 'Edit'){
     /* testExistId */
        if(isset($_GET['stid']) &&is_numeric($_GET['stid']))
        {
            $stid=$_GET['stid'];
          $row= checkvaleur('soutenances','stid',$stid);
            if($row == 0){ 
                $msg="<div class='alert alert-danger'> soutenance id non connu</div>"; 
                    redirect($msg,$url="soutenances.php","previous page");  }
            else
            {
             include("editsoutenance_form.php");
            } 
        }else { //else de testExistId
            $msg="<div class='alert alert-danger'>soutenance id non trouvé</div>";
                       redirect($msg,$url="soutenances.php");
        }
 }
/****** End Edit *******/   
 /****** Start Update *******/
elseif($do == 'Update'){
     if($_SERVER['REQUEST_METHOD']=='POST')
        {
          empty($_POST['date'])?$date=$_POST['olddate']:$date=$_POST['date'];
         empty($_POST['salle'])?$salle=$_POST['oldsalle']:$salle=$_POST['salle'];
         $sql="UPDATE soutenances SET sid = ? , tuteur1 = ? , tuteur2 = ? , date = ? , salle = ? WHERE stid = ?";
         $res=$db->prepare($sql);
         $res->execute(array($_POST['sid'],$_POST['tut1'],$_POST['tut2'],$date,$salle,$_POST['stid']));
         $count=$res->rowCount();
            if($count< 0 )
                 {  $msg = "<div class='alert alert-danger'>Erreur</div>";
                        redirect($msg,$url='soutenances.php');
                        }
                else{
                $msg= "<div class='alert alert-success'> Mis à jour effectué</div>";
                redirect($msg,$url='soutenances.php');
                }
         
         
         
}else {
         $msg="<div class='alert alert-danger'>vous ne pouves pas entrer directement dans cette page</div>";
        redirect($msg,$url="soutenances.php");
         }
 
    
}
/****** End Update *******/  
/****** Start Delet *******/
 elseif($do == 'Delet'){
    if( isset($_GET['stid'])&&is_numeric($_GET['stid']) )
       {
            $stid=$_GET['stid']; 
        
        $row= checkvaleur('soutenances','stid',$stid);
            if($row == 0){ 
                $msg="<div class='alert alert-danger'> soutenqnce id  non connu</div>"; 
                    redirect($msg,$url="soutenances.php","previous page");
            }
            else {
                $sql="DELETE FROM soutenances WHERE stid=?";
                $res = $db-> prepare ($sql);
                $res->execute(array($stid));
                if(!$res){
                    $msg = "<div class='alert alert-danger'>Erreur</div>";
                        redirect($msg,$url='soutenances.php');
                        }
                else{
                $msg= "<div class='alert alert-success'> suppresion effectuée</div>";
                redirect($msg,$url='soutenances.php');
                }      
            }            
     }else {
               echo $msg="<div class='alert alert-danger'>soutenance id non trouvé</div>";
                redirect($msg,$url="soutenances.php");
              }
}
 /****** End Delet *******/   
    
    
?> 

<?php
    include $thm . 'footer.php';
    }//fin edit
      else {
   header('location: index.php');
    exit();
}
?>
