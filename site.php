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

$list_site=mysql_fetch_row(mysql_query("SELECT * FROM 1two_annuaire_sites WHERE compteur='".$_GET['site_id']."'",$db));

$idmenu=$list_site[6];
while ($idmenu!=0)
	{
	$list_cat_temps=mysql_fetch_row(mysql_query("SELECT name, inside, compteur FROM 1two_annuaire_cat WHERE compteur='$idmenu'",$db));
	$tabmenu[]="<a href='/".fonc_url($list_cat_temps[0])."-$list_cat_temps[2]-1.html' class='liencatnav'>$list_cat_temps[0]</a>";
	$tabtitle[]="$list_cat_temps[0]";
	$idmenu=$list_cat_temps[1];
	if ($idmenu==0) $_SESSION["cat_vignette"]=$list_cat_temps[2];
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
<title><?PHP echo $list_site[1]; ?> - Annuaire de liens 1two</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0" />
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<meta name="description" content="<?PHP echo $list_site[1]; ?> - Annuaire de liens 1two" />
<meta name="keywords" content="<?PHP echo $list_site[1]; ?> - Annuaire de liens 1two" />
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
				$nbrtabmenu=count ($tabmenu);
				for ($t=$nbrtabmenu-1; $t>=0; $t--)
					{
					if ($t==0) echo "<li>$tabmenu[$t]<li>";
					else echo "<li>$tabmenu[$t] <span class='divider'>/</span><li>";
					}
				echo "</ul>";
				//
				
				if ($list_site[11]!=1)
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
					//else echo "<div class='main_frame'><div align='center'><a href='http://www.supersuceuse.com/fr/index.html?id=57295&tracker=_468x60_09' target='_blank'><img src='http://media.supersuceuse.com/fr/bh46880/468X80_09.gif'></a></div></div>";
					}
						
					
				echo "<h1>$list_site[1]</h1>";
				
				echo "<div align='center'><img src='http://www.robothumb.com/src/?url=$list_site[2]&size=320x240' class='img-polaroid' alt=\"$list_site[1]\" title=\"$list_site[1]\" /></div>";
				
				echo "<div class='hero-unit'><p>$list_site[4]</p><p>Visiter <a href='$list_site[2]'>$list_site[1]</a></p></div>";
				

				$res_othersites=mysql_query("SELECT compteur, title, url, description, owner, mail, date_ins FROM 1two_annuaire_sites WHERE category='$list_site[6]' AND valid=1 ORDER BY RAND() LIMIT 10",$db);
				if (mysql_num_rows($res_othersites)!=0)
					{
					echo "<p class='lead'>Autres sites dans la même catégorie :</p>";
					echo "<table class='table table-striped table-hover'>";
					echo "<tbody>";
					$nbr_othersites=mysql_num_rows($res_othersites);
					for ($i=0; $i<$nbr_othersites; $i++)
						{
						$list_othersites=mysql_fetch_row($res_othersites);
						echo "<tr><td><img src='http://www.robothumb.com/src/?url=$list_othersites[2]&size=120x90' class='img-polaroid pull-left' alt=\"$list_othersites[1]\" title=\"$list_othersites[1]\" /> <a href=\"site-".fonc_url($list_othersites[1])."-$list_othersites[0]\">$list_othersites[1]</a><br /><span class='muted'>$list_othersites[3]</span><br /><span class='text-success'>$list_othersites[2]</span></td></tr>";
						}
					echo "</tbody>";
					echo "</table>";
					}
				
				?>
				
			</div>
			
			
			<div class="span3">
				<?PHP
				include ('inc/bloc-main-categories.php');
				
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