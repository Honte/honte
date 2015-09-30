<?php
class Photo extends AppModel {
	
	// utf w/o bom trick: ą
	var $actsAs = array('Upload'); 
	
	var $belongsTo = array(
			'Article' => array('className' => 'Article',
								'foreignKey' => 'article_id',
								'dependent' => false,
								'conditions' => '',
								'order' => 'Photo.order ASC',
								'limit' => '',
								'offset' => '',
								'exclusive' => '',
								'counterCache' => true
			)
	);
		
	// var $validate = array(
		// 'email' => array('rule' => 'email', 'message' => 'Prosze podac prawidlowy adres email'),
	// );
	
	
}
?>