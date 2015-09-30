<?php
class MeetException extends AppModel {
	
	var $name = 'MeetException';
	var $useTable = 'exceptions';
	
	var $belongsTo = array(
			'Meeting' => array('className' => 'Meeting',
								'foreignKey' => 'meeting_id',
								'dependent' => false,
								'conditions' => '',
								'order' => '',
								'limit' => '',
								'offset' => '',
								'exclusive' => '',
			)
	);

    var $validate = array(
		'from' => array(
			'rule' => array('minLength', 1),
			'message' => 'niepoprawne imię (min. 2 znaki)',
            'allowEmpty' => true
		),
	);
	
}
?>