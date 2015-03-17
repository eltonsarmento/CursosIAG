<?php
// ===================================================================
class Input {
	// ===============================================================
	public static function parse_incoming() {
		$return = array();
        if (is_array($_GET)) {
            while(list($k, $v) = each($_GET)) {
                if (is_array($_GET[$k])) {
                    while(list($k2, $v2) = each($_GET[$k])) {
                        $return[self::clean_key($k)][self::clean_key($k2)] = self::clean_value($v2);
                    }
                } else {
                    $return[self::clean_key($k)] = self::clean_value($v);
                }
            }
        }
        if (is_array($_POST)) {
            while(list($k, $v) = each($_POST)) {
                if (is_array($_POST[$k])) {
                    while(list($k2, $v2) = each($_POST[$k])) {
                        $return[self::clean_key($k)][self::clean_key($k2)] = self::clean_value($v2);
                    }
                } else {
                    $return[self::clean_key($k)] = self::clean_value($v);
                }
            }
        }
        $return['request_method'] = strtolower($_SERVER['REQUEST_METHOD']);
        return $return;
	}
	// ===============================================================
	private function clean_key($key) {
        if ($key == '') return '';
        $key = htmlspecialchars(urldecode(strip_tags(addslashes(trim($key)))));
        $key = preg_replace("/\.\./"           , ""  , $key);
        $key = preg_replace("/\_\_(.+?)\_\_/"  , ""  , $key);
        $key = preg_replace("/^([\w\.\-\_]+)$/", "$1", $key);
        $key = preg_replace("/(from|select|insert|delete|where|drop table|show tables|#|\*|--|\\\\)/i", "", $key);
		return $key;
    }
    // ===============================================================
    private function clean_value($val) {
      	if ($val == '') return '';
        $val = str_replace ("<!--"        , "&#60;&#33;--"  , $val);
        $val = str_replace ("-->"         , "--&#62;"       , $val);
        $val = preg_replace("/<script/i"  , "&#60;script"   , $val);
        $val = str_replace (">"           , "&gt;"          , $val);
        $val = str_replace ("<"           , "&lt;"          , $val);
        $val = str_replace ("\""          , "&quot;"        , $val);
        $val = preg_replace("/\\\$/"      , "&#036;"        , $val);
        $val = preg_replace("/\r/"        , ""              , $val);
        $val = str_replace ("!"           , "&#33;"         , $val);
        $val = str_replace ("'"           , "&#39;"         , $val);
        $val = preg_replace("/\\\(?!&amp;#|\?#)/", "&#092;" , $val);
        return $val;
    }
	// ===============================================================
}
// ===================================================================