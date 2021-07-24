<?php
    function isMobile() {
        return preg_match("/(android|avantgo|blackberry|bolt|boost|cricket|docomo|fone|hiptop|mini|mobi|palm|phone|pie|tablet|up\.browser|up\.link|webos|wos)/i", $_SERVER["HTTP_USER_AGENT"]);
    }
    function showGuestHeader($bool){
        if ($bool){
            if (!isMobile()){
            ?>
            
            <header>
                <nav class="navbar navbar-expand-lg navbar-dark" style="background-color: rgba(117,199,253, 0.8); border-bottom: 1px solid rgba(117,237,253,0.3)">
                    <div class="container-fluid">
                      <a class="navbar-brand" href="/"><b>Ежедневник</b></a>
                      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarColor03" aria-controls="navbarColor03" aria-expanded="false" aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon"></span>
                      </button>
                      <div class="collapse navbar-collapse" id="navbarColor03">
                        <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                          <li class="nav-item">
                            <a class="nav-link active" aria-current="page" href="register.php"><b>Регистрация</b></a>
                          </li>
                        </ul>
                        <form class="d-flex" method="POST">
                                          
        
                          <input class="form-control me-2" name="login" type="text" placeholder="Логин">
                          
                          <input class="form-control me-2" name="password" type="password" placeholder="Пароль">
                          
                          <input class="btn btn-primary" name="submit" type="submit" value="Войти">
        
                        </form>
                      </div>
                    </div>
                </nav>
            </header>
            <?php
            }
            else{
            ?>
            <header>
                <nav class="navbar navbar-expand-lg navbar-dark" style="background-color: rgba(117,199,253, 0.8); border-bottom: 1px solid rgba(117,237,253,0.3)">
                    <div class="container-fluid">
                      <a class="navbar-brand" href="/"><b>Ежедневник</b></a>
                      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarColor03" aria-controls="navbarColor03" aria-expanded="false" aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon"></span>
                      </button>
                      <div class="collapse navbar-collapse" id="navbarColor03">
                        <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                          <li class="nav-item">
                            <a class="nav-link active" aria-current="page" href="register.php"><b>Регистрация</b></a>
                          </li>
                          <li class="nav-item">
                            <a class="nav-link active" aria-current="page" href="login.php"><b>Вход</b></a>
                          </li>
                        </ul>

                      </div>
                    </div>
                </nav>
            </header>
            
            <?php    
            }
        }
        
    }
    
    function showRegisterHeader($bool){
        if ($bool){
        ?>
            <header>
                <nav class="navbar navbar-expand-lg navbar-dark" style="background-color: rgba(117,199,253, 0.8); border-bottom: 1px solid rgba(117,237,253,0.3)">
                    <div class="container-fluid">
                      <a class="navbar-brand" href="/"><b>Ежедневник</b></a>
                      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarColor03" aria-controls="navbarColor03" aria-expanded="false" aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon"></span>
                      </button>
                      <div class="collapse navbar-collapse" id="navbarColor03">
                        <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                          <li class="nav-item">
                            <a class="nav-link active" aria-current="page" href="register.php"><b>Регистрация</b></a>
                          </li>
                          <li class="nav-item">
                            <a class="nav-link active" aria-current="page" href="login.php"><b>Вход</b></a>
                          </li>
                        </ul>
                      </div>
                    </div>
                </nav>
            </header>
        <?php
        }
        
    }
    
    function showUserHeader($bool){
        if ($bool){
            session_start();
            ?>
            <header>
                <nav class="navbar navbar-expand-lg navbar-dark" style="background-color: rgba(117,199,253, 0.8); border-bottom: 1px solid rgba(117,237,253,0.3)">
                    <div class="container-fluid">
                      <a class="navbar-brand" href="/"><b>Привет, <?php echo $_SESSION['user_login'] ?></b></a>
                      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarColor03" aria-controls="navbarColor03" aria-expanded="false" aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon"></span>
                      </button>
                      <div class="collapse navbar-collapse" id="navbarColor03">
                        <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                          <li class="nav-item">
                            <a class="nav-link active" aria-current="page" href="weight.php"><b>Похудение</b></a>
                          </li>
                          <li class="nav-item">
                            <a class="nav-link active" aria-current="page" href="tasks.php"><b>Задачи</b></a>
                          </li>
                        </ul>
                          <a class="btn btn-primary px-3" href="logout.php">Выйти</a>
                      </div>
                    </div>
                </nav>
            </header>
            
            <?php
        }
        
    }



?>