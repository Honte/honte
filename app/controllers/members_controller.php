<?php
class MembersController extends AppController {
	
	var $uses = array('Member');

    var $admin_navigation = 'members_nav';
	var $pageTitle = 'Klubowicze';
    var $description = 'Lista klubowiczów Wielkopolskiego Ośrodka Go w Poznaniu';
	var $current = "klub";

	function beforeRender() {
		
		$this->addBreadcrumb(array(
			'anchor' => 'Klub',
			'link' => array('controller' => 'pages', 'action' => 'display', 'club'),
		));
		$this->addBreadcrumb(array(
			'anchor' => 'Klubowicze'
		));
		parent::beforeRender();
		
	}	
	
	// -------------------------------------------------------------------------------------- LISTA CZŁONKÓW
	
	function index() {

		$this->paginate = array(
			'Member' => array(
                'contain' => '',
				'order' => 'rank DESC, surname ASC',
                'limit' => (4 * $this->paginationLimit)
				)
		);
		
		$members = $this->paginate('Member');
		$rank = Configure::read('Levels');
		
		$this->set('members', $members);
		$this->set('rank', $rank);
		
	}
	
	// -------------------------------------------------------------------------------------- ADMIN SECTION
	
	function admin_add() {
		
		if (!empty($this->data)) {

            //if (empty($this->data['Member']['photo']['name'])) {
            //    $this->data['Member']['photo'] = '';
            //}

			if ($this->Member->save($this->data)) {
                $this->Session->setFlash('dodano klubowicza', 'default', array('class' => 'success'));
				$this->redirect('/admin/members');
			}
		}
		
		$rank = Configure::read('Levels');
		$this->set('rank', $rank);
	}
	
	function admin_index() {
		
		$this->paginate = array(
			'Member' => array(
				'limit' => $this->paginationLimit,
				'order' => 'Member.rank DESC'
			)
		);
		
		$members = $this->paginate('Member');
		$rank = Configure::read('Levels');
		
		$this->set('members',$members);
		$this->set('rank',$rank);
		
	}

	function admin_edit($id = null) {
		
		if (!empty($this->data)) {

            //if (empty($this->data['Member']['photo']['name'])) {
            //    unset($this->data['Member']['photo']);
            //}

			if ($this->Member->save($this->data)) {
                $this->Session->setFlash('zapisano zmiany', 'default', array('class' => 'success'));
				$this->redirect('/admin/members');
			}
			
			$id = $this->data['Member']['id'];
		}
		
		if (empty($id)) {
			$this->Session->setFlash('nie ma takiego klubowicza', 'default', array('class' => 'failure'));
			$this->redirect($this->referer());
		}
		
		$member = $this->Member->findById($id);
		
		if (empty($member)) {
			$this->Session->setFlash('nie ma takiego klubowicza', 'default', array('class' => 'failure'));
			$this->redirect($this->referer());
		}
		
		$this->data = $member;
		$rank = Configure::read('Levels');
		$this->set('rank', $rank);
		
	}
	
	function admin_delete($id = null) {
		
		if (empty($id)) {
			$this->redirect($this->referer());
		}
		
		if ($this->Member->delete($id)) {
			$this->Session->setFlash('usunięto klubowicza', 'default', array('class' => 'success'));
		} else {
			$this->Session->setFlash('nie można usunąć klubowicza', 'default', array('class' => 'failure'));
		}
		
		$this->redirect($this->referer());
	}

    function admin_remove_photo($id = null) {

        if (!empty($id)) {

            $member = $this->Member->findById($id);

            if (!empty($member)) {
                $member['Member']['photo'] = '';
                // usunięcie pliku
                if ($this->Member->save($member)) {
                    $this->Session->setFlash('usnięto zdjęcie', 'default', array('class' => 'success'));
                } else {
                    $this->Session->setFlash('nie można usunąc zdjęcia', 'default', array('class' => 'failure'));
                }
            }
            
        }

        $this->redirect($this->referer());
    }
}
?>