<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Free blog installazione</title>
<link rel="stylesheet" href="../admin/css/bootstrap.min.css" />
</head>

<body>
<div class="container">
  <div class="row">
    <div class="col-sm-8 col-sm-offset-2">
    <?php if( !empty($_GET['ok'] ) && $_GET['ok'] == 'yes' ) : ?>
       <h2>Freeblog Installazione avvenuta con successo</h2>
       <h3>Ricordati di cancellare la cartella install e tutto il suo contenuto</h3>
       <h4>Controlla se è stato creato il file .htaccess, nella root principale del tuo sito</h4>
       <p>In caso non fosse stato creato puoi crearne uno, aprendo un normale edito di testo, anche notepap di windows va bene e incollare il seguente codice:<br />
       Se hai installato freeblog non in una sotto directory:<br />
       <pre>
       RewriteEngine On
       RewriteBase /
       RewriteRule ^sitemap.xml ./sitemap.php [L,QSA]
       RewriteRule ^index\.php$ - [L]
       RewriteCond %{REQUEST_FILENAME} !-f
       RewriteCond %{REQUEST_FILENAME} !-d
       RewriteRule . /index.php [L]
       </pre><br />
       Se hai installato freeblog in una sotto directory:
       <pre>
       RewriteEngine On
       RewriteBase /
       RewriteRule ^sitemap.xml ./sitemap.php [L,QSA]
       RewriteRule ^index\.php$ - [L]
       RewriteCond %{REQUEST_FILENAME} !-f
       RewriteCond %{REQUEST_FILENAME} !-d
       RewriteRule . /tua_directory/index.php [L]
       </pre><br />
       Sostituendo tua directory con il nome effettivo della tua root.<br />
       Ora salva il file inserendo nel campo nome: .htaccess<br />
       
       </p>
       <p>
       <p><a class="btn btn-primary" href="../">Vai al tuo sito</a></p>
	<?php else : ?>
      <h2>Freeblog Installazione</h2>
      <p>Prima di effettuare l'installazione assicurati che:
        <ul>
          <li>Aver configurato i dati necessari per la connessione al tuo database</li>
          <li>Il database sia realmente esistente</li>
        </ul>
      Il file di configurazione si trova in /Classes/config.php
      </p>
      <p><?php if( !empty( $_GET['error'] ) ) : echo $_GET['error']; endif; ?></p>
      <form class="form-horizontal" role="form" action="dat.php" method="post">
        <div class="form-group">
          <label class="col-sm-3 control-label">Nome del sito</label>
          <div class="col-sm-9">
            <input type="text" class="form-control" name="site_title">
          </div>
        </div>
        <div class="form-group">
          <label class="col-sm-3 control-label">Email di registrazione</label>
          <div class="col-sm-9">
            <input type="email" class="form-control" name="email">
          </div>
        </div>
        <div class="form-group">
          <label class="col-sm-3 control-label">Username</label>
          <div class="col-sm-9">
            <input type="text" class="form-control" name="username">
          </div>
        </div>
        <div class="form-group">
          <label class="col-sm-3 control-label">Password</label>
          <div class="col-sm-9">
            <input type="password" class="form-control" name="password">
          </div>
        </div>
        <div class="form-group">
          <label class="col-sm-3 control-label">Ripeti Password</label>
          <div class="col-sm-9">
            <input type="password" class="form-control" name="password2">
          </div>
        </div>
        <div class="form-group">
          <div class="col-sm-offset-3 col-sm-9">
            <input type="submit" name="submit" class="btn btn-primary" value="registra">
          </div>
        </div>
      </form>
      <?php endif; ?>
    </div>
  </div>
</div>
</body>
</html>