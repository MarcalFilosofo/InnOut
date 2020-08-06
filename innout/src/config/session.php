<?php

function RequireValidSession(){
    $user = $_SESSION['user'];
    if(!isset($user)){
        header('Location: loginController.php');
        exit();
    }
}