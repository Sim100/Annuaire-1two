<?PHP
if ($_POST['search_site']!="") $_GET['search_site']=$_POST['search_site'];


if ($_GET['action']=="deletesite")
	{
	$list_delete_site=mysql_fetch_row(@mysql_query("SELECT * FROM 1two_annuaire_sites WHERE compteur='".$_GET['compteur']."'",$db));
	
	mail("$list_delete_site[5]","Site refusé, annuaire de liens 1two","Bonjour,\n\nMerci pour votre contribution à 1two.org.\n\nMalheureusement, votre site $list_delete_site[2] n'a pas été accepté dans notre annuaire http://www.1two.org car il ne répond pas complètement à nos conditions d'acceptation.\n\nLa raison peut être l'une des suivantes :\n- Nom de domaine non valide (nous n'acceptons que les noms de domaine sous la forme http://www.site.com ou http://site.com),\n- Description trop courte ou non conforme,\n- Site soumis dans une catégorie principale (soumettez votre site dans une sous-catégorie),\n- etc...\n\nN'hésitez pas à soumettre votre site une nouvelle fois en tenant compte de ces critère, nous nous ferons un plaisir de le valider.\n\nVeuillez lire nos conditions d'acceptation http://www.1two.org/submit-a-site-0.html et faire le nécessaire pour que votre site les respecte si vous souhaitez le soumettre une nouvelle fois.\n\nCordialement,\nL'équipe 1two.org","From: Annuaire 1two <webmaster@1two.org>\r\n");
	
	$res=mysql_query("DELETE FROM 1two_annuaire_sites WHERE compteur='".$_GET['compteur']."'",$db);
	echo "<div class='alert alert-success'><button type='button' class='close' data-dismiss='alert'>×</button>Le site a été effacé.</div>";
	}
	
	
if ($_POST['SubmitSite']=="Soumettre")
	{
	//CHECK PREMIUM STATUE FOR PREMIUM EMAIL
	$list_check_premium=mysql_fetch_row(mysql_query("SELECT premium, mail FROM 1two_annuaire_sites WHERE compteur='".$_GET['compteur']."'",$db));
	if (($list_check_premium[0]==0) and ($_POST['premium']==1)) {
	mail($list_check_premium[1],"Annuaire 1two, confirmation Premium","Cher(e) ".$_POST['owner'].",\n\n
	
	Merci d'avoir choisi de passer en compte Premium. Vous pouvez dès à présent bénéficier des avantages sur votre page web dédiée. En tant que membre Premium, votre Service apparaît au dessus des autres dans la catégorie que vous avez choisie.\n\n
	
	Cordialement,\n
	L'équipe de l'annuaire 1two\nhttp://www.1two.org","From: Annuaire 1two <webmaster@1two.org>\r\n");
	}
	//END
	
	
	
	$query="UPDATE 1two_annuaire_sites SET category='".$_POST['category']."', url='".$_POST['url']."', mail='".$_POST['mail']."', owner='".$_POST['owner']."', title='".$_POST['title']."', description='".$_POST['description']."', date_ins='".$_POST['date_ins']."', valid=\"".$_POST['valid']."\", premium='".$_POST['premium']."', prem_date='".$_POST['premiumdate']."', premium_recall=0, prem_val=NOW() WHERE compteur='".$_GET['compteur']."'";
	$res_modif_biz=mysql_query($query,$db);
	echo "<div class='alert alert-success'><button type='button' class='close' data-dismiss='alert'>×</button>Le site a été modifié.</div>";
	}
if ($_GET['action']=="editsite")
	{
	$list_edit_site=mysql_fetch_row(mysql_query("SELECT * FROM 1two_annuaire_sites WHERE compteur='".$_GET['compteur']."'",$db));
	echo "<div class='hero-unit'><p>Edition du site <b>$list_edit_site[2]</b> (tous les champs sont obligatoires)</p>";
	echo "<form method='post' action='' class='form-horizontal'>";
	echo "<div class='control-group'>";
	echo "<label class='control-label' for='inputCat'>Catégorie</label>";
	echo "<div class='controls'>";
										echo "<select name='category' id='inputCat' class='input-xxlarge'>";
										
										$res_compteur=mysql_query("SELECT * FROM 1two_annuaire_cat",$db);
										if (mysql_num_rows($res_compteur)!=0)
											{
											for ($i=0; $i<mysql_num_rows($res_compteur); $i++)
												{
												$list_compteur=mysql_fetch_row($res_compteur);
												
												$tabmenu=""; $ligne="";
												$tabmenu[]="$list_compteur[3]";
												$idcat=$list_compteur[3];
												while ($idcat!=0)
													{
													$list_cat_temps=mysql_fetch_row(mysql_query("SELECT name, inside, compteur FROM 1two_annuaire_cat WHERE compteur='$idcat'",$db));
													$tabmenu[]="$list_cat_temps[0]";
													$idcat=$list_cat_temps[1];
													}
												
												$nbrtabmenu=count($tabmenu);
												for ($t=$nbrtabmenu-1; $t>=0; $t--)
													{
													if ($t==$nbrtabmenu-1) $ligne="$tabmenu[$t]"; elseif ($t!=0) $ligne.=" > $tabmenu[$t]"; else $ligne.=" > - $tabmenu[$t]";
													if ($t==0) $tabfinal[]="$ligne";
													}
												}
											$nbrtabfinal=count($tabfinal);
											$tabfinal[]=rsort($tabfinal);
											for ($f=$nbrtabfinal-1; $f>=0; $f--)
												{
												$ExplodeLine=explode(" > - ", $tabfinal[$f]);
												$CatName=$ExplodeLine[0];
												$CatNum=$ExplodeLine[1];
												
												$TestOptGroup=mysql_fetch_row(mysql_query("SELECT inside FROM 1two_annuaire_cat WHERE compteur=$CatNum",$db));
												
												if ($TestOptGroup[0]==0)
													{
													if ($f==$nbrtabfinal-1) echo "<optgroup label=\"$CatName\">";
													else echo "</optgroup><optgroup label=\"$CatName\">";
													}
												else echo "<option value='$CatNum'"; if ($list_edit_site[6]==$CatNum) echo " selected"; echo ">$CatName</option>";
												if ($f==0) echo "</optgroup>";
												}
											}
										
										echo "</select>";
	echo "</div>";
	echo "</div>";
	echo "<div class='control-group'>";
	echo "<label class='control-label' for='inputNom'>Votre nom</label>";
	echo "<div class='controls'><input name='owner' type='text' id='inputNom' maxlength='20' value=\"$list_edit_site[8]\"></div>";
	echo "</div>";
	echo "<div class='control-group'>";
	echo "<label class='control-label' for='inputMail'>Adresse email</label>";
	echo "<div class='controls'><input name='mail' type='text' id='inputMail' maxlength='100' value='$list_edit_site[5]' class='input-xxlarge'></div>";
	echo "</div>";
	echo "<div class='control-group'>";
	echo "<label class='control-label' for='inputTitre'>Titre du site</label>";
	echo "<div class='controls'><input name='title' type='text' id='inputTitre' maxlength='100' value=\"$list_edit_site[1]\" class='input-xxlarge'></div>";
	echo "</div>";
	echo "<div class='control-group'>";
	echo "<label class='control-label' for='inputUrl'>Url du site</label>";
	echo "<div class='controls'><input name='url' type='text' id='inputUrl' maxlength='200' value='$list_edit_site[2]' class='input-xxlarge'></div>";
	echo "</div>";
	echo "<div class='control-group'>";
	echo "<label class='control-label' for='inputDesc'>Description du site</label>";
	echo "<div class='controls'><textarea name='description' id='inputDesc' rows='8' class='input-xxlarge'>$list_edit_site[4]</textarea></div>";
	echo "</div>";
	echo "<div class='control-group'>";
	echo "<label class='control-label' for='inputDateins'>Date d'inscription</label>";
	echo "<div class='controls'><input name='date_ins' type='text' id='inputDateins' maxlength='200' value='$list_edit_site[7]' class='input-xxlarge'></div>";
	echo "</div>";
	echo "<div class='control-group'>";
	echo "<div class='controls'><label class='checkbox'>Valide <input type='checkbox' name='valid' value='1'"; if ($list_edit_site[3]==1) echo " checked"; echo "></label>";
	echo "</div></div>";
	echo "<div class='control-group'>";
	echo "<div class='controls'><label class='checkbox'>Premium <input type='checkbox' name='premium' value='1'"; if ($list_edit_site[11]==1) echo " checked"; echo "></label> Date de fin de premium (0000-00-00; ex. 2007-10-21) <input type='text' name='premiumdate' value='$list_edit_site[12]' />";
	echo "</div></div>";
	echo "<div class='control-group'>";
	echo "<div class='controls'><input type='submit' class='btn btn-info' name='SubmitSite' value='Soumettre'></div>";
	echo "</div>";
	echo "</form></div>";
	}
	
	
$res_valid=mysql_query("SELECT * FROM 1two_annuaire_sites WHERE mail LIKE '%".$_GET['search_site']."%' or title LIKE '%".$_GET['search_site']."%' or url LIKE '%".$_GET['search_site']."%' ORDER BY date_ins DESC, hour_ins DESC",$db);
if (mysql_num_rows($res_valid)!=0)
	{
	echo "<p><b>Liste des sites :</b></p>";
	echo "<table class='table table-hover table-bordered table-striped table-condensed'>";
	echo "<thead>";
	echo "<tr>";
	echo "<th>Catégorie</th>";
	echo "<th>URL</th>";
	echo "<th>Email</th>";
	echo "<th>Nom</th>";
	echo "<th>Titre</th>";
	echo "<th>Date d'inscription</th>";
	echo "<th>Valide</th>";
	echo "<th>Premium</th>";
	echo "<th></th>";
	echo "</tr>";
	echo "</thead>";
	echo "<tbody>";

	$nb_valid=mysql_num_rows($res_valid);
	for ($i=0; $i<$nb_valid; $i++)
		{
		$list_valid=mysql_fetch_row($res_valid);
		echo "<tr>";	
		echo "<td>";
		$cat_name=mysql_fetch_row(mysql_query("SELECT name FROM 1two_annuaire_cat WHERE compteur='$list_valid[6]'",$db));
		echo "$cat_name[0]";
		echo "</td>";
		echo "<td>$list_valid[2]</td>";
		echo "<td>$list_valid[5]</td>";
		echo "<td>$list_valid[8]</td>";
		echo "<td>$list_valid[1]</td>";
		echo "<td>$list_valid[7]</td>";
		echo "<td>$list_valid[3]</td>";
		
		echo "<td>"; if ($list_valid[11]==1) echo "Oui<br />Jusqu'au ".wiki_aff_date_fr($list_valid[12]); else echo "No"; echo "</td>";
		
		echo "<td><div class='btn-toolbar'><div class='btn-group'>";
		echo "<a class='btn' href='?menu=siteedition&compteur=$list_valid[0]&action=editsite&search_site=".$_GET['search_site']."'><i class='icon-pencil'></i></a>";
		echo "<a class='btn' href='?menu=siteedition&compteur=$list_valid[0]&action=deletesite&search_site=".$_GET['search_site']."'><i class='icon-trash'></i></a>";
		echo "</div></div></td>";

		echo "</tr>";
		}
	echo "</tbody></table>";
	}
else echo "<div class='alert alert-info'><button type='button' class='close' data-dismiss='alert'>×</button>Pas de sites trouvés !</div>";
?>
