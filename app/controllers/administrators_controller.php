<?php
class AdministratorsController extends AppController {

	var $name = 'Administrators';
	var $uses = 'User';
	
	function admin_index() {
	
	}
	
	
	function admin_edit() {
	
		if (!$this->Session->check('User')) {
			
			$this->redirect('/admin');
			
		}
		
		if(!empty($this->data)) {
			
			$password = $this->User->generateHash($this->data['User']['password']);
			$this->data['User']['hash'] = $password['hash'];
			$this->data['User']['salt'] = $password['salt'];
			
			if($this->User->save($this->data))
				$this->Session->setFlash('Twoje hasło zostało zmienione!');
		} else {
		
			$this->data['User']['id'] = $this->Session->read('User.id');
		}
	}
	
	
	function admin_login() {
	
		
		$this->layout = 'login';
		$this->pageTitle = 'Logowanie';
		
		if($this->Session->check('User')) {
			
			$this->redirect('/admin/home');
			
		}
		
		if (!empty($this->data)) {
			
			$this->User->contain();
			$adminData = $this->User->findByLogin($this->data['User']['login']);
			
			if (!empty($adminData)) {
			

				$hash = hash('sha512',$this->data['User']['password'].$adminData['User']['salt']);
					
				if ($hash == $adminData['User']['hash']) {
										
					$this->Session->write('User', $adminData['User']);
					$this->redirect('/admin/home');
					
				} 
			}
		}
	}
	
	
	function admin_logout() {
	
		$this->Session->delete('User');
		$this->redirect('/admin');
	}
}
?>