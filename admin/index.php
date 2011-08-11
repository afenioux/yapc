<?php
include('../inc/include_fns.php');
include('inc/header.php');

if (!check_auth_user()) {
	print_login_form();
}
else {
    $_SESSION['destination'] = 'index.php';
?>

    <div class="titlearea">
        <small>Vous êtes connecté <?php print $_SESSION['auth_user'].'!';?></small>
        <br /><br />
        <h1>Page d'administration</h1>
    </div>
    
    <div class="pagearea buttonarea">
    
        <div>
           <a href="new_article.php">
            <img src="img/new.png" alt="Nouvel article"/>
            <span>Nouvel article</span><br />Poster un nouvel article.
          </a>
        </div>
        
        <div>
          <a href="edit.php">
            <img src="img/edit.png" alt="Editer articles et catégories"/>
            <span>Editer articles et categories</span><br />Editer les articles ainsi que leurs catégories.
          </a>
        </div>
        
        <div>
          <a href="users.php">
            <img src="img/users.png" alt="Utilisateurs"/>
            <span>Utilisateurs</span><br />Créer, supprimer ou modifier un compte utilisateur.
          </a>
        </div>
        
        <div>
          <a href="../">
            <img src="img/preview.png" alt="site public"/>
            <span>Site public</span><br />Voyez ce que tout le monde peut voir de votre site.
          </a>
        </div>
        
        <div>
          <a href="logout.php">
            <img src="img/logout.png" alt="Logout"/>
            <span>Logout</span><br />Fermer votre session, ou se connecter sous un autre nom.
          </a>
        </div>
        
    </div>
<?php
    include('inc/footer.php');
}
?>
