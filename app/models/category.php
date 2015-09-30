<?php
class Category extends AppModel {

	// utf w/o bom trick: ą
	var $hasMany = array(
			'Article' => array('className' => 'Article',
								'foreignKey' => 'category_id',
								'dependent' => false,
								'conditions' => '',
								'fields' => '',
								'order' => '',
								'limit' => '',
								'offset' => '',
								'exclusive' => '',
								'finderQuery' => '',
								'counterQuery' => ''
			)
	);
		
	var $validate = array(
		'email' => array('rule' => 'email', 'message' => 'Prosze podac prawidlowy adres email'),
	);
	
	
}
?>