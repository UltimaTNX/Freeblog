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
if( $_GET['c'] ) {
	$obj->where = array( 'category_id' => $_GET['c'] );
} else {
	$url = str_replace( ROOT, '', $_SERVER['REQUEST_URI'] );
		$url = str_replace('/', '', $url );
	$cat = new phpdoquery();
	$cat->where = array( 'url' => $url );
	$cat_id = $cat->SingleQuery();
	$obj->where = array('category_id' => $cat_id->id );
}
// assegno i parametri di configurazione ai pulsanti di paginazione
$param = array(
               'title_prev' => 'Precedente',
			   'title_next' => 'Successivo'
			   );
// ora è possibile aggiungere la paginazione
// effettuo un controllo
if( $obj->HaveQuery() ) : $result = $obj->DoQuery(); 
while( $row = $obj->Rows( $result ) ) : ?>
          <div class="blog-post col-sm-12">
            <h2 class="blog-post-title"><a href="<?php echo the_permalink( $row->id ); ?>" title="<?php the_title( $row->title ); ?>"><?php the_title( $row->title ); ?></a></h2>
            <p class="blog-post-meta"><?php post_meta( $row->timeset ); ?></p>

            <p><?php the_excerpt( $row->description ) ?></p>
          </div><!-- /.blog-post -->
<?php endwhile; ?>
          

          <ul class="pagination">
            <?php $obj->prev_page( $param ) . $obj->next_page( $param ); ?>
          </ul>
<?php
else:
echo '<div class="blog-post col-sm-12">
            <h2 class="blog-post-title">No posts to display</h2>
	  </div>';
endif;
?>
        </div><!-- /.blog-main -->
<?php get_sidebar(); ?>
<?php get_footer(); ?>