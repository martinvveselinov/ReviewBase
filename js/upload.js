function upload(type){
    var location;
    if(type == 'ref'){
        location = './upload_Ref.php';
    }
    else if(type == 'inv'){
        location = './uploadInv.php';
    }
    else if(type == 'pres'){
        location = './upload_Pres.php';
    }
    var file = document.getElementById("file");
    var comment = document.getElementById("comment");
    var form = document.getElementById('myForm');
    var formData = new FormData(form);
    var xhr = new XMLHttpRequest();
    xhr.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
			document.getElementById("error").innerHTML = this.responseText;
			if(this.responseText.trim() === "Файлът беше качен успешно!"){
				setTimeout(function(){ 
					window.location.reload(true);
				}, 2000);
			}
		}	
    };
    xhr.open('POST', location, true);
    xhr.send(formData);
}
function grade(theme, ref, pres, inv){
    var xhr = new XMLHttpRequest();
    xhr.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
           document.getElementById("status").innerHTML = this.responseText;
        }
    };
    xhr.open('GET', "./setgrades.php?role=0&theme="+theme+"&ref="+ref+"&pres="+pres+"&inv="+inv, true);
    xhr.send();
}
function cleara(type){
    var xhr = new XMLHttpRequest();
    xhr.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
           document.getElementById("status").innerHTML = this.responseText;
           $("#log-container").load("../../admin/renders/"+type + ".php");
        }
    };
    xhr.open('GET', "../../admin/clear.php?type="+type, true);
    xhr.send();
}
function view(i, file){
    var x = document.getElementById(i);
    if (x.style.display === "none") {
        x.style.display = "block";
        x.src=file;
    } 
    else {
        x.style.display = "none";
        x.src="";
    }
}

