<?php
// ===================================================================
//session_name('session_system');
//session_save_path(dirname(__FILE__).'/lms/_sources/libraries/session/');
session_set_cookie_params(0, '/', '.cursosiag.com.br');
session_cache_expire(180);
session_start();

$_GET['categoria'] = 'site';
if (!$_GET['module']) 
	$_GET['module'] = 'home';
if (!$_GET['do']) 
	$_GET['do'] = 'index';

	require(dirname(__FILE__).'/lms/global.php');
	$system = new System(false);
	$system->site->Load($system->input['module']);
	$system->site->Run();
	die;	
// ===================================================================
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<META HTTP-EQUIV=Refresh CONTENT="1; URL=http://www.adrianogianini.com.br/site">
<title>Redirecionando...</title>
</head>

<body>

</body>
</html>