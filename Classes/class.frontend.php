<?php
/* front-end public function
*/
class frontend extends phpdoquery {
	public function get_title() {
		if( $_SERVER['REQUEST_URI'] != ROOT  ) {
			$url = str_replace( ROOT, '', $_SERVER['REQUEST_URI'] );
			$url = str_replace('/', '', $url );
		}
		if( !empty($_GET['p']) ) {
			$this->where = array( 'id' => $_GET['p'] );
			$row = $this->SingleQuery();
			$title = getinfo( 'site_title' ) . ' | ' . $row->title;
		} elseif( !empty($_GET['c']) ) {
			$this->where = array( 'id' => $_GET['c'] );
			$row = $this->SingleQuery();
			$title = getinfo( 'site_title' ) . ' | Categoria ' . $row->title;
			
		} elseif( !empty( $url ) && empty( $_GET['s'] ) && empty( $_GET['month'] ) && empty( $_GET['year'] ) && empty( $_GET['c'] ) && empty( $_GET['form'] ) && empty( $_GET['error'] ) ) {
			$obj->where = array( 'url' => $url );
			$row = $this->SingleQuery();
			if( $row->type == 'categories' ) {
				$title = getinfo( 'site_title' ) . ' | Categoria ' . $row->title ;
			} else {
				$title = getinfo( 'site_title' ) . ' | ' . $row->title;
			}
		} elseif( !empty( $_GET['s'] ) ) {
				$title = getinfo( 'site_title' ) . ' | Risultati di ricerca per ' . $_GET['s'];
				
		} elseif( !empty( $_GET['month'] ) && !empty( $_GET['year'] ) ) {
				$title = getinfo( 'site_title' ) . ' | Archivio di ' . $_GET['month'] . ' ' . $_GET['year'];
				
		} elseif( !empty( $_GET['form'] ) ) {
				$title = getinfo( 'site_title' ) . ' | Contact';
				
		} else {
				$title = getinfo( 'site_title' ) . ' | ' . getinfo( 'site_description' );
		}
		
		return $title;
	}
	
	public function get_meta_description() {
		
		if( $_SERVER['REQUEST_URI'] != ROOT  ) {
			$url = str_replace( ROOT, '', $_SERVER['REQUEST_URI'] );
			$url = str_replace('/', '', $url );
		}
		if( !empty($_GET['p']) ) {
			$this->where = array( 'id' => $_GET['p'] );
			$row = $this->SingleQuery();
			$description =  $row->meta_description;
		} elseif( !empty($_GET['c']) ) {
			$this->where = array( 'id' => $_GET['c'] );
			$row = $this->SingleQuery();
			$description =  $row->meta_description;
			
		} elseif( !empty( $url ) && empty( $_GET['s'] ) && empty( $_GET['month'] ) && empty( $_GET['year'] ) && empty( $_GET['c'] ) && empty( $_GET['form'] ) && empty( $_GET['error'] ) ) {
			$obj->where = array( 'url' => $url );
			$row = $this->SingleQuery();
			if( $row->type == 'categories' ) {
				$description =  $row->meta_description ;
			} else {
				$description =  $row->meta_description;
			}
				
		} elseif( !empty( $_GET['s'] ) ) {
				$description = getinfo( 'meta_description' );
				
		} elseif( !empty( $_GET['month'] ) && !empty( $_GET['year'] ) ) {
				$description = getinfo( 'meta_description' );
				
		} elseif( !empty( $_GET['form'] ) ) {
				$description = getinfo( 'meta_description' );
				
		} else {
				$description = getinfo( 'meta_description' );
		}
		
		return $description;
	}
	
	public function get_keywords() {
		
		if( $_SERVER['REQUEST_URI'] != ROOT  ) {
			$url = str_replace( ROOT, '', $_SERVER['REQUEST_URI'] );
			$url = str_replace('/', '', $url );
		}
		if( !empty($_GET['p']) ) {
			$this->where = array( 'id' => $_GET['p'] );
			$row = $this->SingleQuery();
			$key =  $row->keywords;
		} elseif( !empty($_GET['c']) ) {
			$this->where = array( 'id' => $_GET['c'] );
			$row = $this->SingleQuery();
			$key =  $row->keywords;
			
		} elseif( !empty( $url ) && empty( $_GET['s'] ) && empty( $_GET['month'] ) && empty( $_GET['year'] ) && empty( $_GET['c'] ) && empty( $_GET['form'] ) && empty( $_GET['error'] ) ) {
			$obj->where = array( 'url' => $url );
			$row = $this->SingleQuery();
			if( $row->type == 'categories' ) {
				$key =  $row->keywords ;
			} else {
				$key =  $row->keywords;
			}
				
		} elseif( !empty( $_GET['s'] ) ) {
				$key = getinfo( 'meta_keywords' );
				
		} elseif( !empty( $_GET['month'] ) && !empty( $_GET['year'] ) ) {
				$key = getinfo( 'meta_keywords' );
				
		} elseif( !empty( $_GET['form'] ) ) {
				$key = getinfo( 'meta_keywords' );
				
		} else {
				$key = getinfo( 'meta_keywords' );
		}
		
		return $key;
	}
}