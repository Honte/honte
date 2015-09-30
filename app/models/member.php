<?php
class Member extends AppModel {

    var $actsAs = array('Upload');

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
		'city' => array(
			'rule' => array('minLength', 2), 
			'message' => 'niepoprawne miasto (min. 2 znaki)'
		),
        'baduk_tag' => array(
			'rule' => '/[a-zA-Z0-9-_ +]/',
			'message' => 'niepoprawny tag',
			'allowEmpty' => true
		),
        'egd' => array(
			'rule' => '/^[0-9]{8}$/',
			'message' => 'niepoprawne id (8 cyfr) ',
			'allowEmpty' => true
		)
	);

    function collectById($conditions = null, $limit = null) {

        if (empty($conditions)) {
            $conditions = '1 = 1';
        }

        $members_temp = $this->find('all', array(
                'conditions' => $conditions,
                'limit' => $limit
        ));

        $members = array();
        foreach ($members_temp as $member) {
            $members[$member['Member']['id']] = $member;
        }

        return $members;

    }
	
	
}
?>