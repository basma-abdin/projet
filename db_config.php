<?php
$hostname='localhost';
$username='root';
$password='maha1994';
$dbname='2017_projet6_stages';
$dsn = "mysql:host=$hostname;dbname=$dbname;charset=utf8";
 try{
        $db=new PDO($dsn,$username,$password);
      $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }catch(PDOException $e){
        echo "error SQL";
    }
?>