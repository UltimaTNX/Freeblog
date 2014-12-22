<?php
// user class
require 'class.phpdoquery.php';

class controller_user extends phpdoquery {
	
	public $register = array();
	
	// check if user exists
	public function is_User_Exists() {
		
		foreach( $this->register as $key => $value ) {
			if( $key === 'username' ) {
				$username = $value;
			}
			if( $key === 'email' ) {
				$email = $value;
			}
		}
		$this->table = 'users';
		$this->where = array( 'username' => $username, 'email' => $email );
		if( $this->HaveQuery() ) {
			return true;
		} else {
			return false;
		}
	}
	
	// check all input isn't empty
	public function check_User_input() {
		
		$args = array();
		
		foreach( $this->register as $key => $value ) {
			if( empty( $value ) || $value == '' ) {
				$args[] = $key;
			}
		}
		
		return $args[];
	}
	
	// check if password ...
	public function check_User_Password() {
		
		foreach( $this->register as $key => $value ) {
			if( $key === 'password' ) {
				$password = $value;
			}
			if( $key === 'password2' ) {
				$password2 = $value;
			}
		}
		if( $password != $password2 ) {
			return false;
		} else {
			return true;
		}
	}
	
	// insert new controller_user
	public function create_New_User() {
		if( $this->is_User_Exists() && $this->check_User_Password() ) {
			
			$this->table = 'users';
			$this->insert = array( 
								'username' => mysql_escape_string($_POST['username']), 
								'password' => md5($_POST['password']),
								'rules' => '5',
								'email' => mysql_escape_string($_POST['email'])
								);
			if( $this->DoInsert() ) {
				$id = mysqli_insert_id();
				// creo le sessioni
				$_SESSION['logged'] = TRUE;
				$_SESSION['user'] = $id;
				$_SESSION['rules'] = 5;
				
				return true;
			} else {
				return false;
			}
		}
	}
}