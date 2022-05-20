<?php

//----------------------------------
//----------------------------------
// Validation of the user
function authUser(){

// Start session
    session_start();

// get $_POST variablesfrom the form
    $email = $_POST['email'];
    $password = $_POST['password'];
    //  ? print_r $email;

    // Validate if user is in our fake data base and redirect the user
    if (checkUser($email, $password)){
        $email = $_SESSION['email'];
        echo $email;
        echo strstr($email, "@", true);
        // header("Location:../panel.php");
    }else{
        $_SESSION['loginError'] = "Wrong email or password";
        // echo $_SESSION['loginError'];
        header("Location:../index.php");
    }
};


// Validate user in our fake data base and redirect
function checkUser($email, $password){
    
    // "Fake" Data Base
    $emailDb = "jose@gmail.com";
    $passwordDb = "123";

    // Encrypt the password (in a database passwords always encripted)
    $passwordEnc = password_hash($passwordDb, PASSWORD_DEFAULT);

    if ($email === $emailDb && password_verify($password, $passwordEnc)) return true;
    else return false;
};

?>