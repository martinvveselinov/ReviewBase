function submit(){
    var username = document.getElementById("name");
    var email = document.getElementById("mail");
    var fn = document.getElementById("fn");
    var password = document.getElementById("pass");
    var password2 = document.getElementById("pass2");
    var xhr = new XMLHttpRequest();
    xhr.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
           location.href="../index.php";
        }
    };
    xhr.open('GET', "../php/register.php?name="+username+"&mail="+email+"&fn="+fn+"&pass="+password+"&pass2="+password2, true);
    xhr.send();
}