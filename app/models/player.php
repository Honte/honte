<?php
class Player extends AppModel {
	
	var $belongsTo = array(
			'Tournament' => array('className' => 'Tournament',
								'foreignKey' => 'tournament_id',
								'dependent' => false,
								'conditions' => '',
								'order' => 'Player.rank DESC',
								'limit' => '',
								'offset' => '',
								'exclusive' => '',
								'counterCache' => true
			)
	);
		
	var $validate = array(
        'email' => array(
            'rule' => 'email',
            'message' => 'Podaj prawidłowy adres e-mail.',
            'allowEmpty' => true
        ),
        'name' => array(
            'rule' => array('minLength', 2),
            'message' => 'Imię musi posiadać co najmniej 2 znaki'
        ),
        'surname' => array(
            'rule' => array('minLength', 2),
            'message' => 'Nazwisko musi posiadać co najmniej 2 znaki'
        ),
        'rank' => array(
            'rule' => 'numeric',
            'message' => 'Podaj ranking'
        ),
        'city' => array(
            'rule' => array('minLength', 2),
            'message' => 'Nazwa miasta musi posiadać co najmniej 2 znaki'
        )
	);

	function getLastPair() {
		$player = $this->find('first', array('order' => 'pair_id desc', 'contain' => array()));
		return $player['Player']['pair_id'];
	}

	function parsePairs($results) {
		
		$pairs = array();
		foreach ($results as $i => $player) {
			$pairs[$player['Player']['pair_id']] []= $player['Player'];
		}

		return $pairs;

	}

	function savePair($pair) {

		$email = $pair['Player']['email'];
		$hash = md5(microtime());

		$pair_id = $this->getLastPair() + 1;
		
		$players = array();
		foreach ($pair['Pair'] as $p) {
			$players []= array(
				'Player' => am($p, array(
					'email' => $email,
					'pair_id' => $pair_id,
					'hash' => $hash
				))
			);
		}

		foreach ($players as $p) {
			$this->set($p);
			if (!$this->validates()) return false;
		}

		foreach ($players as $p) {
			$this->create();
			$this->save($p);
		}

		return true;
		
	}
	
}
?>