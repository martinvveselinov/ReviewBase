<!DOCTYPE html>
<html>
    <head>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
        <title>Смяна на паролата</title>
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
                    <span class="span_title"><img src="../../img/logo.png" style="height: 10vw; width: 27vw;"></span>
                </div>
            </div>    
            <div class="row">
                <div class="col text-center">
                    <h2>Смяна на паролата</h2>
                </div>
            </div>
            <div class="row">
                <div class="col text-center">
                    <span id="result"></span>
                </div>
            </div>
            <div class="r-form justify-content-center">
                <form id="myform" method="post" onsubmit="return false;">
                    <div class="row">
                        <div class="col">
                            <label for="code" class="form-label">Вашият код:</label>
                            <input type="text" class="form-control" id="code" name="code">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">
                            <label for="newPass" class="form-label">Въведете новата си парола:</label> 
                            <input type="password" class="form-control" id="newPass" name="newPass">
                        </div>
                    </div>
                    <div class="row m-auto mt-3 text-center">
                        <div class="col">
                            <a class="btn w-50 btn-outline-success" onclick="check()">Смени паролата</a>
                            <a href="../../index.php" class="btn w-50 btn-outline-success">Назад</a>
                        </div>
                    </div>
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
                if(this.responseText.localCompare("Упешно сменихте паролата си! Ще бъдете пренасочени към входната страница след 3 секунди!") == 0){
                    setTimeout(function(){ 
                        location.href="../../index.php";
                    }, 3000);               
                }
                else{
                    alert(this.responseText);
                }
            }
            else{
                alert(this.readyState + "    SUSHTO TAKA    " + this.status + "  SUSHTO TAKA  " + this.responseText);
            }
        };
        xhttp.open("GET", "new_password.php?token="+code+"&newPass=" + newPass, true);
        xhttp.send();
        }
</script>
</html>