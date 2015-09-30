<?php
class UsersController extends AppController {
	var $name = 'Users';

    var $admin_navigation = 'users_nav';
	
	// TODO: logowanie użytkowników - sprawdzanie aktywnośći
	// TODO: access_level użytkowników
	
	/*
	function register() { 
		
		$this->pageTitle = 'Rejestracja';
		
		if ($this->Session->check('User')) {
			$this->redirect('/users/profile');
		}
		
		if (!empty($this->data)) {
			$password = $this->User->generateHash($this->data['User']['password']);
			$this->data['User']['hash'] = $password['hash'];
			$this->data['User']['salt'] = $password['salt'];
			
			if ($this->User->save($this->data)) {
				
				// pobranie id
				$id = $this->User->id;
				$this->data['User']['id'] = $id;
				
				// zapis do sesji
				$this->Session->setFlash('dziękujemy za rejestrację', 'default', array('class' => 'success'));
				$this->Session->write('User',$this->data['User']);
				// $this->Session->write('Status',$this->userStatus($this->data['User']));
				
				// posłanie maila
				// $dane = array();
					// $dane['template'] = 'register';
					// $dane['to'] = $this->data['User']['email'];
					// $dane['from'] = Configure::read('Serwis.noreply');
					// $dane['subject'] = 'Witamy w portalu Ogłoszenia Parafialne';
					// $dane['content'] = array('login' => $this->data['User']['login'], 'email' => $this->data['User']['email'], 'password' => $this->data['User']['password'], 'link' => $link);
					// $this->sendMail($dane);
					
				
				// przekierowanie na stronę główną
				$this->redirect('/');
			}	
		} // else $this->Session->setFlash('wypełnij formularz', 'default', array('class' => 'failure'));
		
		
	}
	
	function login() {
	
		$this->User->contain();
		
		if($this->Session->check('User')) {
			$this->redirect(array('controller' => 'users', 'action' => 'profile'));
		}
		
		if (!empty($this->data)) {
			
			$userData = $this->User->findByLogin($this->data['User']['login']);
			
			if (empty($userData)) {
				$this->Session->setFlash('nieprawidłowy login i/lub hasło','default',array('class' => 'failure'));
			} else {
				
				$hash = hash('sha512',$this->data['User']['password'].$userData['User']['salt']);
					
				if ($hash == $userData['User']['hash']) {
					
					if ($this->data['User']['remember'] == '1') {
						$cookie = array();  
						$cookie['login'] = $this->data['User']['login'];
						$this->Cookie->write('User', $cookie, true, '+2 weeks');
					} else 
					{ $this->Cookie->del('User'); }
					
					$this->User->updateAll(array('last_login' => 'NOW()'), array('User.id' => $userData['User']['id']));
					
					$this->Session->setFlash('zalogowano', 'default', array('class' => 'success'));
					$this->Session->write('User', $userData['User']);
					$this->redirect('/');
				} 
				else {
					$this->Session->setFlash('nieprawidłowy login i/lub hasło','default',array('class' => 'failure'));
				}
			}
		}
	}
	
	// function resetPassword($id = null) {
		
		// if (isset($this->data['User']['email'])) {
				
			// $userData = $this->User->findByEmail($this->data['User']['email']);
		
			// if (!empty($userData)) {

				// $token = $this->User->generateShortHash(40);
				// $link = 'http://192.168.1.2'.Helper::url(array('controller' => 'users', 'action' => 'reset'),false).'/'.$token;
				// $this->data['User']['id'] = $userData['User']['id'];
				// $this->data['User']['security_hash'] = $token;
				// $tomorrow = date("Y-m-d H:i:s", mktime(date("H"), date("i"), date("s"), date("m") , date("d")+1, date("Y")));
				// $this->data['User']	['expire_date'] = $tomorrow;
				
				// if ($this->User->save($this->data, false))
				// {
					// $data = array();
					// $data['template'] = 'reset';
					// $data['to'] = $this->data['User']['email'];
					// $data['from'] = Configure::read('Serwis.noreply');
					// $data['subject'] = 'Resetowanie hasła';
					// $data['content'] = array('link' => $link);
					// if ($this->sendMail($data)) $this->Session->setFlash('Na twój adres e-mail wysłano dalsze instrukcje.','default',array('class' => 'sucess')); 
					// Log Section
					// $this->log_action($this->data['User']['id'], 'password reset');
					
				// } else $this->Session->setFlash('Nie udało się wysłać wiadomości, spróbuj jeszcze raz','default',array('class' => 'failure'));
				// $this->redirect($this->referer());
			// } else {
				// $this->User->invalidate('email', 'Nieprawidłowy adres');
				// $this->redirect($this->referer());
				// }
		// } 
	// }
	
	// function reset($token = null) {
		
		// if (isset($token)) {
				
			// $userData = $this->User->findBySecurityHash($token);
						
		
			// if (!empty($userData) && ($userData['User']['expire_date'] >= date("Y-m-d H:i:s"))) {

				// $newPasswordPlainText = $this->User->generateShortHash(8);
				// $password = $this->User->generateHash($newPasswordPlainText);
				
				// $this->data = $userData;
				// $this->data['User']['security_hash'] = '';
				// $this->data['User']['expire_date'] = '';
				// $this->data['User']['sha1_512_hash'] = $password['hash'];
				// $this->data['User']['salt'] = $password['salt'];
				
				// if ($this->User->save($this->data, false)) {
					// $data = array();
					// $data['template'] = 'reseted';
					// $data['to'] = $this->data['User']['email'];
					// $data['from'] = Configure::read('Serwis.noreply');
					// $data['subject'] = 'Twoje nowe hasło';
					// $data['content'] = array('password' => $newPasswordPlainText);
					// $this->sendMail($data);
					// $this->Session->setFlash('Na twój adres e-mail zostało wysłane nowe hasło.','default',array('class' => 'success'));
					
				// } else $this->Session->setFlash('Nie można zresetować hasła','default', array('class' => 'failure'));
				// $this->redirect('/');
			// } else {
				// $this->Session->setFlash('Nie można zresetować hasła ');
				// }
		// } 
	// }
	
	function logout() {
		$this->Cookie->del('User');
		$this->Session->delete('User');
		$this->Session->setFlash('wylogowano', 'default', array('class' => 'success'));
		$this->redirect('/');
	}
	
	// function delete() {
			
		// if (isset($this->data)) {
			
				// $user = $this->User->findByLogin($this->data['User']['login']);
				// $hash = hash('sha512',$this->data['User']['password'].$user['User']['salt']);
				// $id = $user['User']['id'];
				
				// if ( ($hash == $user['User']['sha1_512_hash']) && ($this->data['User']['email'] == $user['User']['email']) ) 
				// {
				
					// if ($this->User->del($user['User']['id']))
					// {
						// // Log Section
						// $this->log_action($id, 'deleted');

						// $this->Session->setFlash('Skasowano konto', 'default', array('class' => 'success'));
						// $this->Session->delete('User');

						// //ACL delete:
							// // znalezienie aro i aco
							// $user_acl = 'User'.$id;
							
							// if ($user_acl != 'User')
							// {
							// $aro = $this->Acl->Aro->findByAlias($user_acl);
							// $aco = $this->Acl->Aco->findByAlias($user_acl);
							// }

							// // usunięcie aro i aco
							// $this->Acl->Aro->del($aro['Aro']['id']);
							// $this->Acl->Aco->del($aco['Aco']['id']);
						// // koniec ACL

					// } else { $this->Session->setFlash('Nie można skasować konta','default',array('class' => 'failure')); }
				// } else { $this->Session->setFlash('Niepoprawne dane','default',array('class' => 'failure')); }
			// }
	// }
	
	function profile($login = null) {
		
		$current_user = false;
		
		if (empty($login)) {
			if ($this->Session->check('User')) {
				$login = $this->Session->read('User.login');
				$current_user = true;
			} else {
				$this->Session->setFlash('zaloguj się', 'default', array('class' => 'failure'));
				$this->redirect($this->referer());
			}
		}
		
		$this->User->contain();
		$user = $this->User->findByLogin(strtolower($login));
		
		if (empty($user)) {
			$this->Session->setFlash('nie ma takiego użytkownika', 'default', array('class' => 'failure'));
			$this->redirect($this->referer());
		}
		
				
		// // sprawdzenie którą zakładkę wyświetlić
		// if (isset($this->passedArgs['task'])) {
			// switch ($this->passedArgs['task']) {
				// case 'info':		$active[0] = 'active'; 
									// $content = 'user/info'; 
									// if(!empty($this->data)) $this->updateProfile($this->data);
									// break; 
				// case 'password':	$active[1] = 'active'; 
									// $content = 'user/password'; 	
									// if(!empty($this->data)) $this->changePassword($this->data);
									// break;
				// case 'parishes':	$active[2] = 'active'; 
									// $content = 'user/parishes'; 	
									// $user = $this->myParishes();
									// break;
				// case 'settings':	$active[3] = 'active'; 
									// $content = 'user/settings';
									// if(!empty($this->data)) $this->saveSettings($this->data);
									// break;
				// default: 			$active[0] = 'active'; 
									// $content = 'user/info'; 		
									
									// break;
			// }
		// } else {
			// $active[0] = 'active';
			// $content = 'user/info';
		// }
		
		// // jeśli w porządku pobranie usera z bazy danych
		// if (!isset($user)) $user = $this->User->findById($id);
		
		// // przesłanie WIELU zmiennych do widoku
		// $this->set('content', $content);
		// $this->set('active', $active);
		// $this->set('pageTitle','Profil');
		// $this->set('user',$user);
		// $this->data = $user;
	}
	
	*/
	
	// ADMIN SECTION ---------------------------------------------------------------------------------------------------------------------------------------------------------------------
	
	function admin_index() {
		
		$this->paginate = array(
			'Users' => array(
				'limit' => $this->paginationLimit,
				'order' => 'User.login DESC'
			)
		);
		
		$users = $this->paginate('User');
		
		$this->set('users',$users);
	}
	
	function admin_add() {
	
		if (!empty($this->data)) {
			
			$password = $this->User->generateHash($this->data['User']['password']);
			$this->data['User']['hash'] = $password['hash'];
			$this->data['User']['salt'] = $password['salt'];
			
			$this->User->create();
			if ($this->User->save($this->data)) {
				$this->Session->setFlash('dodano użytkownika', 'default', array('class' => 'success'));
				$this->redirect('/admin/users');
			}
			
		} 
		
	}
	
	function admin_block($id = null) {
	
		if (empty($id)) {
			$this->redirect($this->referer());
		}
		
		$user = $this->User->findById($id);
		
		if (empty($user)) {
			$this->redirect($this->referer());
		}
		
		$user['User']['active'] = 0;
		
		if ($this->User->save($user)) {
			$this->Session->setFlash('zablokowano uzytkownika '.$user['User']['login'], 'default', array('class' => ''));
		} else {
			$this->Session->setFlash('nie można zablokować użytkownika '.$user['User']['login'], 'default', array('class' => ''));
		}
		
		$this->redirect('/admin/users');
		
	}
	
	function admin_unblock($id = null) {
	
		if (empty($id)) {
			$this->redirect($this->referer());
		}
		
		$user = $this->User->findById($id);
		
		if (empty($user)) {
			$this->redirect($this->referer());
		}
		
		$user['User']['active'] = 1;
		
		if ($this->User->save($user)) {
			$this->Session->setFlash('odblokowano uzytkownika '.$user['User']['login'], 'default', array('class' => ''));
		} else {
			$this->Session->setFlash('nie można odblokować użytkownika '.$user['User']['login'], 'default', array('class' => ''));
		}
		
		$this->redirect('/admin/users');
		
	}
	
	function admin_delete($id = null) {
		
		if (empty($id)) {
			$this->redirect($this->referer());
		}
		
		if ($this->User->delete($id)) {
			$this->Session->setFlash('skasowano użytkownika', 'default', array('class' => 'success'));
		} else {
			$this->Session->setFlash('nie można skasować użytkownika', 'default', array('class' => 'failure'));
		}
		
		$this->redirect('/admin/users');
	}
}
?>