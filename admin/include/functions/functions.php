<?php
/***********
 test si le valeur existe ds un table
************/
echo "<div class='contaner'>";
function checkvaleur($table,$select,$valeur,$select2=null,$valeur2 = null){
    global $db;
    if (!isset($select2)){
     $sql="SELECT * FROM $table WHERE $select=? ";
                $res=$db->prepare($sql);
                $res->execute(array($valeur));
    }else {
         $sql="SELECT * FROM $table WHERE $select=? AND $select2=?";
                $res=$db->prepare($sql);
                $res->execute(array($valeur,$valeur2));
    }
                $row=$res->rowCount();
            return $row;

}
/*rediriger la page en cas d'erreur et de succes**/
function redirect($msg,$url = null,$where=null) {
    if ($url == null){
        $url="index.php";
    }
    if($where == null ){$where=""; }
    echo $msg;
    echo "<div class='alert alert-info'>redirection $where dans 4 sec</div>";
    header("refresh:4;url=$url");
    
}
function testuid($session,$idget)
{
    if ($session != $idget){
            return false;
    }  else return true;
}
echo "</div>";
?>
<script type="text/javascript">
    function submitForm(action)
    {
        document.getElementById('form1').action = action;
        document.getElementById('form1').submit();
    }
</script>
<?php
function send_mail($token,$mail){
     $to = $mail;
    $url="http://localhost/myfiles/Link%20to%20projet_web/listnote.php?token=".$token ;
    $subject = 'lien pour accedes à la list de notes';
    $message = 'Bonjour, veuillez trouvez ci-joint un lien pour acceder à la list de notes : ' .$url ;
    return $url;
    mail($to, $subject, $message);

    echo 'Email Sent.';
    
} 