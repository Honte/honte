<?php
class LadderGames extends AppModel {
			
	var $useTable = 'ladder_games';
	
	var $belongsTo = array(
			'LadderGamesAsBlack' => array('className' => 'Member',
								'foreignKey' => 'black_id',
								'dependent' => false,
								'conditions' => '',
								'order' => '',
								'limit' => '',
								'offset' => '',
								'exclusive' => '',
			),
			'LadderGamesAsWhite' => array('className' => 'Member',
								'foreignKey' => 'white_id',
								'dependent' => false,
								'conditions' => '',
								'order' => '',
								'limit' => '',
								'offset' => '',
								'exclusive' => '',
			)
	);

	var $validate = array(
		'black_id' => array(
			'NotWhite' => array(
				'rule' => array('compareUnique','white_id'), 
				'message' => 'gracze nie mogą rozegrać gry ze sobą'
			),
		),
		'white_id' => array(
			'NotBlack' => array(
				'rule' => array('compareUnique','black_id'), 
				'message' => 'gracze nie mogą rozegrać gry ze sobą'
			),
		),
		'result' => array(
			'format' => array(
				// 'rule' => '/^([bBwW]{1}[+][0-9]{1,}[.][5])|([bBwW]{1}[+]{1}[?rR]{1})|([?]{1})$/',
				'rule' => '/(^[0-9]{1,}[.,]{1}[5]{1}$)|(^[?]{1}$)|(^[0-9]{1,}$)/',
				'message' => 'niepoprawny format wyniku',
                'allowEmpty' => true
			)
		),
		'date_played' => array(
			'rule' => array('date', 'ymd'),
			'message' => 'niepoprawny format daty (XXXX-XX-XX)',
		),
        'baduk_id' => array(
            'higher' => array(
                'rule' => array('comparison', '>', 0),
                'message' => 'ID jest większe od 0',
                'allowEmpty' => true
            ),
            'decimal' => array(
                'rule' => 'numeric',
                'message' => 'ID składa się tylko i wyłącznie z cyfr',
                'allowEmpty' => true
                )
		),
        'url' => array(
			'rule' => 'url',
			'message' => 'niepoprawny format adresu',
            'allowEmpty' => true
		),
	);

}
?>