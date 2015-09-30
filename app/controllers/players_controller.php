<?php
class PlayersController extends AppController {

    var $name = 'Players';
    var $uses = array('Player');
    var $helpers = array('Registering');

    var $admin_navigation = 'tournaments_nav';
    var $pageTitle = 'Rejestracja na turnieje Go';
    var $description = 'Zapisy na turniej oraz lista zarejestrowanych graczy';
    var $current = "turnieje";

    function beforeRender() {

//        $this->AddBreadcrumb(array(
//            'Artykuły' => array('controller' => 'articles', 'action' => 'index')
//        ));
        parent::beforeRender();

    }

    function beforeFilter() {
        parent::beforeFilter();
    }

    function register($id = null) {

        $this->Player->Tournament->contain();
        $tournament = $this->Player->Tournament->findById($id);

        $this->addBreadcrumb(array(
            'anchor' => 'Turnieje',
            'link' => array('controller' => 'tournaments', 'action' => 'index')
        ));

        if (!empty($this->data)) {
            
            $this->data['Player']['hash'] = md5(microtime());
            if ($this->Player->save($this->data)) {

                if (!empty($this->data['Player']['email'])) {
                    $dane = array();
                    $dane['template'] = 'register';
                    $dane['to'] = $this->data['Player']['name'].' '.$this->data['Player']['surname'].' <'.$this->data['Player']['email'].'>';
                    $dane['from'] = 'Wielkopolski Ośrodek Go <poznan@go.art.pl>';
                    $dane['replyTo'] = 'poznan@go.art.pl';
                    $dane['subject'] = 'Rejestracja na turniej Go';
                    $dane['content'] = array('hash' => $this->data['Player']['hash'], 'title' => $tournament['Tournament']['title'], 'desc' => $tournament['Tournament']['short']);
                    if ($this->sendMail($dane)) {
                        $this->Session->setFlash('Zgłoszenie zostało przyjęte. W ciągu kilku minut powinna pojawić się prośba o potwierdzenie.', 'default', array('class' => 'success'));
                    } else {
                        $this->set('smtp-errors', $this->Email->smtpError);
                        $this->Session->setFlash('Zgłoszenie zostało przyjęte, nie udało się jednak wysłać wiadomości', 'default', array('class' => 'success'));
                    }
                } else {
                    $this->Session->setFlash('Zgłoszenie zostało przyjęte', 'default', array('class' => 'success'));
                }

                $this->redirect(array('controller' => 'tournaments', 'action' => 'view', $this->data['Player']['tournament_id']));

            }
        }

        if (empty($tournament)) {
            $this->Session->setFlash('Nie ma takiego turnieju', 'default', array('class' => 'failure'));
            $this->redirect($this->referer());
        }

        $this->addBreadcrumb(array(
            'anchor' => $tournament['Tournament']['title'],
            'link' => array('controller' => 'tournaments', 'action' => 'view', $tournament['Tournament']['id'])
        ));

        $this->addBreadcrumb(array(
            'anchor' => 'Rejestracja',
        ));

        if (!$tournament['Tournament']['status']) {
            $this->Session->setFlash('Turniej już się zakończył i nie prowadzi rejestracji', 'default', array('class' => 'failure'));
            $this->redirect($this->referer());
        }

        $this->pageTitle = $tournament['Tournament']['title'].' : Rejestracja';
        $this->description = $tournament['Tournament']['short'].'  - rejestracja';

        $this->set('tournament', $tournament);
        $this->set('rank', Configure::read('Levels'));
    }

    function view($id = null) {

        $this->Player->Tournament->contain();
        $tournament = $this->Player->Tournament->findById($id);
        
        $this->addBreadcrumb(array(
            'anchor' => 'Turnieje',
            'link' => array('controller' => 'tournaments', 'action' => 'index')
        ));

        if (empty($tournament)) {
            $this->Session->setFlash('Nie ma takiego turnieju', 'default', array('class' => 'failure'));
            $this->redirect(array('controller' => 'tournaments'));
        }

        $this->addBreadcrumb(array(
            'anchor' => $tournament['Tournament']['title'],
            'link' => array('controller' => 'tournaments', 'action' => 'view', $tournament['Tournament']['id'])
        ));

        $this->addBreadcrumb(array(
            'anchor' => 'Zarejestrowani',
        ));

        $players = $this->Player->getRegisteredPlayers(
            $tournament['Tournament']['id'],
            $tournament['Tournament']['max_players']
        );

        $this->pageTitle = $tournament['Tournament']['title'].' : Lista zapisanych graczy';
        $this->description = 'Lista zapisanych graczy na turniej '.$tournament['Tournament']['title'];

        $this->set('players', $players['players']);
        $this->set('reserves', $players['reserves']);
        $this->set('tournament', $tournament);
    }

    function confirm($hash = null) {

        $this->Player->contain();
        $player = $this->Player->findByHash($hash);

        if (!empty($player)) {

            if ($this->Player->updateAll(array('confirmation' => 1),array('Player.id' => $player['Player']['id']))) {
                $this->Session->setFlash('Potwierdzono obecność', 'default', array('class' => 'success'));
            } else {
                $this->Session->setFlash('Nie można potwierdzić obecności', 'default', array('class' => 'failure'));
            }
        } else {
            $this->Session->setFlash('Nie można potwierdzić obecności', 'default', array('class' => 'failure'));
        }

        $this->redirect(array('controller' => 'tournaments'));
        
    }

    function cancel($hash = null) {

        if (!empty($this->data)) {

            if (isset($this->data['cancel'])) {
                if ($this->Player->delete($this->data['Player']['id'])) {
                    $this->Session->setFlash('Usunięto wpis', 'default', array('class' => 'success'));
                } else {
                    $this->Session->setFlash('Nie można usunąć wpsiu', 'default', array('class' => 'failure'));
                }
            }

            elseif (isset($this->data['maybe'])) {
                if ($this->Player->updateAll(array('confirmation' => 0),array('Player.id' => $this->data['Player']['id']))) {
                    $this->Session->setFlash('Anulowano obecność', 'default', array('class' => 'success'));
                } else {
                    $this->Session->setFlash('Nie można anulować obecności', 'default', array('class' => 'failure'));
                }
            }

            $this->redirect(array('controller' => 'tournaments'));
        }

        $player = $this->Player->findByHash($hash);

        if (empty($player)) {
            $this->Session->setFlash('Nie odnaleziono wpisu', 'default', array('class' => 'failure'));
            $this->redirect(array('controller' => 'tournaments'));
        }

        $this->set('player', $player);
    }

    // admin section

    function admin_index() {

    }

    function admin_add() {

    }

    function admin_edit($id = null) {
        
    }

    function admin_delete($id = null) {
        if (empty($id)) {
            $this->redirect($this->referer());
        }

        if ($this->Player->delete($id)) {
            $this->Session->setFlash('usunięto gracza', 'default', array('class' => 'success'));
        } else {
            $this->Session->setFlash('nie można usunąć gracza', 'default', array('class' => 'failure'));
        }

        $this->redirect($this->referer());
    }

    function admin_tournament_players($tournamentId = null) {

        $this->Player->Tournament->contain();
        $tournament = $this->Player->Tournament->findById($tournamentId);

        if (empty($tournament)) {
            $this->Session->setFlash('Nie ma takiego turnieju', 'default', array('class' => 'failure'));
            $this->redirect(array('controller' => 'tournaments'));
        }

        $this->paginate = array(
            'Player' => array(
                 'contain' => array(),
                 'limit' => $this->paginationLimit,
                 'order' => 'created DESC',
                 'conditions' => array(
                     'Player.tournament_id' => $tournament['Tournament']['id']
                 )
            )
        );

        $this->set('players', $this->paginate('Player'));
        $this->set('rank', Configure::read('Levels'));
        $this->set('tournament', $tournament);
    }

    function admin_export($id = null, $format = null) {
        $this->Player->Tournament->contain();
        $tournament = $this->Player->Tournament->findById($id);
        
        if (empty($tournament)) {
            $this->Session->setFlash('Nie ma takiego turnieju', 'default', array('class' => 'failure'));
            $this->redirect(array('controller' => 'tournaments'));
        }
        if (!isset($format))
            $format = "macmahon";
        if ($format !== "macmahon" && $format !== "opengotha") {
            $this->Session->setFlash('Błędny format, expected: macmahon|opengotha', 'default', array('class' => 'failure'));
            $this->redirect(array('controller' => 'tournaments'));
        }

        Configure::write("debug", 0);
        $players = $this->Player->find('all',
            array(
                'contain' => array(),
                'order' => 'rank DESC, surname ASC',
                'conditions' => array(
                    'Player.tournament_id' => $tournament['Tournament']['id']
                 )
            )
        );

        $this->set('players', $players);
        $this->set('rank', Configure::read('Levels'));
        $this->layout = "vbar";
        $this->render($file = 'admin_export_'.$format);        
    }
}