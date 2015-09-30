<?php
class Place extends AppModel {
	
	// utf w/o bom trick: ą
	var $useTable = 'places';
	var $actsAs = array('Upload'); 

	var $hasMany = array(
			'Meetings' => array('className' => 'Meetings',
								'foreignKey' => 'place_id',
								'dependent' => true,
								'conditions' => '',
								'fields' => '',
								'order' => '',
								'limit' => '',
								'offset' => '',
								'exclusive' => '',
								'finderQuery' => '',
								'counterQuery' => ''
			),
			'Special' => array('className' => 'Special',
								'foreignKey' => 'place_id',
								'dependent' => true,
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
		'name' => array(
			'rule' => array('minLength', 2), 
			'message' => 'niepoprawna nazwa miejsca (min. 2 znaki)'
		),
		'address' => array(
			'rule' => array('minLength', 3), 
			'message' => 'niepoprawny adres (min. 3 znaki)'
		),
		'map' => array(
			'rule' => 'url',
			'message' => 'niepoprawny adres www',
			'allowEmpty' => true
		)
	);
	

}
?>