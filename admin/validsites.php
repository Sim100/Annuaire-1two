<?PHP
if ($_GET['action']=="validsite")
	{
	echo "<div class='alert alert-success'><button type='button' class='close' data-dismiss='alert'>×</button>Site validé</div>";
	$resswitch=mysql_query("UPDATE 1two_annuaire_sites SET valid='1', date_val=NOW(), hour_val=NOW() WHERE compteur='".$_GET['sitenum']."'",$db);
	
	$list_valid_site=mysql_fetch_row(mysql_query("SELECT * FROM 1two_annuaire_sites WHERE compteur='".$_GET['sitenum']."'",$db));
	
	mail("$list_valid_site[5]","Site accepté, annuaire de liens 1two","Bonjour,\n\nFélicitations !\nVotre site $list_valid_site[2] a été ajouté dans notre annuaire http://www.1two.org.\n\nVous pouvez modifier votre site web en vous connectant à votre partie administration (http://www.1two.org/mon_compte).\nN'hésitez pas à devenir Membre Premium (10 euros par an) afin de donner une meilleure visibilité à votre site.\n\nVous pouvez, si vous le souhaitez, faire un lien retour vers notre site en copiant le code ci-dessous :\n<a href='http://www.1two.org'>Annuaire de liens 1two</a>\n\nCordialement,\nL'équipe 1two.org","From: Annuaire 1two <webmaster@1two.org>\r\n");	
	}
	
if ($_GET['action']=="deletesite")
	{
	$list_delete_site=mysql_fetch_row(mysql_query("SELECT * FROM 1two_annuaire_sites WHERE compteur='".$_GET['sitenum']."'",$db));
	
	mail("$list_delete_site[5]","Site refusé, annuaire de liens 1two","Bonjour,\n\nMerci pour votre contribution à 1two.org.\n\nMalheureusement, votre site $list_delete_site[2] n'a pas été accepté dans notre annuaire http://www.1two.org car il ne répond pas complètement à nos conditions d'acceptation.\n\nLa raison peut être l'une des suivantes :\n- Nom de domaine non valide (nous n'acceptons que les noms de domaine sous la forme http://www.site.com ou http://site.com),\n- Description trop courte ou non conforme,\n- Site soumis dans une catégorie principale (soumettez votre site dans une sous-catégorie),\nOrthographe,\nTitre ou phrases qui ne commencent pas par une majuscule,\n- etc...\n\nN'hésitez pas à soumettre votre site une nouvelle fois en tenant compte de ces critère, nous nous ferons un plaisir de le valider.\n\nVeuillez lire nos conditions d'acceptation http://www.1two.org/submit-a-site-0.html et faire le nécessaire pour que votre site les respecte si vous souhaitez le soumettre une nouvelle fois.\n\nCordialement,\nL'équipe 1two.org","From: Annuaire 1two <webmaster@1two.org>\r\n");
	
	echo "<div class='alert alert-success'><button type='button' class='close' data-dismiss='alert'>×</button>Site supprimé</div>";
	$resswitch=mysql_query("DELETE FROM 1two_annuaire_sites WHERE compteur='".$_GET['sitenum']."'",$db);
	}
	
	
	
	
	
	
	
if (($_POST['SubmitEditSite']=="Valider") and ($_POST['editowner']!="") and ($_POST['editemail']!="") and ($_POST['edittitlesite']!="") and ($_POST['editurlsite']!="") and ($_POST['editurlsite']!="http://") and ($_POST['editdescriptionsite']!=""))
	{
	$res_modif_site=mysql_query("UPDATE 1two_annuaire_sites SET category='".$_POST['category']."', title='".$_POST['edittitlesite']."', url='".$_POST['editurlsite']."', description='".$_POST['editdescriptionsite']."', owner='".$_POST['editowner']."', mail='".$_POST['editemail']."' WHERE compteur='".$_GET['site']."'",$db);
	echo "<div class='alert alert-success'><button type='button' class='close' data-dismiss='alert'>×</button>Le site a été modifié.</div>";
	}
if ($_GET['action']=="editsite")
	{
	$list_edit_sites=mysql_fetch_row(mysql_query("SELECT * FROM 1two_annuaire_sites WHERE compteur='".$_GET['site']."'",$db));
	echo "<div class='hero-unit'><p>Edition du site <b>$list_edit_sites[2]</b> (tous les champs sont obligatoires)</p>";
	echo "<form method='post' action='index.php?menu=validsites&site=".$_GET['site']."' class='form-horizontal'>";
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
												else echo "<option value='$CatNum'"; if ($list_edit_sites[6]==$CatNum) echo " selected"; echo ">$CatName</option>";
												if ($f==0) echo "</optgroup>";
												}
											}
										
										echo "</select>";
	echo "</div>";
	echo "</div>";
	echo "<div class='control-group'>";
	echo "<label class='control-label' for='inputNom'>Votre nom</label>";
	echo "<div class='controls'><input name='editowner' type='text' id='inputNom' maxlength='20' value=\"$list_edit_sites[8]\"></div>";
	echo "</div>";
	echo "<div class='control-group'>";
	echo "<label class='control-label' for='inputMail'>Adresse email</label>";
	echo "<div class='controls'><input name='editemail' type='text' id='inputMail' maxlength='100' value='$list_edit_sites[5]' class='input-xxlarge'></div>";
	echo "</div>";
	echo "<div class='control-group'>";
	echo "<label class='control-label' for='inputTitre'>Titre du site</label>";
	echo "<div class='controls'><input name='edittitlesite' type='text' id='inputTitre' maxlength='100' value=\"$list_edit_sites[1]\" class='input-xxlarge'></div>";
	echo "</div>";
	echo "<div class='control-group'>";
	echo "<label class='control-label' for='inputUrl'>Url du site</label>";
	echo "<div class='controls'><input name='editurlsite' type='text' id='inputUrl' maxlength='200' value='$list_edit_sites[2]' class='input-xxlarge'></div>";
	echo "</div>";
	echo "<div class='control-group'>";
	echo "<label class='control-label' for='inputDesc'>Description du site</label>";
	echo "<div class='controls'><textarea name='editdescriptionsite' id='inputDesc' rows='8' class='input-xxlarge'>$list_edit_sites[4]</textarea></div>";
	echo "</div>";
	echo "<div class='control-group'>";
	echo "<div class='controls'><input type='submit' class='btn btn-info' name='SubmitEditSite' value='Valider'></div>";
	echo "</div>";
	echo "</form></div>";
	}
$res_valid=mysql_query("SELECT * FROM 1two_annuaire_sites WHERE valid=0 ORDER BY date_ins ASC, hour_ins ASC LIMIT 50",$db);
if (mysql_num_rows($res_valid)!=0)
	{
	$nb_valid=mysql_num_rows($res_valid);
	switch ($_POST['choix'])
		{
		case "Valider" :
			echo "<div class='alert alert-success'><button type='button' class='close' data-dismiss='alert'>×</button>Site(s) validé(s)</div>";
			for ($i=1; $i<=$nb_valid; $i++)
				{
				$j=$i-1;
				$list_valid=mysql_fetch_row($res_valid);
				$newVar=$_POST['checkbox'];
				if ($newVar[$j]== $i) 
					{
					$resswitch=mysql_query("UPDATE 1two_annuaire_sites SET valid='1', date_val=NOW(), hour_val=NOW() WHERE compteur='$list_valid[0]'",$db);
					mail("$list_valid[5]","Site accepté, annuaire de liens 1two","Bonjour,\n\nFélicitations !\nVotre site $list_valid[2] a été ajouté dans notre annuaire http://www.1two.org.\n\nVous pouvez modifier votre site web en vous connectant à votre partie administration (http://www.1two.org/mon_compte).\nN'hésitez pas à devenir Membre Premium (10 euros par an) afin de donner une meilleure visibilité à votre site.\n\nVous pouvez, si vous le souhaitez, faire un lien retour vers notre site en copiant le code ci-dessous :\n<a href='http://www.1two.org'>Annuaire de liens 1two</a>\n\nSi vous possédez une société ou un service en France, donnez lui de la visibilité sur le net en le soumettant dans notre annuaire http://www.franceannuaireservices.fr\n\nSi votre site à un rapport avec le voyage, les photos du monde ou les guides de voyage, nous vous suggérons de le soumettre aussi sur cet annuaire spécialisé : http://directory.twip.org.\n\nCordialement,\nL'équipe 1two.org","From: Annuaire 1two <webmaster@1two.org>\r\n");
					}
				}
			break;
		case "Supprimer" :
			echo "<div class='alert alert-success'><button type='button' class='close' data-dismiss='alert'>×</button>Site(s) supprimé(s)</div>";
			for ($i=1; $i<=$nb_valid; $i++)
				{
				$j=$i-1;
				$list_valid=mysql_fetch_row($res_valid);
				$newVar=$_POST['checkbox'];
				if ($newVar[$j]== $i) 
					{
					$resswitch=mysql_query("DELETE FROM 1two_annuaire_sites WHERE compteur='$list_valid[0]'",$db);
					mail("$list_valid[5]","Site refusé, annuaire de liens 1two","Bonjour,\n\nMerci pour votre contribution à 1two.org.\n\nMalheureusement, votre site $list_valid[2] n'a pas été accepté dans notre annuaire http://www.1two.org car il ne répond pas complètement à nos conditions d'acceptation.\n\nLa raison peut être l'une des suivantes :\n- Nom de domaine non valide (nous n'acceptons que les noms de domaine sous la forme http://www.site.com ou http://site.com),\n- Description trop courte ou non conforme,\n- Site soumis dans une catégorie principale (soumettez votre site dans une sous-catégorie),\n- etc...\n\nN'hésitez pas à soumettre votre site une nouvelle fois en tenant compte de ces critère, nous nous ferons un plaisir de le valider.\n\nVeuillez lire nos conditions d'acceptation http://www.1two.org/submit-a-site-0.html et faire le nécessaire pour que votre site les respecte si vous souhaitez le soumettre une nouvelle fois.\n\nCordialement,\nL'équipe 1two.org","From: Annuaire 1two <webmaster@1two.org>\r\n");
					}
				}
			break;
		}
	}
$res_valid=mysql_query("SELECT * FROM 1two_annuaire_sites WHERE valid=0 ORDER BY date_ins ASC, hour_ins ASC LIMIT 50",$db);

echo "<p>Liste des sites en attente de validation :</p>";
if (mysql_num_rows($res_valid)!=0)
	{
	echo "<form method='post' action=''>";
	echo "<table class='table table-hover table-bordered table-striped table-condensed'><tbody>";
	$nb_valid=mysql_num_rows($res_valid);
	for ($i=0; $i<$nb_valid; $i++)
		{	
		$j=$i+1;
		$list_valid=mysql_fetch_row($res_valid);
		
		echo "<tr>";
		echo "<td>";
		echo "<a href='$list_valid[2]' target='_blank'>$list_valid[1]</a><br />";
		
		echo "<div class='btn-toolbar pull-right'><div class='btn-group'>";
		echo "<a class='btn' href='?menu=validsites&id=$list_valid[6]&site=$list_valid[0]&action=editsite'><i class='icon-pencil'></i></a>";
		echo "<a class='btn' href='?menu=validsites&sitenum=$list_valid[0]&action=validsite'><i class='icon-ok'></i></a>";
		echo "<a class='btn' href='?menu=validsites&sitenum=$list_valid[0]&action=deletesite'><i class='icon-trash'></i></a>";
		echo "</div></div>";
				
		
		$tabmenu="";
		$idmenu=$list_valid[6];
		while ($idmenu!=0)
			{
			$list_cat_temps=mysql_fetch_row(mysql_query("SELECT name, inside, compteur FROM 1two_annuaire_cat WHERE compteur='$idmenu'",$db));
			$tabmenu[]="$list_cat_temps[0]";
			$idmenu=$list_cat_temps[1];
			}
		echo "Catégorie";
		$nbrtabmenu=count($tabmenu);
		for ($t=$nbrtabmenu-1; $t>=0; $t--)
			{
			echo " > ";
			if ($t==0) echo "<b>$tabmenu[$t]</b>";
			else echo "$tabmenu[$t]";
			}
				
		echo "<br />$list_valid[2]<br />".nl2br($list_valid[4])."<br /><small><span class='muted'>Ajouté le ".wiki_aff_date_fr($list_valid[7])." à $list_valid[9]</span></small>";
		echo "</td>";
		echo "<td><input type=\"checkbox\" name=\"checkbox[" . $i . "]\" value=\"" . $j . "\"></td>";
		echo "</tr>";
		}
	echo "<tr><td><input type='submit' class='btn btn-success' name='choix' value='Valider'> <input type='submit' class='btn btn-danger' name='choix' value='Supprimer'></td><td></td></tr>";
	echo "<tbody></table>";
	echo "</form>";
	}
else echo "<div class='alert alert-info'><button type='button' class='close' data-dismiss='alert'>×</button>Pas de site en attente de validation.</div>";
?>