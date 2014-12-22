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
$group_option = array( 
                      'site_title', 
					  'site_email', 
					  'meta_description', 
					  'site_description', 
					  'contact_page', 
					  'meta_keywords', 
					  'user',
					  'footer_credit',
					  'mod_rewrite'
					  );
// creo una sessione per passare l'array
$_SESSION['option'] = '';
$_SESSION['option'] = $group_option;
?>
<div class="col-sm-9">
          <h1 class="page-header">Option page</h1>
  <form method="post" enctype="multipart/form-data" action="lib/options.php">
       <div class="row">
         <div class="col-sm-6">
           <div class="form-group">
             <label>Titolo del sito</label>
             <input type="text" name="site_title" class="form-control" value="<?php echo get_option('site_title'); ?>" />
           </div>
           <div class="form-group">
             <label>Descrizione del sito</label>
             <input type="text" name="site_description" class="form-control" value="<?php echo get_option('site_description'); ?>" />
           </div>
           <div class="checkbox">
             <label>
             <input type="checkbox" name="contact_page" value="1" <?php if( get_option('contact_page') ) : echo 'checked'; endif ?> />Utilizzi la pagina contatti
             </label>           
           </div>
           <div class="checkbox">
             <label>
             <input type="checkbox" name="user" value="1" <?php if( get_option('user') ) : echo 'checked'; endif ?> />Vuoi la registrazione utenti
             </label>           
           </div>
           <div class="checkbox">
             <label>
             <input type="checkbox" name="mod_rewrite" value="1" <?php if( get_option('mod_rewrite') ) : echo 'checked'; endif ?> />Utilizzi il mod_rewrite di Apache ( friendly Urls )
             </label>           
           </div>
           <div class="form-group">
             <label>Email del sito</label>
             <input type="text" name="site_email" class="form-control" value="<?php echo get_option('site_email'); ?>" />
           </div>
           <div class="form-group">
             <label>Crediti nel footer</label>
             <input type="text" name="footer_credit" class="form-control" value="<?php echo get_option('footer_credit'); ?>" />
           </div>
           <h3> Meta sezione per le pagine</h3>
           <div class="form-group">
             <label>Meta description</label>
             <textarea name="meta_description" class="form-control" rows="5"><?php echo get_option('meta_description'); ?></textarea>
           </div>
           <div class="form-group">
             <label>Meta keywords</label>
             <input type="text" name="meta_keywords" class="form-control" value="<?php echo get_option('meta_keywords'); ?>" />
           </div>
           
         </div>
       </div>
       <div class="row">
         <div class="col-sm-2">
           <div class="form-group" style="margin-top:15px">
             <input type="submit" name="submit" class="btn btn-primary btn-block" value="Salva" />
           </div>     
         </div>
       </div>
  </form>
</div><!-- /.blog-main -->
        <?php
get_footer();