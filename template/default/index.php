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
$obj->where = array('type' => 'post' );
$param = array(
               'title_prev' => 'Precedente',
			   'title_next' => 'Successivo'
			   );
// ora è possibile aggiungere la paginazione
// effettuo un controllo
if( $obj->HaveQuery() ) : $rows = $obj->ArrayRows(); 
foreach( $rows as $key => $row ) : ?>
          <div class="blog-post col-sm-12">
            
          <?php if( $row->thumbnail ) : ?>
          <div class="col-sm-4">
          <img src="<?php echo $row->thumbnail; ?>" class="img-responsive" />
          </div>
          <?php endif; ?>
          <?php if( $row->thumbnail ) : echo '<div class="col-sm-8 thumb">'; endif; ?>
            <h2 class="blog-post-title"><a href="<?php echo the_permalink( $row->id ); ?>" title="<?php the_title( $row->title ); ?>"><?php the_title( $row->title ); ?></a></h2>
            <p class="blog-post-meta"><?php post_meta( $row->timeset ); ?></p>

            <p><?php the_excerpt( $row->description ) ?></p>
            <?php if( $row->thumbnail ) : echo '</div>'; endif; ?>
          </div><!-- /.blog-post -->
<?php endforeach; ?>
          

          <ul class="pagination">
            <?php $obj->prev_page( $param ) . $obj->next_page( $param ); ?>
          </ul>
<?php
else: ?>
      <div class="blog-post col-sm-6 col-sm-offset-3">
            <h2 class="blog-post-title">No posts to display</h2>
            <?php get_search_form(); ?>
	  </div>
<?php endif;
?>
        </div><!-- /.blog-main -->
<?php get_sidebar(); ?>
<?php get_footer(); ?>