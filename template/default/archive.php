<?php
/*
index page is a simple redirect
read readme.txt for more info
*/
get_header();
?>
<div class="col-sm-8 blog-main">
<?php
// instanzio la classe
$obj = new phpdoquery;
$obj->where = array( 'MONTHNAME( FROM_UNIXTIME(timeset) )' => $_GET['month'], 'YEAR( FROM_UNIXTIME(timeset) )' => $_GET['year'], 'type' => 'post' );
$param = array(
               'title_prev' => 'Precedente',
			   'title_next' => 'Successiva'
			   );
// effettuo un controllo
if( $obj->HaveQuery() ) : $result = $obj->DoQuery(); 
while( $row = $obj->Rows( $result ) ) : ?>
          <div class="blog-post col-sm-12">
            <h2 class="blog-post-title"><a href="<?php echo the_permalink( $row->id ); ?>" title="<?php the_title( $row->title ); ?>"><?php the_title( $row->title ); ?></a></h2>
            <p class="blog-post-meta"><?php post_meta( $row->timeset ); ?></p>

            <p><?php the_content($row->description); ?></p>
          </div><!-- /.blog-post -->
<?php endwhile;

?>
          

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
<?php
get_sidebar();
get_footer();