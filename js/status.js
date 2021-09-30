function changestatus(id, field) {
      var xhttp;
      xhttp = new XMLHttpRequest();
      xhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            if(field == "promote" || field == "demote"){
                var all = document.getElementsByClassName("privilege");
                for(var i=0;i<all.length;i++){
                    if(all[i].id == id){
                        all[i].innerHTML = this.responseText;                        
                    }
                }
                if(field=="promote"){
                    all = document.getElementsByClassName("clickpromote");
                    for(i=0;i<all.length;i++){
                        if(all[i].id == id){
                            all[i].innerHTML = "Demote";                        
                            all[i].setAttribute('onclick','changestatus(id, \'demote\')');
                        }
                    }
                }
                else{
                    all = document.getElementsByClassName("clickpromote");
                    for(i=0;i<all.length;i++){
                        if(all[i].id == id){
                            all[i].innerHTML = "Promote";                        
                            all[i].setAttribute('onclick','changestatus(id, \'promote\')');
                        }
                    }
                }
                    
            }
            else if(field == "block" || field == "unblock"){
                all = document.getElementsByClassName("ban");
                for(i=0;i<all.length;i++){
                    if(all[i].id == id){
                        all[i].innerHTML = this.responseText;                        
                    }
                }
                if(field=="block"){
                    all = document.getElementsByClassName("clickban");
                    for(i=0;i<all.length;i++){
                        if(all[i].id == id){
                            all[i].innerHTML = "Unblock";                        
                            all[i].setAttribute('onclick','changestatus(id, \'unblock\')');
                        }
                    }
                }
                else{
                    all = document.getElementsByClassName("clickban");
                    for(i=0;i<all.length;i++){
                        if(all[i].id == id){
                            all[i].innerHTML = "Block";                        
                            all[i].setAttribute('onclick','changestatus(id, \'block\')');
                        }
                    }
                }
            }
        }
      };
      xhttp.open("GET", "../../admin/role/role.php?id="+id+"&field=" + field, true);
      xhttp.send();
}