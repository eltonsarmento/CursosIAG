<?php
// ===================================================================
class SqlDB {
	// ===============================================================
    private $db_connect_id;
    private $num_queries = 0;
	private $query_result;
	// ===============================================================
    public function __construct($server, $user, $password, $database, $persistency = true) {
		if ($persistency)
	    	$this->db_connect_id = @mysql_pconnect($server, $user, $password);
		else
	    	$this->db_connect_id = @mysql_connect($server, $user, $password);

		if ($this->db_connect_id) {
	    	if ($database != '') {
				$objSqlselect = @mysql_select_db($database);
				if (!$objSqlselect) {
		    		@mysql_close($this->db_connect_id);
		    		$this->db_connect_id = $objSqlselect;
				}
	    	}
            mysql_query("SET NAMES 'utf8'");
            mysql_query('SET character_set_connection=utf8');
            mysql_query('SET character_set_client=utf8');
            mysql_query('SET character_set_results=utf8');
	    	return $this->db_connect_id;
	    }
    }
	// ===============================================================
    public function __destruct() {
        $this->close();
    }
	// ===============================================================
    public function close() {
		if ($this->db_connect_id) {
	    	if ($this->query_result)
				@mysql_free_result($this->query_result);
	    	return @mysql_close($this->db_connect_id);
		}
    }
	// ===============================================================
    public function select($get, $tbl, $where='', $limit='', $order='') {
        $query = 'SELECT '.$get.' FROM '.$tbl;
        if ($where != '') $query .= ' WHERE '.$where;
        if ($order != '') $query .= ' ORDER BY '.$order;
        if ($limit != '') $query .= ' LIMIT '.$limit;
        return $this->query($query);
    }
	// ===============================================================
    public function update($tbl, $arr, $where='') {
        $dba = $this->compile_db_update_string($arr);
        $query = 'UPDATE '.$tbl.' SET '.$dba;
        if ($where) $query .= ' WHERE '.$where;
        return $this->query($query);
    }
	// ===============================================================
    public function insert($tbl, $arr) {
        $dba = $this->compile_db_insert_string($arr);
        $query = 'INSERT INTO '.$tbl.' ('.$dba['FIELD_NAMES'].') VALUES ('.$dba['FIELD_VALUES'].')';
        return $this->query($query);
    }
    // ===============================================================
    public function timenow($time = false) {
    	return ($time ? time() : date('Y-m-d H:i:s'));
    }
	// ===============================================================
    public function delete($tbl, $where) {
        $query = 'DELETE FROM ' . $tbl;
        if ($where) $query .= ' WHERE ' . $where;
        return $this->query($query);
    }
	// ===============================================================
    public function query($query = '') {
		unset($this->query_result);
        if ($query != '') {
            $this->num_queries++;
            $this->query_result = @mysql_query($query, $this->db_connect_id);
		}
		if ($this->query_result) {
	   		return $this->query_result;
		} else {
            if ($this->db_connect_id) {
                echo 'ERROR SQL<br /> '.$query;
                die (mysql_error());
            }
		}
    }
	// ===============================================================
    public function escape($msg) {
		return mysql_real_escape_string($msg);
	}
	// ===============================================================
    public function numrows($query_id) {
	    return mysql_num_rows($query_id);
    }
	// ===============================================================
    public function affectedrows() {
	    return mysql_affected_rows();
    }
	// ===============================================================
    public function numfields($query_id) {
	    return mysql_num_fields($query_id);
    }
	// ===============================================================
    public function fieldname($offset, $query_id) {
	    return mysql_field_name($query_id, $offset);
    }
	// ===============================================================
    public function fieldtype($offset, $query_id) {
	    return mysql_field_type($query_id, $offset);
    }
	// ===============================================================
    public function fetchrow($query_id) {
	    return mysql_fetch_array($query_id);
    }
	// ===============================================================
    public function queryfetchrow($query) {
        return $this->fetchrow($this->query($query));
    }
	// ===============================================================
    public function querynumrows($query) {
        return $this->numrows($this->query($query));
    }
    // ===============================================================
    public function querycountunit($query_id) {
    	$result = $this->fetchrow($query_id);
        return $result[0];
    }
    // ===============================================================
    public function queryfetchobject($query) {
        return $this->fetchobject($this->query($query));
    }
	// ===============================================================
    public function fetchobject($query_id) {
	    return mysql_fetch_object($query_id);
    }
	// ===============================================================
    public function fetchrowset($query_id) {
	    $result = array();
		while($rowset = $this->fetchrow($query_id))
			$result[] = $rowset;
	    return $result;
    }
	// ===============================================================
    public function rowseek($rownum, $query_id) {
	    return mysql_data_seek($query_id, $rownum);
    }
	// ===============================================================
    public function nextid() {
	    return mysql_insert_id();
    }
	// ===============================================================
    public function freeresult($query_id) {
	    return mysql_free_result($query_id);
    }
	// ===============================================================
    public function error($query_id = 0) {
		$result["message"] = @mysql_error($this->db_connect_id);
		$result["code"] = @mysql_errno($this->db_connect_id);
		return $result;
    }
	// ===============================================================
    private function compile_db_insert_string($data) {
        $field_names  = '';
        $field_values = '';
        foreach($data as $k => $v) {
            $field_names .= "$k,";
            $field_values .= "'$v',";
        }
        $field_names  = preg_replace("/,$/", "", $field_names);
        $field_values = preg_replace("/,$/", "", $field_values);
        return array('FIELD_NAMES'  => $field_names, 'FIELD_VALUES' => $field_values);
    }
	// ===============================================================
    private function compile_db_update_string($data) {
        $return_string = '';
        foreach($data as $k => $v) {
        	$return_string .= $k . "='".$v."',";
        }
        $return_string = preg_replace("/,$/" , "" , $return_string);
        return $return_string;
    }
    // ===============================================================
}
// ===================================================================