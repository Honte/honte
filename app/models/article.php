<?php
class Article extends AppModel {
	
	var $belongsTo = array(
			'Category' => array('className' => 'Category',
								'foreignKey' => 'category_id',
								'dependent' => false,
								'conditions' => '',
								'order' => '',
								'limit' => '',
								'offset' => '',
								'exclusive' => '',
			),
			'User' => array('className' => 'User',
								'foreignKey' => 'user_id',
								'dependent' => false,
								'conditions' => '',
								'order' => '',
								'limit' => '',
								'offset' => '',
								'exclusive' => '',
			)
	);
	
	var $hasMany = array(
			'Photo' => array('className' => 'Photo',
								'foreignKey' => 'article_id',
								'dependent' => false,
								'conditions' => '',
								'fields' => '',
								'order' => 'Photo.order ASC',
								'limit' => '',
								'offset' => '',
								'exclusive' => '',
								'finderQuery' => '',
								'counterQuery' => '',
                                'counterCache' => true
			)
	);
		
	var $validate = array(
		'title' => array(
			'rule' => array('minLength', 3), 
			'message' => 'niepoprawny tytuł (min. 3 znaki)'
		),
		'content' => array(
			'rule' => array('minLength', 3), 
			'message' => 'Treść powinna zawierać co najmniej 3 zanki'
		)
	);

    function beforeSave() {
        if (empty($this->data['Article']['label'])) {
            
            $label = $this->labelize($this->data['Article']['title']);

            $this->contain();
            $other = $this->find('all', array('conditions' => array('label LIKE' => '%'.$label.'%')));

            if (empty($other)) {
                $this->data['Article']['label'] = $label;
            } else {
                $this->data['Article']['label'] = $label.'-'.date("d-m-Y", strtotime($this->data['Article']['created']));
            }

        }

        return true;
    }

}
?>