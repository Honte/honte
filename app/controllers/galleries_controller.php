<?php
class GalleriesController extends AppController {
	
	var $pageTitle = 'Galerie';
    var $admin_navigation = 'galleries_nav';
    var $description = 'Reportaże fotograficzne z wydarzeń goistycznych z obecnością naszych klubowiczów';
	var $current = "galerie";
	
    function beforeRender() {

		$this->addBreadcrumb(array(
			'anchor' => 'Galerie',
		));
		parent::beforeRender();

	}

    function index() {

		$this->paginate = array(
			'Gallery' => array(
                'limit' => $this->paginationLimit,
				'order' => 'Gallery.event_end DESC',
				'conditions' => 'Gallery.active > 0'
			)
		);
		
		$galleries = $this->paginate('Gallery');
	
		$this->set('galleries', $galleries);
	}
	
	function show($id = null) {
		
	}
	
	// -------------------------------------------------------------------------------------- ADMIN SECTION
	
	function admin_index() {
		
		$this->paginate = array(
			'Gallery' => array(
				'limit' => $this->paginationLimit,
				'order' => 'Gallery.created DESC'
			)
		);
		
		$galleries = $this->paginate('Gallery');
		
		$this->set('galleries', $galleries);
	}
	
	function admin_add() {
	
		if (!empty($this->data)) {
			
			if ($this->Gallery->save($this->data)) {
				$this->Session->setFlash('dodano galerie', 'default', array('class' => 'success'));
				$this->redirect('/admin/galleries/');
			}
			
		} 
		
		
	}
	
	function admin_edit($id = null) {
	
		if (!empty($this->data)) {
		
			if (!empty($this->data['Photo'])) {
			}
			
			if ($this->Gallery->save($this->data)) {
				$this->Session->setFlash('zapisano zmiany', 'default', array('class' => 'success'));
			}
		
		}
		
		if (empty($id)) {
			$this->redirect($this->referer());
		}
		
		$gallery = $this->Gallery->findById($id);
		
		if (empty($gallery)) {
			$this->redirect($this->referer());
		}
		
		$this->data = $gallery;
		
	}
	
	function admin_delete($id = null) {
		
		if (empty($id)) {
			$this->redirect($this->referer());
		}
		
		if ($this->Gallery->delete($id)) {
			$this->Session->setFlash('skasowano galerie', 'default', array('class' => 'success'));
		} else {
			$this->Session->setFlash('nie mo�na usun�� galerii', 'default', array('class' => 'failure'));
		}
		
		$this->redirect($this->referer());
	}
	
}
?>