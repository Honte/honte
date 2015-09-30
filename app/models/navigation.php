<?php
class Navigation extends AppModel {
	var $useTable = 'navigation';
	var $actsAs = array('Tree');
	var $order = 'Navigation.order ASC';
	
	var $defaultData = array(
	array(
		'anchor' => 'Strona główna',
		'link' => '/',
		'title' => 'Powrót na stronę główną',
		'chidlren' => array()
	),
	array(
		'anchor' => 'Klub',
		'link' => array('controller' => 'pages', 'action' => 'display', 'club'),
		'title' => 'Informacje o klubie',
		'children' => array(
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
				'anchor' => 'Materiały',
				'link' => array('controller' => 'download', 'action' => 'index'),
				'title' => 'Polecane materiały do Go'
			),
		)
	),
	array(
		'anchor' => 'Turnieje',
		'link' => array('controller' => 'tournaments', 'action' => 'index'),
		'title' => 'Turnieje organizowane przez Wielkopolski Ośrodek Go',
		'children' => array()
	),
	array(		
		'anchor' => 'Galerie',
		'link' => array('controller' => 'galleries', 'action' => 'index'),
		'title' => 'Fotoreportaże z wydarzeń goistycznych',
		'children' => array()
			
	),
//	array(
//		'anchor' => 'Drabinka',
//		'link' => array('controller' => 'ladder', 'action' => 'normal'),
//		'title' => 'Tabela i wyniki wewnętrznej rywalizacji klubowiczów',
//		'children' => array(
//			array(
//				'anchor' => 'Drabinka zwykła',
//				'link' => array('controller' => 'ladder', 'action' => 'normal'),
//				'title' => 'Tabela i wyniki wewnętrznej rywalizacji klubowiczów'
//			),
//			array(
//				'anchor' => 'Drabinka blitzowa',
//				'link' => array('controller' => 'ladder', 'action' => 'blitz'),
//				'title' => 'Tabela i wyniki gier drabinki blitzowej'
//			),
//			array(
//				'anchor' => 'Regulamin',
//				'link' =>  array('controller' => 'pages', 'action' => 'display', 'ladder_rules'),
//				'title' => 'Regulamin drabinki'
//			),
//			array(
//				'anchor' => 'Zgłoszenie wyniku',
//				'link' => array('controller' => 'ladder', 'action' => 'commit'),
//				'title' => 'Formularz zgłaszania wyniku rozegranego pojedynku'
//			),
//		))
	);
	
	public function  beforeSave($options = array()) {
		if (isset($this->data['Navigation'])) {
			// serializing php array
			if (isset($this->data['Navigation']['link'])) {
				$this->data['Navigation']['link'] = serialize($this->data['Navigation']['link']);
			}
		} else {
			if (isset($this->data['link'])) {
				$this->data['link'] = serialize($this->data['link']);
			}
		}
		return true;
	}

	public function afterFind($results, $primary = false) {
		if (isset($results['Navigation'])) {
			if (!empty($results['Navigation']['link'])) {
				$results['Navigation']['link'] = unserialize($results['Navigation']['link']);
			}
		} else {
			foreach ($results as $k => &$v) {
				if (isset($v['Navigation'])) {
					if (!empty($v['Navigation']['link'])) {
						$v['Navigation']['link'] = unserialize($v['Navigation']['link']);
					}
				}
				if (isset($v['link']) && !empty($v['link'])) {
					$v['link'] = unserialize($v['link']);
				}
			}
		}
		return $results;
	}
	
	public function addNavigation($name, $anchor, $link, $title, $class, $parent = false) {
		$this->create();
		if ($parent && !is_numeric($parent)) $parent = $this->field('id', array('Navigation.name' => $parent));
		return $this->save(array('Navigation' => array(
			'name' => $name,
			'anchor' => $anchor,
			'link' => $link,
			'title' => $title,
			'class' => $class,
			'parent_id' => !empty($parent) ? $parent : null
		)));
	}
	
	public function loadData($array, $parent = null) {
		foreach ($array as $el) {
			if (isset($el['Navigation'])) $el = $el['Navigation'];
					
			if (!isset($el['name']) || empty($el['name'])) {
				$el['name'] = low(Inflector::slug($el['anchor'], "-"));
			}
			
			if (!isset($el['class'])) {
				$el['class'] = "n-" . low(Inflector::slug($el['anchor'], "-"));
			}
			
			if (!isset($el['title'])) {
				$el['title'] = $el['anchor'];
			}
			
			$el['parent_id'] = empty($parent) ? false : $parent;
			
			if ($this->addNavigation(
					$el['name'], 
					$el['anchor'], 
					$el['link'], 
					$el['title'], 
					$el['class'],
					$el['parent_id']
			)) {
				if (!empty($el['children'])) {
					$this	->loadData($el['children'], $this->id);
				}
			}
		}
	}
	
}
?>