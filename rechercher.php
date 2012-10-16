<?PHP
session_start();
if (($_POST['username']!="") and ($_POST['password']!="")) {
$_SESSION["username"]=$_POST['username'];
$_SESSION["password"]=$_POST['password']; }

include ('_connexion.php');
include ('fonc-url.php');
include('_users_online.php');

if ($_GET['page']=="") $_GET['page']=1;

if ($_POST['search']!="") $_GET['search']=$_POST['search'];
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="fr" lang="fr">
<head>
<title>1two annuaire de liens<? echo " - Rechercher ".$_GET['search']; ?></title>
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
</head>


<body>
	
	<div class="container">
		
		<?PHP include ('header.php'); ?>
	
		<div class="row">
		
			<div class="span9">
				<?PHP
				echo "<h1>Résultat pour ".$_GET['search']."</h1>";
				
				
				//NAVIGATION
				echo "<ul class='breadcrumb'>";
				echo "<li><a href='http://www.1two.org'>Accueil</a> <span class='divider'>/</span></li>";
				echo "<li class='active'>Recherche</li>";
				echo "</ul>";
				//
				
				
				if ($_GET['search']!="")
					{
					//RESULTAT PREMIUM
					$res_racine_premium=mysql_query("SELECT title, url, description, mail, date_ins, category, compteur FROM 1two_annuaire_sites WHERE valid=1 and premium=1 and ((title LIKE '".$_GET['search']."') or (description LIKE '%".$_GET['search']."%') or (url LIKE '%".$_GET['search']."%')) ORDER BY date_ins DESC, hour_ins DESC",$db);
					if (mysql_num_rows($res_racine_premium)!=0)
						{
						echo "<p class='lead'>Classement Premium</p>";
						echo "<table class='table table-striped table-hover'>";
						echo "<tbody>";
						$nbracine_premium=mysql_num_rows($res_racine_premium);
						for ($i=0; $i<$nbracine_premium; $i++)
							{
							echo "<tr><td>";
							$list_racine_premium=mysql_fetch_row($res_racine_premium);
							$tabmenu="";
							$idmenu=$list_racine_premium[5];
							while ($idmenu!=0)
								{
								$list_cat_temps=mysql_fetch_row(mysql_query("SELECT name, inside, compteur FROM 1two_annuaire_cat WHERE compteur='$idmenu'",$db));
								$tabmenu[]="<a href='/".fonc_url($list_cat_temps[0])."-$list_cat_temps[2]-1.html' class='liensnav'>$list_cat_temps[0]</a>";
								$idmenu=$list_cat_temps[1];
								}
							echo "<small>";
							$nbrtabmenu=count ($tabmenu);
							for ($t=$nbrtabmenu-1; $t>=0; $t--)
								{
								if ($t==$nbrtabmenu-1) echo "Catégorie > ";
								if ($t==0) echo "<b>$tabmenu[$t]</b>";
								else echo "$tabmenu[$t] > ";
								}
							echo "</small>";
							
							echo "<img src='http://www.robothumb.com/src/?url=$list_racine_premium[1]&size=120x90' class='img-polaroid pull-left' alt=\"$list_racine_premium[0]\" title=\"$list_racine_premium[0]\" /><br />";
							echo "<a href='site-".fonc_url($list_racine_premium[0])."-$list_racine_premium[6]'><strong>$list_racine_premium[0]</strong></a> - <span class='muted'><small>".wiki_aff_date_fr($list_racine_premium[4])."</small></span><p>$list_racine_premium[2]<br /><a href='$list_racine_premium[1]'>$list_racine_premium[1]</a></p>";
							echo "</td></tr>";
							}
						echo "</tbody>";
						echo "</table>";
						}
					
					
					//RESULTATS STANDARD
					$res_racine=mysql_query("SELECT title, url, description, mail, date_ins, category, compteur FROM 1two_annuaire_sites WHERE valid=1 and premium=0 and ((title LIKE '".$_GET['search']."') or (description LIKE '%".$_GET['search']."%') or (url LIKE '%".$_GET['search']."%')) ORDER BY date_ins DESC, hour_ins DESC",$db);
					if (mysql_num_rows($res_racine)!=0)
						{
						echo "<p class='lead'>Classement Standard</p>";
						echo "<table class='table table-striped table-hover'>";
						echo "<tbody>";
						$nbracine=mysql_num_rows($res_racine);
						$nbpage=ceil($nbracine/10);
						if ($_GET['page']=="") $_GET['page']=1;
						for ($i=0; $i<$nbracine; $i++)
							{
							$list_racine=mysql_fetch_row($res_racine);
							if ( ($i>=10*$_GET['page']-10) and ($i<10*$_GET['page']) )
								{
								echo "<tr><td>";
								$tabmenu="";
								$idmenu=$list_racine[5];
								while ($idmenu!=0)
									{
									$list_cat_temps=mysql_fetch_row(mysql_query("SELECT name, inside, compteur FROM 1two_annuaire_cat WHERE compteur='$idmenu'",$db));
									$tabmenu[]="<a href='/".fonc_url($list_cat_temps[0])."-$list_cat_temps[2]-1.html' class='liensnav'>$list_cat_temps[0]</a>";
									$idmenu=$list_cat_temps[1];
									}
								echo "<small>";
								$nbrtabmenu=count ($tabmenu);
								for ($t=$nbrtabmenu-1; $t>=0; $t--)
									{
									if ($t==$nbrtabmenu-1) echo "Catégorie > ";
									if ($t==0) echo "<b>$tabmenu[$t]</b>";
									else echo "$tabmenu[$t] > ";
									}
								echo "</small>";
						
								echo "<img src='http://www.robothumb.com/src/?url=$list_racine[1]&size=120x90' class='img-polaroid pull-left' alt=\"$list_racine[0]\" title=\"$list_racine[0]\" /><br />";
								echo "<a href='site-".fonc_url($list_racine[0])."-$list_racine[6]'><strong>$list_racine[0]</strong></a> - <span class='muted'><small>".wiki_aff_date_fr($list_racine[4])."</small></span><p>$list_racine[2]</p><span class='text-success'><small>$list_racine[1]</small></span>";
								echo "</td></tr>";
								}
							}
						echo "</tbody>";
						echo "</table>";
						
						
						
						
						if ($nbpage>1)
							{
							echo "<p><em>Allez à la page :</em></p>";
							
							echo "<p><div class='pagination pagination-centered'><ul>";
							$prev=$_GET['page']-1; if ($_GET['page']!=1)
															{
															$consURL="<a href='/rechercher.php?search=".$_GET['search']."&page=$prev'>&laquo;</a>";
															echo "<li>".$consURL."</li>";
															}
							
							if ($_GET['page']>=10) { echo "<li><a href='/rechercher.php?search=".$_GET['search']."&page=1'>1</a></li><li><a href='/rechercher.php?search=".$_GET['search']."&page=2'>2</a></li><li><span>...</span></li>"; }
							
							for ($j=$_GET['page']-3; $j<=$_GET['page']+3; $j++)
								{
								if (($j>=1) and ($j<=$nbpage))
									{
									if ($j==$_GET['page']) echo "<li class='active'><span>$j</span></li>";
									else
										{
										$consURL="<a href='/rechercher.php?search=".$_GET['search']."&page=$j'>$j</a> ";
										echo "<li>".$consURL."</li>";
										}
									}
								}
							
							$avderpage=$nbpage-1;	
							if ($_GET['page']<=$nbpage-9) { echo "<li><span>...</span></li><li><a href='/rechercher.php?search=".$_GET['search']."&page=$avderpage'>$avderpage</a></li><li><a href='/rechercher.php?search=".$_GET['search']."&page=$nbpage'>$nbpage</a></li>"; }
									
							$next=$_GET['page']+1; if ($_GET['page']!=$nbpage) echo "<li><a href='/rechercher.php?search=".$_GET['search']."&page=$next'>&raquo;</a></li>";
							echo "</ul></div></p>";
							}
							
						
							
						}
						
						
						
					}
				else { echo "<b>Pas de résultats trouvés !</b><br /><br />"; }
				
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