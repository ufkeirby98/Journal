<?php
    function logOut(){
        setcookie("id", "", time() - 3600*24*30*12, "/");
        setcookie("hash", "", time() - 3600*24*30*12, "/");
        
        $_SESSION = array();

// сбросить куки, к которой привязана сессия
        if (ini_get("session.use_cookies")) {
            $params = session_get_cookie_params();
            setcookie(session_name(), '', time() - 42000,
                $params["path"], $params["domain"],
                $params["secure"], $params["httponly"]
            );
}

// уничтожить сессию
session_destroy();
    }
    
    logOut();
    header('Location: index.php');
?>