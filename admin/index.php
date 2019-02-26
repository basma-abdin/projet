<?php 
session_start();
$noMenu='';
$page_title="Index";
if (isset($_SESSION['Username']) && isset($_SESSION['role']) && $_SESSION['role']=='admin'){
    header('location: go.php');
}elseif(isset($_SESSION['Username']) && isset($_SESSION['role']) && $_SESSION['role']=='user') {
     header('location: ../goTuteur.php');
}

include ("init.php");

require("../db_config.php");

    if(!isset($_POST['user'])||!isset($_POST['pass'])){
         include"login-form.php";
    }else
    {
    $username=$_POST['user'];
    $password=$_POST['pass'];
        if($username ==" "|| $password==" "){
            include"login-form.php";
        }else{
    //$hashedPass = sha1($password);
            /*verification */
            $loginexiste=checkvaleur('users','login',$username);
            if ($loginexiste == 0){echo "<div class='alert alert-danger'>Username dont existe !</div>";}
            else{
         $sql="SELECT mdp FROM users WHERE login=? "; 
        $res=$db->prepare($sql);
        $res->execute(array($username));
        $test=$res->fetch();
            $test=$test['mdp'];
            if (password_verify($password,$test)){
    //verifier si username existe 
   $sql="SELECT uid,login,mdp , role ,actif FROM users WHERE login=? AND mdp=? LIMIT 1";
        $res=$db->prepare($sql);
        $res->execute(array($username,$test));
        $row=$res->fetch();
        if(!$row){
            echo "username or password not found! retry";
            include"login-form.php";
        }else{
          $_SESSION['Username']=$username;
          $_SESSION['Uid']=$row['uid'];
          $_SESSION['role']=$row['role'];
         $_SESSION['actif']=$row['actif'];
            if ($row['role']=='admin'){
            header('location: go.php');
            exit();
            }elseif ($row['role']=='user'){
                 header('location: ../goTuteur.php');
                exit();
            }
        }}else {
              echo "<div class='alert alert-danger'> Mot de pass n'est pas correct!</div>";
                include"login-form.php";
            }} ///existe pas
}}
?>

<?php include $thm . 'footer.php';?>
