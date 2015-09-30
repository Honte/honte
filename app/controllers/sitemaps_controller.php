<?php
class SitemapsController extends AppController {
	
	var $pageTitle = 'Mapa witryny';
    var $uses = array('Article', 'Member', 'Gallery', 'Ladder');

    var $statics = array(
        array('/klub', 'monthly'),
        array('/kontakt', 'monthly'),
        array('/drabinka/regulamin', 'monthly'),
        array(array('controller' => 'members', 'action' => 'index'), 'weekly'),
        array(array('controller' => 'meetings', 'action' => 'week'), 'daily'),
        array(array('controller' => 'meetings', 'action' => 'calendar'), 'daily'),
        array(array('controller' => 'meetings', 'action' => 'all'), 'daily'),
        array(array('controller' => 'articles', 'action' => 'events'), 'daily'),
        array(array('controller' => 'articles', 'action' => 'reports'), 'daily'),
        array(array('controller' => 'articles', 'action' => 'articles'), 'daily'),
        array(array('controller' => 'articles', 'action' => 'index'), 'daily'),
        array(array('controller' => 'galleries', 'action' => 'index'), 'daily'),
        array(array('controller' => 'downloads', 'action' => 'index'), 'weekly'),
        array(array('controller' => 'ladder', 'action' => 'normal'), 'daily'),
        array(array('controller' => 'ladder', 'action' => 'normal_games'), 'daily'),
        array(array('controller' => 'ladder', 'action' => 'commit'), 'monthly'),
    );

    function index() {

        $this->Article->contain('Category');
        // $this->Member->contain();
        $this->Gallery->contain();

        $galleries = $this->Gallery->find('all', array('conditions' => array('link LIKE' => '%poznan.go.art.pl%')));
        $articles = $this->Article->find('all');

        $this->layout = 'xml';
        $this->set('statics', $this->statics);
        $this->set('articles', $articles);
        $this->set('galleries', $galleries);
    }
}
?>