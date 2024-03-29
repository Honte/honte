<?php
/**
 * Routes configuration
 *
 * In this file, you set up routes to your controllers and their actions.
 * Routes are very important mechanism that allows you to freely connect
 * different urls to chosen controllers and their actions (functions).
 *
 * PHP versions 4 and 5
 *
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright 2005-2012, Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright 2005-2012, Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @package       cake
 * @subpackage    cake.app.config
 * @since         CakePHP(tm) v 0.2.9
 * @license       MIT License (http://www.opensource.org/licenses/mit-license.php)
 */
/**
 * Here, we are connecting '/' (base path) to controller called 'Pages',
 * its action called 'display', and we pass a param to select the view file
 * to use (in this case, /app/views/pages/home.ctp)...
 */
	Router::connect('/', array('controller' => 'pages', 'action' => 'home'));
/**
 * ...and connect the rest of 'Pages' controller's urls.
 */
/**
 * Then we connect url '/test' to our test controller. This is helpful in
 * developement.
 */
    Router::connect('/sitemap.xml', array('controller' => 'sitemaps', 'action' => 'index'));
	// Router::connect('/artykuly/dodaj', array('controller' => 'articles', 'action' => 'add'));
	Router::connect('/artykuly/rss', array('controller' => 'articles', 'action' => 'rss'));
	Router::connect('/artykuly', array('controller' => 'articles', 'action' => 'index'));
	Router::connect('/artykuly/rozne', array('controller' => 'articles', 'action' => 'articles'));
	Router::connect('/artykuly/*', array('controller' => 'articles', 'action' => 'view'));
	Router::connect('/wydarzenia', array('controller' => 'articles', 'action' => 'events'));
	Router::connect('/reportaze', array('controller' => 'articles', 'action' => 'reports'));

	Router::connect('/klub', array('controller' => 'pages', 'action' => 'display', 'club'));
	Router::connect('/pomoc', array('controller' => 'pages', 'action' => 'display', 'help'));
	Router::connect('/mapastrony', array('controller' => 'pages', 'action' => 'display', 'map'));
	Router::connect('/kontakt', array('controller' => 'pages', 'action' => 'display', 'contact'));
	Router::connect('/historia', array('controller' => 'pages', 'action' => 'display', 'history'));
	Router::connect('/klubowicze', array('controller' => 'members', 'action' => 'index'));
	Router::connect('/download', array('controller' => 'downloads', 'action' => 'index'));
	// Router::connect('/czlonkowie/nowy', array('controller' => 'members', 'action' => 'add'));

	/*
	// zawieszam się :)
	Router::connect('/rejestracja', array('controller' => 'users', 'action' => 'register'));
	Router::connect('/login', array('controller' => 'users', 'action' => 'login'));
	Router::connect('/logout', array('controller' => 'users', 'action' => 'logout'));
	Router::connect('/profil/*', array('controller' => 'users', 'action' => 'profile'));
	*/
	Router::connect('/admin', array('controller' => 'administrators', 'action' => 'login', 'prefix' => 'admin'));
	Router::connect('/admin/home', array('controller' => 'administrators', 'action' => 'index', 'prefix' => 'admin'));
	Router::connect('/admin/logout', array('controller' => 'administrators', 'action' => 'logout', 'prefix' => 'admin'));
	Router::connect('/admin/login', array('controller' => 'administrators', 'action' => 'login', 'prefix' => 'admin'));

	Router::connect('/galerie', array('controller' => 'galleries', 'action' => 'index'));

	Router::connect('/drabinka', array('controller' => 'ladder', 'action' => 'normal'));
	Router::connect('/drabinka/zwykla/gry/rss', array('controller' => 'ladder', 'action' => 'rss'));
    Router::connect('/drabinka/zglos-wynik', array('controller' => 'ladder', 'action' => 'commit'));
	Router::connect('/drabinka/zwykla', array('controller' => 'ladder', 'action' => 'normal'));
	Router::connect('/drabinka/zwykla/gry', array('controller' => 'ladder', 'action' => 'normal_games'));
	Router::connect('/drabinka/zwykla/gry/*', array('controller' => 'ladder', 'action' => 'normal_games'));
    Router::connect('/drabinka/zwykla/zglos-wynik', array('controller' => 'ladder', 'action' => 'commit', 'normal'));
	Router::connect('/drabinka/blitz', array('controller' => 'ladder', 'action' => 'blitz'));
	Router::connect('/drabinka/blitz/gry', array('controller' => 'ladder', 'action' => 'blitz_games'));
	Router::connect('/drabinka/blitz/gry/*', array('controller' => 'ladder', 'action' => 'blitz_games'));
    Router::connect('/drabinka/blitz/zglos-wynik', array('controller' => 'ladder', 'action' => 'commit', 'blitz'));
	Router::connect('/drabinka/regulamin', array('controller' => 'pages', 'action' => 'display', 'ladder_rules'));

    Router::connect('/turnieje', array('controller' => 'tournaments', 'action' => 'index'));
    Router::connect('/turnieje/:tournament/rejestracja', array('controller' => 'players', 'action' => 'register'), array('pass' => array('tournament'), 'tournament' => '[0-9]+'));
    Router::connect('/turnieje/:tournament/lista', array('controller' => 'players', 'action' => 'view'), array('pass' => array('tournament'), 'tournament' => '[0-9]+'));
    Router::connect('/turnieje/:tournament/wyniki', array('controller' => 'tournaments', 'action' => 'results'), array('pass' => array('tournament'), 'tournament' => '[0-9]+'));
    Router::connect('/turnieje/*', array('controller' => 'tournaments', 'action' => 'view'));

	Router::connect('/spotkania', array('controller' => 'meetings', 'action' => 'week'));
	Router::connect('/spotkania/tydzien', array('controller' => 'meetings', 'action' => 'week'));
	Router::connect('/spotkania/kalendarz/*', array('controller' => 'meetings', 'action' => 'calendar'));
	Router::connect('/spotkania/spis/*', array('controller' => 'meetings', 'action' => 'all'));

    Router::connect('/online', array('controller' => 'pages', 'action' => 'display', 'online'));

	Router::connect('/pages/*', array('controller' => 'pages', 'action' => 'display'));
	// Router::connect('/tests', array('controller' => 'tests', 'action' => 'index'));
