function generate(){    var email = "<?php echo $email ?>";    var xhttp = new XMLHttpRequest();    xhttp.onreadystatechange = function() {        if (this.readyState == 4 && this.status == 200) {            document.getElementById("result").innerHTML = "Получихте код на имейл адреса, с който сте се регистрирали! Моля, копирайте го и го поставете в полето долу.";        }    };    xhttp.open("GET", "adddevice.php?email="+email, true);    xhttp.send();}function checkDevice(){    var code = document.getElementById("code").value;    var xhttp;    xhttp = new XMLHttpRequest();    xhttp.onreadystatechange = function() {        if (this.readyState == 4 && this.status == 200) {        document.getElementById("result").innerHTML = "Упешно добавихте новото устройство! Моля, влезте отново, когато бъдете пренасочени след 3 секунди!<br>";        setTimeout(function(){             location.href="../../index.php";        }, 3000);         }    };    xhttp.open("GET", "new_device.php?token="+code, true);    xhttp.send();}