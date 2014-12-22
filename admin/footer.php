<?php
require_once '../Classes/config.php';
function path_url() {
	if( ROOT != '' ) {
		$url = '/' . ROOT;
		
	}
	echo $url;
}
?>
</div>
    </div>


    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="js/jquery.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/docs.min.js"></script>   
    <script src="js/menu/script.js"></script>
    <script src="js/jquery.fancybox.pack.js"></script>  
    <script src="js/tinymce/tinymce.min.js"></script>
    <script>
	  $('.iframe-btn').fancybox({
		  maxWidth	: 900,
		  maxHeight	: 600,
		  fitToView	: false,
		  width		: '100%',
		  height		: '100%',
		  autoSize	: false,
		  closeClick	: false,
		  openEffect	: 'none',
		  closeEffect	: 'none'
	  });
	</script>
	<script type="text/javascript"> 
		tinymce.init({
		selector: ".text",
		theme: "modern",
		plugins: [
			 "advlist autolink link image lists charmap print preview hr anchor pagebreak",
			 "searchreplace wordcount visualblocks visualchars insertdatetime code media nonbreaking",
			 "table contextmenu directionality emoticons paste textcolor responsivefilemanager"
	   ],
	   toolbar1: "undo redo | bold italic underline | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | styleselect | responsivefilemanager |",
	   toolbar2: " image media | forecolor backcolor  | print preview code | link unlink anchor ",
	   image_advtab: true ,
	   
	   external_filemanager_path:"<?php path_url(); ?>/filemanager/",
	   filemanager_title:"File manager" ,
	   external_plugins: { "filemanager" : "<?php path_url(); ?>/filemanager/plugin.min.js"}
	 });	 
	</script>
	<!-- /TinyMCE -->
    <!-- jQuery ajax upload file -->
    
    <!-- end -->
  </body>
</html>