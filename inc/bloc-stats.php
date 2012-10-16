<?PHP
echo "<p><div class='hero-unit'>";
$nbr_sites_valides=mysql_num_rows(mysql_query("SELECT compteur FROM 1two_annuaire_sites WHERE valid=1",$db));
$nbr_sites_waiting=mysql_num_rows(mysql_query("SELECT compteur FROM 1two_annuaire_sites WHERE valid=0",$db));
$nbrcat=mysql_num_rows(mysql_query("SELECT compteur FROM 1two_annuaire_cat",$db));
$nbr_sites_submitted_today=mysql_num_rows(mysql_query("SELECT compteur FROM 1two_annuaire_sites WHERE date_ins='".date("Y-m-d")."'",$db));
$nbr_sites_accepted_today=mysql_num_rows(mysql_query("SELECT compteur FROM 1two_annuaire_sites WHERE date_val='".date("Y-m-d")."' and valid=1",$db));

echo "<p><strong>Statistiques :</strong></p>";
echo "<p><em>Stats globales</em><br /><span class='badge badge-info'>$nbr_sites_valides</span> sites dans l'annuaire<br /><span class='badge badge-info'>$nbr_sites_waiting</span> sites en attente<br /><span class='badge badge-info'>$nbrcat</span> catégories</p>";
echo "<p><em>Stats d'aujourd'hui</em><br /><span class='badge badge-warning'>$nbr_sites_submitted_today</span> nouveaux sites proposés<br /><span class='badge badge-warning'>$nbr_sites_accepted_today</span> nouveaux sites acceptés</p>";
echo "</div></p>";
?>