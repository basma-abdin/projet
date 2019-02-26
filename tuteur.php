<?php
session_start();
$Menu='';
if(isset($_SESSION['Username']) && isset($_SESSION['role']) && $_SESSION['role']=='user' ){
    $page_title= "Tuteur Page" ;
   include ("init.php");
    $right= true;
    $session=$_SESSION['Uid'];
    if (isset($_GET['uid'])){
        $getid=$_GET['uid'];
        $right=testuid($session,$getid);
    }
    if (!$right){
         echo "<div class='alert alert-danger'>Vous n'êtes autorisé que pour votre ID</div>";
//        redirect($msg,$url="goTuteur.php");
    }else{
    $do = (isset($_GET['do']))? $_GET['do'] : header('location: goTuteur.php');
    
if($do == 'Edit')
{
     /* testExistId */
        if(isset($_GET['uid']) &&is_numeric($_GET['uid']))
        {
            $Uid=$_GET['uid'];
           $row= checkvaleur('users','uid',$Uid);
            if($row == 0){ $msg="<div class='alert alert-danger'> Tuteur id  non connu</div>"; 
                    redirect($msg,$url="goTuteur.php");
                         }
            else
            { ?>
             <h1 class="text-center">Changer votre mdp</h1>

    <form class="form-horizontal" action="tuteur.php?do=Update" method="post">
        <input type="hidden" name="uid" value="<?= $Uid ?>" />
        <!--- mdp --->
        <div class="form-group form-group-lg">
            <label class="col-sm-2 control-label">Mot de pass</label>
            <div class="col-sm-10 col-md-4">
            <input type="password" name="mdp" id="mdp" class="form-control" autocomplete="off" required="required"/>
            </div>    
        </div>
          <div class="form-group form-group-lg">
            <label class="col-sm-2 control-label">Retaper le mot de pass</label>
            <div class="col-sm-10 col-md-4">
            <input type="password" name="mdp2" id="mdp2" class="form-control" autocomplete="off" required="required"/>
                 <span id="confirmMessage" class="confirmMessage"></span>
            </div>    
        </div>
        <div class="form-group">
            <div class="col-sm-10 col-md-6">
            <input type="submit"
                value="Changer" class="btn btn-primary check"/>
            </div>    
        </div>
    </form>
        
            <?php } 
        }else { //else de testExistId
            $msg="<div class='alert alert-danger'>Tuteur id non trouvé</div>";
                       redirect($msg,$url="goTuteur.php");
        }
}  
elseif($do == 'Update'){
    if($_SERVER['REQUEST_METHOD']=='POST'){
        $formsError=array();
            if(empty($_POST['mdp'])){$formsError[]= "mot de passe ne doit pas être vide";}
            if(empty($_POST['mdp2'])){$formsError[]= "mot de passe ne doit pas être vide";}
             foreach($formsError as $error ){
               ?> <div class="alert alert-danger"><?= $error ?></div> <?php
            }
            /* si y a pas errors on pass a la requete */
    if (empty($formsError)){
                if ($_POST['mdp2'] != $_POST['mdp'] )
                {
                    $msg="<div class='alert alert-danger'>les deux mot-de-pass ne sont pas identique </div>";
                       redirect($msg,$url="goTuteur.php");
                }else {
                    $id=$_POST['uid'];
                    $newpass= password_hash($_POST['mdp'], PASSWORD_DEFAULT);
                     $sql="UPDATE users SET mdp=?    WHERE uid=$id";
                    $res = $db-> prepare ($sql);
                    $res->execute(array ($newpass));
                    $count=$res->rowCount();
                    if($count >0){
                    echo "<div class='alert alert-success'> changement effectuée</div>";
                        }else{
                            echo "<div class='alert alert-danger'> changement n'est pas effectuée</div>";
                        }
                    
                }

    }  
    }else {
                $msg="<div class='alert alert-danger'>vous ne pouves pas entrer directement dans cette page</div>";
                redirect($msg,$url="goTuteur.php");
                      }    
}
elseif($do == 'Etudiant'){
    $year=$_SESSION['year'];
    if( $_SESSION['actif'] ){
    if(isset($_GET['uid']) &&is_numeric($_GET['uid']))
        {
            $Uid=$_GET['uid'];
           $row= checkvaleur('users','uid',$Uid);
            if($row == 0)
            { $msg="<div class='alert alert-danger'> Tuteur id  non connu</div>"; 
                    redirect($msg,$url="goTuteur.php");
                 }
            else
            { 
                $sql = " SELECT stages.eid ,etudiants.nom , etudiants.prenom FROM etudiants 
                    JOIN stages on stages.eid=etudiants.eid
                    WHERE tuteurP = ? AND YEAR(dateDebut) = ? AND YEAR(dateFin) = ? ";
                $res = $db-> prepare ($sql);
                $res->execute(array ($Uid,$year,$year));
                $rows=$res->fetchALL();
                if(!$rows){
                    echo "Pour l'instatnt vous n'avez pas etudiants dont vous êtes le tuteur pédagogique  ";
                }else{
        /* designe de tableau */
            ?>
        <h3>Vous êtes le tuteur pédagogique de :</h3>
            <table class="mainTable text-center table table-bordered">
            <thead>
              <tr>
                <th>Êtudiant ID</th>
                <th>Nom Prénom</th>
              </tr>
            </thead>
                <?php
                foreach($rows as $row){
                ?>
            <tbody>
              <tr>
                <td><?= $row['eid'] ?></td>
                <td><?= $row['nom']." " . $row['prenom'] ?></td>
              </tr>
           <?php } ?>
            </tbody>
          </table>
       <?php          
                } } 
        }else { //else de testExistId
            $msg="<div class='alert alert-danger'>tuteur id non trouvé</div>";
                       redirect($msg,$url="giTuteur.php");
        }}
    else {
        echo "<div class='alert alert-danger'>vous êtes désactivé</div>";
                       
    }
}
elseif($do == 'Soutenance'){
    $year=$_SESSION['year'];
     if( $_SESSION['actif'] ){
    if(isset($_GET['uid']) &&is_numeric($_GET['uid']))
        {
            $Uid=$_GET['uid'];
           $row= checkvaleur('users','uid',$Uid);
            if($row == 0){ $msg="<div class='alert alert-danger'> Tuteur id  non connu</div>"; 
                    redirect($msg,$url="goTuteur.php");
                 }
            else
            { /*requete pour trouver la soutenances dont le tuteur est principel*/
                $sql="SELECT stid , date , salle  FROM `soutenances` 
                join users on tuteur1 = uid
                WHERE tuteur1 = ? AND YEAR(soutenances.date)=?";
                $res = $db-> prepare ($sql);
                $res->execute(array ($Uid,$year));
                $rows=$res->fetchALL();
                if(!$rows){
                    echo "Pour l'instatnt vous n'avez paz soutenance dont vous êtes le tuteur principale ";
                }else{
        /* designe de tableau */
                    $date = date('Y-m-d h:i:s a', time());
            ?>

        <h3>Vous êtes le tuteur principal de :</h3>
            <table class="mainTable text-center table table-bordered">
            <thead>
              <tr>
                <th>Soutanaces ID</th>
                <th>Date de soutenances</th>
                <th>Salle de soutenances</th>
                <th>Note</th>
              </tr>
            </thead>
                <?php
                foreach($rows as $row){
                ?>
            <tbody>
              <tr>
                <td><?= $row['stid'] ?></td>
                <td><?= $row['date'] ?></td>
                <td><?= $row['salle'] ?></td>
                <td>
                  <?php 
                    if($year == date("Y")){
                    if($date > $row['date'])
                    { 
                    $sql="SELECT notes.sid FROM `notes` WHERE sid = (SELECT soutenances.sid FroM soutenances where stid= ?)";
                    $res = $db-> prepare ($sql);
                    $res->execute(array ($row['stid']));
                    $test=$res->fetch();         
                    if(!$test){ ?>
                    <a href="note.php?do=Add&stid=<?= $row['stid'] ?>" class="btn btn-primary"><span class="glyphicon glyphicon-plus"></span>Ajouter</a>
                   <?php }else{
                   ?>     <a href="note.php?do=Edit&sid=<?= $test['sid'] ?>" class="btn btn-success"><span class="glyphicon glyphicon-edit"></span>Modofier</a> 
                  <?php  } }}
                    ?>
                  </td>
              </tr>
           <?php } ?>
            </tbody>
          </table>
       <?php      
            }
                $sql="SELECT stid , date , salle  FROM `soutenances` 
                join users on tuteur1 = uid
                WHERE tuteur2 = ? AND YEAR(soutenances.date)=?";
                $res = $db-> prepare ($sql);
                $res->execute(array ($Uid,$year));
                $rows=$res->fetchALL();
                if(!$rows){
                    echo "Pour l'instatnt vous n'avez paz soutenance dont vous êtes le tuteur secondaire ";
                }else{
        /* designe de tableau */
                    $date = date('Y-m-d h:i:s a', time());
            ?>
        <h3>Vous êtes le tuteur secondaire de :</h3>
            <table class="mainTable text-center table table-bordered">
            <thead>
              <tr>
                <th>Soutanaces ID</th>
                <th>Date de soutenances</th>
                <th>Salle de soutenances</th>
                <th>Note</th>
              </tr>
            </thead>
                <?php
                foreach($rows as $row){
                ?>
            <tbody>
              <tr>
                <td><?= $row['stid'] ?></td>
                <td><?= $row['date'] ?></td>
                <td><?= $row['salle'] ?></td>
                <td>
                 <?php 
                    if($year == date("Y")){
                    if($date > $row['date'])
                    { 
                    $sql="SELECT notes.sid FROM `notes` WHERE sid = (SELECT soutenances.sid FroM soutenances where stid= ?)";
                    $res = $db-> prepare ($sql);
                    $res->execute(array ($row['stid']));
                    $test=$res->fetch();         
                    if(!$test){ ?>
                    <a href="note.php?do=Add&stid=<?= $row['stid'] ?>" class="btn btn-primary"><span class="glyphicon glyphicon-plus"></span>Ajouter</a>
                   <?php }else{
                   ?>     <a href="note.php?do=Edit&sid=<?= $test['sid'] ?>" class="btn btn-success"><span class="glyphicon glyphicon-edit"></span>Modofier</a> 
                  <?php  } }}
                    ?>
                  </td>
              </tr>
           <?php } ?>
            </tbody>
          </table>
       <?php      
            }
 } 
        }else { //else de testExistId
            $msg="<div class='alert alert-danger'>tuteur id non trouvé</div>";
                       redirect($msg,$url="goTuteur.php");
        }}
    else {
        echo "<div class='alert alert-danger'>vous êtes désactivé</div>";
                       
    }
    
}

    
     include $thm . 'footer.php';
    }}else {
   header('location: index.php');
      }
?>