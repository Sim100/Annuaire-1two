<?PHP
define("host", ""); //serveur
define("user", ""); //utilisateur
define("pass", ""); //mot de passe
define("bdd", "");  //nom de la base

$db=@mysql_pconnect(host,user,pass);
@mysql_select_db(bdd, $db);
?>