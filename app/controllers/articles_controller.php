<?php
class ArticlesController extends AppController {
	
	var $recentLimit = 6;
	var $pageTitle = 'Artykuły';
	var $uses = array('Article');
    var $admin_navigation = 'article_nav';
	var $current = 'artykuly';

	function index() {
		
        $this->sidebarInsert(array('rss_article'));
		$this->sidebarRemove('recent');
        $this->description = 'Artykuły, reportaże, wrażenia - wszystko o Go z punktu widzenia Wielkopolskiego Ośrodka Go';
		$this->addBreadcrumb(array(
			'anchor' => 'Artykuły',
		));
        
		$this->paginate = array(
			'Article' => array(
				'limit' => $this->paginationLimit,
				'contain' => array('Category', 'User.login', 'Photo'),
				'order' => 'Article.created DESC'
			)
		);
		
		$articles = $this->paginate('Article');
		$this->set('articles',$articles);
	}

    function rss() {

        $this->Article->contain('Category', 'User.login', 'Photo');
        $articles = $this->Article->find('all', array('order' => 'Article.created DESC'));

        $this->set('articles', $articles);
        $this->layout = 'xml';

    }
	
	function articles() {

		$this->pageTitle = 'Różne artykuły';
        $this->sidebarInsert(array('rss_article'));
        $this->description = 'Artykuły o Go - dlaczego ta gra jest taka fajna';

		$this->addBreadcrumb(array(
			'anchor' => 'Artykuły',
			'link' => array('controller' => 'articles', 'action' => 'index')
		));
		$this->addBreadcrumb(array(
			'anchor' => 'Różne',
		));
		
		$this->paginate = array(
			'Article' => array(
				'limit' => $this->frontPaginationLimit,
				'contain' => array('Category', 'User.login', 'Photo'),
				'conditions' => 'category_id = 1',
				'order' => 'Article.created DESC'
			)
		);
		
		$articles = $this->paginate('Article');
		$this->set('articles',$articles);
		
		$this->render('index');
	}
	
	function reports() {
	
		$this->pageTitle = 'Reportaże';
        $this->sidebarInsert(array('rss_article'));
        $this->description = 'Relacje z imprez goistycznych organizowanych w Poznaniu oraz z wyjazdów naszych klubowiczów na ogólnopolskie turnieje';

		$this->addBreadcrumb(array(
			'anchor' => 'Artykuły',
			'link' => array('controller' => 'articles', 'action' => 'index')
		));
		$this->addBreadcrumb(array(
			'anchor' => 'Reportaże',
		));
		
		$this->paginate = array(
			'Article' => array(
				'limit' => $this->frontPaginationLimit,
				'contain' => array('Category', 'User.login', 'Photo'),
				'conditions' => 'category_id = 2',
				'order' => 'Article.created DESC'
			)
		);
		
		$articles = $this->paginate('Article');
		$this->set('articles',$articles);
		
		$this->render('index');
	}
	
	function events() {
		$this->pageTitle = 'Wydarzenia';
        $this->sidebarInsert(array('rss_article'));
        $this->description = 'Zapowiedzi nadchodzących wydarzeń goistycznych w Poznaniu i okolicach';

		$this->addBreadcrumb(array(
			'anchor' => 'Artykuły',
			'link' => array('controller' => 'articles', 'action' => 'index')
		));
		$this->addBreadcrumb(array(
			'anchor' => 'Wydarzenia',
		));

		$this->paginate = array(
			'Article' => array(
				'limit' => $this->frontPaginationLimit,
				'contain' => array('Category', 'User.login', 'Photo'),
				'conditions' => 'category_id = 3',
				'order' => 'Article.created DESC'
			)
		);
		
		$articles = $this->paginate('Article');
		$this->set('articles',$articles);
		
		$this->render('index');
	}
	
	function home() {
		
		// jeśli jest wywołanie z widoku
		if (isset($this->params['requested']))	{
			
			// pobranie artykułow dla których jest podana kolejność wyświetlania na głównej stronie
			$this->Article->contain('Category', 'User.login', 'Photo');
			$articles = $this->Article->find("all", array('conditions' => 'main_page > 0', 'order' => 'main_page ASC'));
			return $articles;
		} else {
			// przekierowanie do głównej
			$this->redirect('/');
		}
	}
	
	function recent() {
		
		// jeśli jest wywołanie z widoku
		if (isset($this->params['requested']))	{
			
			// pobranie artykułow dla których jest podana kolejność wyświetlania na głównej stronie
			$this->Article->contain();
			$articles = $this->Article->find("all", array('order' => 'created DESC', 'limit' => $this->recentLimit));
			return $articles;
		} else {
			// przekierowanie do głównej
			$this->redirect('/');
		}
	}
	
	function view($label = null)  {
		
		// redirect gdy nie podano id
		if (empty($label)) {
			$this->redirect($this->referer());
		}
		
		$this->Article->contain('Category', 'User.login', 'Photo');

        if (is_numeric($label)) {
            $article = $this->Article->findById($label);
        } else {
            $article = $this->Article->findByLabel($label);
        }

        if (empty($article)) {
            $this->redirect($this->referer());
        } else if ($article['Category']['title'] === "Turniej") {
            $this->redirect(array(
                'controller' => 'tournaments',
                'action' => 'view',
                strip_tags($article['Article']['content'])
            ));
        }

		$this->addBreadcrumb(array(
			'anchor' => 'Artykuły',
			'link' => array('controller' => 'articles', 'action' => 'index')
		));
		$this->addBreadcrumb(array(
			'anchor' => $article['Category']['title'],
			'link' => array('controller' => 'articles', 'action' => $article['Category']['action'])
		));
		$this->addBreadcrumb(array(
			'anchor' => $article['Article']['title'],
			//'link' => array('controller' => 'articles', 'action' => 'view', $article['Article']['label'])
		));

        $this->pageTitle = $article['Article']['title'];
        $this->description = $article['Category']['name'].' - '.$article['Article']['title'];
		
		$this->set('article', $article);
		
	}
	
	// -------------------------------------------------------------------------------------- ADMIN SECTION
	
	function admin_index() {
		
		$this->paginate = array(
			'Article' => array(
				'limit' => $this->paginationLimit,
				'order' => 'Article.created DESC'
			)
		);
		
		$articles = $this->paginate('Article');
		
		$this->set('articles',$articles);
	}
	
	function admin_add() {
	
		if (!empty($this->data)) {
			
			if ($this->Article->save($this->data)) {
				$this->Session->setFlash('dodano artykuł', 'default', array('class' => 'success'));
				$this->redirect('/admin/articles/');
			}
			
		} 
	
		$categories = $this->Article->Category->find('list', array('fields' => array('id', 'name')));
		$this->set('categories', $categories);
	}
	
	function admin_edit($id = null) {
        
		if (!empty($this->data)) {
			
			if ($this->Article->save($this->data)) {
				
                $this->Session->setFlash('zapisano zmiany', 'default', array('class' => 'success'));
				// $this->redirect('/admin/articles/');
			}


			
		} 
		
		if (empty($id)) {
			$this->redirect($this->referer());
		}
		
		$article = $this->Article->findById($id);
		
		if (empty($article)) {
			$this->redirect($this->referer());
		}
		
		$this->data = $article;
	
		$categories = $this->Article->Category->find('list', array('fields' => array('id', 'name')));
		$this->set('categories', $categories);
	}
	
	function admin_delete($id = null) {
		
		if (empty($id)) {
			$this->redirect($this->referer());
		}
		
		if ($this->Article->delete($id)) {
			$this->Session->setFlash('skasowano artykuł', 'default', array('class' => 'success'));
		} else {
			$this->Session->setFlash('nie można skasować artykułu', 'default', array('class' => 'failure'));
		}
		
		$this->redirect($this->referer());
	}
	
	function admin_home() {
	
	}
	
}
?>