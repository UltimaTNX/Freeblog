<?php session_start();
$frontend = new frontend(); ?>
<!DOCTYPE html>
<html lang="it">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="<?php echo $frontend->get_meta_description() ?>">
    <meta name="keywords" content="<?php echo $frontend->get_keywords(); ?>">
    <meta name="author" content="">

    <title><?php echo $frontend->get_title() ?></title>

    <!-- Bootstrap core CSS -->
    <link href="<?php get_template_directory() ?>css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="<?php get_template_directory() ?>css/blog.css" rel="stylesheet">
    <link href="<?php get_template_directory() ?>style.css" rel="stylesheet">

    <!-- Just for debugging purposes. Don't actually copy this line! -->
    <!--[if lt IE 9]><script src="<?php get_template_directory() ?>js/ie8-responsive-file-warning.js"></script><![endif]-->

    <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
      <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
  </head>

  <body>
    <?php get_template_menu(); ?>
    <div class="container-fluid header">

      <div class="row right">
        <div class="col-sm-12">
          <h1 class="text-center"><a href="<?php bloginfo('/'); ?>" title="<?php bloginfo('site_title'); ?>"><?php bloginfo('site_title'); ?></a></h1>
          <p class="text-center"><?php bloginfo('site_description') ;?></p>
          <div class="col-sm-4 col-sm-offset-4">
           <?php get_search_form(); ?>
          </div>
        </div>
      </div>
    </div>
    <div id="wrapper">
    <div class="container">
      <div class="row">