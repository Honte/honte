<?php
class MppController extends AppController {

	var $name = 'Mpp';
	var $uses = array('Player');
	var $helpers = array('Registering');
	var $mpp = 3; // id turnieju mpp
	var $mpp_addon = 4; // id turnieju towarzyszacego

	var $layout = 'mpp';
    var $pageTitle = 'Turniej';
    var $description = 'Turniej o tytuł najlepszej pary grającej w Go w Polsce';

	function beforeRender() {
		parent::beforeRender();
		$this->set('mpp_id', $this->mpp);
		$this->set('mpp_addon_id', $this->mpp_addon);
	}

    function index() {

    }

	function zapisy() {

		if (!empty($this->data)) {

			if ($this->Player->savePair($this->data)) {
				$this->redirect(array('controller' => 'mpp', 'action' => 'pary'));
			}
		}

		$this->set('rank', Configure::read('Levels'));
	}

	function pary() {

		$players = $this->Player->find('all', array('conditions' => array('tournament_id' => $this->mpp), 'order' => 'rank DESC', 'contain' => array()));
		$pairs = $this->Player->parsePairs($players);

		$this->set('rank', Configure::read('Levels'));
		$this->set('pairs', $pairs);
		$this->set('pary', $this->Player->getLastPair());
	}

	function nocleg() {

	}

	function reguly() {
		
	}

	function wyniki() {

	}

	function kontakt() {

	}

}
?>