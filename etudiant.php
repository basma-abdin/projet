<?php 
session_start();
$page_title="etudiant page";
include ("init.php");
/* 1- cette page recoit les informations de l'eturiant et lui demande la confirmation puis elle stock les informations dans table stage/etudiant
2-l'etudiant peut consulter son dossier a partir de numero de stage 
3- affichage de la liste de toute les soutenances 
*/
    $do = isset($_GET['do'])?$_GET['do']:include("index.php");
  /*** Start Confirm ****/

/* ici on test si les donnes vient de la meme session qui a fait remplir la formulaire ? 
|si non message d'erreur | si oui on affishe tout les donnes recu et on demamde la confrmation  ? | si l'etudiant confirme (touche oui) envoyer les donnes a Insert | si non redamander de remlir la formulaire*/

    if($do == 'Confirm'){
        if(isset($_SESSION['token']) && isset($_POST['token'])&& ($_SERVER['REQUEST_METHOD'] == 'POST') && isset($_SESSION['token_time'])  ){
           if($_SESSION['token'] == $_POST['token'])
        {
               $timestamp_ancien = time() - (15*60);
        //Si le jeton n'est pas expiré
        if($_SESSION['token_time'] >= $timestamp_ancien)
        {
            $formsError=array();
        if(empty($_POST['nom'])){$formsError[]= "nom ne doit pas être vide";}
        if(empty($_POST['prenom'])){$formsError[]= "prénom ne doit pas être vide";}
        if(empty($_POST['email'])){$formsError[]= "email ne doit pas être vide";}
        if(empty($_POST['tel'])){$formsError[]= "telephone ne doit pas être vide";}
        if(empty($_POST['titre'])){$formsError[]= "titre ne doit pas être vide";}
        if(empty($_POST['description'])){$formsError[]= "description ne doit pas être vide";}
        if(empty($_POST['tuteurE'])){$formsError[]= "tuteurE ne doit pas être vide";}
        if(empty($_POST['emailTE'])){$formsError[]= "email tuteurE ne doit pas être vide";}
        if(empty($_POST['dateDebut'])){$formsError[]= "dateDebut ne doit pas être vide";}
        if(empty($_POST['dateFin'])){$formsError[]= "dateFin ne doit pas être vide";}
                /* parcourir et afficher les erreurs */
            foreach($formsError as $error ){
               ?> <div class="alert alert-danger"><?= $error ?></div> <?php
            }
        if(empty($formsError)){  
        //afficher pour confirmer
            ?>
            <h3>vous confirmez tout ces informations?</h3>
            <table class="table table-striped" >
            <td>Nom</td> <td><?= $_POST['nom'] ?></td>
            <tr><td>Prénom</td><td><?= $_POST['prenom'] ?></tr>
           <tr><td>Email</td> <td><?= $_POST['email'] ?></td></tr>
            <tr><td>Telephone</td> <td><?= $_POST['tel'] ?></td></tr>
           <tr><td>Titre</td> <td><?= $_POST['titre'] ?></td></tr>
           <tr><td>description</td> <td><?= $_POST['description'] ?></td></tr>
           <tr><td>TuteurE</td> <td><?= $_POST['tuteurE'] ?></td></tr>
           <tr><td>Email tuteurE</td> <td><?= $_POST['emailTE'] ?></td></tr>
           <tr><td>DateDebut</td> <td><?= $_POST['dateDebut'] ?></td></tr>
            <tr><td>DateFin</td> <td><?= $_POST['dateFin'] ?></td></tr>
        
    </table>
    <!--hidden form pour recupere les valeurs -->
    <form id="form1" name="form1" method="post" onsubmit="" onreset="" action="programname.php">
    <input type="hidden" name="nom" value="<?= $_POST['nom'] ?>"/>
    <input type="hidden" name="prenom" value="<?= $_POST['prenom'] ?>"/>
    <input type="hidden" name="email" value="<?= $_POST['email'] ?>"/>
    <input type="hidden" name="tel" value="<?= $_POST['tel'] ?>"/>
    <input type="hidden" name="titre" value="<?= $_POST['titre'] ?>"/>
    <input type="hidden" name="description" value="<?= $_POST['description'] ?>"/>
    <input type="hidden" name="tuteurE" value="<?= $_POST['tuteurE'] ?>"/>
    <input type="hidden" name="emailTE" value="<?= $_POST['emailTE'] ?>"/>
    <input type="hidden" name="dateDebut" value="<?= $_POST['dateDebut'] ?>"/>
    <input type="hidden" name="dateFin" value="<?= $_POST['dateFin'] ?>"/>
        <div class="form-group">
            <div class="col-sm-10 col-md-6">
            <input type="button" onclick="submitForm('etudiant.php?do=Insert')"
                value="Oui" class="btn btn-success"/>
            </div>    
        </div>
        <div class="form-group">
            <div class="col-sm-10 col-md-6">
            <input type="button" onclick="submitForm('formulaire_form.php?do=Edit')"
                value="Non" class="btn btn-danger"/>
            </div>    
        </div>
    </form>
     <!--FIN hidden form pour recupere les valeurs-->
 <?php }
        } }}
        else {
            $msg="<div class='alert alert-danger'>vous ne pouves pas entrer directement dans cette page</div>";
            redirect($msg);
              }
} 
/*** End Confirm ****/

/*** Start Insert ****/

/* ici apres la confirmation de l'etudiant  on fait la requete pour inserer les donnes */
        
elseif($do == 'Insert'){
      if($_SERVER['REQUEST_METHOD'] == 'POST'){
           /*verifier si l'etudiant deja inscrit*/
           $existe=checkvaleur('etudiants','nom',$_POST['nom'],'prenom',$_POST['prenom']);
           if ($existe != 0 ){
               echo "<div class='alert alert-danger'>vous êtes déjà inscrit</div>";
               echo "<div class='alert alert-info'>si vous voulez juste inscrir votre stage <a id='a1' href='formulaire_form.php?do=findname'>Inscire un stage</a></div>";
           }else{
            $sql="INSERT INTO etudiants (nom,prenom,email,tel) VALUES (?,?,?,?)";
            $res=$db->prepare($sql);
            $res->execute(array($_POST['nom'],$_POST['prenom'],$_POST['email'],$_POST['tel']));
            $rows1=$res->rowCount();
           if ($rows1==0){echo "<div class='alert alert-danger'>Erreur</div>"; }
           else{
            // trouver id de l'etudiant
            $sql="SELECT eid FROM `etudiants` WHERE nom =? AND prenom = ? AND email =?  ";
            $res=$db->prepare($sql);
            $res->execute(array($_POST['nom'],$_POST['prenom'],$_POST['email']));
            $rows2=$res->fetch();
               if(!$rows2){echo"<div class='alert alert-danger'>Erreur</div>";}
               else{
                   $eid= $rows2['eid'];
            $sql="INSERT INTO stages (eid ,titre,description,tuteurE,emailTE,dateDebut,dateFin ) VALUES (?,?,?,?,?,?,?)";
            $res=$db->prepare($sql);
            $res->execute(array($eid,$_POST['titre'],$_POST['description'],$_POST['tuteurE'],$_POST['emailTE'],$_POST['dateDebut'],$_POST['dateFin']));
            $rows3=$res->rowCount();
            if($rows3==0){echo"<div class='alert alert-danger'>Erreur</div>";}
            else {
                $sql="SELECT sid FROM stages WHERE eid=? ";
                $res=$db->prepare($sql);
                $res->execute(array($eid));
                $rows4=$res->fetch();
                if(!$rows4){echo"<div class='alert alert-danger'>Erreur</div>";}
                else{
                    $number=$rows4['sid'];
                echo"<div class='alert alert-success'>Votre stage est bien inscrit</div>";
                echo"<div class='alert alert-info'>le Numéro de votre dossier est : $number </div>";
                }

            }
}}}
      }else {
            $msg="<div class='alert alert-danger'>vous ne pouves pas entrer directement dans cette page</div>";
            redirect($msg,$url="index.php");
              }  
}
/*** End Insert ****/

/*** Start Consulter ****/

/* apres la verification de numero de dossier  , on cherche les informations concernant la soutenance & le tuteur pedagogique & la note pour ce  numero de dossier  */

 elseif($do == 'Consulter'){
     echo "<div class='container'>";
      echo "<br> <br>";
         if($_SERVER['REQUEST_METHOD'] == 'POST'){
            if (!isset($_POST['numero']) || !is_numeric($_POST['numero']) ){
                $msg="<div class='alert alert-danger'>le numéro de stage est demandé </div>";
            redirect($msg,$url="index.php");
            } 
             else {
                 $sid=$_POST['numero'];
                 $val=checkvaleur('stages','sid',$sid);
                 if ($val == 0){
                     $msg="<div class='alert alert-danger'>Cette stage n'est pas déjà inscrit</div>";
                    redirect($msg,$url="index.php");
                 }
                 else{
                $sql="SELECT tuteurP , users.nom , users.prenom FROM stages INNER JOIN users ON tuteurP = uid WHERE sid = ?";
                $res=$db->prepare($sql);
                $res->execute(array($sid));
                $rows1=$res->fetch();
                 if($rows1['tuteurP'] == NULL){
                      echo "<div class='rouge'>Votre tuteur pédagogique n'est pas encore distribué</div>";
                 }else{
                 ?>
                 <h3>Votre Tuteur Pédagogique</h3>
             <table class="text-center table table-striped" > 
                 <tbody>
                 <tr>
                 <td>Monsieur/Madame</td>
                <td><?= $rows1['nom']." ".$rows1['prenom'] ?></td>
                 </tr>
                </tbody>
            </table>
                 <?php }
                $sql="SELECT u.nom as tut1nom, u.prenom as tut1prenom , u2.nom as tut2nom , u2.prenom as tut2prenom , date, salle FROM soutenances 
                JOIN users as u on soutenances.tuteur1=u.uid
                JOIN users As u2 on soutenances.tuteur2=u2.uid
                WHERE sid = ?";
                $res=$db->prepare($sql);
                $res->execute(array($sid));
                $rows2=$res->fetchALL();
                 if (!$rows2){
                     echo"<div class='rouge'>Aucun information sur la soutenance pour l'instant </div>";
                 }
                 else {
                     foreach($rows2 as $row){
                 ?>
                    <h3>Informations concernant la soutenance</h3>
                <table class="text-center table table-striped" > 
                 <tbody>
                 <tr>
                 <td>Tuteur principal</td>
                <td><?= $row['tut1nom']." ".$row['tut1prenom'] ?></td>
                 </tr>
                 <tr>
                 <td>Tuteur secondaire</td>
                <td><?= $row['tut2nom']." ".$row['tut2prenom'] ?></td>
                 </tr>
                <tr>
                 <td>Date </td>
                <td><?= $row['date'] ?></td>
                 </tr>
                 <tr>
                 <td>Salle </td>
                <td><?= $row['salle'] ?></td>
                 </tr>
                </tbody>
            </table>
            <?php
                 }}
            $sql="SELECT note,commentaire FROM notes WHERE sid = ?";
            $res=$db->prepare($sql);
            $res->execute(array($sid));
            $rows3=$res->fetchALL();
            if (!$rows3){
                     echo"<div class='rouge'>Aucun information sur la note pour l'instant </div>";
                 }else {
                foreach($rows3 as $row){
                ?>
                <h3>Informations concernant la note</h3>
                <table class="text-center table table-striped" > 
                 <tbody>
                 <tr>
                 <td>la note</td>
                <td><?= $row['note'] ?></td>
                 </tr>
                 <tr>
                 <td>Tuteur secondaire</td>
                <td><?= $row['commentaire'] ?></td>
                 </tr>
            </tbody>
            </table>
<?php }
            }
                
             }   
             }
 }else {
            $msg="<div class='alert alert-danger'>vous ne pouves pas entrer directement dans cette page</div>";
            redirect($msg,$url="index.php");
              } 
     echo "</div>";
}
/*** End Consulter ****/
/*** Start list ****/
 elseif($do == 'List'){
     /*cette requete vas chercher les titres de stage & le nom d'etudiant de ce stage  & les tuteurs de soutenances avec date et salle de soutenances */
     $date=date("Y");
     $sql="
   SELECT stages.titre ,etudiants.nom as etudiant ,u.nom as tut1nom , u.prenom AS tut1prenom, u2.nom as  tut2nom , u2.prenom as tut2prenom , soutenances.date , salle
   FROM soutenances 
   JOIN stages on soutenances.sid=stages.sid
   JOIN etudiants on stages.eid= etudiants.eid
   JOIN users as u on soutenances.tuteur1=u.uid 
   JOIN users as u2 on soutenances.tuteur2=u2.uid WHERE YEAR(date)= ?
   ORDER BY etudiant";
    
    $res=$db->prepare($sql);
    $res->execute(array($date));
    $rows=$res->fetchALL();
     if (!$rows){
          echo"<div class='rouge'>Aucun soutenance est distribué </div>";
     }else{
    ?>
       <h3>Liste de soutenances</h3>
    <table class="mainTable text-center table table-bordered">
        <thead>
      <tr>
        <th>Titre de stage</th>
        <th>Nom d'etudiant</th>
        <th>Tuteur principal</th>
        <th>Tuteur secondaire</th>
        <th>Date</th>
        <th>Salle</th>
      </tr>
    </thead>
        <?php
        foreach($rows as $row){
        ?>
        <tbody>
            <tr>
                <td><?= $row['titre'] ?></td>
                <td><?= $row['etudiant'] ?></td>
                <td><?= $row['tut1nom']." ".$row['tut1prenom']?></td>
                <td><?= $row['tut2nom']." ".$row['tut2prenom']?></td>
                <td><?= $row['date'] ?></td>
                <td><?= $row['salle'] ?></td>
                 </tr>
            
     <?php } ?>
    </tbody>
  </table>
 <?php   
     }
 }
/*** End list ****/

 include $thm . 'footer.php';
   
?>