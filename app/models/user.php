<?php
class User extends AppModel {

	var $name = 'User';
	var $useTable = 'users';
	// var $actsAs = array('Upload'); 
	
	var $hasMany = array(
			'Article' => array('className' => 'Article',
								'foreignKey' => 'category_id',
								'dependent' => false,
								'conditions' => '',
								'fields' => '',
								'order' => '',
								'limit' => '',
								'offset' => '',
								'exclusive' => '',
								'finderQuery' => '',
								'counterQuery' => ''
			)
	);
	
	var $validate = array(
		'login' => array(
			'unique' => array('rule' => 'isUnique', 'message' => 'ten login jest już zajęty'),
			'minlength' => array('rule' => array('minLength', '3'), 'message' => 'nazwa użytkownika musi mieć długość co najmniej 3 znaków.'),
			'alphanumeric' => array('rule' => 'alphaNumeric', 'message' => 'nazwa użytkownika może składać się wyłącznie z liter i cyfr.'),
		),
		'email' => array(
			'email' => array('rule' => 'email', 'message' => 'proszę podać prawidłowy adres email'),
		),
		'my_email' => array(
			'email' => array('rule' => 'email', 'message' => 'Proszę podać prawidłowy adres email'),
		),

		'oldPassword' => array('rule' => array('passwordMatch'), 'message' => 'nieprawidłowe hasło.'),

		'password' => array(
			'repeatPassword' => array('rule' => array('compareData','repeatPassword'), 'message' => 'hasło i jego powtorzenie muszą być identyczne'),
			'minlength' => array('rule' => array('minLength', '6'), 'message' => 'hasło musi składać się z co najmniej 6 znaków.'),
		),
		
		'rulesAgreement' =>  array('rule' => array('comparison','==','1'), 'message' => 'Wymagana jest akceptacja regulaminu'),
		'privacyAgreement' =>  array('rule' => array('comparison','==','1'), 'message' => 'Wymagana jest akceptacja oświadczenia')
		
	);
	
}
?>