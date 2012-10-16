<?PHP
$res_new_premium=mysql_query("SELECT compteur, title, url FROM 1two_annuaire_sites WHERE premium=1 ORDER BY prem_val DESC LIMIT 10",$db);
if (mysql_num_rows($res_new_premium)!=0)
	{
	echo "<p><table class='table-striped table-hover table-bordered' cellpadding='5'>";
	echo "<caption>Nouveaux premium</caption>";
	echo "<tbody>";
	$nb_new_premium=mysql_num_rows($res_new_premium);
	for ($i=0; $i<$nb_new_premium; $i++)
		{
		$list_new_premium=mysql_fetch_row($res_new_premium);
		echo "<tr><td><img src='http://www.robothumb.com/src/?url=$list_new_premium[2]&size=100x75' width='50' class='img-polaroid pull-right' alt=\"$list_new_premium[1]\" title=\"$list_new_premium[1]\" /> <a href='$list_new_premium[2]'>$list_new_premium[1]</a></td></tr>";
		}
	echo "</tbody>";
	echo "</table></p>";
	}
?>