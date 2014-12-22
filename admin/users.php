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
<div class="col-sm-9">
          <h1 class="page-header">Tutti gli utenti</h1>
<table class="table table-striped">
  <tr>
    <th>Username</th>
    <th>Email</th>
    <th>Modifica</th>
    <th>Cancella</th>
  </tr>
  <?php
  $obj = new phpdoquery();
  $obj->table = 'users';
  $param = array(
                 'title_prev' => 'Precedente',
				 'title_next' => 'Successiva'
				 );
  if( $obj->HaveQuery() ) : $result = $obj->DoQuery();
  while( $row = $obj->Rows( $result ) ) : ?>
  <tr>
    <td><?php echo $row->username ?></td>
    <td><?php echo $row->email ?>
    <td><a href="user.php?id=<?php echo $row->id ?>">Modifica</a></td>
    <td><a href="lib/delete.php?id=<?php echo $row->id ?>&table=users">Cancella</a></td>
  </td>
  <?php endwhile; endif; ?>
</table>
<ul class="pagination">
<?php $obj->prev_page($param) . $obj->next_page($param); ?>
</ul>
</div><!-- /.blog-main -->
        <?php
get_footer();