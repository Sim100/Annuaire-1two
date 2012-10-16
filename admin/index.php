<?PHP
include ('../_connexion.php');
include ('../fonc-url.php');
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="fr" lang="fr">
<head>
<title>Annuaire 1Two - Administration</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="../bootstrap/css/bootstrap.min.css" rel="stylesheet">
<link href="../bootstrap/css/bootstrap-responsive.min.css" rel="stylesheet">
<link rel="stylesheet" href="../style.css" type="text/css">

<script src="../js/jquery.js"></script>
<script src="../bootstrap/js/bootstrap.min.js"></script>

<script type="text/javascript" src="../ckeditor/ckeditor.js"></script>
</head>

<body>
<div class="container">
	<div class="row">
		<div class="span12">
		
			<a href="http://www.1two.org/admin"><img src='../design/logo-1two.png' alt='Annuaire 1two, annuaire de liens et annuaire généraliste gratuit des meilleurs sites web avec liens en dur' title='Annuaire 1two, annuaire de liens et annuaire généraliste gratuit des meilleurs sites web avec liens en dur' /></a>
			
		</div>
	</div>
	<div class="row">
		<div class="span12">
		
			<ul class="nav nav-tabs">
			<li<?PHP if ($_GET['menu']=="") echo " class='active'"; ?>><a href="index.php">Accueil</a></li>
			<li<?PHP if ($_GET['menu']=="gestion") echo " class='active'"; ?>><a href="index.php?menu=gestion">Gérer les sites et catégories</a></li>
			<li<?PHP if ($_GET['menu']=="validsites") echo " class='active'"; ?>><a href="index.php?menu=validsites">Valider les sites en attente</a></li>
			<li>
				<form class="form-search" action=''>
				<div class="input-append">
				<input type="text" name='search_site' placeholder="Email, Titre, URL..." class="span2 search-query"><input type='hidden' name='menu' value='siteedition' />
				<button type="submit" class="btn">Search</button>
				</div>
				</form>
			</li>
			</ul>
			
			<?PHP
			if ($_GET['menu']=="gestion") include ('cat-gestion.php');
			if ($_GET['menu']=="validsites") include ('validsites.php');
			if ($_GET['menu']=="siteedition") include ('site-edition.php');
			
			
			if ($_GET['menu']=="")
				{
				echo "<div class='hero-unit'>";
				echo "<h4>Bienvenue dans la partie administration de l'annuaire</h4>";
				echo "<p>L'annuaire fonctionne très simplement. Vous pouvez ajouter / éditer / supprimer des catégories et sous-catégories sur autant de niveaux que vous le souhaitez, puis vous pouvez gérer les sites web soumis dans ces catégories.</p>";
				echo "<p>Personnellement j'utilise un peu plus de fonctionnalités que ce qui est fournis (comptes premium, forums etc...). Donc parfois dans le programme vous verrez des champs concernant ces fonctionnalités. Idem dans la base de données (ex. les champs \"premium\", \"prem_val\", \"hour_val\", \"premium_recall\" qui concernent les comptes premiums et \"topic_posted\", \"photo\" qui concernent les forums). Ignorez simplement ces champs, ou supprimez-les.</p>";
				echo "<p>L'annuaire 1two est couplé avec Twitter Bootstrap, ce qui en fait un site en responsive design, optimisé aussi bien pour les ordinateurs de bureaux que pour les tablettes et les téléphones.</p>";
				echo "<p>Je fournie aussi les 18 images des 18 catégories principales de l'annuaire 1two. Vous êtes libre de changer l'intitulé de ces catégories et leur image relative.</p>";
				echo "<p>Si vous avez des questions, problème d’installation, besoin de plugins, modifications etc. n’hésitez pas à poster sur les <a href='http://www.1two.org/forums.php'>forums</a>.</p>";
				echo "<p>Enjoy!</p>";
				echo "</a></div>";
				}
			?>
			
			<?PHP @mysql_close($db); ?>
			
		</div>
	</div>
	
	<div class="row">
		<div class="span12">
			<div class='hero-unit'>
				Powered by <a href='http://www.1two.org'>1two.org</a> © 2003.
			</div>
		</div>
	</div>
</div>
</body>
</html>