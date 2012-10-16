<?PHP
$res_latest_sites=mysql_query("SELECT compteur, title, url FROM 1two_annuaire_sites WHERE valid=1 ORDER BY date_val DESC, hour_val DESC LIMIT 10",$db);
if (mysql_num_rows($res_latest_sites)!=0)
	{
	echo "<p><table class='table-striped table-hover table-bordered' cellpadding='5'>";
	echo "<caption>Derniers sites inscrits</caption>";
	echo "<tbody>";
	$nb_latest_sites=mysql_num_rows($res_latest_sites);
	for ($i=0; $i<$nb_latest_sites; $i++)
		{
		$list_latest_sites=mysql_fetch_row($res_latest_sites);
		echo "<tr><td><img src='http://www.robothumb.com/src/?url=$list_latest_sites[2]&size=100x75' width='50' class='img-polaroid pull-right' alt=\"$list_latest_sites[1]\" title=\"$list_latest_sites[1]\" /> <a href='site-".fonc_url($list_latest_sites[1])."-$list_latest_sites[0]'>$list_latest_sites[1]</a></td></tr>";
		}
	echo "</tbody>";
	echo "</table></p>";
	}
?>