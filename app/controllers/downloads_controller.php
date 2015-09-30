<?php
class DownloadsController extends AppController {

	var $name = 'Downloads';
	var $uses = array('Download');
    var $helpers = array('Download');

    var $admin_navigation = 'download_nav';
    var $pageTitle = 'Dział Download';
    var $description = 'Materiały o Go do ściągnięcia zebrane przez klubowiczów Honte';
	var $current = 'artykuly';

    function beforeRender() {

		$this->addBreadcrumb(array(
			'anchor' => 'Download',
		));
		parent::beforeRender();

	}

    function index() {

        $this->paginate = array(
            'Download' => array(
                'limit' => $this->paginationLimit,
                'order' => 'created DESC'
            )
        );

        $files = $this->paginate('Download');
        $this->set('files', $files);
    }


    // admin section

    function admin_index() {

    }

    function admin_add() {

    }

    function admin_edit($id = null) {
        
    }
}
?>