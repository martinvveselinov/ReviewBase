<!DOCTYPE html>
<html>
    <head>
        <link href="../../css/lato100.css" rel="stylesheet" type="text/css">
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <link rel="stylesheet" href="../../css/main.css">
        <link rel="stylesheet" href="../../css/main_menu.css">
        <link rel="stylesheet" href="../../css/buttons.css">
        <link rel="stylesheet" href="../../css/table.css">
        <title>Забравена парола</title>
        <link rel="icon" type="image/png" sizes="32x32" href="../../img/favicon.png">
		<!--<script src="./validate.js"></script>-->
    </head>
    <body>
        <div class="container">
            <div class="title">
                <div class="cssmenuitemwrapper">
                    <span class="span_title"><img src="../../img/logo.png" height="100"></span>
                    <!--<span class="span_title" style="padding-left: 10px">ReviewBase</span>-->
                </div>
            </div>
            <div class="form_holder"> 
                <h3>Забравена парола</h3>
                <span id="result"></span>
                <form id="myform" method="post">
                    <label for="email">Въведете имейл: 
                    <input type="email" id="email" name="email"></input>            
                    <a onclick="generate()" class="btn orange">Изпрати код за нова парола</a>
                    <a href="./reset_password.php" class="btn orange">Вече имам код за нова парола</a>
                    <a href="../../index.php" class="btn orange">Назад</a>
                </form>
            </div>
        </div>
    </body>
    <script>
    function generate(){
        var email = document.getElementById("email").value;
        var xhttp;
        xhttp = new XMLHttpRequest();
        xhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            document.getElementById("result").innerHTML = this.responseText ;
        }
      };
      xhttp.open("GET", "reset.php?email="+email, true);
      xhttp.send();
    }
</script>
</html>