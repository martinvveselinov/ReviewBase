<?php
    session_start();
    include '../db/db_manipulation.php';
    $email = getAccEmail($_SESSION['uname']);
?>
<!DOCTYPE html>
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
    </head>
    <body >
        
        <div class="container">
            <div class="content">
                <div class="title"><div class="cssmenuitemwrapper"><span><img src="" height="100"></span><span style="padding-left: 10px">Puffin</span></div></div>
                <div class="form_holder">
                    
<h3>Добавяне на устройство</h3>
<h2>Вече сте влизали от поне 3 различни устройства, а текущото не е сред тях. За да получите достъп до акаунта си и от това устройстно, моля въведете кода, който ще получите на имейла си след натискане на бутона "Изпрати код".</h2>
<span id="result"></span>
<form id="myform" method="post">
   Въведете кода, който получихте в имейла: 
   <input type="text" id="code" name="code"></input>
      <a onclick="generate()" class="btn orange">Изпрати код</a>
   <a onclick="checkDevice()" class="btn orange">Добави устройство</a>
</form>
<script>
    function generate(){
        var email = "<?php echo $email ?>";
        alert(email);
        var xhttp = new XMLHttpRequest();
        xhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                alert(this.responseText);
                document.getElementById("result").innerHTML = "Получихте код на имейл адреса, с който сте се регистрирали! Моля, копирайте го и го поставете в полето долу.";
            }
        };
        xhttp.open("GET", "adddevice.php?email="+email, true);
        xhttp.send();
    }
</script>
<script>
    function checkDevice(){
        var code = document.getElementById("code").value;
        var xhttp;
        xhttp = new XMLHttpRequest();
        xhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                alert(this.responseText);
                document.getElementById("result").innerHTML = "Упешно добавихте новото устройство! Моля, влезте отново, когато бъдете пренасочени след 3 секунди!<br>";
                setTimeout(function(){ 
                    location.href="../../index.php";
                }, 3000); 
            }
        };
      xhttp.open("GET", "new_device.php?token="+code, true);
      xhttp.send();
    }
</script>
</div>
            </div>
        </div>
    </body>
</html>