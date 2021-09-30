<?php
    session_start();
    if(!isset($_SESSION['uname']) || $_SESSION['role'] != 0){ //you cannot access that page unless you are logged in
        header("Location: ../../index.php");
    }
    else{
        include "../../renders/header.html";
    }
?>
<?php
    echo "<h2>Здравей, " . $_SESSION['uname'] . "!</h2>";
?>
<p>Това е системата за качване на реферати по WWW Технологии. <br>
Тук можеш да ревюираш рефератите на колеги, както и да качиш и получиш ревю за своя.</p>
            </div>
        </div>
    </body>
    <script>
        document.getElementById('homepage').classList.toggle("active");
        document.getElementById('choose').class = "";
        document.getElementById('upload').class = "";
        document.getElementById('grade').class = "";
        document.getElementById('logout').class = "";
    </script>
</html>