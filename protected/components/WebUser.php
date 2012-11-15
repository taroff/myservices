<?php
class WebUser extends CWebUser {
	private $_sessionName = 'userRow';
	
	public function getRole() {
		return ( isset($_SESSION[$this->_sessionName]['role']) ) ? $_SESSION[$this->_sessionName]['role'] : User::ROLE_GUEST;
	}
	
	public function setUserRow( $row ) {
		$_SESSION[$this->_sessionName] = $row; 
	}
	
	public function getUserRow() {
		return $_SESSION[$this->_sessionName]; 
	}
	
	public function getUserId() {
		return ( isset($_SESSION[$this->_sessionName]['id']) ) ? $_SESSION[$this->_sessionName]['id'] : 0;		
	}
}