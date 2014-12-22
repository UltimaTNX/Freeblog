<?php
include_once '../function/function.work.php';
work();
if( isset( $_POST['submit']) && $_POST['submit'] == 'Pubblica' ) {
	
	if( !$_POST['id'] ) {
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
			$obj->insert = array( 
								'title' => $_POST['title'], 
								'description' => $_POST['description'],
								'category_id' => $_POST['category_id'],
								'timeset' => time(),
								'type' => $_POST['type'],
								'thumbnail' => $_POST['thumbnail'],
								'url' => $obj->CleanString( $_POST['title'] ),
								'tag' => $_POST['tag'],
								'meta_description' => $_POST['meta_description'],
								'keywords' =>  $_POST['keywords']
								);
			if( $obj->DoInsert() ) {
				$id = mysqli_insert_id();
				header( 'Location: ../'.$_POST['type'].'.php?id='.$id );
			} else {
				echo 'Qualcosa è andato storto, controlla la query<br>'. $obj->Debug_DoInsert();
			}
		} else {
			echo 'tabella FB_posts non creata!';
		}
	} else {
		$obj = new phpdoquery();
		$obj->where = array( 'id' => $_POST['id'] );
		$obj->set = array( 
							'title' => $_POST['title'], 
							'description' =>  $_POST['description'],
							'thumbnail' => $_POST['thumbnail'],
							'category_id' => $_POST['category_id'],
							'tag' => $_POST['tag'],
							'meta_description' => $_POST['meta_description'],
							'keywords' =>  $_POST['keywords']
							);
		if( $obj->DoUpdate() ) {
			header( 'Location: ../'.$_POST['type'].'.php?id='.$_POST['id'] );
		} else {
			echo 'Qualcosa è andato storto, controlla la query<br>'. $obj->Debug_DoUpdate();
		}
	}
}