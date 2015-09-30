<?php
class Meeting extends AppModel {
	
	var $useTable = 'meetings';
	
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
    var $hasMany = array(
			'Exceptions' => array('className' => 'MeetException',
								'foreignKey' => 'meeting_id',
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
		'starts' => array(
			'rule' => '/^[0-9]{4}-[0-9]{2}-[0-9]{2}$/',
			'message' => 'niepoprawny format daty (XXXX-XX-XX)',
		),
		'ends' => array(
			'rule' => '/^[0-9]{4}-[0-9]{2}-[0-9]{2}$/',
			'message' => 'niepoprawny format daty (XXXX-XX-XX)',
		)
	);
	
	function findNext() {
		$meeting_conditions = 'DATE_SUB(starts, INTERVAL 6 day) < NOW() AND ends > NOW() AND active > 0';
		$result = $this->find('first', array('fields' => array('Meeting.*', 'Place.*', 'DATE_ADD(CURDATE(), INTERVAL ((7 - WEEKDAY(CURDATE()) + day_of_week - 1) % 7) day) AS next' ), 'conditions' => $meeting_conditions, 'order' => 'next ASC, from ASC'));
		return $result;
	}
	
	function findAllNext() {
		$meeting_conditions = 'DATE_SUB(starts, INTERVAL 6 day) < NOW() AND ends > NOW() AND active > 0';
		$result = $this->find('all', array('fields' => array('Meeting.*', 'Place.*', 'DATE_ADD(CURDATE(), INTERVAL ((7 - WEEKDAY(CURDATE()) + day_of_week - 1) % 7) day) AS next' ), 'conditions' => $meeting_conditions, 'order' => 'next ASC, from ASC'));
		return $result;
	}

}
?>