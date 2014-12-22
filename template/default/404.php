<?php
/*
index page is a simple redirect
read readme.txt for more info
*/
?>
<?php get_header(); ?>
<div class="col-sm-8 blog-main">
  <h1 class="text-center">OPS! This is an error 404</h1>
  <h2 class="text-center">Search on this site</h2>
  <div class="col-sm-6 col-sm-offset-3">    
    <?php get_search_form(); ?>
  </div>
</div><!-- /.blog-main -->
<?php get_sidebar(); ?>
<?php get_footer(); ?>