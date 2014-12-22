<?php
include_once '../function/function.work.php';
work();
$obj = new phpdoquery();

if( $_GET['table'] ) : $obj->table = $_GET['table']; endif;

$obj->where = array( 'id' => $_GET['id'] );
if( $obj->DoDelete() ) {
	header( 'Location: ../index.php' );
} else {
	echo 'qualcosa è andato storto, controlla laquery<br>' . Debug_DoDelete();
}