<?php
class Tournament extends AppModel {
	
	var $hasMany = array(
			'Player' => array('className' => 'Player',
								'foreignKey' => 'tournament_id',
								'dependent' => false,
								'conditions' => '',
								'fields' => '',
								'order' => 'Player.rank DESC',
								'limit' => '',
								'offset' => '',
								'exclusive' => '',
								'finderQuery' => '',
								'counterQuery' => '',
                                'counterCache' => true
			)
	);

    // var $validate = array(
		// 'email' => array('rule' => 'email', 'message' => 'Prosze podac prawidlowy adres email'),
	// );
	
	
}
?>