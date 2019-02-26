<?php
session_start();
$Menu='';
if(isset($_SESSION['Username']) && isset($_SESSION['role']) && $_SESSION['role']=='user' ){
    $page_title= "Tuteur Page" ;
   include ("init.php");
    ?>
<p>Bienvenue sur votre espace tuteur</p><br><p>Ici vouz pouvez :</p>
<ul>
<li>modifier votre mot-de-pass</li>
<li>Choisir l'année à consulter</li>
<li>Voir la liste d'étudiants dont vous êtes le tuteur pédagogique</li>
<li>Voir la liste des soutenances dont voue êtes le tuteur principal ou secondaire et ajouter la note une fois la soutenance est passée</li>
<li>Voir la liste de notes et la possibilité de la modifier</li>
<br><p> <span class="glyphicon glyphicon-thumbs-up"></span> Bon travail ! </p>

</ul>
<?php
    if(isset($_POST['year']))
    {
        $_SESSION['year']= $_POST['year'];
    }else $_SESSION['year']=date("Y");
    include $thm . 'footer.php';
}else {
   header('location: index.php');
    exit();
}