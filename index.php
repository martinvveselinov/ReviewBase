<?php
   session_start();
?>
<!DOCTYPE html>
<html>
    <head>
        <link href="./css/lato100.css" rel="stylesheet" type="text/css">
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <link rel="stylesheet" href="./css/main.css">
        <link rel="stylesheet" href="./css/main_menu.css">
        <link rel="stylesheet" href="./css/buttons.css">
        <link rel="stylesheet" href="./css/table.css">
        <title>ReviewBase</title>
        <link rel="icon" type="image/png" sizes="32x32" href="/img/favicon.png">
    </head>
    <body>
        <div class="container">           
            <div class="title">
                <span class="span_title"><img src="./img/logo.png" height="100"></span>
                <!-- <span class="span_title" style="padding-left: 10px">ReviewBase</span> -->
            </div>
            <div class="form_holder">
                <h3>Влезте в своя профил</h3>
                <form id="myform" method="post" action="./php/login/login.php">
                    <?php
                        if(isset($_SESSION['errorMessage'])){
                            echo "<center><span style='color:red;'>Грешно потребителско име или парола!</span></center><br>";
                            unset($_SESSION['errorMessage']);
                        }
                        else if(isset($_SESSION['blocked'])){
                            echo "<center><span style='color:red;'>Вашият акаунт е блокиран. Моля, свържете се с администратор!</span></center><br>";
                            unset($_SESSION['blocked']);
                        }
                        else if(isset($_SESSION['registered'])){
                            echo "<center><span style='color:green;'>Регистрацията беше успешна!</span></center><br>";
                            unset($_SESSION['registered']);
                        }
                    ?>
                    <label for="name">Потребителско име: 
                    <input type="text" name="name" value=''>
                    <label for="pass">Парола: 
                    <input type="password" name="pass">
                    <span class="error"></span>
                    <button type="submit" hidden></button>
                    <a href="#" class="btn green" name="but_submit" onclick="document.getElementById('myform').submit()">Вход</a>
                    <a href="./register.html" class="btn orange">Регистрация</a>
                    <a href="./php/password_reset/get_code.php" class="btn orange">Забравена парола</a>
                </form>
            </div>
        </div>
    </body>
</html>