<?PHP
session_start();
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

$choixmenu="proposerunsite";

include ('_connexion.php');
include ('fonc-url.php');
include('_users_online.php');

if ($_GET['page']=="") $_GET['page']=1;

$idmenu=$_GET['id'];
while ($idmenu!=0)
	{
	$query="SELECT name, inside, compteur FROM 1two_annuaire_cat WHERE compteur='$idmenu'";
	$res_cat_temps = @mysql_query($query,$db);
	$list_cat_temps=@mysql_fetch_row($res_cat_temps);
	$tempstitle=$list_cat_temps[0];
	$tempstitle=fonc_url($tempstitle);
	$tabmenu[]="<a href='/$tempstitle-$list_cat_temps[2]-".$_GET['page'].".html' class='liensnav'>$list_cat_temps[0]</a>";
	$tabtitle[]="$list_cat_temps[0]";
	$idmenu=$list_cat_temps[1];
	}
$nbrtabtitle=count ($tabtitle);
for ($u=$nbrtabtitle-1; $u>=0; $u--)
	{
	$titlepage.=" - $tabtitle[$u]"; $submittitle=$tabtitle[$u];
	}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="fr" lang="fr">
<head>
<title>R�f�rencement gratuit : r�f�rencez gratuitement votre site dans l'annuaire 1two.org, cat�gorie<?PHP echo "$titlepage"; ?></title>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<link href="bootstrap/css/bootstrap.min.css" rel="stylesheet">
<link href="bootstrap/css/bootstrap-responsive.min.css" rel="stylesheet">
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
        if(document.formulaire.urlsite.value == "") 
			{ 
			alert ('Entez une URL pour votre site web'); 
			document.formulaire.urlsite.focus(); 
			return false; 
			}
		if(document.formulaire.urlsite.value == "http://") 
			{ 
			alert ('Entez une URL pour votre site web'); 
			document.formulaire.urlsite.focus(); 
			return false; 
			}
		var pass = document.formulaire.password.value;
		if (pass.length < 6) { alert ('Votre mot de passe doit contenir au moins 6 caract�res'); return false; }
		if(document.formulaire.confpassword.value != document.formulaire.password.value) 
			{ 
			alert ('Le mot de passe et la confirmation sont diff�rents !'); 
			document.formulaire.confpassword.focus(); 
			return false; 
			}
       	if(document.formulaire.owner.value == "") 
			{ 
			alert ('Entrez votre nom'); 
			document.formulaire.owner.focus(); 
			return false; 
			}
		var email = document.formulaire.email.value; 
        if (email.search(/^[_a-z0-9-]+(.[_a-z0-9-]+)*[^._-]@[a-z0-9-]+(.[a-z0-9]{2,4})*$/) == -1)
			{ 
			alert ('Entrez une adresse email valide'); 
			document.formulaire.email.focus(); 
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
		if(document.formulaire.agreeTC.checked == false) 
			{ 
			alert ('Vous devez accepter les Conditions d\'utilisation'); 
			document.formulaire.agreeTC.focus(); 
			return false; 
			}
else {return true;}
}
</script>

<script type="text/javascript">
function ChangeUrl(formulaire)
	{ if (formulaire.ListeUrl.selectedIndex != 0) { location.href = formulaire.ListeUrl.options[formulaire.ListeUrl.selectedIndex].value; }
	else { alert('S�lectionnez une cat�gorie.'); } }
</script>

</head>


<body>
	
	<div class="container">
		
		<?PHP include ('header.php'); ?>
	
		<div class="row">
		
			<div class="span9">
				<?PHP
				echo "<h1>Soumettre un site sur l'annuaire 1two</h1>";
				
				
				//NAVIGATION
				echo "<ul class='breadcrumb'>";
				echo "<li><a href='http://www.1two.org'>Accueil</a> <span class='divider'>/</span></li>";
				if ($_GET['id']==0) echo "<li class='active'>Proposer un site</li>"; else echo "<li><a href='/soumettre-un-site-0.html'>Proposer un site</a> <span class='divider'>/</span></li>";
				$nbrtabmenu=count ($tabmenu);
				for ($t=$nbrtabmenu-1; $t>=0; $t--)
					{
					if ($t==0) { echo "<li>$tabmenu[$t]<li>"; $catname=$tabmenu[$t]; }
					else echo "<li>$tabmenu[$t] <span class='divider'>/</span><li>";
					}
				echo "</ul>";
				//
				
				
				if ($_GET['id']==0)
					{
					echo "<div class='hero-unit'><p>Lorsque vous soumettez un site sur <a href='http://www.1two.org'>www.1two.org</a> (1two.org) toutes les informations, donn�es, textes, logiciels, musiques, sons, photographies, images, vid�os, messages ou tous autres mat�riels (ci-apr�s d�nomm�s collectivement le �Contenu�) sont sous la seule responsabilit� de la personne ayant �mis ce Contenu. Vous seul, et non 1two.org, �tes enti�rement responsable du Contenu que vous affichez. En toutes hypoth�ses, 1two.org ne pourra en aucun cas �tre tenu pour responsable du Contenu des sites soumis, notamment <b>du caract�re ill�gal du Contenu au regard de la r�glementation en vigueur</b>.</p></div>";
					
					echo "<p class='lead'>Conditions d'acceptation :</p>";
					
					echo "<div class='alert alert-warning'><button type='button' class='close' data-dismiss='alert'>�</button>Pour �tre accept� sur 1two.org, votre Site Web doit :
					
					<ul>
					<li>pr�senter un Contenu l�gal au regard de la r�glementation en vigueur et qui ne soit en aucun cas nuisible, mena�ant, abusif, constitutif de harc�lement, diffamatoire, vulgaire, obsc�ne, mena�ant pour la vie priv�e d'autrui, haineux, raciste, ou autrement r�pr�hensible (sites relatifs � la p�dophilie, aux ventes d'organes, aux ventes de substances illicites ou de toute autre objets et/ou prestations illicites, faisant l'apologie du terrorisme, des crimes de guerre, du nazisme) ;</li>
					<li>ne pas porter atteinte d'une quelconque mani�re aux utilisateurs mineurs ;</li>
					<li>pr�senter une charte graphique correcte ;</li>
					<li>avoir son propre nom de domaine (ex : votre-site.com) ;</li>
					<li>�tre en fran�ais ou poss�der une version fran�aise ;</li>
					<li>�tre soumis dans la cat�gorie qui lui correspond le mieux ou � d�faut dans une nouvelle cat�gorie que vous proposerez ;</li>
					<li>pr�senter une orthographe et une grammaire correcte ;</li>
					<li>ne pas �tre d�crit simplement par une succession de mots-cl�s.</li>
					</ul>
					
					</div>";
					
					echo "<div class='alert alert-info'><button type='button' class='close' data-dismiss='alert'>�</button>1two.org se r�serve le droit, � sa seule discr�tion, (sans que cela ne constitue une obligation) de refuser ou de supprimer tout site ne correspondant pas � ces exigences.</div>";
					
					echo "<table class='table'><tbody><tr>
					<td valign='bottom'><img src='design/arrow-down.gif' alt='' /></td>
					<td>
					Pour <b>soumettre un site dans l'annuaire 1two</b> :
					<ol>
					<li>baladez-vous dans l'annuaire jusqu'� rencontrer la cat�gorie qui correspond le mieux � votre site, puis cliquez sur le bouton <a href='#' class='btn btn-success'>Proposer un site dans ...</a></li>
					<li>ou s�lectionnez directement votre cat�gorie dans le menu d�roulant ci-dessous.</li>
					<ol>
					</td>
					</tr></tbody></table>
					";
					
										echo "<form method='post' action=''><select name='ListeUrl' onchange='ChangeUrl(this.form)' class='input-xlarge'><option value=''>S�lectionnez une cat�gorie</option>";
										
										$res_compteur=mysql_query("SELECT * FROM 1two_annuaire_cat",$db);
										if (mysql_num_rows($res_compteur)!=0)
											{
											for ($i=0; $i<mysql_num_rows($res_compteur); $i++)
												{
												$list_compteur=mysql_fetch_row($res_compteur);
												
												$tabmenu=""; $ligne="";
												$tabmenu[]="$list_compteur[3]";
												$idcat=$list_compteur[3];
												while ($idcat!=0)
													{
													$list_cat_temps=mysql_fetch_row(mysql_query("SELECT name, inside, compteur FROM 1two_annuaire_cat WHERE compteur='$idcat'",$db));
													$tabmenu[]="$list_cat_temps[0]";
													$idcat=$list_cat_temps[1];
													}
												
												$nbrtabmenu=count($tabmenu);
												for ($t=$nbrtabmenu-1; $t>=0; $t--)
													{
													if ($t==$nbrtabmenu-1) $ligne="$tabmenu[$t]"; elseif ($t!=0) $ligne.=" > $tabmenu[$t]"; else $ligne.=" > - $tabmenu[$t]";
													if ($t==0) $tabfinal[]="$ligne";
													}
												}
											$nbrtabfinal=count($tabfinal);
											$tabfinal[]=rsort($tabfinal);
											for ($f=$nbrtabfinal-1; $f>=0; $f--)
												{
												$ExplodeLine=explode(" > - ", $tabfinal[$f]);
												$CatName=$ExplodeLine[0];
												$CatNum=$ExplodeLine[1];
												
												$TestOptGroup=mysql_fetch_row(mysql_query("SELECT inside FROM 1two_annuaire_cat WHERE compteur=$CatNum",$db));
												
												if ($TestOptGroup[0]==0)
													{
													if ($f==$nbrtabfinal-1) echo "<optgroup label=\"$CatName\">";
													else echo "</optgroup><optgroup label=\"$CatName\">";
													}
												else echo "<option value='/soumettre-un-site-$CatNum.html'>$CatName</option>";
												if ($f==0) echo "</optgroup>";
												}
											}
										
										echo "</select></form>";
										
										
										echo "<p><a href='/wiki-votre-compte-premium-sur-1twoorg-p5'>D�couvrez aussi l'option compte Premium.</a></p>";
					}
					
				if ($_GET['id']!=0)
					{
					echo "<p>Vous avez s�lectionnez la cat�gorie <strong>$catname</strong> pour r�f�rencer votre site.</p>";
					
					echo "<p>Tous les champs sont requis</p>";
					
					echo "<p><em>L'adresse du site (URL) et le mot de passe seront vos identifiants de connexion</em></p>";
					
					echo "<div class='alert alert-error'><button type='button' class='close' data-dismiss='alert'>�</button>Attention, <b>A LIRE</b> : 1two.org n'accepte plus que les sites avec un <b>Nom de Domaine PROPRE</b>, achet�, de la forme <b>http://www.nom-du-site.tld</b> ou <b>http://nom-du-site.tld</b>. Donc inutile de soumettre des sous-domaines ou des noms de domaine gratuits (free, zilio, blog wordpress etc...tout cela sera refus� et imm�diatement effac�).</div>";
					
					echo "<form method='post' action='/mon_compte' name='formulaire' onsubmit='return validation();' class='form-horizontal'><input type='hidden' name='category' value='".$_GET['id']."' />";

					echo "<div class='control-group'>";
					echo "<div class='alert alert-info'><button type='button' class='close' data-dismiss='alert'>�</button>Exemple de noms de domaine <b>accept�s</b> : http://www.1two.org, http://1two.org, http://www.exemple.com/index-fr.html, http://fr.exemple.com<br />
					- Exemple de noms de domaine <b>refus�s</b> : http://exemple.free.fr, http://www.exemple.com/article-de-mon-choix.html, http://exemple.com/index.php?id=2&article=5&page=1</div>";
					echo "<label class='control-label'>Adresse du site</label><div class='controls'><input name='urlsite' class='input-xlarge' type='text' maxlength='200' value='http://' value='".$_POST['urlsite']."' /></div>";
					echo "</div>";
					
					echo "<hr></hr>";
					
					echo "<div class='control-group'>";
					echo "<div class='alert alert-info'><button type='button' class='close' data-dismiss='alert'>�</button>6-20 caract�res, entr�es alphanumeriques seulement</div>";
					echo "<label class='control-label'>Mot de Passe</label><div class='controls'><input name='password' type='password' placeholder='Mot de passe' maxlength='20' /></div>";
					echo "</div>";
					
					echo "<div class='control-group'>";
					echo "<label class='control-label'>Confirmez votre Mot de Passe</label><div class='controls'><input name='confpassword' placeholder='Confirmation' type='password' maxlength='20' /></div>";
					echo "</div>";
					
					echo "<hr></hr>";
					
					echo "<div class='control-group'>";
					echo "<div class='alert alert-info'><button type='button' class='close' data-dismiss='alert'>�</button>Votre nom, un pseudo, un nom de soci�t�, etc...</div>";
					echo "<label class='control-label'>Votre nom</label><div class='controls'><input name='owner' type='text' placeholder='Nom' maxlength='20' value='".$_POST['owner']."' /></div>";
					echo "</div>";
					
					echo "<hr></hr>";
					
					echo "<div class='control-group'>";
					echo "<div class='alert alert-info'><button type='button' class='close' data-dismiss='alert'>�</button>Renseignez une adresse email valide. <b>Cet email n'apparaitra pas sur le site</b> et vous permettra de recevoir un email de confirmation d'acceptation ou de refus de votre site web.</div>";
					echo "<label class='control-label'>Votre email</label><div class='controls'><input name='email' type='text' placeholder='Email' maxlength='100' value='".$_POST['email']."' /></div>";
					echo "</div>";
					
					echo "<hr></hr>";
					
					echo "<div class='control-group'>";
					echo "<div class='alert alert-info'><button type='button' class='close' data-dismiss='alert'>�</button><b>LE TITRE DU SITE</b> : un titre est une suite de quelques mots maximum (pas une phrase). Le titre commence par une majuscule. Pas de point final � la fin du titre. Ne mettez pas de caract�res sp�ciaux dans votre titre. Merci.</div>";
					echo "<label class='control-label'>Titre du site</label><div class='controls'><input name='titlesite' type='text' class='input-xxlarge' placeholder='Titre' maxlength='100' value='".$_POST['titlesite']."' /></div>";
					echo "</div>";
					
					echo "<hr></hr>";
					
					echo "<div class='control-group'>";
					echo "<div class='alert alert-info'><button type='button' class='close' data-dismiss='alert'>�</button>R�digez une <b>description d'une longueur correcte</b>, il n'y a pas de limite, mais les descriptions trop courtes seront refus�es. Attention � l'orthographe, � la grammaire et � la ponctuation.</div>";
					echo "<label class='control-label'>Description du site</label><div class='controls'><textarea name='descriptionsite' class='input-xxlarge' rows='8' placeholder='Description du site'>".$_POST['descriptionsite']."</textarea></div>";
					echo "</div>";
					
					echo "<hr></hr>";
					
					echo "<div class='control-group'>";
					echo "<div class='controls'>";
					echo "<label class='checkbox'><input type='checkbox' name='agreeTC' value='1'"; if ($_POST['agreeTC']=="1") echo " checked"; echo "/> En m'inscrivant � 1two.org, j'accepte les conditions d'utilisation et la politique de gestion des <a href='/wiki-1twoorg-donnees-personnelles-confidentialite-p4'>donn�es personnelles</a> du site.</label>";
					
					echo "<input type='submit' class='btn btn-info' name='SubmitSite' value='Soumettre votre site' />";
					echo "</div>";
					echo "</div>";
					
					
					
					echo "</form>";	
					}
				
				?>
				
			</div>
			
			
			<div class="span3">
				<?PHP
				include ('inc/bloc-latest-sites.php');
					
				include ('inc/bloc-new-premium.php');
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