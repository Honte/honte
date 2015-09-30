<?php
class Event extends AppModel {

	// utf w/o bom trick: ą
	var $name = 'Event';
	var $useTable = 'events';
	
	var $validate = array(
		'email' => array('rule' => 'email', 'message' => 'Prosze podac prawidlowy adres email'),
	);
	
	
}
?>