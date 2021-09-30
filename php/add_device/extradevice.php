<!DOCTYPE html>../..
<html>
    <head>
        <link href="../../css/lato100.css" rel="stylesheet" type="text/css">
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <link rel="stylesheet" href="../../css/main.css">
        <link rel="stylesheet" href="../../css/main_menu.css">
        <link rel="stylesheet" href="../../css/buttons.css">
        <link rel="stylesheet" href="../../css/table.css">
        <title>Ново устройство</title>
        <link rel="icon" type="image/png" sizes="32x32" href="./img/favicon.png">
		<!--<script src="./validate.js"></script>-->
    </head>
    <body>
        
        <div class="container">
            <div class="content">
                <div class="title"><center><div class="cssmenuitemwrapper"><span><img src="http://w14ref.w3c.fmi.uni-sofia.bg/img/logo.png" height="100"></span><span style="padding-left: 10px">ReviewBase</span></div></center></div>
                <div class="form_holder">
                    
<h3>Добавяне на ново устройство</h3>
<span id="result"></span>
<form id="myform" method="post">
    <a onclick="generate()" class="btn orange">Изпрати код за ново устройство</a>
    <a href="./reset_password.php" class="btn orange">Вече имам код за нова парола</a>
</form>
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
</div>
            </div>
        </div>
    </body>
</html>