<?php
class AppModel extends Model {

	var $actsAs = array('Containable'); 

	function compareData ($data=array(), $compare_field=null) {
       
	   foreach( $data as $key => $value ){
            $compare_value = $this->data[$this->name][ $compare_field ];                 
            if($value !== $compare_value) return false;
            else continue;
        }
        return true;
    }
	
	function compareUnique ($data=array(), $compare_field=null) {
       
	   foreach( $data as $key => $value ){
            $compare_value = $this->data[$this->name][ $compare_field ];                 
            if($value == $compare_value) return false;
            else continue;
        }
        return true;
    }
		
	function generateShortHash ($length = 8) {
	
	  $password = '';
	  $possible = '0123456789abcdfghjkmnpqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ'; 
	  $i = 0; 
	 
	  while ($i < $length) { 
	    $char = substr($possible, mt_rand(0, strlen($possible)-1), 1);
	    $password .= $char;
	    $i++;
	  }
	  
	  return $password;
	}
	
	function generateHash($password) {
		
		$result = array();
		$result['salt'] = $this->generateShortHash(8);
		$result['hash'] = hash('sha512', $password.$result['salt'] );
		return $result;
		
	}	
	
	function passwordMatch ($data=array()) {
		
		if(empty($this->data)) return false;
		$dbData = $this->findById($this->data[$this->name]['id']);
		if(empty($dbData)) return false;
	    $hash = hash('sha512', $data['oldPassword'].$dbData[$this->name]['salt']);
		if($hash == $dbData[$this->name]['hash']) return true;
		else return false;
    }
	
	function isUnique($data) {
        $field = array_shift(array_keys($data));
        $value = array_shift(array_values($data));
        $conditions = array("$this->name.$field" => $value);
        if (isset($this->data[$this->name][$this->primaryKey])) {
            $conditions["$this->name.$this->primaryKey"] = '<> '.$this->data[$this->name][$this->primaryKey];
        }
        return !$this->hasAny($conditions);
    }

    function labelize($text) {
        $tu_zamieniac   = trim(mb_strtolower($text, "utf-8"));
		$do_zamiany 	= array(" ", "ą", "ę", "ć", "ś", "ń", "ł", "ó", "ż", "ź", ".", "--");
		$zamienic_na 	= array("-", "a", "e", "c", "s", "n", "l", "o", "z", "z", "-", "-");
		$result = str_replace($do_zamiany, $zamienic_na, $tu_zamieniac);
		$allowed = "/[^a-z0-9\\040\\-\\_]/i";
		$result = preg_replace($allowed,"",$result);
		return $result;
    }
}
?>