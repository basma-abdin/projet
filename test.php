<!DOCTYPE html>
<html lang="en">
<head>
  <title>Bootstrap Example</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.0/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
  <style>
    /* Remove the navbar's default margin-bottom and rounded borders */ 
    .navbar {
      margin-bottom: 0;
      border-radius: 0;
    }
    
    /* Add a gray background color and some padding to the footer */
    footer {
      background-color: #f2f2f2;
      padding: 25px;
    }
  </style>
</head>
<body>

<nav class="navbar navbar-inverse">
  <div class="container-fluid">
    <div class="navbar-header">
      <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar">
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>                        
      </button>
      <a class="navbar-brand" href="#">Portfolio</a>
    </div>
    <div class="collapse navbar-collapse" id="myNavbar">
      <ul class="nav navbar-nav">
        <li class="active"><a href="#">Home</a></li>
      </ul>
    </div>
  </div>
</nav>

<div class="jumbotron">
  <div class="container text-center">
    <h1>Université Paris Est De Créteil</h1>      
    <p>Bienvenu sur le site de gestion de stage de la faculté sciences et technologie</p>
  </div>
</div>
  
<div class="container-fluid bg-3 text-center">    
  <h3>Vous êtes ?</h3><br>
  <div class="row">
    <div class="col-sm-4">
         <div class="panel panel-default">
    <div class="panel-heading">Etudiant</div>
              <div class="panel-body">
        <ul>
        <li><a href="etudiant.php?do=Inscrire">Inscrire votre stage</a> </li>
        <li>Consulter Votre stage</li>
            </ul>
           <form class="form-horizontal" action="etudiant.php?do=Consulter" method="post">
              <div class="form-group md">
                  <label class="col-sm-6 control-label">Numero de stage</label>
            <div class="col-sm-4">
                <input type="text" name="numero" class="form-control" required="required"/>
            </div>
              </div>
             <div class="form-group md">
            <div class="col-sm-12">
            <input type="submit" 
                value="Consulter" class="btn btn-primary"/>
            </div>    
        </div>
              </form>
             </div>
        </div>
      </div>
    <div class="col-sm-4"> 
      <div class="panel panel-default">
    <div class="panel-heading">Professionel</div>
              <div class="panel-body">
          <a href="admin/index.php" class="btn">Connectez à votre espace</a> 
                 <p>pour gerer </p>
          </div></div></div>
    <div class="col-sm-4"> 
      <div class="panel panel-default">
    <div class="panel-heading">Gestionnaire administratif</div>
              <div class="panel-body">
     <img src="https://placehold.it/150x80?text=IMAGE" class="img-responsive" style="width:100%" alt="Image">
          </div></div></div>
    
  </div>
</div><br>

<br><br>

<footer class="container-fluid text-center">
  <p>Footer Text</p>
</footer>

</body>
</html>
/* dans le formulaire*/
elseif($do == 'findname'){
    echo "<h3>Veuillez entrer votre nom et prenom :</h3>";
    ?>
<div class="container">
    <form class="form-horizontal" action="etudiant.php?do=findname" method="post">
        <input type="hidden" name="token" id="token" value="<?= $token ?>"/>
       <!-- start Nom -->
        <div class="form-group form-group-lg">
            <label class="col-sm-2 control-label">Nom</label>
            <div class="col-sm-10 col-md-6">
                <input type="text" name="nom" class="form-control" required="required"/>
            </div>
        </div>
    <!-- End Nom -->
    <!-- start prenom -->
        <div class="form-group form-group-lg">
            <label class="col-sm-2 control-label">Prenom</label>
            <div class="col-sm-10 col-md-6">
                <input type="text" name="prenom" class="form-control" required="required"/>
            </div>
        </div>
    <!-- End prenom -->
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
elseif ( $do == 'stage' ){
  ?>
<div class="container">
    <form class="form-horizontal" action="etudiant.php?do=Confirmstage" method="post">
        <input type="hidden" name="token" id="token" value="<?= $token ?>"/>
 <h4>Information concernant le stage : </h4>
          <!-- start titre -->
        <div class="form-group form-group-lg">
            <label class="col-sm-2 control-label">Titre</label>
            <div class="col-sm-10 col-md-6">
                <input type="text" name="titre" class="form-control" required="required"/>
            </div>
        </div>
    <!-- End titre -->
          <!-- start descreption -->
        <div class="form-group form-group-lg">
            <label class="col-sm-2 control-label">Description</label>
            <div class="col-sm-10 col-md-6">
                <input type="text" name="description" class="form-control" required="required"/>
            </div>
        </div>
    <!-- End descreption -->
           <!-- start tuteurE -->
        <div class="form-group form-group-lg">
            <label class="col-sm-2 control-label">TuteurE</label>
            <div class="col-sm-10 col-md-6">
                <input type="text" name="tuteurE" class="form-control" required="required"/>
            </div>
        </div>
    <!-- End tuteurE -->
      <!-- start emailTE -->
        <div class="form-group form-group-lg">
            <label class="col-sm-2 control-label">Email TuteurE</label>
            <div class="col-sm-10 col-md-6">
                <input type="email" name="emailTE" class="form-control" required="required"/>
            </div>
        </div>
    <!-- End emailTE -->
    <!-- start dateDebut -->
        <div class="form-group form-group-lg">
            <label class="col-sm-2 control-label">Date Debut</label>
            <div class="col-sm-10 col-md-6">
                <input type="date" name="dateDebut" class="form-control" required="required"/>
            </div>
        </div>
    <!-- End dateDebut -->
         <!-- start dateFin -->
        <div class="form-group form-group-lg">
            <label class="col-sm-2 control-label">Date Fin</label>
            <div class="col-sm-10 col-md-6">
                <input type="date" name="dateFin" class="form-control" required="required"/>
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
/*****/
/**dans etudiant*****/
               elseif ($do == 'findname'){
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
          if(empty($formsError)){  
            $existe=checkvaleur('etudiants','nom',$_POST['nom'],'prenom',$_POST['prenom']);
           if ($existe == 0 ){
               echo "<div class='alert alert-danger'>vous n'êtes pas déjà inscrit</div>";
               echo "<div class='alert alert-info'>pour inscrir <a id='a1' href='formulaire_form.php'>Remplir le faormulaire</a></div>";
           }
    else {
        header('location: formulaire_form.php?do=stage');
    }}
        
        }}} else {
         $msg="<div class='alert alert-danger'>vous ne pouves pas entrer directement dans cette page</div>";
            redirect($msg);
    }
}
elseif($do == 'Confirmstage'){
    if(isset($_SESSION['token']) && isset($_POST['token'])&& ($_SERVER['REQUEST_METHOD'] == 'POST') && isset($_SESSION['token_time'])  ){
           if($_SESSION['token'] == $_POST['token'])
        {
               $timestamp_ancien = time() - (15*60);
        //Si le jeton n'est pas expiré
        if($_SESSION['token_time'] >= $timestamp_ancien)
        {
            $formsError=array();
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
            <tr><td>Titre</td> <td><?= $_POST['titre'] ?></td></tr>
           <tr><td>description</td> <td><?= $_POST['description'] ?></td></tr>
           <tr><td>TuteurE</td> <td><?= $_POST['tuteurE'] ?></td></tr>
           <tr><td>Email tuteurE</td> <td><?= $_POST['emailTE'] ?></td></tr>
           <tr><td>DateDebut</td> <td><?= $_POST['dateDebut'] ?></td></tr>
            <tr><td>DateFin</td> <td><?= $_POST['dateFin'] ?></td></tr>
        
    </table>
    <!--hidden form pour recupere les valeurs -->
    <form id="form1" name="form1" method="post" onsubmit="" onreset="" action="programname.php">
    <input type="hidden" name="titre" value="<?= $_POST['titre'] ?>"/>
    <input type="hidden" name="description" value="<?= $_POST['description'] ?>"/>
    <input type="hidden" name="tuteurE" value="<?= $_POST['tuteurE'] ?>"/>
    <input type="hidden" name="emailTE" value="<?= $_POST['emailTE'] ?>"/>
    <input type="hidden" name="dateDebut" value="<?= $_POST['dateDebut'] ?>"/>
    <input type="hidden" name="dateFin" value="<?= $_POST['dateFin'] ?>"/>
        <div class="form-group">
            <div class="col-sm-10 col-md-6">
            <input type="button" onclick="submitForm('etudiant.php?do=Insertstage')"
                value="Oui" class="btn btn-success"/>
            </div>    
        </div>
        <div class="form-group">
            <div class="col-sm-10 col-md-6">
            <input type="button" onclick="submitForm('formulaire_form.php?do=Editstage')"
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
elseif($do == 'Insertstage'){
     if($_SERVER['REQUEST_METHOD'] == 'POST'){
    
}else {
            $msg="<div class='alert alert-danger'>vous ne pouves pas entrer directement dans cette page</div>";
            redirect($msg,$url="index.php");
              }  
    
}
               /**********************/
               /*appele a la fonc*/
    <li><a id="a1" onclick="Confirm.render('Vous êtes déjà inscrit ? ')">Inscrire votre stage</a> </li>