<?PHP
if (($_POST['SubmitModify']=="Modifier") and ($_POST['owner']!="") and ($_POST['email']!="") and ($_POST['titlesite']!="") and ($_POST['descriptionsite']!="") )
	{
	$query="UPDATE 1two_annuaire_sites SET category='".$_POST['listecat']."', owner='".$_POST['owner']."', mail='".$_POST['email']."', title='".$_POST['titlesite']."', description='".$_POST['descriptionsite']."', valid=0 WHERE url='".$_SESSION["username"]."' or url='".$_SESSION["username"]."/'";
	$update_site=mysql_query($query,$db);
	
	mail("webmaster@1two.org","1two Site Modifié","Un site existant a été modifié sur 1two (".$_SESSION["username"]."), vérifier la liste d'attente","From: 1two <webmaster@1two.org>\r\n");
	echo "<div class='alert alert-success'><button type='button' class='close' data-dismiss='alert'>×</button>Votre compte a été modifié. Votre site est en attente de validation.</div>";
	}


$list_user=mysql_fetch_row(mysql_query("SELECT * FROM 1two_annuaire_sites WHERE url='".$_SESSION["username"]."' or url='".$_SESSION["username"]."/'",$db));

echo "<div class='alert alert-block'><button type='button' class='close' data-dismiss='alert'>×</button>Attention : si vous modifiez votre site, il passera en attente de validation</div>";

echo "<form method='post' action='' name='formulaire' class='form-horizontal' onsubmit='return validation();'>";

echo "<div class='control-group'>";
echo "<label class='control-label'>Catégorie</label><div class='controls'>";
echo "<select class='input-xxlarge' name='listecat'>";
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
												else echo "<option value='$CatNum'"; if ($list_user[6]==$CatNum) echo " selected"; echo ">$CatName</option>";
												if ($f==0) echo "</optgroup>";
												}
											}
										
echo "</select></div></div>";
	
	
echo "<div class='control-group'><label class='control-label'>Votre nom</label><div class='controls'><input name='owner' type='text' maxlength='20' value=\"$list_user[8]\" /></div></div>";
echo "<div class='control-group'><label class='control-label'>Votre email</label><div class='controls'><input name='email' type='text' size='40' maxlength='100' value=\"$list_user[5]\" /></div></div>";
echo "<div class='control-group'><label class='control-label'>Titre du site</label><div class='controls'><input class='input-xxlarge' name='titlesite' type='text' size='40' maxlength='100' value=\"$list_user[1]\" /></div></div>";
echo "<div class='control-group'><label class='control-label'>Description du site</label><div class='controls'><textarea class='input-xxlarge' name='descriptionsite' cols='40' rows='8'>$list_user[4]</textarea></div></div>";
echo "<div class='control-group'><div class='controls'><input class='btn btn-info' type='submit' name='SubmitModify' value='Modifier' /></div></div>";

echo "</form>";	
?>