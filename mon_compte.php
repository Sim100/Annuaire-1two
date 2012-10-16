<?PHP
session_start();

$choixmenu="moncompte";

include ('_connexion.php');
include ('fonc-url.php');
include('_users_online.php');

//Delete site dans 1two
if ($_GET['action']=="supprimerOK")
	{
	$result_delete_site=mysql_query("DELETE FROM 1two_annuaire_sites WHERE url='".$_SESSION["username"]."'",$db);
	}
//

//SAVE DATABASE
$sitesanshttp=explode("http://", $_POST['urlsite']); //www.site.com ou www.site.com/ est dans $sitesanshttp[1]
$sitesansslashfinal=explode("/", $sitesanshttp[1]); //retrait du / final
$_POST['urlsite']="http://".$sitesansslashfinal[0];

if (($_POST['SubmitSite']=="Soumettre votre site") and ($_POST['urlsite']!=""))
	{
	$query="SELECT url FROM 1two_annuaire_sites WHERE url='".$_POST['urlsite']."' or url='".$_POST['urlsite']."/'";
	$res_url=@mysql_query($query,$db);
	if (@mysql_num_rows($res_url)!=0)
		{
		$testurl="false";
		}
	}
if ( ($_POST['SubmitSite']=="Soumettre votre site") and ($testurl!="false") )
	{
	$_POST['owner']=strip_tags($_POST['owner']);
	$_POST['email']=strip_tags($_POST['email']);
	$_POST['titlesite']=strip_tags($_POST['titlesite']); $_POST['titlesite']=rtrim($_POST['titlesite'], " ");
	$_POST['descriptionsite']=strip_tags($_POST['descriptionsite']);
	$_POST['urlsite']=strip_tags($_POST['urlsite']);
	$query="INSERT INTO 1two_annuaire_sites (category, owner, mail, title, url, description, date_ins, hour_ins, valid, password) VALUES ('".$_POST['category']."', '".$_POST['owner']."', '".$_POST['email']."', '".$_POST['titlesite']."', '".$_POST['urlsite']."', '".$_POST['descriptionsite']."', NOW(), NOW(), '0', '".md5($_POST['password'])."')";
	$res_insert_site=@mysql_query($query,$db);
	
	//avertissement webmaster
	mail("webmaster@1two.org","Site soumis dans 1two","Le site ".$_POST['urlsite']." a été soumis dans 1two\n\nCatégorie suggérée: ".$_POST['suggestcat']."","From: Annuaire 1two <webmaster@1two.org>\r\n");
	//
	
	mail("".$_POST['email']."","Site en attente de validation dans l'annuaire 1two","Cher(e) ".$_POST['owner'].",\n\nMerci pour l'inscription de votre site dans l'annuaire 1two.\n\nVos informations de connexion sont les suivantes :\n\nNom d'utilisateur (votre site web) : ".$_POST['urlsite']."\n\nMot de passe : ".$_POST['password']."\n\nConnectez vous maintenant sur http://www.1two.org.\n\nVotre Site est en attente de validation, vous recevrez un email dès qu'il aura été accepté.\n\nVous pouvez déjà acheter un Compte Premium (10 euros par an), en vous connectant (http://www.1two.org/mon_compte), pour une validation en moins de 24 heures et un positionnement privilégié dans l’annuaire.\n\nPour faire un lien retour (pas obligatoire mais toujours appéciable), copier le simple code suivant : \n<a href='http://www.1two.org'>Annuaire 1two</a>\n\nSi vous avez des questions au sujet de notre site, envoyez-nous un email à info@1two.org.\n\nCordialement,\nL'équipe de l'annuaire 1two\nhttp://www.1two.org","From: Annuaire 1two <webmaster@1two.org>\r\n");
	
	$_POST['username']=$_POST['urlsite'];
	$_POST['password']=$_POST['password'];
	}
//

if (($_POST['username']!="") and ($_POST['password']!="")) {
$_SESSION["username"]=$_POST['username'];
$_SESSION["password"]=$_POST['password']; }

if ($_GET['session']=="logout") { session_destroy(); setcookie("onetwourl"); setcookie("onetwopass");	}

//COOKIE
if ($_POST['keepupdated']==1)
	{
	$expire=30*24*3600;
	setcookie("onetwourl","".$_SESSION["username"]."",time()+$expire);
	setcookie("onetwopass","".$_SESSION["password"]."",time()+$expire);
	}
//END COOKIE
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="fr" lang="fr">
<head>
<title>Mon Compte - Annuaire 1two</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0" />
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<link href="bootstrap/css/bootstrap.min.css" rel="stylesheet" />
<link href="bootstrap/css/bootstrap-responsive.min.css" rel="stylesheet" />
<link rel="stylesheet" href="style.css" type="text/css" />


<script type="text/javascript" src="js/jquery.js"></script>
<script type="text/javascript" src="bootstrap/js/bootstrap.min.js"></script>
<link type="text/css" rel="stylesheet" href="css/jquery.autocomplete.css" />
<script type="text/javascript" src="js/jquery.autocomplete.js"></script>

<script type="text/javascript">
  $(document).ready(function () {
    $("[rel=tooltip]").tooltip();
  });
</script>

<script type="text/javascript" src="https://apis.google.com/js/plusone.js"></script>

<script type="text/javascript"> 
function validation() 
{ 
        var email = document.formulaire.email.value; 
        if (email.search(/^[_a-z0-9-]+(.[_a-z0-9-]+)*[^._-]@[a-z0-9-]+(.[a-z0-9]{2,4})*$/) == -1)
        { 
        alert ('Entrez une adresse email valide'); 
        document.formulaire.email.focus(); 
        return false; 
        }
       	if(document.formulaire.owner.value == "") 
		{ 
        alert ('Entrez votre nom'); 
        document.formulaire.owner.focus(); 
        return false; 
    	}
		if(document.formulaire.titlesite.value == "") 
		{ 
        alert ('Entrez un titre pour votre site'); 
        document.formulaire.titlesite.focus(); 
        return false; 
    	}
		if(document.formulaire.descriptionsite.value == "") 
		{ 
        alert ('Entez une description pour votre site'); 
        document.formulaire.descriptionsite.focus(); 
        return false; 
    	}
else {return true;}
}
</script>

</head>


<body>
	
	<div class="container">
		
		<?PHP include ('header.php'); ?>
	
		<div class="row">
		
			<div class="span9">
				<?PHP
				//NAVIGATION
				echo "<ul class='breadcrumb'>";
				echo "<li><a href='http://www.1two.org'>Accueil</a> <span class='divider'>/</span></li>";
				echo "<li><a href='/mon_compte'>Mon compte</a></li>";
				echo "</ul>";
				//
				
				
				if ( ($_POST['SubmitSite']=="Soumettre votre site") and ($testurl!="false") )
					{
					echo "<div class='alert alert-success'><button type='button' class='close' data-dismiss='alert'>×</button>Bravo ! Votre compte a été créé et votre site a été soumis dans notre annuaire, en attente de validation. Vous allez bientôt recevoir un email de confirmation avec vos informations de connexion.</div>";
					}
				if ($testurl=="false")
					{
					echo "<div class='alert alert-error'><button type='button' class='close' data-dismiss='alert'>×</button>Le site ".$_POST['urlsite']." est déja référencé dans notre annuaire</div>";
					}
				if ($_GET['action']=="supprimerOK")
					{
					//delete dans la base de données plus haut
					echo "<div class='alert alert-block'><button type='button' class='close' data-dismiss='alert'>×</button>Votre Site Web a été supprimé de l'annuaire 1two</div>";
					}
				
				
				if (($_GET['session']=="logout") or ($_SESSION['username']=="") and ($_SESSION['password']==""))
					{
					session_destroy();
					include ('inc/login-box.php');
					}
				else
					{
					if ( ($_SESSION["username"]!="") and ($_SESSION["password"]!="") )
						{
						$query="SELECT password FROM 1two_annuaire_sites WHERE url='".$_SESSION["username"]."' or url='".$_SESSION["username"]."/'";
						$res_connection=mysql_query($query,$db);
						if (mysql_num_rows($res_connection)!=0)
							{
							$list_connection=mysql_fetch_row($res_connection);
							if ( $list_connection[0]==md5($_SESSION["password"]) )
								{					
								$list_name=mysql_fetch_row(mysql_query("SELECT * FROM 1two_annuaire_sites WHERE url='".$_SESSION["username"]."' or url='".$_SESSION["username"]."/'",$db));
								
								echo "<h1>$list_name[8] (site : $list_name[2])</h1>";
								
								echo "<ul class='nav nav-tabs'>";
								echo "<li"; if ($_GET['action']=="") echo " class='active'"; echo ">";
								echo "<a href='/mon_compte' title='Accueil de mon compte personnel'>Accueil</a>";
								echo "</li>";
								echo "<li"; if ($_GET['action']=="infos") echo " class='active'"; echo ">";
								echo "<a href='/mon_compte:infos' title='Modifer les infos de mon Site Web'>Mes infos</a>";
								echo "</li>";
								echo "<li"; if ($_GET['action']=="password") echo " class='active'"; echo ">";
								echo "<a href='/mon_compte:password' title='Changer mon Mot de Passe'>Mot de Passe</a>";
								echo "</li>";
								echo "<li"; if ($_GET['action']=="supprimer") echo " class='active'"; echo ">";
								echo "<a href='/mon_compte:supprimer' title=\"Supprimer mon site de l'annuaire 1two\">Supprimer</a>";
								echo "</li>";
								echo "<li><a href='/index.php?session=logout'><img src='design/cross.png' alt='' /> Déconnection</a></li>";
								if ($list_name[5]==1) {
									echo "<li"; if ($_GET['action']=="annonceur") echo " class='active'"; echo ">";
									echo "<a href='/mon_compte:annonceur'>Annoncez</a>";
									echo "</li>";
									}
								echo "</ul>";
								
								if ($_GET['action']=="")
									{
									if ($list_name[3]==0) echo "<div class='alert'> <button type='button' class='close' data-dismiss='alert'>×</button>Votre site web est en attente de validation</div><br />";
									if ($list_name[11]==0)
										{
										echo "<ul class='thumbnails'>";
										echo "<li class='span4'>";
										?>
										<p>Un <strong>Compte Premium</strong> est conseillé aux entreprises ou aux particuliers qui souhaitent bénéficier d'une meilleure visibilité sur le net.</p>
										<div align='center'>
										<p>
										<form action="https://www.paypal.com/cgi-bin/webscr" method="post">
										<input type="hidden" name="cmd" value="_s-xclick">
										<input type="hidden" name="hosted_button_id" value="CDEYMPAGEANEQ">
										<table>
										<tr><td><input type="hidden" name="on0" value="Site Web"></td></tr><tr><td><input type="hidden" name="os0" maxlength="60" value="<?PHP echo $list_name[2]; ?>"></td></tr>
										</table>
										<input type="image" src="http://www.1two.org/design/devenez-premium.gif" border="0" name="submit" alt="PayPal - la solution de paiement en ligne la plus simple et la plus sécurisée !">
										<img alt="" border="0" src="https://www.paypal.com/fr_FR/i/scr/pixel.gif" width="1" height="1">
										</form>
										</p>

										<p><img src="design/premium-screenshot.gif" alt="Exemple d'emplacement de votre site web en tête d'une catégorie" title="Exemple d'emplacement de votre site web en tête d'une catégorie" /></p>
										</div>
										<?PHP
										echo "</li>";
										echo "<li class='span4'><p class='text-error'><strong>AVANTAGES DU COMPTE PREMIUM</strong></p>";
										echo "<ul>";
										echo "<li><b>\"Fast Track\"</b> - Votre Site Web est validé en 24h.</li>";
										echo "<li><b>Recherche Préférentielle</b> - Quand un visiteur effectue une recherche, votre Site apparait avant les Sites inscrits gratuitement.</li>";
										echo "<li><b>Visibilité</b> - Votre Site est mis en avant, en tête de la catégorie dans lequel il est enregistré.</li>";
										echo "<li><b>Page Web Dédiée</b> - Votre propre page Web pour présenter votre Site.</li>";
										echo "<li><b>Pas de Publicité</b> - Votre page Web dédiée ne contiendra pas de publicité.</li>";
										echo "<li><b>Rappel Email</b> - 30 jours avant la fin de validité de votre Compte Premium, nous vous enverrons un email pour vous proposer de le prolonger.</li>";
										echo "<li><b>Prix Réduit</b> - <span class='text-error'>Seulement 10€ par an</span>.</li>";
										echo "</ul>";
										echo "</li>";
										echo "</ul>";
										}
									else
										{
										echo "<p><b>Vous êtes membre Premium jusqu'au</b> <span class='text-error'>".wiki_aff_date_fr($list_name[12])."</span></p>";

										echo "<p>Renouveler votre abonnement Premium pour un an supplémentaire (10€) *</p>";
										?>
										<p><form action="https://www.paypal.com/cgi-bin/webscr" method="post">
										<input type="hidden" name="cmd" value="_s-xclick">
										<input type="hidden" name="hosted_button_id" value="Y82HLLL558XAQ">
										<table>
										<tr><td><input type="hidden" name="on0" value="Site Web"></td></tr><tr><td><input type="hidden" name="os0" maxlength="60" value="<?PHP echo $list_name[2]; ?>"></td></tr>
										</table>
										<input type="image" src="http://www.1two.org/design/renouveler.gif" border="0" name="submit" alt="PayPal - la solution de paiement en ligne la plus simple et la plus sécurisée !">
										<img alt="" border="0" src="https://www.paypal.com/fr_FR/i/scr/pixel.gif" width="1" height="1">
										</form></p>
										<?PHP
										}
									
									echo "<p>* Vous pouvez renouveler un compte Premium à tout moment. L'année supplémentaire payée sera ajoutée à partir de la fin de l'année déja payée.</p>";
									}
								if ($_GET['action']=="infos")
									{
									include ('inc/mes-infos.php');
									}
								if ($_GET['action']=="password")
									{
									include ('inc/password.php');
									}
								if ($_GET['action']=="supprimer")
									{
									include ('inc/supprimer.php');
									}
								}
							else include ('inc/login-box.php');
							}
						else { if ($_GET['action']!="supprimerOK") include ('inc/login-box.php'); }
						}
					else include ('inc/login-box.php');
					}
				?>
				
			</div>
			
			
			<div class="span3">
				<?PHP
				include ('inc/bloc-stats.php');
				?>
			</div>
			
		</div>
		
		<div class="row">
			<div class="span12">
				<?PHP include ('footer.php'); ?>
			</div>
		</div>
	
	
	<?PHP @mysql_close($db); ?>
	</div>
	
	
	
					

</body>
</html>