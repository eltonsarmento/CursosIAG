<?php
// ===================================================================
class Loader {
	// ===============================================================
	private $system = null;
	// ===============================================================
	public function __construct() {
		$this->system =& getInstancia();
	}
	// ===============================================================
	public function model($modelname, $name='') {
		if ($modelname == '') return;
		if (strpos($modelname, '/') === false)
			$path = '';
		else {
			$x = explode('/', $modelname);
			$modelname = end($x);
			unset($x[count($x)-1]);
			$path = implode('/', $x).'/';
		}
		
		if ($name == '') $name = $modelname;
		$modelname = strtolower($modelname);
		
		require_once($this->system->getRootPath() . '/_sources/_model/' . $path . $modelname . '.model.php');
		$modelname = ucfirst($modelname.'MODEL');
		$this->system->$name = new $modelname();
	}
	// ===============================================================
	public function dao($daoname, $name='') {
		if ($daoname == '') return;
		if (strpos($daoname, '/') === false)
			$path = '';
		else {
			$x = explode('/', $daoname);
			$daoname = end($x);
			unset($x[count($x)-1]);
			$path = implode('/', $x).'/';
		}
		
		if ($name == '') $name = $daoname;
		$daoname = strtolower($daoname);
		
		require_once($this->system->getRootPath() . '/_sources/_data/' . $path . $daoname . '.dao.php');
		$daoname = ucfirst($daoname.'DAO');
		$this->system->$name = new $daoname();
	}
	// ===============================================================
	public function library($libraryname, $name='', $prefix='') {
		if ($libraryname == '') return;
		if (strpos($libraryname, '/') === false)
			$path = '';
		else {
			$x = explode('/', $libraryname);
			$libraryname = end($x);
			unset($x[count($x)-1]);
			$path = implode('/', $x).'/';
		}
		
		if ($name == '') $name = $libraryname;
		$libraryname = strtolower($libraryname);
		
		require_once($this->system->getRootPath() . '/_sources/libraries/' . $path . $libraryname . '.library.php');
		$libraryname = ucfirst($libraryname);
		$this->system->$name = new $prefix.$libraryname();
	}
	// ===============================================================
}
// ===================================================================