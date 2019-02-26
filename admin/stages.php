<?php
session_start();
if(isset($_SESSION['Username'])){
    $page_title= "mainPage" ;
   include ("init.php");

///cette page gere les stages | afficher | supprimer
      $do = isset($_GET['do'])? $_GET['do'] : 'Manage';
      
    if($do == 'Manage'){
        $year= $_SESSION['year'];
        //l'affichage de list de stages avac option de suppresrion
        echo "<h1 class='text-center'>Gestion des stages</h1>";
        $sql="SELECT * FROM stages WHERE YEAR(dateDebut) = ? AND YEAR(dateFin) = ?";
        $res=$db->prepare($sql);
        $res->execute(array($year,$year));
        $rows=$res->fetchALL();
        //designe de tableau
    ?>
    <table class="mainTable table table-bordered table-hover">
    <thead>
      <tr>
        <th>stageID</th>
        <th>EtudiantID</th>
        <th>Titre</th>
        <th>description</th>
        <th>TuteutE</th>
        <th>EmailTE</th>
        <th>TuteurP</th>
        <th>DateDebut</th>
        <th>DateFin</th>
        <th> </th>
      </tr>
    </thead>
        <?php
        foreach($rows as $row){
        ?>
    <tbody>
      <tr>
        <td><?= $row['sid'] ?></td>
        <td><?= $row['eid'] ?></td>
        <td><?= $row['titre'] ?></td>
        <td><?= $row['description'] ?></td>  
        <td><?= $row['tuteurE'] ?></td>
        <td><?= $row['emailTE'] ?></td>
        <td><?= $row['tuteurP'] ?></td>
        <td><?= $row['dateDebut'] ?></td>
        <td><?= $row['dateFin'] ?></td>
        <td> 
            <a href="stages.php?do=Delet&sid=<?= $row['sid'] ?>" class='btn btn-danger confirm'><span class="glyphicon glyphicon-remove"></span>Supprimer</a>
          </td>
      </tr>
   <?php 
        }
        ?>
    </tbody>
  </table>
        
    <?php
    }
    elseif ($do == 'Delet' ){
        if( isset($_GET['sid'])&&is_numeric($_GET['sid']) )
       {
                $Sid=$_GET['sid']; 
                $sql="DELETE FROM stages WHERE sid=?";
                $res = $db-> prepare ($sql);
                $res->execute(array($Sid));
                 if(!$res){$msg = "<div class='alert alert-danger'>Erreur</div>";
                        redirect($msg,$url='stages.php');
                        }
                else{
                $msg= "<div class='alert alert-success'> suppresion effectuée</div>";
                       redirect($msg,"stages.php");}
       }else {
                echo $msg="<div class='alert alert-danger'>stage id non trouvé</div>";
                redirect($msg,$url="stages.php");
              }
    }
////////////////////////////////////////////
    

    include $thm . 'footer.php';
    }//fin edit
      else {
   header('location: index.php');
    exit();
}
?>

