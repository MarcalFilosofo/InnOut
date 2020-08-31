<?php

function RequireValidSession($requiresadmin = false){
    $user = $_SESSION['user'];
    if(!isset($user)){
        header('Location: loginController.php');
        exit();
    }elseif($requiresadmin && !$user->is_admin){
        addErrorMsg('Acesso negado.');
        header('Location: day_records.php');
        exit();
    }
}