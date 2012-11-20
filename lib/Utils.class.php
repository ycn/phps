<?php

class Utils
{
	const PARAM_STR = 0;
    const PARAM_INT = 1;
    const PARAM_URI = 2;

    public static function getClientRealIP() {
        if (getenv("HTTP_CLIENT_IP") && strcasecmp(getenv("HTTP_CLIENT_IP"), "unknown"))
           $ip = getenv("HTTP_CLIENT_IP");
        else if (getenv("HTTP_X_FORWARDED_FOR") && strcasecmp(getenv("HTTP_X_FORWARDED_FOR"), "unknown"))
           $ip = getenv("HTTP_X_FORWARDED_FOR");
        else if (getenv("REMOTE_ADDR") && strcasecmp(getenv("REMOTE_ADDR"), "unknown"))
           $ip = getenv("REMOTE_ADDR");
        else if (isset($_SERVER['REMOTE_ADDR']) && $_SERVER['REMOTE_ADDR'] && strcasecmp($_SERVER['REMOTE_ADDR'], "unknown"))
           $ip = $_SERVER['REMOTE_ADDR'];
        else
           $ip = "unknown";
        return($ip);
    }

    public static function userInput($input, $type=0) {
        $input = htmlspecialchars($input, ENT_QUOTES);

        switch ($type) {
            case self::PARAM_URI:
                if (!preg_match('/^http(s)?:\/\//', $input)) {
                        $input = 'http://' . $input;
                }
                $input = urldecode($input);
                break;
            case self::PARAM_INT:
                $input = intval($input);
                break;
            case self::PARAM_STR:
            default:
                break;
        }

        return $input;
    }

    public static function jsonEncode($array=false){
        if(is_null($array)) return 'null';
        if($array === false) return 'false';
        if($array === true) return 'true';
        if(is_scalar($array)){
            if(is_float($array)){
                return floatval(str_replace(",", ".", strval($array)));
            }
            if(is_string($array)){
                static $jsonReplaces = array(array("\\", "/", "\n", "\t", "\r", "\b", "\f", '"'), array('\\\\', '\\/', '\\n', '\\t', '\\r', '\\b', '\\f', '\"'));
                return '"' . str_replace($jsonReplaces[0], $jsonReplaces[1], $array) . '"';
            }
            else return $array;
        }
        $isList = true;
        for($i=0, reset($array); $i<count($array); $i++, next($array)){
            if(key($array) !== $i){
                $isList = false;
                break;
            }
        }
        $result = array();
        if($isList){
            foreach($array as $v) $result[] = self::jsonEncode($v);
            return '[' . join(',', $result) . ']';
        }
        else {
            foreach ($array as $k => $v) $result[] = self::jsonEncode($k).':'.self::jsonEncode($v);
            return '{' . join(',', $result) . '}';
        }
    }

    public static function debug($obj, $type='html') {
        switch ($type) {
            case 'html':
                echo '<pre>';
                print_r($obj);
                echo '</pre>';
                break;
            default:
                break;
        }
    }

    public static function getFileExt ($path) {
        $name = basename($path);
        $pos = strrpos($name, ".");
        $ext = substr($name, $pos + 1);
        return $ext;
    }

}
?>