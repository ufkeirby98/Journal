<?php
    require 'isauth.php';
    require 'headerFunctions.php';
    
    if (isAuth()){
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

    mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
    $conn = mysqli_connect("localhost", "ufkeirby98_list", "5ylDp*wb", "ufkeirby98_list");
    
    if(isset($_POST['submit'])){
        $err = array();
        # проверям логин
        if(!preg_match("/^[a-zA-Z0-9]+$/", $_POST['login']))
        {
            $err[] = "Логин может состоять только из букв английского алфавита и цифр";
        }
        if(strlen($_POST['login']) < 3 or strlen($_POST['login']) > 30)
        {
            $err[] = "Логин должен быть не меньше 3-х символов и не больше 30";
        }
        if(strlen($_POST['password']) < 3 or strlen($_POST['password']) > 30)
        {
            $err[] = "Пароль должен быть не меньше 3-х символов и не больше 30";
        }
        # проверяем, не сущестует ли пользователя с таким именем
        $query = mysqli_query($conn, "SELECT user_id FROM users WHERE user_login='".mysqli_real_escape_string($conn, $_POST['login'])."'");
        $row = mysqli_fetch_array($query);
        if(!empty($row['user_id']))
        {
            $err[] = "Пользователь с таким логином уже существует в базе данных";
        }
        # Если нет ошибок, то добавляем в БД нового пользователя
        if(count($err) == 0)
        {
            $login = $_POST['login'];
            # Убираем лишние пробелы и делаем двойное шифрование
            $password = md5(md5($_POST['password']));
            mysqli_query($conn, "INSERT INTO users SET user_login='".$login."', user_password='".$password."'");
            
            
            $hash = md5(generateCode(10));
            $query2 = mysqli_query($conn, "SELECT user_id FROM users WHERE user_login='".$login."' LIMIT 1");
            $data = mysqli_fetch_assoc($query2);
            # Записываем в БД новый хеш авторизации и IP
            mysqli_query($conn, "UPDATE users SET user_hash='".$hash."' ".$insip." WHERE user_id='".$data['user_id']."'");
    
            # Ставим куки
            setcookie("id", $data['user_id'], time()+60*60*24*30);
            setcookie("hash", $hash, time()+60*60*24*30);
            
            header("Location: check.php");
    }
}

    function showErrors($err){
        if(count($err) > 0){
            echo "<b>При регистрации произошли следующие ошибки:</b><br>";
            foreach($err AS $error)
            {
                echo $error."<br>";
                }
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
    <title>Регистрация</title>

</head>
<body>
    <?php 
        showRegisterHeader(true); 
    ?>
    
    <div class="container mt-5">
        <div class="card">
            <div class="card-header display-5">
                Регистрация
            </div>
            <div class="card-body">
                <form action="" method="POST" class="my-3">
                
                    <label for="login" class="mb-3" >Логин</label> 
                    <input class="form-control" name="login" type="text">
                    
                    <label for="password" class="my-3" >Пароль</label>
                    <input class="form-control" name="password" type="text">
                    
                    <input class="btn btn-primary mt-4" name="submit" type="submit" value="Зарегистрироваться">
                    
                    <br>
                    <div class="mt-3">
                        <?php
                            showErrors($err);
                        ?>
                    </div>
                    
                </form>
            </div>
        </div>
    </div>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-gtEjrD/SeCtmISkJkNUaaKMoLD0//ElJ19smozuHV6z3Iehds+3Ulb9Bn9Plx0x4" crossorigin="anonymous"></script>
</body>
</html>