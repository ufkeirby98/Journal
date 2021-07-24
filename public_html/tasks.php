<?php
    require 'isauth.php';
    require 'headerFunctions.php';
    require ('date.php');
    
    if (!isAuth()){
        header('Location: index.php');
    }
    session_start();
    
    if(!isset($_SESSION['openedTab_id'])){
        mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
        $conn = mysqli_connect("localhost", "ufkeirby98_list", "5ylDp*wb", "ufkeirby98_list");
        
        $user_id      = $_COOKIE['id'];
        
        $res = mysqli_query($conn, "SELECT * FROM tabs WHERE user_id = $user_id LIMIT 1");
        if ($row = mysqli_fetch_assoc($res)){
            $_SESSION['openedTab_id'] = $row['tab_id'];
            $_SESSION['openedTab_name'] = $row['tab_name'];
        }
    }
    
    if(isset($_POST['tab']) ){
        $_SESSION['openedTab_id'] = $_POST['tab'];
        
        mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
        $conn = mysqli_connect("localhost", "ufkeirby98_list", "5ylDp*wb", "ufkeirby98_list");
        
        $user_id = $_COOKIE['id'];
        $tab_id  = $_POST['tab'];
        $res = mysqli_query($conn, "SELECT tab_name FROM tabs WHERE user_id = $user_id AND tab_id = $tab_id LIMIT 1");
        if ($row = mysqli_fetch_assoc($res)){
            $_SESSION['openedTab_name'] = $row['tab_name'];
        }
    }
    
    if(isset($_POST['submitNewTab']) ){
        mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
        $conn = mysqli_connect("localhost", "ufkeirby98_list", "5ylDp*wb", "ufkeirby98_list");
        
        $tabName = $_POST['tabName'];
        $user_id = $_COOKIE['id'];
        mysqli_query($conn, "INSERT INTO tabs SET tab_name='".$tabName."', user_id='".$user_id."' ");
        
        $res = mysqli_query($conn, "SELECT tab_id FROM tabs WHERE tab_name='$tabName'");
        if ($row = mysqli_fetch_assoc($res)){
            $_SESSION['openedTab_name'] = $tabName;
        }
        
        $_SESSION['openedTab_id'] = $row['tab_id'];
    }
    
    if(isset($_POST['deleteTab'])){
        mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
        $conn = mysqli_connect("localhost", "ufkeirby98_list", "5ylDp*wb", "ufkeirby98_list");
        
        $tab_id = $_POST['deleteTab'];
        $user_id = $_COOKIE['id'];
        
        mysqli_query($conn, "DELETE FROM tabs WHERE tab_id = '$tab_id'");
        
        $res = mysqli_query($conn, "SELECT tab_name FROM tabs WHERE user_id = $user_id LIMIT 1");
        if ($row = mysqli_fetch_assoc($res)){
            $_SESSION['openedTab_name'] = $row['tab_name'];
        }
        else{
            unset($_SESSION['openedTab_name']);
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
        .navbar-toggler:focus{
            box-shadow: 0 0 0 0;
        }
        .mybtn{
            padding: 0;
              border: none;
              font: inherit;
              color: inherit;
              background-color: transparent;
              /* отображаем курсор в виде руки при наведении; некоторые
              считают, что необходимо оставлять стрелочный вид для кнопок */
              cursor: pointer;
        }
        .x{
            width: 23px;
            height: 15px;
            color:white;
            border-radius: 3px;
            opacity:0.3;
            margin-bottom:1.4em;
            padding:0px;
            margin-left:0em;
        }
        .x:hover{
            background: red;
            opacity:0.6;
        }
    </style>
    <title>Задачи</title>
</head>
<body>
    <?php showUserHeader(true); ?>
    
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
            <div class="card-body">
                
                    <nav class="navbar navbar-expand-lg navbar-light bg-light">
                      <div class="container-fluid">
                        
                        <a class="navbar-brand">
                            <?php 
                                if (isMobile() && isset($_SESSION['openedTab_name'])){
                                    echo $_SESSION['openedTab_name'];
                                } else {
                                    echo 'Категории';
                                }
                            ?>
                            
                        </a>
                        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                          <span class="navbar-toggler-icon"></span>
                        </button>
                        <div class="collapse navbar-collapse" id="navbarSupportedContent">
                               
                          <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                              
                            <?php
                                if (!isMobile()){
                                    ?>
                                    <form action="" method="POST" class="d-flex">
                                    <?php
                                }
                                else{
                                    ?>
                                    <form action="" method="POST" class="d-block">
                                    <?php
                                    
                                }
                            ?>
                            
                                <?php
                                    mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
                                    $conn = mysqli_connect("localhost", "ufkeirby98_list", "5ylDp*wb", "ufkeirby98_list");
                            
                                    $user_id      = $_COOKIE['id'];
                                    
                                    $res = mysqli_query($conn, "SELECT * FROM tabs WHERE user_id = '$user_id'");
                                    while($row = mysqli_fetch_assoc($res)){
                                        
                                        if (isMobile() ){
                                            ?>
                                            <li class="nav-item d-flex">
                                              <button style="padding-left:0; text-align:left; margin: 1em 0em; font-size:120%; width:90%;" class="mybtn text-secondary" name="tab" value="<?php echo $row['tab_id']; ?>"><?php echo $row['tab_name']; ?>
                                              </button>
                                                      <button class="btn btn-danger" value="<?php echo $row['tab_id'];?>" name="deleteTab" style="height:2.44em; margin-top:1em; width:3.7em;">
                                                        <svg style="" xmlns="http://www.w3.org/2000/svg" width="17" height="17" fill="currentColor" class="bi bi-x-lg" viewBox="0 0 16 16">
                                                            <path d="M1.293 1.293a1 1 0 0 1 1.414 0L8 6.586l5.293-5.293a1 1 0 1 1 1.414 1.414L9.414 8l5.293 5.293a1 1 0 0 1-1.414 1.414L8 9.414l-5.293 5.293a1 1 0 0 1-1.414-1.414L6.586 8 1.293 2.707a1 1 0 0 1 0-1.414z"/>
                                                        </svg>
                                                      </button>
                                            </li>
                                            <?php
                                        }
                                        else{
                                            ?>
                                            <li class="nav-item d-flex">
                                              <button style="padding-left:0; text-align:left; margin: 0em 0em; font-size:120%; width:90%;" class="mybtn" name="tab" value="<?php echo $row['tab_id']; ?>"><?php echo $row['tab_name']; ?>
                                              </button>
                                                      <button class="x  me-4" value="<?php echo $row['tab_id'];?>" name="deleteTab">
                                                            
                                                      </button>
                                            </li>
                                            <?php
                                        }
                                    }
                                    
                                    
                                    
                                ?>
                                
                            </form>
                          </ul>
                                    <form class="d-flex" method="POST">
                                        <input class="form-control me-2" type="text" placeholder="Новая категория" name="tabName" autocomplete="off">
                                        <button class="btn btn-outline-primary" type="submit" name="submitNewTab">Добавить</button>
                                    </form>
                          
                          
                        </div>
                      </div>
                    </nav>
             
            </div>
        </div>
            </div>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-gtEjrD/SeCtmISkJkNUaaKMoLD0//ElJ19smozuHV6z3Iehds+3Ulb9Bn9Plx0x4" crossorigin="anonymous"></script>
</body>
</html>