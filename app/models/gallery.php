<?php
class Gallery extends AppModel {
	
	// utf w/o bom trick: ą
	var $actsAs = array('Upload'); 
		
	// var $validate = array(
		// 'email' => array('rule' => 'email', 'message' => 'Prosze podac prawidlowy adres email'),
	// );
	
	
}
?>