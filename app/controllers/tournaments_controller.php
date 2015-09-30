<?php
/**
 * @property Tournament $Tournament
 */
class TournamentsController extends AppController {

    var $name = 'Tournaments';
    var $uses = array('Tournament');
    var $helpers = array('Registering', 'DatePicker');

    var $admin_navigation = 'tournaments_nav';
    var $pageTitle = 'Turnieje Go w Poznaniu';
    var $description = 'Turnieje Go organizowane przez Poznański klub Go - informacja i rejestracja na turnieje.';
    var $current = 'turnieje';

    var $routeAdminIndex = array('controller' => 'tournaments', 'prefix' => 'admin', 'action' => 'index');

    function beforeRender() {

//        $this->AddBreadcrumb(array(
//            'Artykuły' => array('controller' => 'articles', 'action' => 'index')
//        ));
        parent::beforeRender();

    }

    function beforeFilter() {
        parent::beforeFilter();
    }

    function index() {

        $this->addBreadcrumb(array(
            'anchor' => 'Turnieje',
        ));

        $this->paginate = array(
            'Tournament' => array(
                'contain' => array(),
                'order' => 'start DESC',
                'limit' => $this->paginationLimit
            )
        );

        $this->set('tournaments', $this->paginate('Tournament'));
    }

    function view($id = null) {

        $this->addBreadcrumb(array(
            'anchor' => 'Turnieje',
            'link' => array('controller' => 'tournaments', 'action' => 'index')
        ));

        $tournament = $this->Tournament->findById($id);
        if (empty($tournament)) {
            $this->Session->setFlash('Nie znaleziono turnieju', 'default', array('class' => 'failure'));
            $this->redirect(array('controller' => 'tournaments'));
        }
        $this->addBreadcrumb(array(
            'anchor' => $tournament['Tournament']['title'],
        ));

        $players = $this->Tournament->Player->getRegisteredPlayers(
            $tournament['Tournament']['id'],
            $tournament['Tournament']['max_players']
        );

        $this->set('players', $players);

        $this->pageTitle = "Turniej Go : ".$tournament['Tournament']['title'];
        $this->description = $tournament['Tournament']['short'];

        $this->set('tournament', $tournament);
    }

    function get($id) {
        if (isset($this->params['requested']))  {
            return $this->Tournament->findById($id);
        } else {
            $this->redirect(array('controller' => 'tournaments', 'action' => 'index'));
        }
    }
    
    function results($id = null) {

        $this->addBreadcrumb(array(
            'anchor' => 'Turnieje',
            'link' => array('controller' => 'tournaments', 'action' => 'index')
        ));

        $tournament = $this->Tournament->findById($id);
        if (empty($tournament)) {
            $this->Session->setFlash('Nie znaleziono turnieju', 'default', array('class' => 'failure'));
            $this->redirect(array('controller' => 'tournaments'));
        }
        $this->addBreadcrumb(array(
            'anchor' => $tournament['Tournament']['title'],
            'link' => array('controller' => 'tournaments', 'action' => 'view', $id)
        ));
        $this->addBreadcrumb(array(
            'anchor' => "Wyniki",
        ));

        $this->pageTitle = "Turniej Go : ".$tournament['Tournament']['title'] . ' - Wyniki';
        $this->description = "Wyniki turnieju " . $tournament['Tournament']['title'];

        $this->set('tournament', $tournament);
    }


    // -------------------------------------------------------------------------------------- ADMIN SECTION

    function admin_add() {

        if (!empty($this->data)) {

            //if (empty($this->data['Member']['photo']['name'])) {
            //    $this->data['Member']['photo'] = '';
            //}

            if ($this->Tournament->save($this->data)) {
                $this->Session->setFlash('dodano turniej', 'default', array('class' => 'success'));
                $this->redirect('/admin/tournaments');
            }
        }

    }

    function admin_index() {

        $this->paginate = array(
            'Tournament' => array(
                'limit' => $this->paginationLimit,
                'order' => 'Tournament.created DESC'
            )
        );

        $tournaments = $this->paginate('Tournament');

        $this->set('tournaments', $tournaments);

    }

    function admin_edit($id = null) {

        if (!empty($this->data)) {

            if ($this->Tournament->save($this->data)) {
                $this->Session->setFlash('zapisano zmiany', 'default', array('class' => 'success'));
                $this->redirect($this->routeAdminIndex);
            }

            $id = $this->data['Tournaments']['id'];
        }

        if (empty($id)) {
            $this->Session->setFlash('nie ma takiego turnieju', 'default', array('class' => 'failure'));
            $this->redirect($this->referer());
        }

        $tournament = $this->Tournament->findById($id);

        if (empty($tournament)) {
            $this->Session->setFlash('nie ma takiego turnieju', 'default', array('class' => 'failure'));
            $this->redirect($this->referer());
        }

        $this->data = $tournament;

    }

    function admin_delete($id = null) {

        if (empty($id)) {
            $this->redirect($this->referer());
        }

        if ($this->Tournament->delete($id)) {
            $this->Session->setFlash('usunięto turniej', 'default', array('class' => 'success'));
        } else {
            $this->Session->setFlash('nie można usunąć turnieju', 'default', array('class' => 'failure'));
        }

        $this->redirect($this->referer());
    }

    function admin_mail($id = null) {

        if (!empty($this->data)) {
            $id = $this->data['Tournament']['id'];
        }

        if (empty($id)) {
            $this->Session->setFlash('nie ma takiego turnieju', 'default', array('class' => 'failure'));
            $this->redirect($this->referer());
        }

        $tournament = $this->Tournament->findById($id);

        if (empty($tournament)) {
            $this->Session->setFlash('nie ma takiego turnieju', 'default', array('class' => 'failure'));
            $this->redirect($this->referer());
        }

        $players = array();
        foreach ($tournament['Player'] as $player) {
            if (!empty($player['email'])) {
                $players []= $player;
            }
        }

        if (!empty($this->data)) {
            $this->Session->setFlash('test', 'default', array('class' => 'success'));

            $failed = 0;
            foreach ($players as $player) {
                $dane = array();
                $dane['template'] = 'reminder';
                $dane['to'] = "{$player['name']} {$player['surname']} <{$player['email']}>";
                $dane['from'] = 'Wielkopolski Ośrodek Go <poznan@go.art.pl>';
                $dane['replyTo'] = 'poznan@go.art.pl';
                $dane['subject'] = 'Przypomnienie o turnieju Go';
                $dane['content'] = array('hash'  => $player['hash'],
                                         'title' => $tournament['Tournament']['title'],
                                         'message'  => $this->data['Tournament']['message']
                );


                if (!$this->sendMail($dane)) {
                    $failed += 1;
                }
            }

            if ($failed > 0) {
                $this->set('smtp-errors', $this->Email->smtpError);
                $this->Session->setFlash("Nie udało się wysłać {$failed} przypomnień", 'default', array('class' => 'failure'));
            } else {
                $this->Session->setFlash('Wysłano przypomnienie.', 'default', array('class' => 'success'));

            }
        }

        $this->set('tournament', $tournament);
        $this->set('players', $players);
    }
}