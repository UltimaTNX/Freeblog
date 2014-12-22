<?php
session_start();
if( $_SESSION['logged'] != TRUE ) : header( 'Location:../index.php'); endif;
/*
index page is a simple redirect
read readme.txt for more info
*/

require '../function/required.function.php';
required_admin();
get_header();

?>
<div class="col-sm-9">
          <h1 class="page-header">Dashboard</h1>

          <div class="row placeholders">
            <div class="col-xs-6 col-sm-3 placeholder">
              <a href="post.php"><img data-src="holder.js/200x200/text:New post/auto/sky" class="img-responsive" alt="Generic placeholder thumbnail"></a>
            </div>
            <div class="col-xs-6 col-sm-3 placeholder">
              <a href="page.php"><img data-src="holder.js/200x200/text:New page/auto/vine" class="img-responsive" alt="Generic placeholder thumbnail"></a>
            </div>
            <div class="col-xs-6 col-sm-3 placeholder">
              <a href="users.php"><img data-src="holder.js/200x200/text:All users/auto/sky" class="img-responsive" alt="Generic placeholder thumbnail"></a>
            </div>
            <div class="col-xs-6 col-sm-3 placeholder">
              <a href="options.php"><img data-src="holder.js/200x200/text:Go setting/auto/vine" class="img-responsive" alt="Generic placeholder thumbnail"></a>
            </div>
          </div>          
        </div>
        <?php
get_footer();