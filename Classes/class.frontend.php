<?php
/* front-end public function
*/
class frontend extends phpdoquery {
	public function get_title() {
		if( !empty( $_SERVER['REDIRECT_URL'] ) ) {
			$get = explode( '/', $_SERVER['REDIRECT_URL'] );
		}
		if( !empty( $get[1] ) ) {
			$this->where = array( 'url' => !empty( $get[1] ) );
			$row = $this->SingleQuery();
			if( $row->type == 'categories' ) {
				$title = getinfo( 'site_title' ) . ' | Categoria ' . $row->title ;
			} else {
				$title = getinfo( 'site_title' ) . ' | ' . $row->title;
			}
		} elseif( !empty( $_GET['p'] ) ) {
				$this->where = array( 'id' => $_GET['p'] );
				$row = $this->SingleQuery();
				$title = getinfo( 'site_title' ) . ' | ' . $row->title;
				
		} elseif( !empty( $_GET['s'] ) ) {
				$title = getinfo( 'site_title' ) . ' | Risultati di ricerca per ' . $_GET['s'];
				
		} elseif( !empty( $_GET['month'] ) && !empty( $_GET['year'] ) ) {
				$title = getinfo( 'site_title' ) . ' | Archivio di ' . $_GET['month'] . ' ' . $_GET['year'];
				
		} elseif( !empty( $_GET['c'] ) ) {
				$this->where = array( 'id' => $_GET['c'], 'type' => 'categories' );
				$row = $this->SingleQuery();
				$title = getinfo( 'site_title' ) . ' | Categoria ' . $row->title ;
				
		} elseif( !empty( $_GET['form'] ) ) {
				$title = getinfo( 'site_title' ) . ' | Contact';
				
		} else {
				$title = getinfo( 'site_title' ) . ' | ' . getinfo( 'site_description' );
		}
		
		return $title;
	}
	
	public function get_meta_description() {
		
		if( !empty( $_SERVER['REDIRECT_URL'] ) ) {
			$get = explode( '/', $_SERVER['REDIRECT_URL'] );
		}
		if( !empty( $get[1] ) ) {
			$this->where = array( 'url' => !empty( $get[1] ) );
			$row = $this->SingleQuery();
			$description = $row->meta_description;
		} elseif( !empty( $_GET['p'] ) ) {
				$this->where = array( 'id' => $_GET['p'] );
				$row = $this->SingleQuery();
				$description = $row->meta_description;
				
		} elseif( !empty( $_GET['s'] ) ) {
				$description = getinfo( 'meta_description' );
				
		} elseif( !empty( $_GET['month'] ) && !empty( $_GET['year'] ) ) {
				$description = getinfo( 'meta_description' );
				
		} elseif( !empty( $_GET['c'] ) ) {
				$this->where = array( 'id' => $_GET['c'], 'type' => 'categories' );
				$row = $this->SingleQuery();
				$description = $row->meta_description;
				
		} elseif( !empty( $_GET['form'] ) ) {
				$description = getinfo( 'meta_description' );
				
		} else {
				$description = getinfo( 'meta_description' );
		}
		
		return $description;
	}
	
	public function get_keywords() {
		
		if( !empty( $_SERVER['REDIRECT_URL'] ) ) {
			$get = explode( '/', $_SERVER['REDIRECT_URL'] );
		}
		if( !empty( $get[1] ) ) {
			$this->where = array( 'url' => !empty( $get[1] ) );
			$row = $this->SingleQuery();
			$key = $row->keywords;
		} elseif( !empty( $_GET['p'] ) ) {
				$this->where = array( 'id' => $_GET['p'] );
				$row = $this->SingleQuery();
				$key = $row->keywords;
				
		} elseif( !empty( $_GET['s'] ) ) {
				$key = getinfo( 'meta_keywords' );
				
		} elseif( !empty( $_GET['month'] ) && !empty( $_GET['year'] ) ) {
				$key = getinfo( 'meta_keywords' );
				
		} elseif( !empty( $_GET['c'] ) ) {
				$this->where = array( 'id' => $_GET['c'], 'type' => 'categories' );
				$row = $this->SingleQuery();
				$key = $row->keywords;
				
		} elseif( !empty( $_GET['form'] ) ) {
				$key = getinfo( 'meta_keywords' );
				
		} else {
				$key = getinfo( 'meta_keywords' );
		}
		
		return $key;
	}
}