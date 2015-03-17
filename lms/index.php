<?php
// ===================================================================
//session_name('sessionsystem');
//session_save_path(dirname(__FILE__).'/_sources/libraries/session/');
session_set_cookie_params(0, '/', '.localiag.com');
session_cache_expire(180);
session_start();

require(dirname(__FILE__).'/global.php');
$system = new System();
$system->admin->Load($system->input['module']);
$system->admin->Run();
die;
// ===================================================================