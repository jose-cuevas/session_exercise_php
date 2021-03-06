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

    // Validate if user is in our fake data base and redirect the user
    if (checkUser($email, $password)){
        $_SESSION['email'] = $email;   
        header("Location:../panel.php");
    }else{
        $_SESSION['loginError'] = "Wrong email or password";
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


//----------------------------------
//----------------------------------
// Check Session on Panel PHP
function checkSession(){
    session_start();    

    $urlFile = basename($_SERVER['REQUEST_URI']);    

    if ($urlFile === 'index.php'){
        if (isset($_SESSION['email'])){
            header('Location:../panel.php');
        } else if ($alert = checkLoginError()) return $alert;     
      
    }
    
    }

function checkLoginError(){    
        if (isset($_SESSION["loginError"])) {
            $errorText = $_SESSION["loginError"];
            unset($_SESSION["loginError"]);
            return ["type" => "danger", "text" => $errorText];
        } 
    }

    
//----------------------------------
//----------------------------------
// Close Session - Log Out
function destroySession(){

    // Start session to access the $_SESSION superglobal variable
    session_start();
        
    
    // Delete $_SESSION superglobal variable
    unset($_SESSION);

    // Delete Cookies
    destroySessionCookie();

    session_destroy();
    header("Location:../index.php");
}
function destroySessionCookie(){
    if (ini_get("session.use_cookies")) {
        $params = session_get_cookie_params();
        setcookie(
            session_name(),
            '',
            time() - 42000,
            $params["path"],
            $params["domain"],
            $params["secure"],
            $params["httponly"]
        );
    }
}

?>