<?php
class PagesController extends AppController {

	var $name = 'Pages';
	var $uses = array('Page');

    var $admin_navigation = 'pages_nav';

	// TODO: mały kontakt
	
	function home() {
		
		$this->current = "strona-glowna";
		
//		$this->Navigation->deleteAll("1 = 1");
//		$this->Navigation->loadData($this->Navigation->defaultData);

        $this->sidebars = array('meeting', 'contact', 'events', 'recent', 'ads');

		$this->pageTitle = 'Strona główna';
		$this->render('home');
	}
	
	function display() {
		$path = func_get_args();

		if (!count($path)) {
			$this->redirect('/');
		}
		
		$count = count($path);
		$label = $subpage = $title = null;

		if (!empty($path[0])) {
			$label = $path[0];
		}
		
		$page = $this->Page->findByLabel($label);
		
		$this->pageTitle = $page['Page']['title'];
		if (!empty($page['Page']['menu'])) {
			
			$this->current = $page['Page']['menu'];			

			if ($this->current == 'drabinka') $this->addBreadcrumb(array(
					'anchor' => 'Drabinka',
					'link' => array('controller' => 'ladder', 'action' => 'normal')
			));

			$this->addBreadcrumb(array(
					'anchor' => $page['Page']['title']
			));
		}
		
		$this->set('page', $page);
		
		$this->render('show');
	}

    function render_list() {
        if (isset($this->params['requested'])) {
            return $this->Page->find('all', array('order' => 'title ASC'));
        }
    }
	
	// -------------------------------------------------------------------------------------- ADMIN SECTION
	
	function admin_index() {
		
//		$this->paginate = array(
//			'Page' => array(
//				'limit' => $this->paginationLimit,
//				'order' => 'title ASC'
//			)
//		);
//
//		$pages = $this->paginate('Page');
//
//		$this->set('pages',$pages);

        $this->redirect(array('controller' => 'pages', 'action' => 'edit', 'prefix' => 'admin', 1));
		
	}
	
	function admin_edit($id = null) {
	
		if (!empty($this->data)) {
			
			if ($this->Page->save($this->data)) {
				$this->Session->setFlash('zapisano zmiany', 'default', array('class' => 'success'));
			} else {
                $this->Session->setFlash('błąd walidacji', 'default', array('class' => 'failure'));
            }
			
		} 
		
		if (empty($id)) {
			$this->redirect($this->referer());
		}
		
		$page = $this->Page->findById($id);
		
		if (empty($page)) {
			$this->redirect($this->referer());
		}
		
		$this->data = $page;
	
	}

	function admin_add() {
	
		if (!empty($this->data)) {
			
			if ($this->Page->save($this->data)) {
				$this->Session->setFlash('dodano strone', 'default', array('class' => 'success'));
			}
			
		} 
		
	
	}
}
?>