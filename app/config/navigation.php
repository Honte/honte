<?php $config['Navigation'] = array(
	array(
		'anchor' => 'Klub',
		'link' => array('controller' => 'pages', 'action' => 'display', 'club'),
		'title' => 'Informacje o klubie',
		'current' => true,
		'children' => array(
			array(
				'anchor' => 'Strona główna',
				'link' => '/',
				'title' => 'Powrót na stronę główną'
			),
			array(
				'anchor' => 'O klubie',
				'link' => array('controller' => 'pages', 'action' => 'display', 'club'),
				'title' => 'Informacje o klubie'
			),
			array(
				'anchor' => 'Klubowicze',
				'link' => array('controller' => 'members', 'action' => 'index'),
				'title' => 'Lista klubowiczów Wielkopolskiego Ośrodka Go'
			),
			array(
				'anchor' => 'Kontakt',
				'link' => array('controller' => 'pages', 'action' => 'display', 'contact'),
				'title' => 'Informacje kontaktowe'
			),
		)
	),
	array(
		'anchor' => 'Spotkania',
		'link' => array('controller' => 'meetings', 'action' => 'week'),
		'title' => 'Czas i miejsce spotkań klubu',
		'children' => array(
			array(
				'anchor' => 'Tydzień goisty',
				'link' => array('controller' => 'meetings', 'action' => 'week'),
				'title' => 'Tydzień poznańskiego goisty - czas i miejsce spotkań'
			),
			array(
				'anchor' => 'Kalendarz goisty',
				'link' => array('controller' => 'meetings', 'action' => 'calendar'),
				'title' => 'Kalendarz wydarzeń goistycznych'
			),
			array(
				'anchor' => 'Spis wydarzeń',
				'link' => array('controller' => 'meetings', 'action' => 'all'),
				'title' => 'Spis wydarzeń gositycznych w ciągu roku'
			),
			array(
				'anchor' => 'Turnieje',
				'link' => array('controller' => 'tournaments', 'action' => 'index'),
				'title' => 'Turnieje organizowane przez Wielkopolski Ośrodek Go'
			),
		)
	),
	array(
		'anchor' => 'Artykuły',
		'link' => array('controller' => 'articles', 'action' => 'index'),
		'title' => 'Artykuły i reportaże z działalności klubu',
		'children' => array(
			array(
				'anchor' => 'Wydarzenia',
				'link' => array('controller' => 'articles', 'action' => 'events'),
				'title' => 'Zapowiedzi nadchodzących wydarzeń goistycznych'
			),
			array(
				'anchor' => 'Reportaże',
				'link' => array('controller' => 'articles', 'action' => 'reports'),
				'title' => 'Relacje z wydarzeń goistycznych'
			),
			array(
				'anchor' => 'Różne',
				'link' => array('controller' => 'articles', 'action' => 'articles'),
				'title' => 'Różne artykuły o Go'
			),
			array(
				'anchor' => 'Galerie',
				'link' => array('controller' => 'galleries', 'action' => 'index'),
				'title' => 'Fotoreportaże z wydarzeń goistycznych'
			),
			array(
				'anchor' => 'Download',
				'link' => array('controller' => 'download', 'action' => 'index'),
				'title' => 'Polecane materiały do Go'
			),
		)
	),
	array(
		'anchor' => 'Drabinka',
		'link' => array('controller' => 'ladder', 'action' => 'normal'),
		'title' => 'Tabela i wyniki wewnętrznej rywalizacji klubowiczów',
		'children' => array(
			array(
				'anchor' => 'Drabinka zwykła',
				'link' => array('controller' => 'ladder', 'action' => 'normal'),
				'title' => 'Tabela i wyniki wewnętrznej rywalizacji klubowiczów'
			),
			array(
				'anchor' => 'Drabinka blitzowa',
				'link' => array('controller' => 'ladder', 'action' => 'blitz'),
				'title' => 'Tabela i wyniki gier drabinki blitzowej'
			),
			array(
				'anchor' => 'Regulamin',
				'link' =>  array('controller' => 'pages', 'action' => 'display', 'ladder_rules'),
				'title' => 'Regulamin drabinki'
			),
			array(
				'anchor' => 'Zgłoszenie wyniku',
				'link' => array('controller' => 'ladder', 'action' => 'commit'),
				'title' => 'Formularz zgłaszania wyniku rozegranego pojedynku'
			),
		)
	),

); ?>