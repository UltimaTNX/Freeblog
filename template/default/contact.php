<?php
/*
index page is a simple redirect
read readme.txt for more info
*/
?>
<?php get_header(); ?>
<div class="col-sm-8 blog-main">
<?php
// instanzio la classe
$obj = new phpdoquery;
$obj->where = array( 'type' => $_GET['form'] );

// effettuo un controllo
if( $obj->HaveQuery() ) : $row = $obj->SingleQuery() ?>
          <div class="blog-post col-sm-12">
            <h2 class="blog-post-title"><?php the_title( $row->title ); ?></h2>
            <p><?php the_content( $row->description ) ?></p>
          </div><!-- /.blog-post -->
          

<?php
else:
echo '<div class="blog-post col-sm-12">
            <h2 class="blog-post-title">Ops! This post not exists!</h2>
	  </div>';
endif;
?>
        </div><!-- /.blog-main -->
<?php get_sidebar(); ?>
<?php get_footer(); ?>