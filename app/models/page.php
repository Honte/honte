<?php
class Page extends AppModel {
	
	var $useTable = 'pages';
	
	var $validate = array(
		'label' => array(
			'rule' => array('minLength', 3), 
			'message' => 'Niepoprawna nazwa strony (min. 3 znaki)'
		),
		'content' => array(
			'rule' => array('minLength', 10), 
			'message' => 'Treść powinna zawierać co najmniej 10 znaków'
		)
	);
	
	
}
?>