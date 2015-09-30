<?php
class PhotosController extends AppController {
	
	var $pageTitle = 'Zdjęcia';
    var $admin_navigation = 'article_nav';

    function getRandom($number = null) {
        if (isset($this->params['requested'])) {

            $number = ($number > 0) ? 5 : $number;
            $photos = $this->Photo->find('all', array('limit' => $number, 'order' => 'RAND()', 'conditions' => array('article_id' => null)));
            return $photos;

        }

        $this->redirect($this->referer());
    }

    function ajax_order() {
        Configure::write("debug", 0);
        $this->autoRender = false;

        $fails = 99;
        if (!empty($this->data['Photos'])) {
            $fails = 0;
            foreach ($this->data['Photos'] as $photo) {
                if (!$this->Photo->save($photo)) {
                    $fails++;
                }
            }
        }

        echo $fails;
    }

    function ajax_edit() {
        Configure::write("debug", 0);
        $this->autoRender = false;

        if ( (!empty($this->params['form']['photo_id'])) && (!empty($this->params['form']['photo_desc']))) {
            
            $photo = array();
            $photo['Photo']['id'] = $this->params['form']['photo_id'];
            $photo['Photo']['description'] = $this->params['form']['photo_desc'];
            if ($this->Photo->save($photo)) {
                $result = array(
                    'id' => $photo['Photo']['id'],
                    'desc' => $photo['Photo']['description']
                );
                echo $this->json->encode($result);
            } else {
                echo -1;
            }
        }

    }

    function ajax_delete() {
        Configure::write("debug", 0);
        $this->autoRender = false;

        if (!empty($this->params['form']['photo_id'])) {

            $id = $this->params['form']['photo_id'];
            if ($this->Photo->delete($id)) {
                echo $id;
            } else {
                echo -1;
            }
        }
    }

    function ajax_add() {
        Configure::write("debug", 0);
        $this->layout = 'ajax';

        $this->set('id', $this->params['form']['article_id']);

    }

    function ajax_main_add() {
        Configure::write("debug", 0);
        $this->autoRender = false;

        $this->set('photo', null);
        $this->set('success', 0);
    }

    // admin section

	function admin_add($article_id = null) {
		
		if (!empty($this->data)) {

            if ($this->Photo->save($this->data)) {
                $this->Session->setFlash('Dodano zdjęcie', 'default', array('class' => 'success'));
                $this->redirect($this->referer());
            }

		}
		
        $articles = $this->Photo->Article->find('list', array('fields' => array('Article.id', 'Article.title'), 'order' => 'title ASC'));

        $this->set('articles', $articles);
        $this->data['Photo']['article_id'] = $article_id;

	}
	
	function admin_ajax_add() {
		
		$this->autoRender = false;
		
		pr($this->data);
	}
	
	function edit() {
	}
	
	function admin_delete($id = null) {
		
		if (empty($id)) {
			$this->redirect($this->referer());
		}
		
		if ($this->Photo->delete($id)) {
			$this->Session->setFlash('skasowano zdjęcie', 'default', array('class' => 'success'));
		} else {
			$this->Session->setFlash('nie można skasować zdjęcia', 'default', array('class' => 'failure'));
		}
		
		$this->redirect($this->referer());
	}
	
}
?>