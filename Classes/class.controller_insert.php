<?php
/* up grade classe phpdoquery() */

class controller_insert extends phpdoquery {
	
	public function CleanString($string) {
		$strResult = str_ireplace("à", "a", $string);
		$strResult  = str_ireplace("á", "a", $strResult);
		$strResult =  str_ireplace("è", "e", $strResult);
		$strResult =  str_ireplace("é", "e", $strResult);
		$strResult =  str_ireplace("ì", "i", $strResult);
		$strResult =  str_ireplace("í", "i", $strResult);
		$strResult =  str_ireplace("ò", "o", $strResult);
		$strResult =  str_ireplace("ó", "o", $strResult);
		$strResult =  str_ireplace("ù", "u", $strResult);
		$strResult =  str_ireplace("ú", "u", $strResult);
		$strResult =  str_ireplace("ç", "c", $strResult);
		$strResult =  str_ireplace("ö", "o", $strResult);
		$strResult =  str_ireplace("û", "u", $strResult);
		$strResult =  str_ireplace("ê", "e", $strResult);
		$strResult =  str_ireplace("ü", "u", $strResult);
		$strResult =  str_ireplace("ë", "e", $strResult);
		$strResult =  str_ireplace("ä", "a", $strResult);
		$strResult =  str_ireplace("'", " ", $strResult);
	 
		$strResult = preg_replace('/[^A-Za-z0-9 ]/', "", $strResult);
		$strResult = trim($strResult);
		$strResult =  preg_replace('/[ ]{2,}/', " ", $strResult);
	 
		$strResult = str_replace(" ", "-", $strResult);
	 
		return $strResult;
	}
}