<?php
$do = isset($_GET['do'])? $_GET['do'] : 'Manage';
if($do == 'Manage'){
    echo "manage";
}elseif ($do == 'Add'){
    echo "add";
}elseif ($do == 'Edit'){
    echo "edit";
}else{
    echo "rien";
}


?>