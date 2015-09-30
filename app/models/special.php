<?php
class Special extends AppModel {
	
	// utf w/o bom trick: ą
	var $name = 'Special';
	var $useTable = 'special_meetings';
	
	var $belongsTo = array(
			'Place' => array('className' => 'Place',
								'foreignKey' => 'place_id',
								'dependent' => false,
								'conditions' => '',
								'order' => '',
								'limit' => '',
								'offset' => '',
								'exclusive' => '',
			)
	);
	
	
}
?>