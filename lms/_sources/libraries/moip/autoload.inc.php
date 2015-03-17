<?php

//Autoload function. Only charges a class if they required.
function __autoload($classe){
	if (file_exists(dirname(__FILE__)."/lib/{$classe}.php"))
		include_once "lib/{$classe}.php";
}

?>
