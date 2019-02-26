<?php
session_start();
if(isset($_SESSION['Username'])){
    $page_title= "mainPage" ;
   include ("init.php");
    ?>
    <p>Bienvenue sur votre espace admin </p><br>
    <p>Ici vous pouvez</p>
    <ul>
        <li>Modifier votre profile</li>
        <li>Choisir l'année à consulter</li>
        <li>Gérer la liste d'utilisateurs (Ajouter , Modifier , Supprimer) un utilisateur</li>
        <li>Voir la liste des stages et possibilté de supprimer</li>
        <li>Gérer la liste des tuteurs pédagogiques (distribuer les tuteurs pour les stages , changer le tuteur d'un stage , supprimer le tuteur d'un stage)</li>
       <li>Gérer la liste des soutenances (Ajouter , Modifier , Supprimer) une soutanances</li>
        <li>Gérer la liste des gestionnaire adminstratifs (Ajouter ,  Supprimer) un gestionnaire et régénérer du token.</li>
        <br>
</ul>
<h3>les deux tableau de bord : </h3><br>
<?php
    if(isset($_POST['year']))
    {
        $_SESSION['year']= $_POST['year'];
    }else $_SESSION['year']=date("Y");
   /*tableau de bord */
    $year=$_SESSION['year'];
    $sql="SELECT tuteurP, users.nom , users.prenom, COUNT(eid ) as nb, users.nom FROM stages 
JOIN users on tuteurP=users.uid
WHERE  actif = 1 AND YEAR(dateDebut) = ? 
GROUP BY tuteurP";
    $res=$db->prepare($sql);
    $res->execute(array ($year));
    $rows=$res->fetchALL();
    ?>
    <div class="row">
        <div class="col-sm-6">
        <div class="table-responsive">          
  <table class="table tab-bord">
      <label>Nombre d'étudiants pour les tuteurs pédagogiques</label>
    <thead>
      <tr>
        <th>ID tuteurP</th>
        <th>Nom/Prenom tuteur</th>
        <th>Nb d'étudiant</th>
      </tr>
    </thead>
      <?php
        foreach($rows as $row){
        ?>
    <tbody>
      <tr>
        <td><?= $row['tuteurP'] ?></td> 
        <td><?= $row['nom']." ".$row['prenom'] ?></td>
        <td><?= $row['nb'] ?></td>  
      </tr>
            <?php } ?>
    </tbody>
  </table>
  </div>
        </div>

</div>
<br>
<?php
$sql="SELECT tuteur1 ,nom , prenom,  COUNT(sid ) as nb FROM soutenances 
JOIN users on soutenances.tuteur1=users.uid
WHERE  actif = 1 AND YEAR(date)= ?
GROUP BY tuteur1";
    $res=$db->prepare($sql);
    $res->execute(array ($year));
    $rows=$res->fetchALL();
    ?>
<div class="row">
        <div class="col-sm-6">
        <div class="table-responsive">          
  <table class="table tab-bord">
      <label>Nombre d'étudiants pour les tuteurs principales</label>
    <thead>
      <tr>
        <th>ID tuteur principal</th>
        <th>Nom/Prenom tuteur</th>
        <th>Nb d'étudiant</th>
      </tr>
    </thead>
      <?php
        foreach($rows as $row){
        ?>
    <tbody>
      <tr>
        <td><?= $row['tuteur1'] ?></td> 
        <td><?= $row['nom']." ".$row['prenom'] ?></td>
        <td><?= $row['nb'] ?></td>  
      </tr>
            <?php } ?>
    </tbody>
  </table>
  </div>
        </div>

    <?php
    $sql="SELECT tuteur2 ,nom , prenom,  COUNT(sid ) as nb FROM soutenances 
JOIN users on soutenances.tuteur2=users.uid
WHERE  actif = 1 AND YEAR(date)= ?
GROUP BY tuteur2";
    $res=$db->prepare($sql);
    $res->execute(array ($year));
    $rows=$res->fetchALL();
    ?>
<div class="row">
        <div class="col-sm-6">
        <div class="table-responsive">          
  <table class="table tab-bord">
      <label>Nombre d'étudiants pour les tuteurs secondaire</label>
    <thead>
      <tr>
        <th>ID tuteur secondaire</th>
        <th>Nom/Prenom tuteur</th>
        <th>Nb d'étudiant</th>
      </tr>
    </thead>
      <?php
        foreach($rows as $row){
        ?>
    <tbody>
      <tr>
        <td><?= $row['tuteur2'] ?></td> 
        <td><?= $row['nom']." ".$row['prenom'] ?></td>
        <td><?= $row['nb'] ?></td>  
      </tr>
            <?php } ?>
    </tbody>
  </table>
  </div>
        </div>
</div>  

    <?php
    include $thm . 'footer.php';
}else {
   header('location: index.php');
    exit();
}

//SELECT tuteur2 ,nom , prenom,  COUNT(sid ) as nb FROM soutenances 
//JOIN users on soutenances.tuteur2=users.uid
//WHERE  actif = 1 AND YEAR(date)= 2017
//GROUP BY tuteur2