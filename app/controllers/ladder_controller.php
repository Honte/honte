<?php
class LadderController extends AppController {
	
	var $pageTitle = 'Drabinka';
	var $uses = array('Ladder', 'LadderGames', 'Member');

    var $admin_navigation = 'ladder_nav';
	var $sidebars = array('recent', 'ads', 'contact');
	var $helpers = array('DatePicker', 'LadderGame');
    var $description = 'Klubowa drabinka - wyścig goistów o najlepszego gracza w Wielkopolskim Ośrodku Go "Honte"';
	var $current = 'drabinka';

	function beforeFilter() {
		parent::beforeFilter();		
		if (empty($this->params['prefix'])) {
			$this->render(null, null, 'shutdowned');
		}
	}

	function normal() {
	
		$this->pageTitle = 'Drabinka zwykła';
		$this->sidebarInsert(array('rss_ladder'));

		$this->addBreadcrumb(array(
			'anchor' => 'Drabinka zwykła',
		));

        // wczytanie drabinki: kolejność i ostatnia aktualizacja
		$ladder = $this->Ladder->find('first', array('order' => 'created DESC'));

        // zarrayowanie kolejnosci
		$order = $this->getOrder($ladder);
        // dane graczy ktorzy biora udzial w drabince
        $players = $this->sortPlayers($order, $this->Member->collectById(array('id' => $order)));

        $games = $this->LadderGames->find('all', array('limit' => 3, 'order' => 'date_played DESC', 'conditions' => 'visible = 1'));
		
		$this->set('rank', Configure::read('Levels'));
		$this->set('order', $order);
		$this->set('players', $players);
		$this->set('games', $games);
		$this->set('ladder', $ladder);
	}

    function normal_games($player_id = null) {

        $this->pageTitle = 'Drabinka zwykła : Gry';
        $this->sidebarInsert(array('rss_ladder', 'ladder_players'));

		$this->addBreadcrumb(array(
			'anchor' => 'Drabinka zwykła',
			'link' => array('controller' => 'ladder', 'action' => 'normal')
		));

        $this->Member->contain();
        $player = $this->Member->findById($player_id);

        $list_title = 'Wszystkie gry';
        $condition = array();
        $condition['visible'] = 1;

        if (!empty($player)) {
			$condition['or'] = array(
				'black_id' => $player_id,
				'white_id' => $player_id
			);
            $player_name = $player['Member']['name'].' '.$player['Member']['surname'];
            $this->set('player_name', $player_name);

            $this->pageTitle .= ' : '.$player_name;
			$this->addBreadcrumb(array(
				'anchor' => 'Gry',
				'link' => array('controller' => 'ladder', 'action' => 'normal_games')
			));
           	$this->addBreadcrumb(array(
				'anchor' => $player_name,
			));
        }  else {
			$this->addBreadcrumb(array(
				'anchor' => 'Gry',
			));
		}

        $this->paginate = array(
			'LadderGames' => array(
				'limit' => $this->paginationLimit,
				'order' => 'date_played DESC',
                'conditions' => $condition
			)

		);

        $this->set('games', $this->paginate('LadderGames'));
    }
	
	function blitz() {
		
		$this->addBreadcrumb(array(
			'anchor' => 'Drabinka blitzowa',
		));

		$this->pageTitle = 'Drabinka blitzowa';
	}
	
	function rules() {
	
		$this->pageTitle = 'Regulamin drabinki';
	}
	
	function top_normal($top = null) {
		if (isset($this->params['requested']))	{

            if (empty($top)) {
                $top = 5;
            }

            $order = $this->getCurrentOrder($top);

            $this->Member->contain();
			$players = $this->Member->collectById(array('id' => $order));

			return $this->sortPlayers($order, $players);
		 }

         $this->redirect($this->referer());
	}

//    function recent_normal($number = null) {
//
//		if (isset($this->params['requested']))	{
//
//            if (empty($number)) {
//                $number = 3;
//            }
//
//            $order = $this->getCurrentOrder();
//
//            $this->Member->contain();
//			$players = $this->Member->collectById(array('id' => $order), $top);
//
//			return $this->sortPlayers($order, $players);
//		}
//
//        $this->redirect($this->referer());
//	}

    function commit($ladder = 'normal') {
	
        if (!empty($this->data)) {

            if ($this->data['LadderGames']['ladder'] == 0) {

                if ($this->LadderGames->save($this->data)) {
                    $this->Session->setFlash('Wysłano zgłoszenie', 'default', array('class' => 'success'));
                }

            }

            $ladder = ($this->data['LadderGames']['ladder'] < 1) ? 'normal' : 'blitz';
            unset($this->data['LadderGames']);
        }

        $ladder_type = 0;
        $conditions = array('id' => $this->getCurrentOrder());
        if ($ladder == 'normal') {
            $conditions = array('id' => $this->getCurrentOrder());
			$this->addBreadcrumb(array(
				'anchor' => 'Drabinka zwykła',
				'link' => array('controller' => 'ladder', 'action' => 'normal')
			));
        } elseif ($ladder == 'blitz') {
            $this->Session->setFlash('Tymczasowo wstrzymano drabinkę blitzową', 'default', array('class' => 'failure'));
            $this->redirect($this->referer());
            // $conditions = array('id' => $this->getCurrentOrder());;
            //$ladder_type = 1;
        }

		$this->addBreadcrumb(array(
			'anchor' => 'Formularz zgłoszenia wyniku',
		));

        $this->Member->contain();
        $this->set('players', $this->playersList($this->Member->find('all', array('conditions' => $conditions))) );
        $this->set('ladder', $ladder);
        $this->set('ladder_type', $ladder_type);
    }

    function positions_normal() {
        // Tabela pozycji - na rzecz zakładki klubowicze
        // otrzymany wynik to:
        // array(
        //  id gracza => pozycja
        // )

        if (isset($this->params['requested']))	{

            $order = array(); // przygotowanie tabeli
            $order_temp = $this->getCurrentOrder(); // pobranie aktualnej kolejnosci

            foreach ($order_temp as $key => $val) {
                $order[$val] = $key + 1;
            }

			return $order;
		}
        
        $this->redirect($this->referer());
	}

    function rss() {

        $games = $this->LadderGames->find('all', array('order' => 'date_played DESC', 'conditions' => 'visible = 1'));

        $this->set('games', $games);
        $this->layout = 'xml';
    }
	
	// -------------------------------------------------------------------------------------- dodatkowe funkcje
	
	protected function getOrder($order, $limit = null) {

        $max = (is_numeric($limit) && $limit > 0) ? null : $limit;
        return array_slice(explode(" ", $order['Ladder']['order']), 0, $limit);

	}

    protected function getCurrentOrder($limit = null) {

        $order = $this->Ladder->find('first', array('order' => 'created DESC'));
        return $this->getOrder($order, $limit);

    }

    protected function sortPlayers($order, $players_by_id) {

        $players = array();
        foreach ($order as $o) {
            if (isset($players_by_id[$o]))
            $players []= $players_by_id[$o];
        }

        return $players;
    }

    protected function sortCurrentPlayers() {

        $order = $this->getCurrentOrder();
        return $this->sortPlayers($order, $this->Member->collectById(array('id' => $order)));
    }
	
    protected function playersList($players) {

		$result = array();
		$rank = Configure::read('Levels');

		foreach ($players as $i => $player) {
			$result[$player['Member']['id']] = $player['Member']['name'].' '.$player['Member']['surname'].' ('.$rank[$player['Member']['rank']].')';
		}

		return $result;
	}

	// -------------------------------------------------------------------------------------- ADMIN SECTION
	
	function admin_index() {
		$this->paginate = array(
			'LadderGames' => array(
				'limit' => $this->paginationLimit,
				'order' => 'LadderGames.date_played DESC',
			)
		);
		
		$this->set('games',$this->paginate('LadderGames'));
		$this->set('rank', Configure::read('Levels'));
	}
	
	function admin_add_game() {
		
		$this->pageTitle = 'dodaj gre';
		
		
		if (!empty($this->data)) {
		
			if ($this->LadderGames->save($this->data)) {
				$this->Session->setFlash('dodano gre', 'default', array('class' => 'success'));
			} 	
		}
		
		$this->Member->contain();
		$players = $this->playersList($this->Member->find('all'));
		
		
		$this->set('players', $players);
		$this->set('rank', Configure::read('Levels'));
		
	}
	
	function admin_edit_game($id = null) {
		
		$this->pageTitle = 'edycja gry';
		
		
		if (!empty($this->data)) {
		
			if ($this->LadderGames->save($this->data)) {
				$this->Session->setFlash('zapisano zmiany', 'default', array('class' => 'success'));
			} 	
		}
		
		if (empty($id)) {
			$this->redirect($this->referer());
		}
		
		$game = $this->LadderGames->findById($id);
		
		if (empty($game)) {
			$this->redirect($this->referer());
		}
		
		$this->Member->contain();
		$players = $this->playersList($this->Member->find('all'));
		
		$this->data = $game;
		
		$this->set('players', $players);
		$this->set('rank', Configure::read('Levels'));
		
	}
	
	function admin_delete_game($id = null) {
		
		if (empty($id)) {
			$this->redirect($this->referer());
		}
		
		if ($this->LadderGames->delete($id)) {
			$this->Session->setFlash('skasowano gre', 'default', array('class' => 'success'));
		} else {
			$this->Session->setFlash('nie można skasować gry', 'default', array('class' => 'failure'));
		}
		
//		$this->redirect($this->referer());
	}
	
	function admin_order() {
		
		// zapisywanie nowej kolejnoĹ›ci
		
		if (!empty($this->data)) {
			
			$this->data['Ladder']['order'] = trim($this->data['Ladder']['order']);
			
			if ($this->Ladder->save($this->data)) {
				$this->Session->setFlash('zapisano nową kolejność', 'default', array('class' => 'success'));
			} else {
				$this->Session->setFlash('nie można zapisać nowej kolejności', 'default', array('class' => 'failure'));
			}
			
		}
		
		// pzygotowania widoku
		
		$ladder = $this->Ladder->find('first', array('order' => 'created DESC'));
		$order = $this->getOrder($ladder);
		
		$this->Member->contain();
		$players_temp = $this->Member->find('all');
		
		$players = $this->playersList($players_temp);
			
		$this->set('rank', Configure::read('Levels'));
		$this->set('order', $order);
	
		$this->set('players', $players);
		$this->set('ladder', $ladder);
	}

    function admin_confirm($id = null) {

        if (empty($id) || !is_numeric($id) || $id <= 0) {
            $this->Session->setFlash('niepoprawny id gry', 'default', array('class' => 'failure'));
            $this->redirect($this->referer());
        }

        $game = $this->LadderGames->findById($id);
        if (empty($game)) {
            $this->Session->setFlash('nie ma takiej gry', 'default', array('class' => 'failure'));
            $this->redirect($this->referer());
        }

        $game['LadderGames']['visible'] = 1;
        if ($this->LadderGames->save($game)) {
            $this->Session->setFlash('zatwierdzono gre', 'default', array('class' => 'success'));
        } else {
            $this->Session->setFlash('nie można zatwierdzić gry!', 'default', array('class' => 'failure'));
        }

        $this->redirect($this->referer());
    }
}
?>