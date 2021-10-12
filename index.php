<?php
   session_start();
?>
<!DOCTYPE html>
<html>
    <head>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
        <title>Вход</title>
    </head>
    <style>
         .r-form{
            width: 50%;
            margin:auto;
            margin-top: 50px;
         }
    </style>
    <body>
        <div class="container">
            <div class="row mb-50">
                <div class="col text-center title">
                    <span class="span_title"><img src="./img/logo.png" style="height: 10vw; width: 27vw;"></span>
                </div>
            </div>
            <div class="row">
                <div class="col text-center">
                    <h2>Влезте в своя профил</h2>
                </div>
            </div>
            <div class="r-form justify-content-center">
                <form id="myform" method="post" action="./php/login/login.php">
                    <span class="error"></span>
                    <?php
                        if(isset($_SESSION['errorMessage'])){
                            echo "<span style='color:red;'>Грешно потребителско име или парола!</span><br>";
                            unset($_SESSION['errorMessage']);
                        }
                        else if(isset($_SESSION['blocked'])){
                            echo "<span style='color:red;'>Вашият акаунт е блокиран. Моля, свържете се с администратор!</span><br>";
                            unset($_SESSION['blocked']);
                        }
                        else if(isset($_SESSION['registered'])){
                            echo "<span style='color:green;'>Регистрацията беше успешна!</span><br>";
                            unset($_SESSION['registered']);
                        }
                    ?>
                    <div class="row">
                        <div class="col">
                            <label for="name" class="form-label">Потребителско име</label>
                            <input type="text" class="form-control" id="name" name="name">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">
                            <label for="pass" class="form-label">Парола</label>
                            <input type="password" class="form-control" id="pass" name="pass">
                        </div>
                    </div>
                </form>
            </div>
           
            <div class="row m-auto mt-3 text-center">
                <div class="col">
                    <button type="submit" class="btn w-25 btn-outline-success" onclick="document.getElementById('myform').submit()">Вход</button>  
                    <a href="./register.html" class="btn w-25 btn-outline-success">Регистрация</a>
                </div>
            </div>
            <div class="row m-auto mt-3 text-center">
                <div class="col">
                    <a href="./php/password_reset/get_code.php" class="btn w-50 btn-outline-success">Забравена парола</a>
                </div>
            </div>


        </div>    
    </body>
</html>