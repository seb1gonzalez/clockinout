<?php
session_start();
if(isset($_POST['password'])){
    if($_POST['password'] == 'g0m!ners'){
        $_SESSION['in'] = true;
        echo 1;
    }else{
        echo 0;
    }
}

if(isset($_GET['exit']) && $_GET['exit'] == true){
    session_destroy(); 
    header('Location: login.html');
}

if(isset($_POST['status'])){
    if(isset($_SESSION['in']) && $_SESSION['in'] == true){
        echo 1;
    }else{
        echo 0;
    }
}
?>