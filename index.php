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

include ('_connexion.php');
include ('fonc-url.php');
include('_users_online.php');

if ($_GET['page']=="") $_GET['page']=1;

$idmenu=$_GET['id'];
while ($idmenu!=0)
	{
	$list_cat_temps=mysql_fetch_row(mysql_query("SELECT name, inside, compteur FROM 1two_annuaire_cat WHERE compteur='$idmenu'",$db));
	$tabmenu[]="<a href='/".fonc_url($list_cat_temps[0])."-$list_cat_temps[2]-1.html'>$list_cat_temps[0]</a>";
	$tabtitle[]="$list_cat_temps[0]";
	$idmenu=$list_cat_temps[1];
	if ($idmenu==0) $_SESSION["cat_vignette"]=$list_cat_temps[2];
	}
$nbrtabtitle=count ($tabtitle);
for ($u=$nbrtabtitle-1; $u>=0; $u--)
	{
	$titlepage.=" - $tabtitle[$u]";
	if ($u==0) $submittitle=$tabtitle[$u];
	}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="fr" lang="fr">
<head>
<title>Annuaire 1two<?PHP if ($_GET['id']=="") echo ", Annuaire de liens et annuaire généraliste gratuit des meilleurs sites web avec liens en dur"; else echo "$titlepage"; ?></title>
<meta name="viewport" content="width=device-width, initial-scale=1.0" />
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<meta name="description" content="Annuaire de liens 1two<?PHP echo "$titlepage"; ?>" />
<meta name="keywords" content="Annuaire de liens 1two<?PHP echo "$titlepage"; ?>" />
<link href="bootstrap/css/bootstrap.min.css" rel="stylesheet" />
<link href="bootstrap/css/bootstrap-responsive.min.css" rel="stylesheet" />
<link rel="stylesheet" href="style.css" type="text/css" />
<link rel="shortcut icon" type="image/vnd.microsoft.icon" href="/favicon.ico" />
<link rel="shortcut icon" href="/favicon.ico" type="image/x-icon" />


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
function confirmer(){if (confirm 
("1TWO.org – Section Adulte\n\nATTENTION : SITE ADULTE RESERVE AUX MAJEURS DE PLUS DE 18 ANS\n\nCe site Internet est réservé à un public majeur et averti et est conforme à toutes les réglementations françaises en vigueur. Il contient des textes, des photos et des vidéos classées X qui peuvent être choquantes pour certaines sensibilités.\n\nJe certifie sur l'honneur à :\n- être majeur selon la loi en vigueur dans mon pays.\n- que les lois de mon état ou mon pays m'autorisent a accéder à ce site et que ce site a le droit de me transmettre de telles données.\n- être informé du caractère pornographique du serveur auquel j'accède.\n- je déclare n'être choqué par aucun type de sexualité et m'interdit de poursuivre la société éditrice de toute action judiciaire.\n- consulter ce serveur à titre personnel sans impliquer de quelque manière que ce soit une société privée ou un organisme public.\n\nJe m'engage sur l'honneur à :\n- ne pas faire état de l'existence de ce serveur et à ne pas en diffuser le contenu à des mineurs.\n- utiliser tous les moyens permettant d'empêcher l'accès de ce serveur à tout mineur.\n- assumer ma responsabilité, si un mineur accède à ce serveur à cause denégligences de ma part : absence de protection de l'ordinateur personnel, absence de logiciel de censure, divulgation ou perte du mot de passe de sécurité.\n- assumer ma responsabilité si une ou plusieurs de mes présentes déclarations sont inexactes.\nToutes les images contenues dans ce site sont en accord avec la loi Française sur la pornographie.\n\nJ'ai lu attentivement les paragraphes ci-dessus et signe électroniquement mon accord avec ce qui précède en cliquant sur le bouton OK.")) 
document.location.href='/xxx-adulte-291-1.html'; return "false"} 
</script>

</head>


<body>
	
	<div class="container">
		
		<?PHP include ('header.php'); ?>
	
		<div class="row">
		
			<div class="span9">
				<?PHP
				//NAVIGATION
				if ($_GET['id']!="")
					{
					echo "<h1>Guide : $submittitle</h1>";
					
					
					echo "<ul class='breadcrumb'>";
					echo "<li><a href='http://www.1two.org'>Accueil</a> <span class='divider'>/</span></li>";
					$nbrtabmenu=count ($tabmenu);
					for ($t=$nbrtabmenu-1; $t>=0; $t--)
						{
						if ($t==0) echo "<li>$tabmenu[$t]<li>";
						else echo "<li>$tabmenu[$t] <span class='divider'>/</span><li>";
						}
					echo "</ul>";
					}
				//
				
				if ( ($_GET['id']!="") and ($_GET['id']!=1) and ($_GET['id']!=28) and ($_GET['id']!=39) and ($_GET['id']!=52) and ($_GET['id']!=67) and ($_GET['id']!=75) and ($_GET['id']!=89) and ($_GET['id']!=97) and ($_GET['id']!=108) and ($_GET['id']!=121) and ($_GET['id']!=129) and ($_GET['id']!=153) and ($_GET['id']!=166) and ($_GET['id']!=172) and ($_GET['id']!=183) and ($_GET['id']!=199) and ($_GET['id']!=211) and ($_GET['id']!=291) ) {
				echo "<p><a href='/soumettre-un-site-".$_GET['id'].".html' class='btn btn-success'>Proposer un site dans $submittitle</a></p>";
				}
	
	
				if ($_GET['id']=="") echo "<div class='hero-unit'><p>1two.org est un annuaire généraliste gratuit. Avec plus de 45,000 sites en base, 1two.org se veut être un annuaire de liens de qualité. Pour référencer gratuitement votre site web, baladez-vous jusqu'à la catégorie qui correspond le mieux à votre site, puis cliquez sur le bouton « <a href='/soumettre-un-site-0.html' rel='tooltip' title=\"Proposez un site dans l'annuaire 1two\">Proposer un site</a> ». Nous offrons aussi un service « Premium » qui donne à votre site une meilleure visibilité, en tête de classement dans sa catégorie. Pour bénéficier de ce service, connectez-vous à votre <a href='/mon_compte' rel='tooltip' title='Accèder à mon compte'>partie membre</a>...</p></div>";
				
				if ($_GET['id']=="")
					{
					$res_cat_racine=mysql_query("SELECT * FROM 1two_annuaire_cat WHERE inside=0 ORDER BY name ASC",$db);
					echo "<ul class='thumbnails'>";
					for ($i=0; $i<18; $i++)
						{
						$list_cat_racine=mysql_fetch_row($res_cat_racine);
						
						
						
						//NOMBRE DE SITES
						$list_cat[]=$list_cat_racine[3];
						while (list($not,$id_cat) = each ($list_cat))
							{
							$query="SELECT compteur FROM 1two_annuaire_cat WHERE inside='$id_cat'"; $res_inside=mysql_query($query,$db); $nbrinside=mysql_num_rows($res_inside);
							for ($h=0;$h<$nbrinside;$h++)
								{
								$list_inside=mysql_fetch_row($res_inside); $list_cat[]=$list_inside[0];
								}
							}
						$query_nbrsites = "SELECT compteur FROM 1two_annuaire_sites WHERE valid=1 and (";
						$nbr_cat = sizeof($list_cat);
						for ($nbc=0;$nbc<$nbr_cat-1;$nbc++)
							{ $query_nbrsites .= "category = '$list_cat[$nbc]' or "; }
						$query_nbrsites .= "category = '$list_cat[$nbc]')";
						$res_nbrsites=mysql_query($query_nbrsites,$db);
						$nbrsites=mysql_num_rows($res_nbrsites);
						$list_cat="";
						//
						
						echo "<li class='span3'>";
							echo "<div class='thumbnail'>";
							
							$cat_content="<p><strong>";
							if ($list_cat_racine[3]==291) $cat_content.="<a href='#' onclick='confirmer()'>"; else $cat_content.="<a href='/".fonc_url($list_cat_racine[0])."-$list_cat_racine[3]-1.html'>";
							$cat_content.="$list_cat_racine[0]</a>";
							$cat_content.="</strong></p>";
							
							echo "<span class='hidden-desktop'><div class='home_cat_title_height'>$cat_content</div></span>";
							echo "<span class='visible-desktop'>$cat_content</span>";
							
							if ($list_cat_racine[3]==291) echo "<a href='#' onclick='confirmer()'>"; else echo "<a href='/".fonc_url($list_cat_racine[0])."-$list_cat_racine[3]-1.html'>";
							echo "<img src='design/cat-photo-".$list_cat_racine[3].".jpg' title=\"$list_cat_racine[0]\" alt=\"$list_cat_racine[0]\" />";
							echo "</a>";
							
							echo "<span class='badge'>$nbrsites sites</span>";
							
							echo "</div>";
						echo "</li>";
						}
					echo "</ul>";
					}
				else
					{
					if ( (strpos($titlepage, 'XXX-Adulte') === false) and (strpos($titlepage, 'Poker / Casino') === false ) )
						{
						?>
						<p align='center'>
						<span class="hidden-phone">
						<script type="text/javascript"><!--
						google_ad_client = "pub-8396385936154281";
						/* 468x60, date de création 25/08/09 */
						google_ad_slot = "1440800833";
						google_ad_width = 468;
						google_ad_height = 60;
						//-->
						</script>
						<script type="text/javascript"
						src="http://pagead2.googlesyndication.com/pagead/show_ads.js">
						</script>
						</span>
						
						<span class="visible-phone">
						<script type="text/javascript"><!--
						google_ad_client = "ca-pub-8396385936154281";
						/* 1two_mobile */
						google_ad_slot = "5880232319";
						google_ad_width = 320;
						google_ad_height = 50;
						//-->
						</script>
						<script type="text/javascript"
						src="http://pagead2.googlesyndication.com/pagead/show_ads.js">
						</script>
						</span>
						</p>
						<?PHP
						}
					
					$res_cat_racine=mysql_query("SELECT * FROM 1two_annuaire_cat WHERE inside='".$_GET['id']."' ORDER BY name ASC",$db);
					if (mysql_num_rows($res_cat_racine)!=0)
						{
						echo "<table class='table table-hover table-bordered' cellpadding='2'>";
						echo "<caption>Sous-catégories</caption>";
						echo "<tbody>";
						$nbcatracine=mysql_num_rows($res_cat_racine);
						for ($i=0; $i<$nbcatracine; $i++)
							{
							if ($i % 2 == 0) echo "<tr>";
							$list_cat_racine=@mysql_fetch_row($res_cat_racine);
							$query="SELECT * FROM 1two_annuaire_cat WHERE inside='$list_cat_racine[3]' ORDER BY name ASC LIMIT 15";
							$res_cat_souscat=mysql_query($query,$db);
							echo "<td><a href='/".fonc_url($list_cat_racine[0])."-$list_cat_racine[3]-1.html'><strong>$list_cat_racine[0]</strong></a>";
							
							$list_cat[]=$list_cat_racine[3];
							while (list($not,$id_cat) = each ($list_cat))
								{
								$res_inside=mysql_query("SELECT compteur FROM 1two_annuaire_cat WHERE inside='$id_cat'",$db); $nbrinside=mysql_num_rows($res_inside);
								for ($h=0;$h<$nbrinside;$h++)
									{
									$list_inside=mysql_fetch_row($res_inside); $list_cat[]=$list_inside[0];
									}
								}
							$query_nbrsites = "SELECT compteur FROM 1two_annuaire_sites WHERE valid=1 and (";
							$nbr_cat = sizeof($list_cat);
							for ($nbc=0;$nbc<$nbr_cat-1;$nbc++)
								{ $query_nbrsites .= "category = '$list_cat[$nbc]' or "; }
							$query_nbrsites .= "category = '$list_cat[$nbc]')";
							$res_nbrsites=@mysql_query($query_nbrsites,$db);
							$nbrsites=mysql_num_rows($res_nbrsites);
							$list_cat="";
							echo " <span class='badge badge-warning'>$nbrsites</span>";
							
							echo "<br />";
							if (@mysql_num_rows($res_cat_souscat)!=0)
								{
								$nbsouscat=mysql_num_rows($res_cat_souscat);
								for ($j=0; $j<$nbsouscat; $j++)
									{
									$list_cat_souscat=@mysql_fetch_row($res_cat_souscat);
									echo "<a href='/".fonc_url($list_cat_souscat[0])."-$list_cat_souscat[3]-1.html'>$list_cat_souscat[0]</a>";
									if ($j!=$nbsouscat-1) echo " - "; else echo "...";
									}
								}
							echo "</td>";
							if ($i % 2 != 0) echo "</tr>";
							}
						if ($i % 2 != 0) echo "</tr>";
						echo "</tbody>";
						echo "</table>";
						}
					}
					
				if ($_GET['id']!="")
					{
					echo "<div class='alert alert-info'><button type='button' class='close' data-dismiss='alert'>×</button><h4>Devenez Membre Premium</h4>Vous pouvez devenir <strong>Membre Premium</strong> et voir votre Site Web s'afficher <strong>ICI</strong>, en tête de cette catégorie et sur toutes ses pages. <a href='/soumettre-un-site-".$_GET['id'].".html' rel='tooltip' title=\"Proposez votre site dans l'annuaire 1two\"><strong>Inscrivez votre site</strong></a> ou <a href='/mon_compte' rel='tooltip' title=\"Accéder à mon compte personnel\"><strong>connectez-vous</strong></a>.</div>";
					
					$res_site_premium=mysql_query("SELECT compteur, title, url, description, owner, mail, date_ins FROM 1two_annuaire_sites WHERE category='".$_GET['id']."' and valid=1 and premium=1 ORDER BY date_ins DESC, hour_ins DESC",$db);
					if (mysql_num_rows($res_site_premium)!=0)
						{
						echo "<p class='lead'>Classement Premium</p>";
						echo "<table class='table table-striped table-hover'>";
						echo "<tbody>";
						$nbsite_premium=mysql_num_rows($res_site_premium);
						for ($i=0; $i<$nbsite_premium; $i++)
							{
							$list_site_premium=mysql_fetch_row($res_site_premium);
							echo "<tr>";
							echo "<td><img src='http://www.robothumb.com/src/?url=$list_site_premium[2]&size=120x90' class='img-polaroid pull-left' alt=\"$list_site_premium[1]\" title=\"$list_site_premium[1]\" />";
							echo "<a href='site-".fonc_url($list_site_premium[1])."-$list_site_premium[0]'><strong>$list_site_premium[1]</strong></a> - <span class='muted'><small>".wiki_aff_date_fr($list_site_premium[6])."</small></span><p>".nl2br($list_site_premium[3])."<br /><a href='$list_site_premium[2]'>$list_site_premium[2]</a></p></td>";
							echo "</tr>";
							}
						echo "</tbody>";
						echo "</table>";
						}
						
						
						
					$res_site=mysql_query("SELECT compteur, title, url, description, owner, mail, date_ins FROM 1two_annuaire_sites WHERE category='".$_GET['id']."' and valid=1 and premium=0 ORDER BY date_ins DESC, hour_ins DESC",$db);
					if (mysql_num_rows($res_site)!=0)
						{
						echo "<p class='lead'>Classement Standard</p>";
						echo "<table class='table table-striped table-hover'>";
						echo "<tbody>";
						$nbsite=mysql_num_rows($res_site);
						$nbpage=ceil($nbsite/10);
						if ($_GET['page']=="") $_GET['page']=1;
						for ($i=0; $i<$nbsite; $i++)
							{
							$list_site=@mysql_fetch_row($res_site);
							if ( ($i>=10*$_GET['page']-10) and ($i<10*$_GET['page']) )
								{
								echo "<tr><td><img src='http://www.robothumb.com/src/?url=$list_site[2]&size=120x90' class='img-polaroid pull-left' alt=\"$list_site[1]\" title=\"$list_site[1]\" />";
								echo "<a href='site-".fonc_url($list_site[1])."-$list_site[0]'><strong>$list_site[1]</strong></a> - <span class='muted'><small>".wiki_aff_date_fr($list_site[6])."</small></span><p>".nl2br($list_site[3])."</p><span class='text-success'><small>$list_site[2]</small></span></td>";
								echo "</tr>";
								}
							}
						echo "</tbody>";
						echo "</table>";
						
						echo "<p><em>Allez à la page :</em></p>";
						
						if ($nbpage>1)
							{
							echo "<p><div class='pagination pagination-centered'><ul>";
							$prev=$_GET['page']-1; if ($_GET['page']!=1)
															{
															$consURL="<a href='/".$_GET['cat']."-".$_GET['id']."-$prev.html'>&laquo;</a>";
															echo "<li>".$consURL."</li>";
															}
							
							if ($_GET['page']>=10) { echo "<li><a href='/".$_GET['cat']."-".$_GET['id']."-1.html'>1</a></li><li><a href='/".$_GET['cat']."-".$_GET['id']."-2.html'>2</a></li><li><span>...</span></li>"; }
							
							for ($j=$_GET['page']-3; $j<=$_GET['page']+3; $j++)
								{
								if (($j>=1) and ($j<=$nbpage))
									{
									if ($j==$_GET['page']) echo "<li class='active'><span>$j</span></li>";
									else
										{
										$consURL="<a href='/".$_GET['cat']."-".$_GET['id']."-$j.html'>$j</a> ";
										echo "<li>".$consURL."</li>";
										}
									}
								}
							
							$avderpage=$nbpage-1;	
							if ($_GET['page']<=$nbpage-9) { echo "<li><span>...</span></li><li><a href='/".$_GET['cat']."-".$_GET['id']."-$avderpage.html'>$avderpage</a></li><li><a href='/".$_GET['cat']."-".$_GET['id']."-$nbpage.html'>$nbpage</a></li>"; }
									
							$next=$_GET['page']+1; if ($_GET['page']!=$nbpage) echo "<li><a href='/".$_GET['cat']."-".$_GET['id']."-$next.html'>&raquo;</a></li>";
							echo "</ul></div></p>";
							}
							
						}
					}
				?>
				
			</div>
			
			
			<div class="span3">
				<?PHP
				if ($_GET['id']=="")
					{
					include ('inc/bloc-stats.php');
					
					include ('inc/bloc-latest-sites.php');
					
					include ('inc/bloc-new-premium.php');
					}
				else
					{
					echo "<p><img src='design/cat-photo-".$_SESSION["cat_vignette"].".jpg' width='' class='img-polaroid' alt=\"Catégorie$titlepage\" title=\"Catégorie$titlepage\" /></p>";
					
					include ('inc/bloc-main-categories.php');
					}
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