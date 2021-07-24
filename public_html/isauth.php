<?php
    
    function isAuth(){
        mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
        $conn = mysqli_connect("localhost", "ufkeirby98_list", "5ylDp*wb", "ufkeirby98_list");
        
        if (isset($_COOKIE['id']) and isset($_COOKIE['hash']))
        
        {   
        
            $query = mysqli_query($conn, "SELECT *,INET_NTOA(user_ip) FROM users WHERE user_id = '".intval($_COOKIE['id'])."' LIMIT 1");
        
            $userdata = mysqli_fetch_assoc($query);
        
        
            if(($userdata['user_hash'] !== $_COOKIE['hash']) or ($userdata['user_id'] !== $_COOKIE['id']) or (($userdata['user_ip'] !== $_SERVER['REMOTE_ADDR'])  and ($userdata['user_ip'] !== "0")))
        
            {
        
                setcookie("id", "", time() - 3600*24*30*12, "/");
        
                setcookie("hash", "", time() - 3600*24*30*12, "/");
        
                return false;
        
            }
        
            else
        
            {
        
                return true;
        
            }
        
        }
        
        else
        {
            return false;
        }
                
    }


?>