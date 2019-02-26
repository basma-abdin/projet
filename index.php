<?php 
$page_title = "Main page";
include ("init.php");

?>


<div class="jumbotron">
  <div class="container text-center co">
    <h1>Université Paris Est De Créteil</h1>      
    <p>Bienvenue sur le site de gestion de stage de la faculté sciences et technologie</p>
  </div>
</div>
  <div id="dialogoverlay"></div>
<div id="dialogbox">
  <div>
    <div id="dialogboxhead"></div>
    <div id="dialogboxbody"></div>
    <div id="dialogboxfoot"></div>
  </div>
</div>
<div class="container-fluid bg-3 text-center">    
  <h3>Vous êtes ?</h3><br>
  <div class="row">
    <div class="col-sm-4">
         <div class="panel panel-default">
    <div class="panel-heading ">Etudiant</div>
              <div class="panel-body pb">
        <ul>
        <li><a id="a1" href="formulaire_form.php">Inscrire votre stage</a> </li>
        <li><a id="a1" href="etudiant.php?do=List">Liste de toutes les soutenances</a> </li>
        <li>Consulter Votre stage</li>
            </ul>
           <form class="form-horizontal" action="etudiant.php?do=Consulter" method="post">
              <div class="form-group md">
                  <label class="col-sm-6 control-label">Numero de dossier</label>
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
              <div class="panel-body pb">
          <a id="a1" href="admin/index.php" class="btn">Connectez à votre espace</a> 
                 <p>pour gerer la liste d'étudiants , de soutenances et de notes  </p>
          </div></div></div>
    <div class="col-sm-4"> 
      <div class="panel panel-default">
    <div class="panel-heading">Gestionnaire administratif</div>
              <div class="panel-body pb">
     <p>pour accéder à la liste de note : entrez par le lien que vous avez reçu de notre part par mail</p><br>
        <p>Si vous avez votre token vous pouvez entrer directement en le entrant</p>
        <form action="listnote.php?do=check" method="post">
                <div class="form-group md">
                  <label class="col-sm-6 control-label">Votre token</label>
            <div class="col-sm-12">
                <input type="text" name="token" class="form-control" required="required"/>
            </div>
              </div>
             <div class="form-group md">
            <div class="col-sm-12">
            <input type="submit" 
                value="Check" class="btn btn-primary"/>
            </div>    
        </div>  
                  
                  
                  </form>
          </div></div></div>
    
  </div>
</div><br>

<br><br>

<footer class="container-fluid text-center f">
  <p>Copyright &copy;</p>
</footer>
<?php
/*SELECT users.nom as tut1 , users.nom  as tut2 , date, salle 
FROM soutenances 
INNER Join users 
	on soutenances.tuteur1=users.uid 
INNER JOIN users tut2
	ON soutenances.tuteur2 = tut2.uid WHERE sid = 5*/
 include $thm . 'footer.php';
?>