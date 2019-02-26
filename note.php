<?php
session_start();
$Menu='';
if(isset($_SESSION['Username']) && isset($_SESSION['role']) && $_SESSION['role']=='user' ){
    $page_title= "Note Page" ;
   include ("init.php");
   if( $_SESSION['actif'] ){
    $do = (isset($_GET['do']))? $_GET['do'] :'Manage';
       $uid= $_SESSION['Uid'];
if ($do == 'Manage'){
    echo "<h1 class='text-center'>Gestion des notes</h1>";

        /* designe de tableau */
    ?>
    <table class="mainTable text-center table table-bordered">
    <thead>
        
      <tr>
        <th>stageID</th>
        <th>Note</th>
        <th>Commentaire</th>
        <th>modifications</th>
      </tr>
    </thead>
        <?php  $date = date('Y-m-d h:i:s a', time());   
    $sql="SELECT sid , date FROM soutenances WHERE tuteur1=? OR tuteur2=? AND YEAR(date)= ?";
        $res=$db->prepare($sql);
        $res->execute(array($uid,$uid,$date));
        $rows=$res->fetchALL();
        foreach($rows as $row){
        $sql="SELECT sid,note,commentaire FROM notes WHERE sid=? ";
        $res=$db->prepare($sql);
        $res->execute(array($row['sid']));
        $rows=$res->fetchALL(); ?>
        <?php
        foreach($rows as $row){
        ?>
    <tbody>
      <tr>
        <td><?= $row['sid'] ?></td>
        <td><?= $row['note'] ?></td>
        <td><?= $row['commentaire'] ?></td>
        <td> 
            <!--ajoute button modif  -->
            <a href="note.php?do=Edit&sid=<?= $row['sid'] ?>" class="btn btn-success"> <span class="glyphicon glyphicon-edit"></span>Modifier</a>
          </td>
      </tr>
   <?php } }?>
    </tbody>
  </table>
        <!--ajoute button "ajout" -->
    <?php  
}   
      
elseif ($do == 'Add'){
   
if(isset($_GET['stid']) &&is_numeric($_GET['stid']))
        {
            $stid=$_GET['stid'];
           $row= checkvaleur('soutenances','stid',$stid);
            if($row == 0){ 
                $msg="<div class='alert alert-danger'> Soutenances id  non connu</div>"; 
                    redirect($msg,$url="goTuteur.php");
            }else{ 
        ?>
<h3>Ajoute note pour la soutenance </h3>
                <form class="form-horizontal" action="note.php?do=Insert" method="post">
                    <input type="hidden" name="stid" value="<?= $stid ?>"/>
    <!-- start nom -->
        <div class="form-group form-group-lg">
            <label class="col-sm-2 control-label">Note</label>
            <div class="col-sm-10 col-md-4">
                <input type="text" name="note" class="form-control"required="required"/>
            </div>
        </div>
    <!-- End nom -->
    <!-- start prenom -->
        <div class="form-group form-group-lg">
            <label class="col-sm-2 control-label">Commentaire</label>
            <div class="col-sm-10 col-md-4">
                <input type="text" name="coment" class="form-control" required="required"/>
            </div>
        </div>
    <!-- End prenom -->

<!-- envoyer -->
          <div class="form-group">
            <div class="col-sm-10 col-md-6">
            <input type="submit" 
                value="Ajouter" class="btn btn-primary"/>
            </div>    
        </div>

    </form>
    <?php               
            } 
}else { //else de testExistId
     $msg="<div class='alert alert-danger'>Soutenance id non trouvé</div>";
    redirect($msg,$url="goTuteur.php");
}
    
}     
 elseif($do == 'Insert'){
     if($_SERVER['REQUEST_METHOD'] == 'POST'){
          $formsError=array();
                /* si un entree vide rempli le tab $formsError */
         if(empty($_POST['note'])){$formsError[]= "La note ne doit pas être vide";}
        if(empty($_POST['coment'])){$formsError[]= "Commentaire ne doit pas être vide";}

         foreach($formsError as $error ){
               ?> <div class="alert alert-danger"><?= $error ?></div> <?php
            }
         if (empty($formsError)){
            $sql="SELECT sid FROM `soutenances` WHERE stid = ?";
             $res = $db-> prepare ($sql);
             $res->execute(array ($_POST['stid']));
            $row=$res->fetch();
            $sql="INSERT INTO `notes`( sid,note,commentaire) VALUES ( ?,? , ?)";
            $res = $db-> prepare ($sql);
            $res->execute(array ($row['sid'],$_POST['note'],$_POST['coment']));
            $row=$res->rowCount();
            if($row >0){
                    echo "<div class='alert alert-success'> ajout effectuée</div>";
                        }else{
                            echo "<div class='alert alert-danger'> ajout n'est pas effectuée</div>";
                        }
         }
}else {
            $msg="<div class='alert alert-danger'>vous ne pouves pas entrer directement dans cette page</div>";
            redirect($msg,$url="goTuteur.php");
              } 
 }       
 elseif($do == 'Edit'){     
if(isset($_GET['sid']) &&is_numeric($_GET['sid']))
        {
            $sid=$_GET['sid'];
           $row= checkvaleur('stages','sid',$sid);
            if($row == 0){ $msg="<div class='alert alert-danger'> Stages  id  non connu</div>"; 
                    redirect($msg,$url="goTuteur.php");
                 }
            else
            {
             $sql="SELECT note , commentaire FROM notes WHERE sid = ?";
            $res = $db-> prepare ($sql);
            $res->execute(array ($sid));
            $row=$res->fetch();
            ?>
            <form class="form-horizontal" action="note.php?do=Update" method="post">
       <input type="hidden" name="sid" value="<?= $sid ?>" />
            <div class="form-group ">
      <label class="col-sm-2 control-label">Note</label>
          <div class="col-sm-10 col-md-4">
            <input type="text" name="note" class="form-control" value="<?= $row['note'] ?>"/>
        </div>
    </div> 
        <div class="form-group ">
       <label class="col-sm-2 control-label">Commentaire</label>
          <div class="col-sm-10 col-md-4">
            <input type="text" name="coment" class="form-control" value="<?= $row['commentaire'] ?>"/>
        </div>
    </div> 
    <div class="form-group">
            <div class="col-sm-10 col-md-6">
            <input type="submit" 
                value="Modifier" class="btn btn-primary"/>
            </div>    
        </div>  
</form>
 
<?php
            } 
 }else { $msg="<div class='alert alert-danger'> Soutenances  id  non connu</div>"; 
                    redirect($msg,$url="goTuteur.php");
        }
 }      
       
elseif($do == 'Update'){            
   if($_SERVER['REQUEST_METHOD'] == 'POST'){
          $formsError=array();
                /* si un entree vide rempli le tab $formsError */
         if(empty($_POST['note'])){$formsError[]= "La note ne doit pas être vide";}
        if(empty($_POST['coment'])){$formsError[]= "Commentaire ne doit pas être vide";}

 foreach($formsError as $error ){
               ?> <div class="alert alert-danger"><?= $error ?></div> <?php
            }
         if (empty($formsError)){
            $sid=$_POST['sid'];
            $sql="UPDATE notes SET note=? ,commentaire=? WHERE sid=?";
            $res = $db-> prepare ($sql);
            $res->execute(array ($_POST['note'],$_POST['coment'],$sid,));
            $row=$res->rowCount();
             if($row >0){
                    echo "<div class='alert alert-success'> modification effectuée</div>";
                        }else{
                            echo "<div class='alert alert-danger'> modification n'est pas effectuée</div>";
                        }
             
             
 }
}else {
            $msg="<div class='alert alert-danger'>vous ne pouves pas entrer directement dans cette page</div>";
            redirect($msg,$url="goTuteur.php");
              }     
       
       
       
}
       
       
       
       
       
       
       
       
       
       
       
       
       
       
       
       
       
       
       
       
       
       
       
       
       
       
       
       
       
       
       
       }else {
        echo "<div class='alert alert-danger'>vous êtes désactivé</div>";                  
    } 
      include $thm . 'footer.php';
    }else {
   header('location: index.php');
      }
?>