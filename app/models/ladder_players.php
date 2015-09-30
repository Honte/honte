<?php
class LadderPlayers extends AppModel {
			
	var $useTable = 'ladder_players';
	
	
	var $hasMany = array(
			'LadderGamesAsBlack' => array('className' => 'LadderGames',
								'foreignKey' => 'black_id',
								'dependent' => false,
								'conditions' => '',
								'fields' => '',
								'order' => '',
								'limit' => '',
								'offset' => '',
								'exclusive' => '',
								'finderQuery' => '',
								'counterQuery' => ''
			), 
			'LadderGamesAsWhite' => array('className' => 'LadderGames',
								'foreignKey' => 'white_id',
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
		'name' => array(
			'rule' => array('minLength', 2), 
			'message' => 'niepoprawne imię (min. 2 znaki)'
		),
		'surname' => array(
			'rule' => array('minLength', 2), 
			'message' => 'niepoprawne nazwisko (min. 2 znaki)'
		),
		'tag' => array(
			'rule' => '/[a-zA-Z0-9-_ +]/',
			'message' => 'niepoprawny tag',
			'allowEmpty' => true
		)
	);
	


}
?>