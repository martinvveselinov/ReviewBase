function back(){
    location.href="./index.php";
}
function submit(){
    var username = document.getElementById("name").value;
    var email = document.getElementById("mail").value;
    var fn = document.getElementById("fn").value;
    var password = document.getElementById("pass").value;
    var password2 = document.getElementById("pass2").value;
    var xhr = new XMLHttpRequest();
    xhr.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            if(this.responseText != ""){
                document.getElementsByClassName("error")[0].innerHTML = this.responseText;
            }
            else{
                location.href="./index.php";
            }
        }
    };
    xhr.open('GET', "./php/login/register.php?name="+username+"&mail="+email+"&fn="+fn+"&pass="+password+"&pass2="+password2, true);
    xhr.send();
}