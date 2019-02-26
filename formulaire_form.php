<?php
 session_start();
$token = uniqid(rand(), true);
$_SESSION['token'] = $token;
$_SESSION['token_time'] = time();
$page_title="etudiant page";
include ("init.php");
 $do = isset($_GET['do'])?$_GET['do']:'Remplir';
if ($do == 'Remplir'){
  echo "<h3>Veuillez remplir le formulaire pour inscrire :</h3>";
?>
<div class="container">
    <form class="form-horizontal" action="etudiant.php?do=Confirm" method="post">
        <h4>Information personnel : </h4>
        <input type="hidden" name="token" id="token" value="<?= $token ?>"/>
       <!-- start Nom -->
        <div class="form-group form-group-lg">
            <label class="col-sm-2 control-label">Nom</label>
            <div class="col-sm-10 col-md-6">
                <input type="text" name="nom" class="form-control" required="required" autocomplete="off"/>
            </div>
        </div>
    <!-- End Nom -->
    <!-- start prenom -->
        <div class="form-group form-group-lg">
            <label class="col-sm-2 control-label">Prenom</label>
            <div class="col-sm-10 col-md-6">
                <input type="text" name="prenom" class="form-control" required="required" autocomplete="off"/>
            </div>
        </div>
    <!-- End prenom -->
    <!-- start email -->
        <div class="form-group form-group-lg">
            <label class="col-sm-2 control-label">Email</label>
            <div class="col-sm-10 col-md-6">
                <input type="email" name="email" class="form-control" required="required" autocomplete="off"/>
            </div>
        </div>
    <!-- End email -->
         <!-- start tel -->
        <div class="form-group form-group-lg">
            <label class="col-sm-2 control-label">Telephone</label>
            <div class="col-sm-10 col-md-6">
                <input type="tel" name="tel" class="form-control" required="required" autocomplete="off"/>
            </div>
        </div>
    <!-- End tel -->
        <h4>Information concernant le stage : </h4>
          <!-- start titre -->
        <div class="form-group form-group-lg">
            <label class="col-sm-2 control-label">Titre</label>
            <div class="col-sm-10 col-md-6">
                <input type="text" name="titre" class="form-control" required="required" autocomplete="off"/>
            </div>
        </div>
    <!-- End titre -->
          <!-- start descreption -->
        <div class="form-group form-group-lg">
            <label class="col-sm-2 control-label">Description</label>
            <div class="col-sm-10 col-md-6">
                <input type="text" name="description" class="form-control" required="required" autocomplete="off"/>
            </div>
        </div>
    <!-- End descreption -->
           <!-- start tuteurE -->
        <div class="form-group form-group-lg">
            <label class="col-sm-2 control-label">TuteurE</label>
            <div class="col-sm-10 col-md-6">
                <input type="text" name="tuteurE" class="form-control" required="required" autocomplete="off"/>
            </div>
        </div>
    <!-- End tuteurE -->
      <!-- start emailTE -->
        <div class="form-group form-group-lg">
            <label class="col-sm-2 control-label">Email TuteurE</label>
            <div class="col-sm-10 col-md-6">
                <input type="email" name="emailTE" class="form-control" required="required" autocomplete="off"/>
            </div>
        </div>
    <!-- End emailTE -->
    <!-- start dateDebut -->
        <div class="form-group form-group-lg">
            <label class="col-sm-2 control-label">Date Debut</label>
            <div class="col-sm-10 col-md-6">
                <input type="date" name="dateDebut" class="form-control" required="required" autocomplete="off"/>
            </div>
        </div>
    <!-- End dateDebut -->
         <!-- start dateFin -->
        <div class="form-group form-group-lg">
            <label class="col-sm-2 control-label">Date Fin</label>
            <div class="col-sm-10 col-md-6">
                <input type="date" name="dateFin" class="form-control" required="required" autocomplete="off"/>
            </div>
        </div>
    <!-- End dateFin -->
    <!-- envoyer -->
          <div class="form-group md">
            <div class="col-sm-8">
            <input type="submit" 
                value="Envoyer" class="btn btn-primary"/>
            </div>    
        </div>

    </form>
</div>
<?php
}
elseif($do == 'Edit'){
    ?>
<div class="container">
    <form class="form-horizontal" action="etudiant.php?do=Confirm" method="post">
        <h4>Information personnel : </h4>
        <input type="hidden" name="token" id="token" value="<?= $token ?>"/>
       <!-- start Nom -->
        <div class="form-group form-group-lg">
            <label class="col-sm-2 control-label">Nom</label>
            <div class="col-sm-10 col-md-6">
                <input type="text" name="nom" value="<?= $_POST['nom'] ?>" class="form-control" required="required" autocomplete="off"/>
            </div>
        </div>
    <!-- End Nom -->
    <!-- start prenom -->
        <div class="form-group form-group-lg">
            <label class="col-sm-2 control-label">Prenom</label>
            <div class="col-sm-10 col-md-6">
                <input type="text" name="prenom" value="<?= $_POST['prenom'] ?>" class="form-control" required="required" autocomplete="off"/>
            </div>
        </div>
    <!-- End prenom -->
    <!-- start email -->
        <div class="form-group form-group-lg">
            <label class="col-sm-2 control-label">Email</label>
            <div class="col-sm-10 col-md-6">
                <input type="email" name="email" value="<?= $_POST['email'] ?>" class="form-control" required="required" autocomplete="off"/>
            </div>
        </div>
    <!-- End email -->
         <!-- start tel -->
        <div class="form-group form-group-lg">
            <label class="col-sm-2 control-label">Telephone</label>
            <div class="col-sm-10 col-md-6">
                <input type="tel" name="tel" value="<?= $_POST['tel'] ?>" class="form-control" required="required" autocomplete="off"/>
            </div>
        </div>
    <!-- End tel -->
        <h4>Information concernant le stage : </h4>
          <!-- start titre -->
        <div class="form-group form-group-lg">
            <label class="col-sm-2 control-label">Titre</label>
            <div class="col-sm-10 col-md-6">
                <input type="text" name="titre" value="<?= $_POST['titre'] ?>" class="form-control" required="required" autocomplete="off"/>
            </div>
        </div>
    <!-- End titre -->
          <!-- start descreption -->
        <div class="form-group form-group-lg">
            <label class="col-sm-2 control-label">Description</label>
            <div class="col-sm-10 col-md-6">
                <input type="text" name="description" value="<?= $_POST['description'] ?>" class="form-control" required="required" autocomplete="off"/>
            </div>
        </div>
    <!-- End descreption -->
           <!-- start tuteurE -->
        <div class="form-group form-group-lg">
            <label class="col-sm-2 control-label">TuteurE</label>
            <div class="col-sm-10 col-md-6">
                <input type="text" name="tuteurE" value="<?= $_POST['tuteurE'] ?>" class="form-control" required="required" autocomplete="off"/>
            </div>
        </div>
    <!-- End tuteurE -->
      <!-- start emailTE -->
        <div class="form-group form-group-lg">
            <label class="col-sm-2 control-label">Email TuteurE</label>
            <div class="col-sm-10 col-md-6">
                <input type="email" name="emailTE" value="<?= $_POST['emailTE'] ?>" class="form-control" required="required" autocomplete="off"/>
            </div>
        </div>
    <!-- End emailTE -->
    <!-- start dateDebut -->
        <div class="form-group form-group-lg">
            <label class="col-sm-2 control-label">Date Debut</label>
            <div class="col-sm-10 col-md-6">
                <input type="date" name="dateDebut" value="<?= $_POST['dateDebut'] ?>" class="form-control" required="required" autocomplete="off"/>
            </div>
        </div>
    <!-- End dateDebut -->
         <!-- start dateFin -->
        <div class="form-group form-group-lg">
            <label class="col-sm-2 control-label">Date Fin</label>
            <div class="col-sm-10 col-md-6">
                <input type="date" name="dateFin" value="<?= $_POST['dateFin'] ?>" class="form-control" required="required" autocomplete="off"/>
            </div>
        </div>
    <!-- End dateFin -->
    <!-- envoyer -->
          <div class="form-group md">
            <div class="col-sm-8">
            <input type="submit" 
                value="Envoyer" class="btn btn-primary"/>
            </div>    
        </div>

    </form>
</div>
<?php
}
 include $thm . 'footer.php';
?>