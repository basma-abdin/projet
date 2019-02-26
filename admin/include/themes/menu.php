


<div class="container-fluid">
  <div class="row content">
    <div class="col-sm-3 sidenav">
      <h4 class='text-center'>Menu options</h4>
      <ul class="nav nav-pills nav-stacked">
        <li class="active"><a href="logout.php"> <span class="glyphicon glyphicon-log-out"></span> Logout</a></li>
         <li><a href="go.php">Main page</a></li>
        <li><a href="members.php?do=Edit&uid=<?= $_SESSION['Uid'] ?>">Edit profile</a></li>
        <li><a href="date.php">Choix de l'année</a></li>
        <li><a href="members.php">Gestion des utilisateurs</a></li>
        <li><a href="stages.php">Gestion des stages</a></li>
          <li><a href="gestionTutP.php">Gestion des affectation des tuteurs pédagogiques</a></li>
        <li><a href="soutenances.php">Gestion des soutenance</a></li>
        <li><a href="gestionnaires.php"> Gestion des gestionnaires administratifs</a></li>

      </ul><br>
     
    </div>
      <div class="col-sm-9">
      

 