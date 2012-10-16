<?PHP
$list_password=mysql_fetch_row(mysql_query("SELECT password FROM 1two_annuaire_sites WHERE url='".$_SESSION["username"]."' or url='".$_SESSION["username"]."/'",$db));

if ( ($_POST['UpdatePassword']=="Modifier") and ($_POST['password']==$_POST['confpassword']) and (strlen($_POST['password'])>=6) and (md5 ($_POST['current_password'])==$list_password[0]) )
	{
	$query="UPDATE 1two_annuaire_sites SET password='".md5 ($_POST['password'])."' WHERE url='".$_SESSION["username"]."' or url='".$_SESSION["username"]."/'";
	$res_update_password=mysql_query($query,$db);
		
	echo "<div class='alert alert-success'><button type='button' class='close' data-dismiss='alert'>×</button>Votre mot de passe a été modifié</div>";
	}
else
	{
	if (($_POST['UpdatePassword']=="Modifier") and (($_POST['password']!=$_POST['confpassword']) or (strlen($_POST['password'])<6) or (strlen($_POST['password'])>20) or (md5 ($_POST['current_password'])!=$list_password[0]))) { echo "<div class='alert alert-error'><button type='button' class='close' data-dismiss='alert'>×</button>Erreur, essayez à nouveau !</div>"; }
	}
?>
<p><b>Changer mon Mot de Passe :</b></p>
<form method="post" action="" class="form-horizontal">

<div class="control-group">
<label class="control-label">Mot de passe actuel</label>
<div class="controls"><input name="current_password" type="password" placeholder="Mot de passe" maxlength="20" /></div>
</div>

<div class="control-group">
<label class="control-label">Nouveau mot de passe</label>
<div class="controls"><input name="password" type="password" placeholder="Confirmation" maxlength="20" /><span class="help-inline">6-20 caractères, entrèes alphanumeriques seulement</span></div>
</div>

<div class="control-group">
<label class="control-label">Retapez votre nouveau mot de passe</label>
<div class="controls"><input placeholder="Nouveau mot de passe" name="confpassword" type="password" maxlength="20" /></div>
</div>

<div class="control-group">
<div class="controls">
<td><input type="submit" class='btn btn-info' name="UpdatePassword" value="Modifier" /></div>
</div>

</form>