<?php
session_start();
if( $_SESSION['logged'] != TRUE  ) : header( 'Location:../index.php'); endif;
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
$obj->table = 'users';
$obj->where = array('id' => $_GET['id'] );
$row = $obj->SingleQuery();
?>
<div class="col-sm-9">
          <h1 class="page-header">Profile page</h1>
  <form method="post" enctype="multipart/form-data" action="lib/register.php">
  <input type="hidden" name="id" value="<?php echo $row->id; ?>" />
       <div class="row">
         <div class="col-sm-6">
           <div class="form-group">
             <?php if( $row->avatar ) : ?>
             <div class="col-sm-12">
               <img src="<?php echo $row->avatar; ?>" class="img-resposnive" />
             </div>
             <?php endif; ?>
             <label>Inserisci la url per il tuo avatar. Includi HTTP</label>
             <input type="text" name="avatar" class="form-control" value="<?php echo $row->avatar; ?>" />
           </div>
           <div class="form-group">
             <label>Username</label>
             <input type="text" name="username" class="form-control" value="<?php echo $row->username; ?>" />
           </div>
           <div class="form-group">
             <label>e-Mail</label>
             <input type="text" name="email" class="form-control" value="<?php echo $row->email; ?>" />
           </div>
           <div class="form-group">
             <label>Surname</label>
             <input type="text" name="surname" class="form-control" value="<?php echo $row->surname; ?>" />
           </div>
           <div class="form-group">
             <label>First Name</label>
             <input type="text" name="first_name" class="form-control" value="<?php echo $row->first_name; ?>" />
           </div>
           <div class="form-group">
             <label>Last Name</label>
             <input type="text" name="last_name" class="form-control" value="<?php echo $row->last_name; ?>" />
           </div>
           <?php if( $_SESSION['rules'] == 1 ) : ?>
           <div class="form-group">
             <label>Rules</label>
             <select type="text" name="rules" class="form-control" />
               <option value="<?php echo $row->rules; ?>"><?php get_rules( $row->rules ); ?></option>
               <option value="1">Admin</option>
               <option value="2">Editor</option>
               <option value="3">Published</option>
               <option value="4">Writer</option>
               <option value="5">Subscriber</option>
             </select>
           </div>
           <?php endif; ?>
           <div class="form-group">
             <label>Password</label>
             <input type="password" name="password" class="form-control" />
           </div>
           <div class="form-group">
             <label>Ripeti password</label>
             <input type="password" name="password2" class="form-control" />
           </div>
           
         </div>
       </div>
       <div class="row">
         <div class="col-sm-2">
           <div class="form-group" style="margin-top:15px">
             <input type="submit" name="submit" class="btn btn-primary btn-block" value="Register" />
           </div>     
         </div>
       </div>
  </form>
</div><!-- /.blog-main -->

        <?php
get_footer();