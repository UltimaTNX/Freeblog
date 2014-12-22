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
$obj->free = "SELECT * FROM FB_posts WHERE title LIKE '%".$_GET['s']."%' OR description LIKE '%".$_GET['s']."%' ORDER BY id DESC";
// effettuo un controllo
if( $obj->HaveQuery() ) : $result = $obj->DoQuery(); 
while( $row = $obj->Rows( $result ) ) : ?>
          <div class="blog-post col-sm-12">
            <h2 class="blog-post-title"><a href="<?php echo the_permalink( $row->id ); ?>" title="<?php the_title( $row->title ); ?>"><?php the_title( $row->title ); ?></a></h2>
            <p class="blog-post-meta"><?php post_meta( $row->timeset ); ?></p>

            <p><?php the_excerpt( $row->description ) ?></p>
          </div><!-- /.blog-post -->
<?php endwhile; ?>
          

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