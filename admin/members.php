<?php
session_start();
if(isset($_SESSION['Username'])){
    $page_title= "maembers page" ;
   include ("init.php");

/***************************************************************************************
**cette page peut afficher| ajouter | modifier (mdp , actif) |supprimer list de users **
****************************************************************************************/
   
    $do = isset($_GET['do'])? $_GET['do'] : 'Manage';
    /****** Start manage ******/
    if($do == 'Manage'){
        /* l'affichage de list de users avac option de modification | suppresion */
        echo "<h1 class='text-center'>Gestion des utilisateurs</h1>";
        $sql="SELECT * FROM users";
        $res=$db->prepare($sql);
        $res->execute();
        $rows=$res->fetchALL();
        /* designe de tableau */
    ?>
    <table class="mainTable text-center table table-bordered">
    <thead>
      <tr>
        <th>UesrID</th>
        <th>Nom</th>
        <th>Prenom</th>
        <th>login</th>
        <th>Mot-de-pass</th>
        <th>Role</th>
        <th>Actif</th>
        <th>modifications</th>
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
        <td><?= $row['login'] ?></td>  
        <td><?= $row['mdp'] ?></td>
        <td><?= $row['role'] ?></td>
        <td><?= $row['actif'] ?></td>
        <td> 
            <!--ajoute button modif | supp -->
            <a href="members.php?do=Edit&uid=<?= $row['uid'] ?>" class="btn btn-success"> <span class="glyphicon glyphicon-edit"></span>Modifier</a>
            <a href="members.php?do=Delet&uid=<?= $row['uid'] ?>" class='btn btn-danger confirm'><span class="glyphicon glyphicon-remove"></span>Supprimer</a>
          </td>
      </tr>
   <?php } ?>
    </tbody>
  </table>
        <!--ajoute button "ajout" -->
        <a href="members.php?do=Add" class="btn btn-primary"><span class="glyphicon glyphicon-plus"></span>Ajouter utilisateur</a>
    <?php
    }
    /****** End manage *******/
    
    /****** Start Add ******/
    
    /* diriger vers  ajouter "just le form contenant les infos pour ajouter" */
    elseif($do == 'Add'){
         echo "<h1 class='text-center'>Ajouter utilisateur</h1>";
        include("add_form.php");
    }
    /* fait le requet pour ajouter */
    elseif($do == 'Insert'){
        if($_SERVER['REQUEST_METHOD'] == 'POST'){
            echo "<h1 class='text-center'>Ajouter</h1>";
            /* test pour valider les entres */
            $formsError=array();
                /* si un entree vide rempli le tab $formsError */
            if(empty($_POST['login'])){$formsError[]= "login ne doit pas être vide";}
            if(empty($_POST['nom'])){$formsError[]= "nom ne doit pas être vide";}
            if(empty($_POST['prenom'])){$formsError[]= "prénom ne doit pas être vide";}
            if(empty($_POST['mdp'])){$formsError[]= "mot de passe ne doit pas être vide";}
                /* parcourir et afficher les erreurs */
            foreach($formsError as $error ){
               ?> <div class="alert alert-danger"><?= $error ?></div> <?php
            }
            
            /* si y a pas errors on pass a la requete */
            if (empty($formsError)){
            $login = $_POST['login'];
                /* test si le login existe pas deja */
                    /*start testLogin*/
                    $row=checkvaleur('users','login',$login);
                    //si row > 0 alors login existe, on aura msg error |sinon ,on l'ajout
                if ($row>0){
                    $msg="<div class='alert alert-danger'> login existe déjà</div>"; 
                    redirect($msg,$url="members.php?do=Add","previous page");
                    /*end testLogin */
                }else{
                    /*on recuper tt les valeurs d'entrees puis fait le requete pour ajouter */
            $nom = $_POST['nom'];
            $prenom = $_POST['prenom'];
            $pass = password_hash($_POST['mdp'], PASSWORD_DEFAULT);
            $role = $_POST['role'];
            $actif = $_POST['actif'];
            if($actif == 0){
            $sql="INSERT INTO users (nom,prenom,login,mdp,role,actif) VALUES (?,?,?,?,?,0)";}
            else{$sql="INSERT INTO users (nom,prenom,login,mdp,role,actif) VALUES (?,?,?,?,?,1)";}
            $res=$db->prepare($sql);
            $res->execute(array($nom,$prenom,$login,$pass,$role));
            $count=$res->rowCount();
            if($count>0){
                $msg="<div class='alert alert-success'> l'ajout effectué</div>";
                 redirect($msg,$url="members.php");
            }else{
                $msg= "<div class='alert alert-danger'> l'ajout n'est pas effectué</div>";
                redirect($msg,$url="members.php");
            }
            } //acolad de else de testLogin
            } //acolad de testEmptyEerror
        } //acolad de server_method_post
        else {
            $msg="<div class='alert alert-danger'>vous ne pouves pas entrer directement dans cette page</div>";
            redirect($msg);
              }
    }
    /****** End Add *******/
    
    /****** Start Edit *******/
    
    /* modifier mdp/actif  user/moi "just form" */
    elseif($do == 'Edit')
    {
        /* testExistId */
        if(isset($_GET['uid']) &&is_numeric($_GET['uid']))
        {
            $Uid=$_GET['uid'];
           $row= checkvaleur('users','uid',$Uid);
            if($row == 0){ $msg="<div class='alert alert-danger'> Utilisateur id  non connu</div>"; 
                    redirect($msg,$url="members.php?do=Edit","previous page");  }
            else
            {
             include("Edit-form.php");
            } 
        }else { //else de testExistId
            $msg="<div class='alert alert-danger'>Utilisateur id non trouvé</div>";
                       redirect($msg);
        }
    }
    /* fait le requet pour modifier */
    elseif($do == 'Update'){
        echo "<h1 class='text-center'>mis à jour de mot de passe et actif</h1>";
            if($_SERVER['REQUEST_METHOD']=='POST')
            {
                    if (empty($_POST['password'])){
                        $newpass=$_POST['oldpassword'];
                    }else {
                        $newpass=password_hash($_POST['password'], PASSWORD_DEFAULT);
                          }
                
                        $actif=$_POST['actif-choix'];
                        $id=$_POST['uid'];
                    if ($actif == 'Non'){//change pas le valeur a 0
                        $sql="UPDATE users SET mdp=? WHERE uid=$id";
                    }elseif($actif == '0') { 
                             $sql="UPDATE users SET mdp=?, actif=0 WHERE uid=$id";
                          }
                    else{
                        $sql="UPDATE users SET mdp=?, actif=1 WHERE uid=$id";
                    }
                        $res = $db-> prepare ($sql);
                        $res->execute(array ($newpass));
                        $count=$res->rowCount();
                        if($count >0){
                        echo "<div class='alert alert-success'> modification effectuée</div>";
                        }else{
                            echo "<div class='alert alert-danger'> modification n'est pas effectuée</div>";
                        }
                        
                    
                }else {
                $msg="<div class='alert alert-danger'>vous ne pouves pas entrer directement dans cette page</div>";
                redirect($msg);
                      }
            }
        /****** End Edit *******/
    
        /****** Start Delet *******/
    
        elseif($do == 'Delet'){   
            if( isset($_GET['uid'])&&is_numeric($_GET['uid']) )
       {
            $uid=$_GET['uid']; 
                $sql="DELETE FROM users WHERE uid=?";
                $res = $db-> prepare ($sql);
                $res->execute(array($uid));
                if(!$res){
                    $msg = "<div class='alert alert-danger'>Erreur</div>";
                        redirect($msg,$url='members.php');
                        }
                else{
                $msg= "<div class='alert alert-success'> suppresion effectuée</div>";
                redirect($msg,$url='members.php');
                }            }else {
                echo $msg="<div class='alert alert-danger'>Utilisateur id non trouvé</div>";
                redirect($msg,$url="members.php");
              }
        }
    /****** End Delet *******/
    

    include $thm . 'footer.php';
    }//fin edit
      else {
   header('location: index.php');
      }
?>