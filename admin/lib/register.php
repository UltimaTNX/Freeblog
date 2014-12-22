<?php
include_once '../function/function.work.php';
work();
if( isset( $_POST['submit']) && $_POST['submit'] == 'Register' ) {
	
	if( !$_POST['id'] ) {
		$create = new phpdoquery();
		// creo la tabella se non esiste
		$query = "CREATE TABLE IF NOT EXISTS `". TABLE_PREFIX ."users` (
		`id` int(11) NOT NULL AUTO_INCREMENT,
		`username` varchar(255) NOT NULL,
		`password` text NOT NULL,
		`rules` int(1) NOT NULL,
		`first_name` varchar(20) NOT NULL,
		`last_name` varchar(20) NOT NULL,
		`surname` varchar(20) NOT NULL,
		`email` text NOT NULL,
		`avatar` text NOT NULL,
		PRIMARY KEY (`id`)
		)";
		
		if( $create->FreeQuery( $query ) ) {
			unset( $create );
			if( !$_POST['password'] || !$_POST['password2'] || !$_POST['username'] || !$_POST['email'] ) {
				header( 'Location: ../login.php?error=Devi compilare tutti i campi');
				exit();
			}
			if( $_POST['password'] === $_POST['password2'] ) {
				$obj = new phpdoquery();
				$obj->table = 'users';
				$obj->insert = array( 
									'username' => $_POST['username'], 
									'password' => md5($_POST['password']),
									'rules' => '5',
									'email' => $_POST['email']
									);
				if( $obj->DoInsert() ) {
					$id = mysqli_insert_id();
					// creo le sessioni
					$_SESSION['logged'] = TRUE;
					$_SESSION['user'] = $id;
					$_SESSION['rules'] = 5;
					header( 'Location: ../../index.php' );
				} else {
					echo 'Qualcosa è andato storto, controlla la query<br>';
					$obj->Debug_DoInsert();
				}
			} else {
				header( 'Location: ../login.php?error=le password non coincidono' );
			}
		} else {
			echo 'tabella FB_posts non creata!';
		}
	} else {
		$obj = new phpdoquery();
		$obj->table = 'users';
		$obj->where = array( 'id' => $_POST['id'] );
		if( $_POST['password'] ) {
			if( $_POST['password'] === $_POST['password2'] ) {
				$obj->set = array( 
									'username' => $_POST['username'], 
									'password' => md5($_POST['password']),
									'rules' => $_POST['rules'],
									'first_name' => $_POST['first_name'],
									'last_name' => $_POST['last_name'],
									'surname' => $_POST['surname'],
									'email' => $_POST['email'],
									'avatar' => $_POST['avatar']
									);
				if( $obj->DoInsert() ) {
					header( 'Location: ../user.php?id='.$_POST['id'] );
				} else {
					echo 'Qualcosa è andato storto, controlla la query<br>';
					$obj->Debug_DoInsert();
				}
			} else {
				header( 'Location: ../user.php?id='.$_POST['id'].'&error=1' );
			}
		} else {
			$obj->set = array( 
								'username' => $_POST['username'],
								'rules' => $_POST['rules'],
								'first_name' => $_POST['first_name'],
								'last_name' => $_POST['last_name'],
								'surname' => $_POST['surname'],
								'email' => $_POST['email'],
							    'avatar' => $_POST['avatar']
								);
		}
		if( $obj->DoUpdate() ) {
			header( 'Location: ../user.php?id='.$_POST['id'] );
		} else {
			echo 'Qualcosa è andato storto, controlla la query<br>'. $obj->Debug_DoUpdate();
		}
	}
}