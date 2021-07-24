<?php
    require 'isauth.php';
    require 'headerFunctions.php';
    



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
    <style>
        .form_radio_btn {
        	display: inline-block;
        	margin-right: 10px;
        }
        .form_radio_btn input[type=radio] {
        	display: none;
        }
        .form_radio_btn label {
        	display: inline-block;
        	cursor: pointer;
        	padding: 0px 10px;
        	line-height: 30px;
        	border: 1px solid #999;
        	border-radius: 6px;
        	user-select: none;
        }
         
        /* Checked */
        .form_radio_btn input[type=radio]:checked + label {
        	background: lightblue;
        }
         
        /* Hover */
        .form_radio_btn label:hover {
        	color: #666;
        }
    </style>
    <title>Главная</title>

</head>
<body>
    
    
    <?php 
        showGuestHeader(!isAuth()); 
        showUserHeader(isAuth()); 
    ?>
    <div class="container">
        
        
        <div class="card mt-2 border border-secondary mb-2">
            <div class="card-header">
                Что есть на сайте:
            </div>
            <div class="card-body">
                <h2 style="color:red"><?php echo $err.""; ?></h2>
                <h5>Раздел похудение</h5>
                <figure class="figure" style="margin-bottom:0">
                
                 <?php
                 
                     if (isMobile()){
                         ?>
                         
                         <img style="max-width: 75%;" src="img/preview1.jpg" class="figure-img img-fluid rounded" >
                         <figcaption class="figure-caption ">В этом разделе можно добавлять записи о времени приемов пищи.<br><span class="text-dark"><b>Войдите в аккаунт, чтобы воспользоваться.</b></span></figcaption>
                         </figure>
                         <?php
                     }
                     else{
                         ?>
                         <p>В этом разделе можно добавлять записи о времени приемов пищи. <br></p>
                         <a href="http://ufkeirby98.beget.tech/img/preview1.jpg">
                         <img style="max-width: 30%; margin-bottom:0;" src="img/preview1.jpg" class="figure-img img-fluid rounded border border-secondary">
                         </a>
                         </figure><br>
                         <div class="mt-3">
                              <i>Войдите в аккаунт, чтобы воспользоваться.</i>
                         </div>
                        
                         <?php
                     }
                 ?>
                
                
            </div>
        </div>
        
        
    </div>
    
      
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-gtEjrD/SeCtmISkJkNUaaKMoLD0//ElJ19smozuHV6z3Iehds+3Ulb9Bn9Plx0x4" crossorigin="anonymous"></script>
</body>
</html>