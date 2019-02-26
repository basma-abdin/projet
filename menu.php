<div class="container-fluid ">
  <div class="row content">
    <div class="col-sm-3 sidenav">
      <h4 class='text-center'>Menu options</h4>
      <ul class="nav nav-pills nav-stacked">
        <li class="active"><a href="logout.php"> <span class="glyphicon glyphicon-log-out"></span> Logout</a></li>
        <li><a href="date.php">Choix de l'année</a></li>
        <li><a href="tuteur.php?do=Edit&uid=<?= $_SESSION['Uid'] ?>">Changer mot-de-pass</a></li>
        <li><a href="tuteur.php?do=Etudiant&uid=<?= $_SESSION['Uid'] ?>">List d'étudiant</a></li>
        <li><a href="tuteur.php?do=Soutenance&uid=<?= $_SESSION['Uid'] ?>">List soutenance</a></li>
        <li><a href="note.php">List de notes</a></li>
      </ul><br>
     
    </div>
      <div class="col-sm-9">
      
