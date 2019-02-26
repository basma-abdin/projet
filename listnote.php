<?php 
session_start();
$page_title="gestionnaire administratif page";
include ("init.php");
$do = isset($_GET['do'])? $_GET['do'] : 'Main';
if($do == 'check'){
    if (isset($_POST['token'])){
        $token=$_POST['token'];
    header('location: listnote.php?token='.$token); }
} 
elseif($do == 'Main'){
 if(isset($_GET['token']))
        {
            $token=$_GET['token'];
          $row= checkvaleur('gestionnaires','token',$token);
            if($row == 0){ 
                $msg="<div class='alert alert-danger'>le token n'est pas connu</div>"; 
                    redirect($msg,$url="index.php");  }
            else
            {
                $sql="SELECT gid FROM gestionnaires WHERE token = ?";
                $res = $db-> prepare ($sql);
                $res->execute(array($token));
                $row=$res->rowCount();
                if ($row == 0){
                    echo "<div class='alert alert-info'> ce token n'est pas valide</div>";
                }
                else header('location: listnote.php?do=affichage');
            }
 }else {
     $msg="<div class='alert alert-danger'> token non trouve</div>"; 
                    redirect($msg,$url="index.php");  
 }
}
elseif($do == 'affichage'){
   echo "<h1 class='text-center'>la liste de toutes les notes</h1>";
        $sql="SELECT stages.titre , soutenances.date, etudiants.nom , etudiants.prenom , note , commentaire  FROM `notes` 
join stages on notes.sid=stages.sid
JOIN soutenances on soutenances.sid=stages.sid
JOIN etudiants on stages.eid=etudiants.eid WHERE YEAR(date)= ? 
ORDER BY date";
    $date=date("Y");
        $res=$db->prepare($sql);
        $res->execute(array($date));
        $rows=$res->fetchALL(); 
        ?>
    <table class="mainTable text-center table table-bordered">
    <thead>
      <tr>
        <th>Nom Prenom (étudiant)</th>
        <th>Titre de stage</th>
        <th>Date de soutenances</th>
        <th>Note</th>
        <th>Commentaire</th>
      </tr>
    </thead>
        <?php
        foreach($rows as $row){
        ?>
    <tbody>
      <tr>
        <td><?= $row['nom']." ".$row['prenom'] ?></td>
        <td><?= $row['titre'] ?></td>  
        <td><?= $row['date'] ?></td>
        <td><?= $row['note'] ?></td>
        <td><?= $row['commentaire'] ?></td>
      </tr>
   <?php } ?>
    </tbody>
  </table>
<?php   
}
include $thm . 'footer.php';
   
?>