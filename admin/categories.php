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
          <h1 class="page-header">Categorie</h1>
<div class="col-sm-4">
     <form method="post" enctype="multipart/form-data" action="lib/post.php">
	 <input type="hidden" name="id" value="<?php echo $row->id ?>">
     <input type="hidden" name="type" value="categories" />
       <div class="form-group">
           <label>Focus Keywords</label>
           <input type="text" class="form-control" name="keywords" value="<?php echo $row->keywords; ?>" />
           <small>Puoi inserire le parole chiave separandole con le virgole.</small>
         </div>
         <div class="form-group">
           <label>Meta Description</label>
           <textarea name="meta_description" class="form-control" rows="5"><?php echo $row->meta_description ?></textarea>
         </div>
       <div class="form-group">
         <label>Name</label>
         <div class="input-group">
           <input type="text" name="title" class="form-control" value="<?php echo $row->title ?>" />
           <span class="input-group-btn">
             <input type="submit" name="submit" class="btn btn-primary" value="Pubblica" />
           </span>
         </div>
       </div>
     </form>
</div>
<div class="col-sm-8">
  <?php
  $cat = new phpdoquery();
  $cat->where = array( 'type' => 'categories' );
  if( $cat->HaveQuery() ) : $result = $cat->DoQuery(); ?>
  
  <table class="table table-striped">
    <tr>
      <th>Nome</th>
      <th>Modifica</th>
      <th>Cancella</th>
    </tr>
    <?php
	while( $rows = $cat->Rows( $result ) ) : ?>
    <tr>
      <td><?php echo $rows->title ?></td>
      <td><a href="categories.php?id=<?php echo $rows->id ?>">Modifica</a></td>
      <td><a href="lib/delete.php?id=<?php echo $rows->id ?>">Cancella</a></td>
    </tr>
    <?php endwhile; ?>
    </table>
    <?php	
	// no categories
	else :
	echo '<h3>No categories in the DB</h3>';
	endif;
	?>
  </table>
</div>
</div>
        <?php
get_footer();