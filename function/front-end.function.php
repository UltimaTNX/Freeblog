<?php
/* front-end function
*/

function get_title() {
	$obj = new phpdoquery();
	$get = explode( '/', $_SERVER['REDIRECT_URL'] );
	if( $get[1] ) {
		$obj->where = array( 'url' => $get[1] );
		$row = $obj->SingleQuery();
		if( $row->category_id == 0 ) {
			$title = getinfo( 'site_title' ) . ' | Categoria ' . $row->title ;
		} else {
			$title = getinfo( 'site_title' ) . ' | ' . $row->title;
		}
	} elseif( $_GET['p'] ) {
			$obj->where = array( 'id' => $_GET['p'] );
			$row = $obj->SingleQuery();
			$title = getinfo( 'site_title' ) . ' | ' . $row->title;
			
	} elseif( $_GET['s'] ) {
			$title = getinfo( 'site_title' ) . ' | Risultati di ricerca per ' . $_GET['s'];
			
	} elseif( $_GET['month'] && $_GET['year'] ) {
			$title = getinfo( 'site_title' ) . ' | Archivio di ' . $_GET['month'] . ' ' . $_GET['year'];
			
	} elseif( $_GET['c'] ) {
			$obj->where = array( 'id' => $_GET['c'], 'type' => 'categories' );
			$row = $obj->SingleQuery();
			$title = getinfo( 'site_title' ) . ' | Categoria ' . $row->title ;
			
	} elseif( $_GET['form'] ) {
			$title = getinfo( 'site_title' ) . ' | Contact';
			
	} else {
			$title = getinfo( 'site_title' ) . ' | ' . getinfo( 'site_description' );
	}
	
	return $title;
}

function get_meta_description() {
	$obj = new phpdoquery();
	$get = explode( '/', $_SERVER['REDIRECT_URL'] );
	if( $get[1] ) {
		$obj->where = array( 'url' => $get[1] );
		$row = $obj->SingleQuery();
		$description = $row->meta_description;
	} elseif( $_GET['p'] ) {
			$obj->where = array( 'id' => $_GET['p'] );
			$row = $obj->SingleQuery();
			$description = $row->meta_description;
			
	} elseif( $_GET['s'] ) {
			$description = getinfo( 'meta_description' );
			
	} elseif( $_GET['month'] && $_GET['year'] ) {
			$description = getinfo( 'meta_description' );
			
	} elseif( $_GET['c'] ) {
			$obj->where = array( 'id' => $_GET['c'], 'type' => 'categories' );
			$row = $obj->SingleQuery();
			$description = $row->meta_description;
			
	} elseif( $_GET['form'] ) {
			$description = getinfo( 'meta_description' );
			
	} else {
			$description = getinfo( 'meta_description' );
	}
	
	return $description;
}

function get_keywords() {
	$obj = new phpdoquery();
	$get = explode( '/', $_SERVER['REDIRECT_URL'] );
	if( $get[1] ) {
		$obj->where = array( 'url' => $get[1] );
		$row = $obj->SingleQuery();
		$key = $row->keywords;
	} elseif( $_GET['p'] ) {
			$obj->where = array( 'id' => $_GET['p'] );
			$row = $obj->SingleQuery();
			$key = $row->keywords;
			
	} elseif( $_GET['s'] ) {
			$key = getinfo( 'meta_keywords' );
			
	} elseif( $_GET['month'] && $_GET['year'] ) {
			$key = getinfo( 'meta_keywords' );
			
	} elseif( $_GET['c'] ) {
			$obj->where = array( 'id' => $_GET['c'], 'type' => 'categories' );
			$row = $obj->SingleQuery();
			$key = $row->keywords;
			
	} elseif( $_GET['form'] ) {
			$key = getinfo( 'meta_keywords' );
			
	} else {
			$key = getinfo( 'meta_keywords' );
	}
	
	return $key;
}