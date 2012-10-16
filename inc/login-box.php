<?PHP
$form="<form method='post' class='form-horizontal' action=''>";
$form.="<div class='control-group'><label class='control-label'>Votre site web (sans le / à la fin)</label><div class='controls'><input type='text' name='username' value='http://' /></div></div>";
$form.="<div class='control-group'><label class='control-label'>Mot de passe</label><div class='controls'><input type='password' name='password' placeholder='Mot de passe' /></div></div>";
$form.="<div class='control-group'><div class='controls'><input type='submit' class='btn btn-info' name='membersaccess' value='Connexion' /></div></div>";
$form.="</form>";
$form.="<a href='/forgot-password.php'>Mot de passe oublié ?</a>";

echo "<h1>Accéder à mon compte</h1>";
echo $form;
?>