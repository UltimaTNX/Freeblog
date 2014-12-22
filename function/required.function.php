<?php
function required() {
	include_once 'Classes/class.phpdoquery.php';
	include_once 'Classes/class.frontend.php';
	include_once 'generic.function.php';
	include_once 'template/' . TEMPLATEPATH .'/functions.php';
}
function required_admin() {
	include_once '../Classes/class.phpdoquery.php';
	include_once '../Classes/class.controller_insert.php';
	include_once 'function/generic.function.php';
}