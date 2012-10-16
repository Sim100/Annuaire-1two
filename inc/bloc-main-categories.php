<?PHP
$res_main_cat_recall=mysql_query("SELECT * FROM 1two_annuaire_cat WHERE inside=0 and name!='XXX-Adulte' ORDER BY name ASC",$db);
$nb_main_cat_recall=mysql_num_rows($res_main_cat_recall);
echo "<p><ul class='nav nav-pills nav-stacked'>";
for ($i=0; $i<$nb_main_cat_recall; $i++)
	{
	$list_main_cat_recall=mysql_fetch_row($res_main_cat_recall);
	echo "<li";
	
	if ( ($_GET['id']==$list_main_cat_recall[3]) or ($_SESSION["cat_vignette"]==$list_main_cat_recall[3]) ) echo " class='active'";
	
	echo "><a href='/".fonc_url($list_main_cat_recall[0])."-$list_main_cat_recall[3]-1.html'>";
	
	if ( ($_GET['id']==$list_main_cat_recall[3]) or ($_SESSION["cat_vignette"]==$list_main_cat_recall[3]) ) echo "<i class='icon-chevron-left icon-white'></i> ";
	
	echo "$list_main_cat_recall[0]</a></li>";
	}
echo "</ul></p>";
?>