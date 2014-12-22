</div><!-- /.row -->

    </div><!-- /.container -->
</div><!-- /#wrapper -->

    <div class="blog-footer">
      <p><?php bloginfo('footer_credit'); ?>
      <p><a href="httpwww.stefanopascazi.it">Created whit FreeBlog CMS</a></p>
      <p>
        <a class="click" href=".header">Back to top</a>
      </p>
    </div>

    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="<?php get_template_directory() ?>js/jquery.js"></script>
    <script src="<?php get_template_directory() ?>js/bootstrap.min.js"></script>
    <script src="<?php get_template_directory() ?>js/docs.min.js"></script>
    <script>
	jQuery(document).ready(function($) {
		$('.click').bind('click',function(event){
        var $anchor = $(this);
         
        $('html, body').stop().animate({
            scrollTop: $($anchor.attr('href')).offset().top
        }, 1500);
         
        event.preventDefault();
		});
	})
	</script>
  </body>
</html>