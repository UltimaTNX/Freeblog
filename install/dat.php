<?php
session_start();
require_once '../Classes/class.phpdoquery.php';
require_once '../Classes/class.controller_insert.php';
if( isset( $_POST['submit'] ) && $_POST['submit'] == 'registra' ) {
	
	// open the .htaccess file for editing
	$file = fopen( '../.htaccess', 'w' );
	
	//Inserisco il contenuto
	$content_string = "RewriteEngine On\n";
	$content_string .= "RewriteBase /\n";
	$content_string .= "RewriteRule ^sitemap.xml ./sitemap.php [L,QSA]\n";
	$content_string .= "RewriteRule ^index\.php$ - [L]\n";
	$content_string .= "RewriteCond %{REQUEST_FILENAME} !-f\n";
	$content_string .= "RewriteCond %{REQUEST_FILENAME} !-d\n";
	if( ROOT == '' ) {
		$content_string .= "RewriteRule . /index.php [L]\n";
	} else {
		$content_string .= "RewriteRule . /" . ROOT . "/index.php [L]\n";
	}
	fwrite($file, $content_string);
	//
	fclose($file);
	// creo l'utente amministratore
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
		
		if( !$_POST['password'] || !$_POST['password2'] || !$_POST['username'] || !$_POST['email'] ) {
			header( 'Location: index.php.php?error=Devi compilare tutti i campi');
			exit();
		}
		if( $_POST['password'] === $_POST['password2'] ) {
			$obj = new phpdoquery();
			$obj->table = 'users';
			$obj->insert = array( 
								'username' => $_POST['username'], 
								'password' => md5($_POST['password']),
								'rules' => '1',
								'email' => $_POST['email']
								);
			if( $obj->DoInsert() ) {
				$id = mysqli_insert_id();
				// creo le sessioni
				$_SESSION['logged'] = TRUE;
				$_SESSION['user'] = $id;
				$_SESSION['rules'] = 1;
			}
		} else {
			header( 'Location: index.php.php?error=Le password non coincidono');
			exit();
		}
		
		// se tutto ok, proseguo e creo la tabella posts
		
		// prima cancello gli oggetti
		unset( $create );
		unset( $obj );
		
		// todo
		$create = new controller_insert();
		// creo la tabella se non esiste
		$query = "CREATE TABLE IF NOT EXISTS `". TABLE_PREFIX ."posts` (
		`id` int(11) NOT NULL AUTO_INCREMENT,
		`category_id` int(11) NOT NULL,
		`title` varchar(255) NOT NULL,
		`description` text NOT NULL,
		`timeset` int(11) NOT NULL,
		`type` varchar(20) NOT NULL,
		`thumbnail` text NOT NULL,
		`url` text NOT NULL,
		`tag` varchar(255) NOT NULL,
		`meta_description` varchar(255) NOT NULL,
		`keywords` varchar(255) NOT NULL,
		PRIMARY KEY (`id`)
		)";
		
		if( $create->FreeQuery( $query ) ) {
			unset( $create );
			$obj = new controller_insert();
			$category = new controller_insert();
			// creo la categoria e recupero l'id
			$category->insert = array(
			                          'title' => 'Senza categoria',
									  'timeset' => time(),
									  'type' => 'categories',
									  'url' => $category->CleanString( 'Senza categoria' )
									  );
		    $category->DoInsert();
			$category_id = 1;
									  
			$obj->insert = array( 
								'title' => 'Benvenuto nel tuo Freeblog', 
								'description' => '<p>Questo è soltanto un post di esempio, potrai cancellarlo quando vorrai</p>',
								'category_id' => $category_id,
								'timeset' => time(),
								'type' => 'post',
								'url' => $obj->CleanString( 'Benvenuto nel tuo Freeblog' )
								);
			if( $obj->DoInsert() ) {
				
				// cancello gli oggetti
				unset( $create );
				unset( $obj );
				unset( $category );
				
				// installo la tabella options
				//todo
				$create = new phpdoquery();
				// creo la tabella se non esiste
				$query = "CREATE TABLE IF NOT EXISTS `". TABLE_PREFIX ."options` (
				`id` int(11) NOT NULL AUTO_INCREMENT,
				`name` varchar(255) NOT NULL,
				`value` text NOT NULL,
				PRIMARY KEY (`id`)
				)";
				if( $create->FreeQuery( $query ) ) {
					$obj = new phpdoquery();
					$obj->table = 'options';
					$obj->insert = array( 'name' => 'site_title', 'value' => $_POST['site_title'] );
					if( $obj->DoInsert() ) {
						unset( $obj );
						unset( $create );
						header( 'Location: index.php?ok=yes' );
					} else {
						echo 'Ops! insert options non andato a buon fine';
					}
				} else {
					echo 'Tabella options non creata';
				}
			} else {
				echo 'Ops! La tabella posts non ha fatto insert';
			}
		} else {
			echo 'Ops! Non si è creata la tabella posts';
		}
		
	} else {
		echo 'Ops! tabella users non creata!';
	}
}