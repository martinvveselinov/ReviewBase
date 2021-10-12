<!DOCTYPE html>
<html>
    <head>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
        <title>Забравена парола</title>
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
                    <h2>Забравена парола</h2>
                </div>
            </div>
            <div class="row">
                <div class="col text-center">
                    <span id="result"></span>
                </div>
            </div>
            <div class="r-form justify-content-center">
                <form id="myform" method="post">
                    <div class="row">
                        <div class="col">
                            <label for="email" class="form-label">Въведете имейл адресът, с който сте регистрирани:</label>
                            <input type="email" class="form-control" id="email" name="email">
                        </div>
                    </div>
                </form>
            </div>
            <div class="row m-auto mt-3 text-center">
                <div class="col">
                    <button class="btn w-25 btn-outline-success" onclick="generate()">Изпрати код за нова парола</button>  
                    <a href="./reset_password.php" class="btn w-25 btn-outline-success">Вече имам код за нова парола</a>
                    <a href="../../index.php" class="btn w-25 btn-outline-success">Назад</a>
                </div>
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
            document.getElementById("result").innerHTML = this.responseText;
            if(this.responseText.localeCompare("Кодът е изпратен на адрес " + email) == 0){
                location.href="./reset_password.php";
            }
        }
      };
      xhttp.open("GET", "reset.php?email="+email, true);
      xhttp.send();
    }
</script>
</html>