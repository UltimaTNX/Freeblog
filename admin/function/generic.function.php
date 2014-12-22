<?php
/*
Generic function
author name: stefano Pasazi
Author uri: www.stefanopascazi.it
revision: 1.0
*/
function get_header() {
	include_once 'header.php';
}

function get_sidebar() {
	include_once 'sidebar.php';
}

function get_footer() {
	include_once 'footer.php';
}

function the_content( $var ) {	
	$content = stripslashes( $var );
	$content = html_entity_decode( $content );
	
	echo $content;
}



function the_excerpt( $var ) {
	$content = stripslashes( $var );
	$content = html_entity_decode( $content );
	$content =  substr( $content, 0, 500 );
	
	echo strip_tags($content).'[..]';
}

// funzione di rescritura carateri
function category_name ( $var ) {
	if( $var == 0 ) {
		echo 'Nessuna categoria';
	} else {
		$obj = new phpdoquery();
		$obj->where = array( 'id' => $var, 'type' => 'categories' );
		$row = $obj->SingleQuery();
		
		echo $row->title;
	}
}

function admin_url() {
	$url = 'http://' . $_SERVER['SERVER_NAME'] . dirname( $_SERVER['PHP_SELF'] ) . '/admin/';
	
	echo $url;
}

function get_option( $var ) {
	$obj = new phpdoquery();
	$obj->table = 'options';
	$obj->where = array( 'name' => $var );
	$obj->pre_page = '';
	if( $obj->HaveQuery() ) : $row = $obj->SingleQuery();
	$value = $row->value;
	else :
	$value = false;
	endif;
	return $value;
}

function get_rules( $var ) {
	if( $var == 1 ) {
		$rules = 'Admin';
	} elseif( $var == 2 ) {
		$rules = 'Editor';
	} elseif( $var == 3 ) {
		$rules = 'Published';
	} elseif( $var == 4 ) {
		$rules = 'Writer';
	} else {
		$rules = 'Subscriber';
	}
	echo $rules;
}