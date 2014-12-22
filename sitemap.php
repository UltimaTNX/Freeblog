<?php header('Content-Type: text/xml');
echo '<?xml version="1.0" encoding="UTF-8"?>
<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">'; 
include('function/required.function.php');
required();  ?>
<url>
<loc><?php bloginfo('/'); ?></loc>
<changefreq>Monthly</changefreq>
<priority>1.0</priority>
</url>
<?php
$obj = new phpdoquery();
$obj->per_page = '';
$obj->where = array( 'type' => 'post' );
if( $obj->HaveQuery() ) : $result = $obj->DoQuery();
while( $row = $obj->Rows( $result ) ) : ?>
<url>
<loc><?php echo the_permalink( $row->id ); ?></loc>
<changefreq>Monthly</changefreq>
<priority>0.9</priority>
</url>
<?php
endwhile;
endif;

?>
<?php
$page = new phpdoquery();
$obj->per_page = '';
$page->where = array( 'type' => 'page' );
if( $page->HaveQuery() ) : $resultpage = $page->DoQuery();
while( $rowpage = $page->Rows( $resultpage ) ) : ?>
<url>
<loc><?php echo the_permalink( $rowpage->id ); ?></loc>
<changefreq>Monthly</changefreq>
<priority>0.7</priority>
</url>
<?php
endwhile;
endif;

?>
<?php
$cat = new phpdoquery();
$obj->per_page = '';
$cat->where = array( 'type' => 'categories' );
if( $cat->HaveQuery() ) : $resultcat = $cat->DoQuery();
while( $rowcat = $cat->Rows( $resultcat ) ) : ?>
<url>
<loc><?php echo the_permalink( $rowcat->id ); ?></loc>
<changefreq>Monthly</changefreq>
<priority>0.6</priority>
</url>
<?php
endwhile;
endif;

?>
</urlset>