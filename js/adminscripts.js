
function upl(){
    document.getElementById('course-works').classList.toggle("active");

    $("#admin-panel").hide(); 
    $("#course-works").toggle();
    hide();
    //$("#upl-container").load("upl.php");
}
function upl_section(){
    $("#grading").hide(); 
    $("#uploads").show();
    $("#start-grades-container").hide();
    $("#stop-grades-container").hide();
    hide();
    //$("#upl-container").load("upl.php");
}
function grade_section(){
    $("#grading").show(); 
    $("#uploads").hide();
    hide();
    //$("#upl-container").load("upl.php");
}
function adm(){
    $("#admin-panel").toggle(); 
    $("#course-works").hide();
    hide();
    //$("#upl-container").load("upl.php");
}
function hide(){
    $("#log-container").hide();
    $("#acc-container").hide();
    $("#upl-container").hide();
}
function ref(){
    $("#log-container").show();
    $("#acc-container").hide();
    $("#upl-container").hide();
    $("#log-container").load("../../admin/renders/ref.php");
}
function pres(){
    $("#log-container").show();
    $("#acc-container").hide();
    $("#upl-container").hide();
    $("#log-container").load("../../admin/renders/pres.php");
}
function inv(){
    $("#log-container").show();
    $("#acc-container").hide();
    $("#upl-container").hide();
    $("#log-container").load("../../admin/renders/inv.php");
}

function grades(){
    $("#log-container").show();
    $("#acc-container").hide();
    $("#upl-container").hide();
    $("#start-grades-container").hide();
    $("#stop-grades-container").hide();
    $("#log-container").load("../../admin/grades/gradecomponents.php");
}
function start_grade(){
    $("#log-container").show();
    $("#start-grades-container").show();
    $("#stop-grades-container").hide();
    $("#acc-container").hide();
    $("#upl-container").hide();
    $("#log-container").load("../../admin/grades/start_grade.php");
}
function stop_grade(){
    $("#log-container").show();
    $("#acc-container").hide();
    $("#upl-container").hide();
    $("#start-grades-container").hide();
    $("#stop-grades-container").show();
    $("#log-container").load("../../admin/grades/stop_grade.php");
}
function log(){
    $("#log-container").show();
    $("#acc-container").hide();
    $("#upl-container").hide();
    $("#log-container").load("../../admin/renders/log.php");
} 

function acc(){
    $("#log-container").hide();
    $("#upl-container").hide();
    $("#acc-container").show();
    $("#acc-container").load("../../admin/renders/users.php");
}