<div class="container-fluid">
      <div class="row">
        <div class="col-sm-3 col-md-2 sidebar">
        <div id="cssmenu">
          <ul class="nav nav-sidebar">
            <li ><a href="<?php admin_url(); ?>">Home</a></li>
            <?php if( $_SESSION['rules'] <= 2 ) : ?>
            <li class="has-sub"><a href="#">Posts</a>
              <ul>
                <li><a href="posts.php">All Posts</a></li>
                <li><a href="post.php">New post</a></li>
                <li class="last"><a href="categories.php">Categories</a></li>
              </ul>
            </li>
            <?php endif; ?>
            <?php if( $_SESSION['rules'] <= 3 ) : ?>
            <li class="has-sub"><a href="#">Pages</a>
              <ul>
                <li><a href="pages.php">All Pages</a></li>
                <li><a href="page.php">New page</a></li>
                <?php if( $_SESSION['rules'] == 1 ) : ?>
                <li><a href="contact.php">Create contact page</a></li>
                <?php endif; ?>
              </ul>
            </li>
            <?php endif; ?>
            <li class="has-sub"><a href="#">Users</a>
              <ul>
                <?php if( $_SESSION['rules'] == 1 ) : ?>
                <li><a href="users.php">All Users</a></li>
                <?php endif; ?>
                <li><a href="user.php?id=<?php echo $_SESSION['user']; ?>">Your profile</a></li>
              </ul>
            </li>
            <?php if( $_SESSION['rules'] == 1 ) : ?>
            <li ><a href="options.php">Options</a></li>
            <?php endif; ?>
          </ul>
        </div>
        </div>