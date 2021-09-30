<?php
    session_start();
    if(!isset($_SESSION['uname']) || $_SESSION['role'] != 1){
        header("Location: ../../index.php");
    }
    //include "../db/db_manipulation.php";
?>
<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <link href="../../css/lato100.css" rel="stylesheet" type="text/css">
        <link rel="stylesheet" href="../../css/main.css">
        <link rel="stylesheet" href="../../css/main_menu.css">
        <link rel="stylesheet" href="../../css/buttons.css">
        <link rel="stylesheet" href="../../css/table.css">
        <title>ReviewBase</title>
        <link rel="icon" type="image/png" sizes="32x32" href="./img/favicon.png">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
        <script src="../../js/adminscripts.js"></script>
    </head>
    <body>
        <div class="container">
            <div class="title">
                <div class="cssmenuitemwrapper">
                    <span><img src="../../img/logo.png" height="100"></span>
                </div>
            </div>
            <div id='cssmenu'>
                <ul>
                    <li>
                        <a onclick="upl()">
                            <div class="cssmenuitemwrapper">
                                <span><img src="../../img/referat.png" width="70" height="70"></span>
                                <span style="padding-left: 10px">Курсови работи</span>
                            </div>
                        </a>
                    </li>
                    <li>
                        <a onclick="adm()">
                            <div class="cssmenuitemwrapper">
                                <span><img src="../../img/admin.png" width="70" height="70"></span>
                                <span style="padding-left: 10px">Администраторски панел</span>
                            </div>
                        </a>
                    </li>
                    <li>
                        <a href='./logout.php'>
                            <div class="cssmenuitemwrapper">
                                <span><img src="../../img/logout.png" width="70" height="70"></span>
                                <span style="padding-left: 10px">Изход</span>
                            </div>
                        </a>
                    </li>

                    <div class="admin-panel" hidden id="admin-panel">
                        <li>
                            <a id="log" onclick="log()">
                                <div class="cssmenuitemwrapper">
                                    <span><img src="../../img/login.png" width="70" height="70"></span>
                                    <span style="padding-left: 10px">Лог на влизания</span>
                                </div>
                            </a>
                        </li>
                        <li>
                            <a id="acc" onclick="acc()">
                                <div class="cssmenuitemwrapper">
                                    <span><img src="../../img/registered.png" width="70" height="70"></span>
                                    <span style="padding-left: 10px">Преглед на регистрираните потребители</span>
                                </div>
                            </a>
                        </li>
                    </div>
                    <div class="course-works" hidden id="course-works">
                        <li>
                            <a onclick="upl_section()">
                                <div class="cssmenuitemwrapper">
                                    <span><img src="../../img/upload.png" width="70" height="70"></span>
                                    <span style="padding-left: 10px">Качвания</span>
                                </div>
                            </a>
                        </li>
                        <li>
                            <a id="log" onclick="grade_section()">
                                <div class="cssmenuitemwrapper">
                                    <span><img src="../../img/grade.png" width="70" height="70"></span>
                                    <span style="padding-left: 10px">Оценяване</span>
                                </div>
                            </a>
                        </li>
                    <div class="uploads" hidden  id="uploads">
                        <li>
                            <a id="log" onclick="ref()">
                                <div class="cssmenuitemwrapper">
                                    <span><img src="../../img/referat.png" width="70" height="70"></span>
                                    <span style="padding-left: 10px">Качени реферати</span>
                                </div>
                            </a>
                        </li>
                        <li>
                            <a id="acc" onclick="pres()">
                                <div class="cssmenuitemwrapper">
                                    <span><img src="../../img/present.png" width="70" height="70"></span>
                                    <span style="padding-left: 10px">Качени презентации</span>
                                </div>
                            </a>
                        </li>
                        <li>
                            <a id="upl" onclick="inv()">
                                <div class="cssmenuitemwrapper">
                                    <span><img src="../../img/invite.png" width="70" height="70"></span>
                                    <span style="padding-left: 10px">Качени покани</span>
                                </div>
                            </a>
                        </li>
                    </div>
                    <div class="grading" hidden id="grading">
                        <li>
                            <a id="upl" onclick="grades()">
                                <div class="cssmenuitemwrapper">
                                    <span><img src="../../img/gradeComponent.png" width="70" height="70"></span>
                                    <span style="padding-left: 10px">Оценки по компоненти</span>
                                </div>
                            </a>
                        </li>
                        <li>
                            <a id="upl" onclick="start_grade()">
                                <div class="cssmenuitemwrapper">
                                    <span><img src="../../img/start.png" width="70" height="70"></span>
                                    <span style="padding-left: 10px">Стартиране на оценяването</span>
                                </div>
                            </a>
                        </li>
                        <li>
                            <a id="upl" onclick="stop_grade()">
                                <div class="cssmenuitemwrapper">
                                    <span><img src="../../img/stop.png" width="70" height="70"></span>
                                    <span style="padding-left: 10px">Край на оценяването</span>
                                </div>
                            </a>
                        </li>     
                    </div>
                    
                </ul>
            </div>
            <div id="start-grades-container" hidden>Кампанията по оценяване беше стартирана!</div>
            <div id="stop-grades-container" hidden>Кампанията по оценяване беше спряна!</div>
            <div id="error"></div>
            <div id="log-container"></div>
            <div id="acc-container"></div>
            <div id="ref-container"></div>
            <div id="inv-container"></div>
            <div id="pres-container"></div>
        </div>
    </body>
    <script src="../../js/upload.js"></script>
</html>