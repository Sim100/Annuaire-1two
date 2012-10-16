<?PHP
session_start();
if (($_POST['username']!="") and ($_POST['password']!="")) {
$_SESSION["username"]=$_POST['username'];
$_SESSION["password"]=$_POST['password']; }

include ('_connexion.php');
include ('fonc-url.php');
include('_users_online.php');
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="fr" lang="fr">
<head>
<title>Mot de Passe oublié - Annuaire 1two</title>
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
</head>


<body>
	
	<div class="container">
		
		<?PHP include ('header.php'); ?>
	
		<div class="row">
		
			<div class="span9">
				<?PHP
				echo "<h1>Mot de Passe oublié</h1>";
				
				
				//NAVIGATION
				echo "<ul class='breadcrumb'>";
				echo "<li><a href='http://www.1two.org'>Accueil</a> <span class='divider'>/</span></li>";
				echo "<li class='active'>Mot de Passe oublié</li>";
				echo "</ul>";
				//
				
				
				$res_conf_username=mysql_query("SELECT mail, owner FROM 1two_annuaire_sites WHERE mail='".$_POST['email']."' and ((url='".$_POST['url']."') or (url='".$_POST['url']."/'))",$db);
				
				if (($_POST['EmailPassword']=="Soumettre") and ($_POST['email']!="") and ($_POST['url']!="") and ($_POST['verification']==$_POST['verifresult']) and (mysql_num_rows($res_conf_username)!=0) )
					{
					$newpassword="1two-".rand(1000, 9999);
					
					$res_update_password=mysql_query("UPDATE 1two_annuaire_sites SET password='".md5($newpassword)."' WHERE mail='".$_POST['email']."' and url='".$_POST['url']."'",$db);
					
					$list_conf_username=mysql_fetch_row($res_conf_username);
					
					echo "<div class='alert alert-success'><button type='button' class='close' data-dismiss='alert'>×</button>Vous allez recevoir un email avec le nouveau mot de passe associé au nom d'utilisateur et au site web entrés. Vous pourrez changer ce nouveau mot de passe plus tard via votre compte personnel.</div>";
							
					mail("$list_conf_username[0]","Votre mot de passe Annuaire 1two","Bonjour $list_conf_username[1],\n\nLe nouveau mot de passe Annuaire 1two suivant est rattaché à cet email :\n\n$newpassword\n\nMerci d'utiliser Annuaire 1two !\n\nhttp://www.1two.org","From: Annuaire 1two <webmaster@1two.org>\r\n");	
					}
				else {
					if (($_POST['EmailPassword']=="Soumettre") and (mysql_num_rows($res_conf_username)==0)) echo "<div class='alert alert-error'><button type='button' class='close' data-dismiss='alert'>×</button>Désolé, cette adresse email ou ce site web ne sont pas présents dans notre base de données</div>";
					if (($_POST['EmailPassword']=="Soumettre") and ($_POST['verification']!=$_POST['verifresult'])) echo "<div class='alert alert-error'><button type='button' class='close' data-dismiss='alert'>×</button>Désolé, le résultat de l'opération n'est pas le bon, merci d'essayer à nouveau</div>";
					}
				
				?>
				
				<form method="post" action="" class="form-horizontal">
				<div class="control-group">
					<label class="control-label">Votre site web</label>
					<div class="controls"><input type="text" name="url" value="http://" /></div>
				</div>
				<div class="control-group">
					<label class="control-label">Votre Email</label>
					<div class="controls"><input type="text" name="email" placeholder="Email" /></div>
				</div>
				<div class="control-group">
					<div class='alert alert-info'><button type='button' class='close' data-dismiss='alert'>×</button>Pour éviter le Spam, nous vous demandons de réaliser l'opération qui apparaît ci-dessous avant de cliquer sur le bouton 'Soumettre' :</div>
					<label class="control-label">Vérification</label>
					<div class="controls">
					<?PHP
					$val1=rand(1, 10);
					$val2=rand(1, 10);
					$verifresult=$val1*$val2;
					?>
					<input type="text" name="verification" placeholder="<?PHP echo "$val1 x $val2 = "; ?>" /><input type="hidden" name="verifresult" value="<? echo $verifresult; ?>" />
				</div></div>
				<div class="control-group">
				  <div class="controls">
					<input type="submit" class='btn btn-info' name="EmailPassword" value="Soumettre" />
				  </div>
				</div>
			  </form>
				
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