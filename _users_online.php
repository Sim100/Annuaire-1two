<?PHP
if( (isset($_COOKIE[onetwourl])) and ($_COOKIE[onetwourl]!="") )
	{
	if( (isset($_COOKIE[onetwopass])) and ($_COOKIE[onetwopass]!="") )
		{
		$_SESSION["username"] = $_COOKIE[onetwourl];
		$_SESSION["password"] = $_COOKIE[onetwopass];
		}
	}
?>
