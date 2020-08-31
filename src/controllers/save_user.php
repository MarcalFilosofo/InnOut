<?php
session_start();
RequireValidSession(true);

$exception = null;
$userData = [];

if(count($_POST) === 0 && isset($_GET['update'])){
    $user = User::getOne(['id' => $_GET['update']]);
    $userData = $user->getValues();
    $userData['password'] = null;
}

if(count($_POST) > 0){
    try{
        $newUser = new User($_POST);
        if($newUser->id){
            $dbUser->update();
            addSuccessMsg('Usuário alterado com sucesso');
            header('Location: users.php');
            exit();
        }else{
            $newUser->insert();
            addSuccessMsg('Usuário cadastrado com sucesso');
        }
        $_POST = [];


    }catch(Exception $e){
        $exception = $e;
    } finally{
        $userData = $_POST;
    }
}

loadTemplateView(
    'save_user',[
    $userData +
    'exception' => $exception
]);