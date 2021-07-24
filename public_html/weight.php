<?php
    if (!isset($_SESSION)){
        session_start();
        
    }
    require ('isauth.php');
    require ('headerFunctions.php');
    require ('date.php');
    
    if (!isAuth()){
        header('Location: index.php');
    }
    
    if (isset($_POST['food_submit']) ) {
        
        mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
        $conn = mysqli_connect("localhost", "ufkeirby98_list", "5ylDp*wb", "ufkeirby98_list");
        $food_type    = $_POST['food_type'];
        $food_quality = $_POST['food_quality'];
        $food_calory  = $_POST['food_calory'];
        $food_time    = $_POST['food_time'];
        $user_id      = $_COOKIE['id'];
        
        $session_date = $_SESSION['date'];
        $mysql_date = date("Y-m-d", strtotime("$session_date") );
        
        mysqli_query($conn, "INSERT INTO food SET food_type='".$food_type."', food_quality='".$food_quality."', food_calory='".$food_calory."', food_time='".$food_time."', user_id='".$user_id."', date='".$mysql_date."' ");
    }
    
    
    function showFood(){
        mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
        $user_id = $_COOKIE['id'];
        
        $session_date = $_SESSION['date'];
        $mysql_date = date("Y-m-d", strtotime("$session_date") );
        
        $conn = mysqli_connect("localhost", "ufkeirby98_list", "5ylDp*wb", "ufkeirby98_list");
        $result = mysqli_query($conn, "SELECT * FROM food WHERE user_id = '$user_id' AND date ='$mysql_date' ORDER BY food_time");
        if ($row = mysqli_fetch_assoc($result) ) {
        ?>
        <div class="d-flex  mt-3 w-100">
            <form action="" method="POST" class="w-100">
                <table class="table w-100">
                     <thead>
                        <tr >
                          <th scope="col">Время</th>
                          <th scope="col" style="text-align:left;">Вид</th>
                          <th scope="col" style="">Вредно</th>
                          <th scope="col">Ккал</th>
                          <th scope="col"></th>
                        </tr>
                     </thead>
        
        <?php
        }
        $result = mysqli_query($conn, "SELECT * FROM food WHERE user_id = '$user_id' AND date ='$mysql_date' ORDER BY food_time");
        while($row = mysqli_fetch_assoc($result)) {
            ?>
                        <tr>
                            <td width="20%">
                                <div class="mt-1">
                                    <b class=> <?php echo $row['food_time']; ?></b>
                                </div>
                            </td>
                            
                            <td width="20%">
                                <div class="mt-1">
                                    <?php echo $row['food_type']; ?>
                                </div>
                            </td>
                            
                            <td width="20%" class="text-left">
                                <div class="mt-1">
                                <?php
                                if ($row['food_quality'] == 'да'){
                                    ?>
                                    <svg style="position:relative;left:1.2em;" xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-check-lg" viewBox="0 0 16 16">
                                      <path d="M13.485 1.431a1.473 1.473 0 0 1 2.104 2.062l-7.84 9.801a1.473 1.473 0 0 1-2.12.04L.431 8.138a1.473 1.473 0 0 1 2.084-2.083l4.111 4.112 6.82-8.69a.486.486 0 0 1 .04-.045z"/>
                                    </svg>
                                    <?php
                                }
                                else{
                                    ?>
                                    <svg style="position:relative;left:1.2em;" xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-x-lg" viewBox="0 0 16 16">
                                      <path d="M1.293 1.293a1 1 0 0 1 1.414 0L8 6.586l5.293-5.293a1 1 0 1 1 1.414 1.414L9.414 8l5.293 5.293a1 1 0 0 1-1.414 1.414L8 9.414l-5.293 5.293a1 1 0 0 1-1.414-1.414L6.586 8 1.293 2.707a1 1 0 0 1 0-1.414z"/>
                                    </svg>
                                    <?php
                                }
                                ?>
                                </div>
                            </td>
                            
                            <td width="20%" >
                                <div class="mt-1">
                                    <?php echo $row['food_calory']; ?>
                                </div>
                            </td>
                            
                            <td width="20%">
                                <div class="">
                                    <button style="width:2.3em;" type="submit" name="delete" value="<?php echo $row['food_id']?>" class="btn-sm btn-outline-danger" >x</button>
                                </div>
                            </td>
                        </tr>
            <?php
        }
        ?>
                </table>
            </form>
        </div>
        <?php
    }
    
    if (isset($_POST['delete'])){
        
        mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
        $conn = mysqli_connect("localhost", "ufkeirby98_list", "5ylDp*wb", "ufkeirby98_list");
        
        $delete_id = $_POST['delete'];
        
        mysqli_query($conn, "DELETE FROM food WHERE food_id = '$delete_id'");
        
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
        input[type="time"]:not(:valid):before {
          content:'Время:';
          margin-right:.6em;
          color:#9d9d9d;
        }
        
    </style>
    <title>Похудение</title>
    
</head>
<body>
    <?php 
        showUserHeader(true); 
    ?>
    
    <div class="container mt-md-5 mt-3">
        <div class="card">
            <?php 
                if (isMobile()){
                    echo '<div class="card-header d-flex justify-content-center">';
                }
                else{
                    echo '<div class="card-header d-flex">';
                }
            ?>
                
                <form action="" method="POST" class="d-flex ">
                    <button name="left" type="submit" class="btn btn-light">
                        <svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-caret-left-fill" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                          <path d="M3.86 8.753l5.482 4.796c.646.566 1.658.106 1.658-.753V3.204a1 1 0 0 0-1.659-.753l-5.48 4.796a1 1 0 0 0 0 1.506z"/>
                        </svg>
                    </button>
                    
                    <div class="display-6 align-self-end"><?php echo $_SESSION['date'];?></div>
                    
                    <button name="right" type="submit" class="btn btn-light">
                        <svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-caret-right-fill" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                            <path d="M12.14 8.753l-5.482 4.796c-.646.566-1.658.106-1.658-.753V3.204a1 1 0 0 1 1.659-.753l5.48 4.796a1 1 0 0 1 0 1.506z"/>
                        </svg>
                    </button>
                </form>
                
            </div>
            
            <div class="card-body table-responsive">
                <h5>Добавить прием пищи</h5>
                <form action="" method="POST" class="d-flex align-items-start">
                    
                    <div class="row g-2">
                        <div class="col-md">
                           
                            <select name="food_type" class="form-select">
                                <option value="Завтрак">Завтрак</option>
                                <option value="Обед">Обед</option>
                                <option value="Ужин">Ужин</option>
                                <option value="Перекус">Перекус</option>
                            </select>
                        </div>
                        <div class="col-md">
                            
                            <select name="food_quality" class="form-select" required>
                                <option value="" disabled selected>Вредное?</option>
                                <option value="нет">нет</option>
                                <option value="да">да</option>
                            </select>
                        </div>
                        <div class="col-md">
               
                            <input type="text" name="food_calory" placeholder = "Калорийность" class="form-control" autocomplete="off">
                        </div>
                        <div class="col-md">
                             
                             <input type="time" name="food_time" class="form-control" required>
                        </div>
                        <div class="col-md">
                            <input type="submit" name="food_submit" value="Добавить"class="btn btn-outline-primary">
                        </div>
                    </div>
                    
                    
                    
                   
                    
                    
                    
                    
                </form>
                <?php showFood();?>
                
                
            </div>
        </div>
    </div>
      
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-gtEjrD/SeCtmISkJkNUaaKMoLD0//ElJ19smozuHV6z3Iehds+3Ulb9Bn9Plx0x4" crossorigin="anonymous"></script>
</body>
</html>