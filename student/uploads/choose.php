                    <?php 
                    session_start();
                    include "../../renders/header.html";
                    include '../../php/db/db_manipulation.php';
                    ?>
                </div>
                <h4>Избраната тема е <?php
                    if(getTheme($_SESSION['uname'], getID($_SESSION['uname'])) != 0){
                        echo getTheme($_SESSION['uname'], getID($_SESSION['uname']));
                    }
                    else echo " - ";	?>
                </h4>
                <p>Ако искате да изберете тема - може изберете отбелязаното в падащото меню.</p>
                <p>Таблица с всички възможни теми (всеки попълва своят ред за избраната тема - като например собствени линкове, ключови думи и т.н.), можеш да се видят <a href="https://docs.google.com/spreadsheets/d/1IQ4P01tBs2A1NAAK5iuCO73Cyp9EUrmEwmQ5MDOvedk/edit#gid=1778397176" target="_blank"><b style="font-weight:bold;">тук</b></a>. </p>
                <div class="form_holder">
                    <h3>Избери тема за реферат</h3>
                    <span class="error"></span>
                    <?php
                    $themes = display_themes();
                    //print_r($themes);
                    echo "<form id=\"myform\" onsubmit=\"choose()\" method=\"post\" \">
                        Номер (тема) на проекта:<select id=\"themes\" name='project_theme_select'>";
                    $i = 1;
                    foreach ($themes as $theme) {
                        $theme_name = $i . " - " . $theme['theme_name'];
                            if(!isset($theme['user_id'])){
                                echo "<option value=" . $i . ">" . $theme_name . "</option>";            
                            }
                            else{
                                if($theme_name == getTheme($_SESSION['uname'], $theme['user_id'])){
                                echo "<option  selected class=\"taken\" disabled=\"disabled \"value=" . $i . ">" . $theme_name . "</option>";
                                }
                                else{
                                    echo "<option class=\"taken\" disabled=\"disabled \"value=" . $i . ">" . $theme_name . "</option>";
                                }
                            }
                            ++$i;
                    }
                    
                    echo "</select><a id=\"submit\" class=\"btn green\" onclick=\"choose()\">Избор</a>
                    </form>";
                    ?>
 
                </div>
            </div>
        </div>
    </body>
    
    <script>
        document.getElementById('homepage').class = "";
        document.getElementById('choose').classList.toggle("active");
        document.getElementById('upload').class = "";
        document.getElementById('grade').class = "";
        document.getElementById('logout').class = "";
        function choose(){
            var x = document.getElementById("themes");
            var i = x.selectedIndex + 1;
            var xhttp;
            xhttp = new XMLHttpRequest();
            xhttp.onreadystatechange = function() {
                if (this.readyState == 4 && this.status == 200) {
                location.href = "./choose.php";
                }
            };
            xhttp.open("GET", "./choose_ref.php?theme_no="+ i, true);
            xhttp.send();
        };
        
        function makeList(){
            var i;
            var xhttp;
            xhttp = new XMLHttpRequest();
            xhttp.onreadystatechange = function() {
                if (this.readyState == 4 && this.status == 200) {
                document.getElementById("result").innerHTML = this.responseText;
                }
            };
            xhttp.open("GET", "./addToDb.php", true);
            xhttp.send();
        }
    </script>
</html>