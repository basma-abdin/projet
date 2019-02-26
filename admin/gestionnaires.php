<?php
session_start();
if(isset($_SESSION['Username'])){
    $page_title= "gestionnaire page" ;
   include ("init.php");


      $do = isset($_GET['do'])? $_GET['do'] : 'Manage';
     if($do == 'Manage'){
        /* l'affichage de list de users avac option de modification | suppresion */
        echo "<h1 class='text-center'>Gestion des gestionnaires adminstratifs</h1>";
        $sql="SELECT * FROM gestionnaires";
        $res=$db->prepare($sql);
        $res->execute();
        $rows=$res->fetchALL();
        /* designe de tableau */
    ?>
    <table class="mainTable text-center table table-bordered">
    <thead>
      <tr>
        <th>Gid</th>
        <th>Nom</th>
        <th>Prenom</th>
        <th>Email</th>
        <th>Token</th>
        <th> </th>
      </tr>
    </thead>
        <?php
        foreach($rows as $row){
        ?>
    <tbody>
      <tr>
        <td><?= $row['gid'] ?></td>
        <td><?= $row['nom'] ?></td>
        <td><?= $row['prenom'] ?></td>
        <td><?= $row['email'] ?></td>  
        <td><?= $row['token'] ?></td>
        <td> 
            <!--ajoute button supp -->
            <a href="gestionnaires.php?do=Edit&gid=<?= $row['gid'] ?>" class='btn btn-success confirm'><span class="glyphicon glyphicon-edit"></span>régénérer token</a>
            <a href="gestionnaires.php?do=Delet&gid=<?= $row['gid'] ?>" class='btn btn-danger confirm'><span class="glyphicon glyphicon-remove"></span>Supprimer</a>
          </td>
      </tr>
   <?php } ?>
    </tbody>
  </table>
        <!--ajoute button "ajout" -->
        <a href="gestionnaires.php?do=Add" class="btn btn-primary"><span class="glyphicon glyphicon-plus"></span>Ajouter gestionnaire adminstratif</a>
    <?php
    }
    /****** End manage *******/
     /****** Start Add ******/
     elseif($do == 'Add'){
         echo "<h1 class='text-center'>Ajouter un gestionnaire adminstratif</h1>";
        include("addgestionnaire_form.php");
    }
    elseif($do == 'Insert'){
        if($_SERVER['REQUEST_METHOD'] == 'POST'){
   
            /* test pour valider les entres */
            $formsError=array();
                /* si un entree vide rempli le tab $formsError */
            if(empty($_POST['nom'])){$formsError[]= "nom ne doit pas être vide";}
            if(empty($_POST['prenom'])){$formsError[]= "prenom ne doit pas être vide";}
            if(empty($_POST['email'])){$formsError[]= "email ne doit pas être vide";}
//            if(empty($_POST['token'])){$formsError[]= "token ne doit pas être vide";}

                /* parcourir et afficher les erreurs */
            foreach($formsError as $error ){
               ?> <div class="alert alert-danger"><?= $error ?></div> <?php
            }
            
            /* si y a pas errors on pass a la requete */
            if (empty($formsError)){
            /*on recuper tt les valeurs d'entrees puis fait le requete pour ajouter */
            $sql="INSERT INTO gestionnaires ( nom , prenom , email , token ) VALUES (?,?,?,?)";
            $res=$db->prepare($sql);
            $res->execute(array($_POST['nom'],$_POST['prenom'],$_POST['email'],$_POST['token']));
            $count=$res->rowCount();
            if($count>0){
                echo "<div class='alert alert-success'> l'ajout effectué</div>";
                 if(isset($_POST['button_pressed'])){
                    $url= send_mail($_POST['token'],$_POST['email']);
            }
                echo "<div class='alert alert-info'>ajout effectué , le gestionnaire administratif va recevoire un mail indiquant son token et avec ce lien : ".$url."</div>";
            }else{
                $msg= "<div class='alert alert-danger'> l'ajout n'est pas effectue</div>";
                redirect($msg,$url="gestionnaires.php");
            }
        } //acolad de testEmptyEerror
        } //acolad de server_method_post
        else {
            $msg="<div class='alert alert-danger'>vous ne pouves pas entrer directement dans cette page</div>";
            redirect($msg,$url="gestionnaires.php");
              }
}
 /****** End Add ******/
elseif($do == 'Delet'){
    if( isset($_GET['gid'])&&is_numeric($_GET['gid']) )
       {
            $gid=$_GET['gid']; 
        
        $row= checkvaleur('gestionnaires','gid',$gid);
            if($row == 0){ 
                $msg="<div class='alert alert-danger'> gestionnaire id non connu</div>"; 
                    redirect($msg,$url="gestionnaires.php","previous page");
            }
            else {
                $sql="DELETE FROM gestionnaires WHERE gid=?";
                $res = $db-> prepare ($sql);
                $res->execute(array($gid));
                if(!$res){
                    $msg = "<div class='alert alert-danger'>Erreur</div>";
                        redirect($msg,$url='gestionnaires.php');
                        }
                else{
                $msg= "<div class='alert alert-success'> suppresion effectué</div>";
                redirect($msg,$url='gestionnaires.php');
                }      
            }            
     }else {
               echo $msg="<div class='alert alert-danger'>gestionnaire id non trouvé</div>";
                redirect($msg,$url="gestionnaires.php");
              }
   
}
elseif($do == 'Edit'){
    if(isset($_GET['gid']) &&is_numeric($_GET['gid']))
        {
            $gid=$_GET['gid'];
          $row= checkvaleur('gestionnaires','gid',$gid);
            if($row == 0){ 
                $msg="<div class='alert alert-danger'> gestionnaire id non connu</div>"; 
                    redirect($msg,$url="gestionnaires.php","previous page");  }
            else
            {
                $token = uniqid(rand(), true);
                /* fait la requete pour recupere l'emai d'gestionnaire */
                $sql="SELECT email FROM gestionnaires WHERE gid=?";
                $res = $db-> prepare ($sql);
                $res->execute(array($gid));
                $row=$res->fetch();
                $mail=$row['email'];
                /* fait la requete pour changer token*/
                $sql="UPDATE gestionnaires SET token = ? WHERE gid = ?";
                $res = $db-> prepare ($sql);
                $res->execute(array($token,$gid));
                $row2=$res->rowCount();
                if ($row2 == 0){
                    $msg="<div class='alert alert-danger'>le changement n'est pas effectué</div>"; 
                    redirect($msg,$url="gestionnaires.php");  
                }
                else {
                    $url=send_mail($token,$mail);
                     echo "<div class='alert alert-info'>changement effectué , le gestionnaire administratif va recevoire un mail indiquant son nouveau token et avec ce lien :  ".$url."</div>"; 
                    
                    }
                } 
        }else { //else de testExistId
            $msg="<div class='alert alert-danger'>gestionnaire id non trouvé</div>";
                       redirect($msg,$url="soutenances.php");
        } 
}
 
    include $thm . 'footer.php';
    }//fin edit
      else {
   header('location: index.php');
      }
?>