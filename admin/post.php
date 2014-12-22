<?php
session_start();
if( $_SESSION['logged'] != TRUE  || $_SESSION['rules'] > 2 ) : header( 'Location:../index.php'); endif;
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
if( $_GET['id'] ) {
$obj = new phpdoquery();
$obj->where = array( 'id' => $_GET['id'] );
$row = $obj->SingleQuery();
}
?>
<div class="col-sm-9">
          <h1 class="page-header">Crea un nuovo post</h1>
  <form method="post" enctype="multipart/form-data" action="lib/post.php">
    <div class="col-sm-9">     
       <input type="hidden" name="id" value="<?php echo $row->id ?>">
       <input type="hidden" name="type" value="post" />
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
     <div class="form-group">
        <label>Categoria</label>
        <select name="category_id" class="form-control">
        <?php if( $_GET['id'] ) : ?>
          <option value="<?php echo $row->category_id ?>"><?php category_name( $row->category_id );?></option>
          <?php endif;
          $cat = new phpdoquery();
          $cat->where = array( 'type' => 'categories' );
          if( $cat->HaveQuery() ) : $res = $cat->DoQuery() ;
          while ( $rows = $cat->Rows( $res ) ) : ?>
          <option value="<?php echo $rows->id ?>"><?php echo $rows->title ?></option>
          <?php
          endwhile; 
		  else : ?>
          <option value="0">Nessuna categoria</option>
          <?php endif; ?>        
        </select>
      </div>
      <div class="form-group">
        <label>Carica immagine in evidenza</label>
        <div class="input-group">
          <input type="text" id="thumbnail" class="form-control" name="thumbnail" value="<?php echo $row->thumbnail; ?>" />
          <span class="input-group-btn">
            <a class="btn btn-default iframe-btn" data-fancybox-type="iframe" href="../filemanager/dialog.php?type=1&field_id=thumbnail" type="button"><span class="glyphicon glyphicon-cloud-upload"></span></a>
          </span>
        </div>
      </div>
         <div class="form-group" style="margin-top:15px">
           <input type="submit" name="submit" class="btn btn-primary btn-block" value="Pubblica" />
         </div>
         <div class="form-group">
           <label>TAG</label>
           <input type="text" class="form-control" name="tag" value="<?php echo $row->tag; ?>" />
           <small>Puoi inserire i tag separandoli con le virgole</small>
         </div>
         <div class="form-group">
           <label>Focus Keywords</label>
           <input type="text" class="form-control" name="keywords" value="<?php echo $row->keywords; ?>" />
           <small>Puoi inserire le parole chiave separandole con le virgole.</small>
         </div>
         <div class="form-group">
           <label>Meta Description</label>
           <textarea name="meta_description" class="form-control" rows="5"><?php echo $row->meta_description ?></textarea>
         </div>
     
    </div>
  </form>
</div><!-- /.blog-main -->
        <?php
get_footer();