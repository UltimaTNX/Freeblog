<?php
session_start();
include_once '../function/function.work.php';
work();
if( isset( $_POST['submit']) && $_POST['submit'] == 'Salva' ) {
	$create = new phpdoquery();
	// creo la tabella se non esiste
	$query = "CREATE TABLE IF NOT EXISTS `". TABLE_PREFIX ."options` (
	`id` int(11) NOT NULL AUTO_INCREMENT,
	`name` varchar(255) NOT NULL,
	`value` text NOT NULL,
	PRIMARY KEY (`id`)
	)";
	$array = $_SESSION['option'];
	if( $create->FreeQuery( $query ) ) {
		unset( $create );
		$obj = new phpdoquery();
		$obj->table = 'options';
		foreach( $array as $name ) {
			
			$obj->where = array( 'name' => $name );
			if( $obj->HaveQuery() ) {
				$obj->set = array( 'value' => $_POST[$name] );
				if( $obj->DoUpdate() ) {
					header( 'Location: ../options.php' );
				} else {
					echo 'Controlla la query <br>'.$obj->Debug_DoUpdate();
				}
			} else {
				$obj->insert = array('name' => $name, 'value' => $_POST[$name] );
				if( $obj->DoInsert() ) {
					header( 'Location: ../options.php' );
				} else {
					echo 'Controlla la query <br>'.$obj->Debug_DoInsert();
				}
			}
		}
	} else {
		echo 'tabella FB_options non creata!';
	}
}