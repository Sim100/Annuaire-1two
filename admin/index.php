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
		
			<a href="http://www.1two.org/admin"><img src='../design/logo-1two.png' alt='Annuaire 1two, annuaire de liens et annuaire g�n�raliste gratuit des meilleurs sites web avec liens en dur' title='Annuaire 1two, annuaire de liens et annuaire g�n�raliste gratuit des meilleurs sites web avec liens en dur' /></a>
			
		</div>
	</div>
	<div class="row">
		<div class="span12">
		
			<ul class="nav nav-tabs">
			<li<?PHP if ($_GET['menu']=="") echo " class='active'"; ?>><a href="index.php">Accueil</a></li>
			<li<?PHP if ($_GET['menu']=="gestion") echo " class='active'"; ?>><a href="index.php?menu=gestion">G�rer les sites et cat�gories</a></li>
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
				echo "<p>L'annuaire fonctionne tr�s simplement. Vous pouvez ajouter / �diter / supprimer des cat�gories et sous-cat�gories sur autant de niveaux que vous le souhaitez, puis vous pouvez g�rer les sites web soumis dans ces cat�gories.</p>";
				echo "<p>Personnellement j'utilise un peu plus de fonctionnalit�s que ce qui est fournis (comptes premium, forums etc...). Donc parfois dans le programme vous verrez des champs concernant ces fonctionnalit�s. Idem dans la base de donn�es (ex. les champs \"premium\", \"prem_val\", \"hour_val\", \"premium_recall\" qui concernent les comptes premiums et \"topic_posted\", \"photo\" qui concernent les forums). Ignorez simplement ces champs, ou supprimez-les.</p>";
				echo "<p>L'annuaire 1two est coupl� avec Twitter Bootstrap, ce qui en fait un site en responsive design, optimis� aussi bien pour les ordinateurs de bureaux que pour les tablettes et les t�l�phones.</p>";
				echo "<p>Je fournie aussi les 18 images des 18 cat�gories principales de l'annuaire 1two. Vous �tes libre de changer l'intitul� de ces cat�gories et leur image relative.</p>";
				echo "<p>Si vous avez des questions, probl�me d�installation, besoin de plugins, modifications etc. n�h�sitez pas � poster sur les <a href='http://www.1two.org/forums.php'>forums</a>.</p>";
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
				Powered by <a href='http://www.1two.org'>1two.org</a> � 2003.
			</div>
		</div>
	</div>
</div>
</body>
</html>