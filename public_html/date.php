<?php
    if (!isset($_SESSION)){
        session_start();
    }
    
    if (!isset($_SESSION['date'])){
        $_SESSION['date'] = date("d.m.Y");
    }
            
    if (isset($_POST['left'])){
        $day_before = date("d.m.Y", strtotime("-1 days", strtotime($_SESSION['date'])));
        $_SESSION['date'] = $day_before;
    }        
    
    if (isset($_POST['right'])){
        $day_after = date("d.m.Y", strtotime("+1 days", strtotime($_SESSION['date'])));
        $_SESSION['date'] = $day_after;
    }       

?>