<?php
session_start();
if( $_SESSION['logged'] != TRUE  || $_SESSION['rules'] != 1 ) : header( 'Location:../index.php'); endif;
/*
index page is a simple redirect
read readme.txt for more info
*/

require '../function/required.function.php';
required_admin();
get_header();
?>
<?php
/*
recupero informazioni se questo è un modifica
*/
$obj = new phpdoquery();
$obj->where = array( 'type' => 'contact' );
$row = $obj->SingleQuery();
?>
<div class="col-sm-9">
          <h1 class="page-header">Crea una pagina contatti</h1>
  <form method="post" enctype="multipart/form-data" action="lib/post.php">
    <div class="col-sm-9">     
       <input type="hidden" name="id" value="<?php echo $row->id ?>">
       <input type="hidden" name="type" value="contact" />
         <div class="form-group">
           <label>Titolo</label>
           <input type="text" name="title" class="form-control" value="<?php echo $row->title ?>" />
         </div>
         <div class="form-group">
           <label>Descrizione</label>
           <textarea name="description" class="form-control text" rows="15"><?php echo $row->description ?></textarea>
         </div>
    </div>
    <div class="col-sm-3">
     <div class="form-group" style="margin-top:15px">
       <input type="submit" name="submit" class="btn btn-primary btn-block" value="Pubblica" />
     </div>     
    </div>
  </form>
</div><!-- /.blog-main -->
        <?php
get_footer();