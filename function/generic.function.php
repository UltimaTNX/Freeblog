<?php
/*
Generic function
author name: stefano Pasazi
Author uri: www.stefanopascazi.it
revision: 1.0
*/
function this_url() {
	if( ROOT == '' ) {
		$url = 'http://' . $_SERVER['SERVER_NAME'];
	} else {
		$url = 'http://' . $_SERVER['SERVER_NAME'] . '/' . ROOT;
	}
	
	return $url;
}
function get_header() {
		include_once 'template/' . TEMPLATEPATH .'/header.php';
}

function get_sidebar() {
		include_once 'template/' . TEMPLATEPATH .'/sidebar.php';
}

function get_footer() {
		include_once 'template/' . TEMPLATEPATH .'/footer.php';
}

function get_file() {
	if( $_SERVER['REQUEST_URI'] != ROOT  ) {
		$url = str_replace( ROOT, '', $_SERVER['REQUEST_URI'] );
		$url = str_replace('/', '', $url );
	}
	if( !empty($_GET['p']) ) {
		include 'template/' . TEMPLATEPATH .'/single.php';
	} elseif( !empty( $url ) && empty( $_GET['s'] ) && empty( $_GET['month'] ) && empty( $_GET['year'] ) && empty( $_GET['c'] ) && empty( $_GET['form'] ) && empty( $_GET['error'] ) ) {
		$obj = new phpdoquery();
		$obj->where = array( 'url' => $url );
		$row = $obj->SingleQuery();
		if( $row->type == 'categories' ) {
			include 'template/' . TEMPLATEPATH .'/category.php';
		} else {
			include 'template/' . TEMPLATEPATH .'/single.php';
		}
	} elseif( !empty($_GET['s'] ) ) {
			include 'template/' . TEMPLATEPATH .'/search.php';
	} elseif( !empty($_GET['month'] ) && !empty( $_GET['year'] ) ) {
			include 'template/' . TEMPLATEPATH .'/archive.php';
	} elseif( !empty($_GET['c'] ) ) {
			include 'template/' . TEMPLATEPATH .'/category.php';
	} elseif( !empty($_GET['form'] ) ) {
			include 'template/' . TEMPLATEPATH .'/contact.php';
	} elseif( !empty($_GET['error'] ) && $_GET['error'] == 404 ) {
			include 'template/' . TEMPLATEPATH .'/404.php';
	} else {
			include 'template/' . TEMPLATEPATH .'/index.php';
	}
}

function the_permalink( $var ) {
	if( get_option( 'mod_rewrite' ) ) {
		$obj = new phpdoquery();
		$obj->where = array( 'id' => $var );
		$obj->per_page = '';
		$row = $obj->SingleQuery();
		$url = this_url() . '/' . $row->url . '/';
	} else {
		$obj = new phpdoquery();
		$obj->where = array( 'id' => $var );
		$obj->per_page = '';
		$row = $obj->SingleQuery();
		if( $row->type == 'categories' ) {
			$url = this_url() .'/?c=' . $var;
		} else {
			$url = this_url() .'/?p=' . $var;
		}
	}
	
	return $url;
}

function get_template_directory() {
	$url = this_url() .'/template/' . TEMPLATEPATH .'/';
	
	echo $url;
}


function bloginfo( $var ) {
	$obj = new phpdoquery();
	$obj->table = 'options';
	if( $var == '/' ) {
		$url = this_url() .$var;
	} else {
		$obj->where = array('name' => $var );
		$row = $obj->SingleQuery();
		$url = $row->value;
	}
	
	echo $url;
}

function getinfo( $var ) {
	$obj = new phpdoquery();
	$obj->table = 'options';
	if( $var == '/' ) {
		$url = this_url() .$var;
	} else {
		$obj->where = array('name' => $var );
		$row = $obj->SingleQuery();
		$url = $row->value;
	}
	
	return $url;
}
	
function the_content( $var ) {	
	$content = stripslashes( $var );
	$content = str_replace('src="../source/', 'src="'. this_url() .'/source/', $content );
	$content = str_replace('<img ', '<img class="img-responsive" ', $content );
	
	echo $content;
}

function the_excerpt( $var ) {
	$content = stripslashes( $var );
	$content =  substr( $content, 0, 500 );
	
	echo strip_tags($content).'[..]';
}

function the_title( $var ) {
	$content = stripslashes( $var );
	
	echo $content;
}
function post_meta( $time ) {
	setlocale(LC_TIME, 'ita', 'it_IT.utf8');
	$data = strftime("%d %B %Y", $time );	
	echo 'Pubblicato il  '. utf8_encode($data);
}

function get_categories_list() {
	$obj = new phpdoquery();
	$obj->free = "SELECT * FROM " . TABLE_PREFIX . "posts WHERE type = 'categories' ORDER BY id DESC LIMIT 0, 10";
	if( $obj->HaveQuery() ) : $result = $obj->DoQuery() ;
	while( $row = $obj->Rows( $result ) ) : ?>
    <li><a href="<?php echo the_permalink( $row->id ); ?>"><?php echo $row->title; ?></a></li>
    <?php endwhile;
	else:
	echo 'No categories in the list';
	endif;
}

function get_archives_list() {
	setlocale(LC_TIME, 'ita', 'it_IT.utf8');
	$obj = new phpdoquery();
	$obj->free = 'SELECT YEAR( FROM_UNIXTIME(timeset) ) AS YEAR, MONTHNAME(FROM_UNIXTIME(timeset) ) AS MONTHNAME FROM '.TABLE_PREFIX.'posts WHERE category_id <> 0 GROUP BY YEAR, MONTHNAME';
	  $result = $obj->DoQuery() ;
	  while( $row = $obj->Rows( $result ) ) : ?>
	  <li><a href="<?php bloginfo('/'); ?>?month=<?php echo $row->MONTHNAME; ?>&year=<?php echo $row->YEAR; ?>"><?php echo $row->MONTHNAME. ' ' .$row->YEAR ?></a></li>
	  <?php endwhile;
}

function check_page() {
	$obj = new phpdoquery();
	$obj->where = array( 'type' => 'page' );
	if( $obj->HaveQuery() ) : $result = true;
	else : $result = false;
	endif;
	return $result;
}

function create_menu_page() {
	
	$obj = new phpdoquery();
	$obj->per_page = '';
	$obj->where = array( 'type' => 'page' );
	if( $obj->HaveQuery() ) : $result = $obj->DoQuery();
	while( $row = $obj->Rows( $result ) ) : ?>
    <li><a href="<?php echo the_permalink( $row->id ); ?>" title="<?php the_title( $row->title ); ?>"><?php the_title( $row->title ); ?></a></li>
    <?php
	endwhile;
	endif;
}

function get_search_form() {
	if( file_exists( 'template/' . TEMPLATEPATH .'/searchform.php' ) ) {
		include 'template/' . TEMPLATEPATH .'/searchform.php';
	} else {
		echo '
		 <form action="<?php bloginfo('/'); ?>" method="get" enctype="multipart/form-data">
              <div class="input-group">
                <input type="text" name="s" class="form-control" placeholder="Cerca">
                <span class="input-group-btn">
                  <input type="submit" class="btn btn-primary" value="Go!">
                </span>
              </div><!-- /input-group -->
            </form>';
	}
}
function get_option( $var ) {
	$obj = new phpdoquery();
	$obj->table = 'options';
	$obj->pre_page = '';
	if( $obj->HaveQuery() ) : $row = $obj->SingleQuery();
	$value = $row->value;
	else :
	$value = false;
	endif;
	return $value;
}

function use_contact() {	
	$obj = new phpdoquery();
	$obj->free = "SELECT * FROM ".TABLE_PREFIX."options WHERE name = 'contact_page' LIMIT 0,1";;
	if( $obj->HaveQuery() ) : $row = $obj->Rows( $obj->DoQuery() );
	    if( $row->value == NULL ) :
		$result = false;
		else : 
		$result = true;
		endif;
	else :
	    $result = false;
	endif;
	
	return $result;
}

function get_contact_page( $var ) { ?>
	<li><a href="<?php bloginfo('/') ?>?form=contact"><?php echo $var ?></a></li>
    <?php
}

function get_template_menu() { ?>
<nav class="navbar navbar-default navbar-fixed-top navbar-inverse" role="navigation">
      <div class="container-fluid">
        <div class="navbar-header">
          <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <a class="navbar-brand" href="<?php bloginfo('/'); ?>"><?php bloginfo('site_title'); ?></a>
        </div>
        <div class="navbar-collapse collapse">
          <ul class="nav navbar-nav">
            <li class="active"><a href="<?php bloginfo('/'); ?>">Home</a></li>
            <?php if( check_page() ) : ?>
            <li class="dropdown">
              <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">Menu <span class="caret"></span></a>
              <ul class="dropdown-menu" role="menu">
                <?php create_menu_page(); ?>
              </ul>
            </li>
            <?php endif; ?>
            <?php if( use_contact() ) : get_contact_page('Contatti'); endif; ?>
          </ul>
          <ul class="nav navbar-nav navbar-right">
			 <?php
            if( !empty( $_SESSION['logged'] ) && $_SESSION['logged'] == TRUE ) : ?> 
            <li><a href="<?php bloginfo('/'); ?>admin/index.php">Admin pannel</a></li>
            <li><a href="<?php bloginfo('/'); ?>admin/logout.php">Logout</a></li>
            <?php else: ?>
            <li><a href="<?php bloginfo('/'); ?>admin/login.php">Login</a></li>
            <?php endif; ?>
          </ul>
        </div><!--/.nav-collapse -->
      </div>
    </nav>    
<?php }