<?php
// DB connection
$config=array(
    'DB_HOST'=>'localhost',
    'DB_USERNAME'=>'root',
    'DB_PASSWORD'=>'',
    'DB_DATABASE'=>'puffinsecurity'
);
$allowed_devices = 3;
$login_attempts = 3;
$lockout_time = 15;
$presentation = array(
    "PRESENTATION_PATH" => "../updates/presetations",
    "INVITATION_PATH" => "../updates/invitations"
);
$user_table = "user";
$grading_table = "grading";
$theme_table = "themes";
$invitations_table = "invitations";
$presentations_table = "presentations";
$referat_table = "referats";
$log_table = "log_stats";
$device_table = "devices";
$new_device = "add_device";
$user_agent = $_SERVER['HTTP_USER_AGENT'];

?>