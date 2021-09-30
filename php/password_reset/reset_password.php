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
        <link rel="icon" type="image/png" sizes="32x32" href="./img/favicon.png">
    </head>
    <body>
        <div class="container">
            <div class="title">
                <div class="cssmenuitemwrapper">
                    <span><img src="../../img/logo.png" height="100"></span>
                    <span style="padding-left: 10px">ReviewBase</span>
                </div>
            </div>
            <div class="form_holder">
                <h3>Забравена парола</h3>
                <span id="result"></span>
                <form id="myform" method="post">
                    <label for="code">Въведете кода, който получихте в имейла: 
                    <input type="text" id="code" name="code"></input>
                    <label for="newPass">Въведете новата си парола: 
                    <input type="password" id="newPass" name="newPass">
                    <a onclick="check()" class="btn orange">Смени паролата</a>
                </form>
            </div>
        </div>
    </body>
    <script>
        function check(){
            var code = document.getElementById("code").value;
            var newPass = document.getElementById("newPass").value;
            var xhttp;
            xhttp = new XMLHttpRequest();
            xhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                document.getElementById("result").innerHTML = this.responseText;
                if(this.responseText == "Упешно сменихте паролата си! Ще бъдете пренасочени към входната страница след 3 секунди!"){
                    setTimeout(function(){ 
                        location.href="../../index.php";
                    }, 3000);               
                }
            }
        };
        xhttp.open("GET", "new_password.php?token="+code+"&newPass=" + newPass, true);
        xhttp.send();
        }
</script>
</html>