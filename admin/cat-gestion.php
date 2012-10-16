<?PHP
if ($_GET['menu']=="") {$_GET['menu']="gestion";}
if ($_GET['menu']=="gestion")
	{
	if ($_GET['action']=="supp")
		{
		if ($_GET['conf']=="oui")
			{
			$query="SELECT inside FROM 1two_annuaire_cat WHERE inside='".$_GET['id']."'";
			$res_is_souscat=mysql_query($query,$db);
			if (mysql_num_rows($res_is_souscat)==0)
				{
				$result_delete_cat=mysql_query("DELETE FROM 1two_annuaire_cat WHERE compteur='".$_GET['id']."'",$db);
				$result_delete_sites=mysql_query("DELETE FROM 1two_annuaire_sites WHERE categorie='".$_GET['id']."'",$db);
				echo "<div class='alert alert-success'><button type='button' class='close' data-dismiss='alert'>×</button>La catégorie a été supprimée.</div>";
				$_GET['id']=0;
				}
			else
				{
				echo "<div class='alert'><button type='button' class='close' data-dismiss='alert'>×</button>Cette catégorie n'est pas vide. Supprimez toutes ses sous-catégories avant de la supprimer.</div>";
				}
			}
		else
			{
			echo "<div class='alert'><button type='button' class='close' data-dismiss='alert'>×</button>Etes-vous sur de vouloir supprimer cette catégorie et tous les sites qu'elle contient ? <a href='?menu=gestion&id=".$_GET['id']."&action=supp&conf=oui'>oui</a> <a href='?menu=gestion&conf=non'>non</a></div>";
			}
		}
	if ($_GET['action']=="edit")
		{
		if ($_POST['EditCategorie']=="Valider")
			{
			$res_modif=mysql_query("UPDATE 1two_annuaire_cat SET name='".$_POST['name']."', description='".$_POST['description']."' WHERE compteur='".$_GET['id']."'",$db);
			echo "<div class='alert alert-success'><button type='button' class='close' data-dismiss='alert'>×</button>La catégorie a été modifiée.</div>";
			}
		else
			{
			$list_edit_cat=mysql_fetch_row(mysql_query("SELECT name, description FROM 1two_annuaire_cat WHERE compteur='".$_GET['id']."'",$db));
			echo "<div class='hero-unit'><form method='post' action='' class='form-horizontal'>";
			echo "<div class='control-group'>";
			echo "<label class='control-label' for='inputTitre'>Titre</label>";
			echo "<div class='controls'><input name='name' type='text' id='inputTitre' value=\"$list_edit_cat[0]\" class='input-xxlarge'></div>"; 
			echo "</div>";
			echo "<div class='control-group'>";
			echo "<label class='control-label' for='inputDesc'>Description</label>";
			echo "<div class='controls'><textarea name='description' id='inputDesc' rows='8' class='input-xxlarge'>$list_edit_cat[1]</textarea></div>";
			echo "</div>";
			echo "<div class='control-group'>";
			echo "<div class='controls'><input type='submit' class='btn btn-info' name='EditCategorie' value='Valider'></div>";
			echo "</div>";
			echo "</form></div>";
			}
		}
	if (($_POST['SubmitCategorie']=="Ajouter") and ($_POST['name']!=""))
		{
		$result=mysql_query("INSERT INTO 1two_annuaire_cat (name, description, inside) VALUES ('".$_POST['name']."', '".$_POST['description']."', '".$_POST['inside']."')",$db);
		echo "<div class='alert alert-success'><button type='button' class='close' data-dismiss='alert'>×</button>La catégorie a été ajoutée.</div>";
		}
	if ($_GET['id']=="") {$_GET['id']="0";}	
	if ($_GET['id']=="0")
		{	
		$res_cat_racine=mysql_query("SELECT * FROM 1two_annuaire_cat WHERE inside='0' ORDER BY name ASC",$db);
		if (mysql_num_rows($res_cat_racine)!=0)
			{
			echo "<table class='table table-hover table-bordered table-striped table-condensed'><tbody>";
			$nbcatracine=mysql_num_rows($res_cat_racine);
			for ($i=0; $i<$nbcatracine; $i=$i+1)
				{
				echo "<tr>";
				$list_cat_racine=mysql_fetch_row($res_cat_racine);
				$inside="0";
				echo "<td><a href='?menu=gestion&id=$list_cat_racine[3]'>$list_cat_racine[0]</a></td>";
				echo "<td>";
				echo "<div class='btn-toolbar'><div class='btn-group'>";
				echo "<a class='btn' href='?menu=gestion&id=$list_cat_racine[3]&action=edit'><i class='icon-pencil'></i></a>";
				echo "<a class='btn' href='?menu=gestion&id=$list_cat_racine[3]&action=supp'><i class='icon-trash'></i></a>";
				echo "</div></div>";
				echo "</td>";
				echo "</tr>";
				}
			echo "</tbody></table>";
			}
		echo "<p>Ajouter une catégorie à la racine</p>";
		}
	else
		{
		//affichage du menu
		$idmenu=$_GET['id'];
		echo "<ul class='breadcrumb'>";
		echo "<li><a href='?menu=gestion'>Accueil</a> <span class='divider'>/</span></li>";
		while ($idmenu!=0)
			{
			$list_cat_temps=mysql_fetch_row(mysql_query("SELECT * FROM 1two_annuaire_cat WHERE compteur='$idmenu'",$db));
			$tabmenu[]="<li><a href='?menu=gestion&id=$list_cat_temps[3]'>$list_cat_temps[0]</a></li>";
			$idmenu=$list_cat_temps[2];
			}
		$nbrtabmenu=count ($tabmenu);
		for ($t=$nbrtabmenu-1; $t>=0; $t--)
			{
			if ($t!=0) echo "$tabmenu[$t] <span class='divider'>/</span>"; else echo "$tabmenu[$t]";
			}
		echo "</ul>";
		//FIN affichage du menu
		
		$list_cat=mysql_fetch_row(mysql_query("SELECT * FROM 1two_annuaire_cat WHERE compteur='".$_GET['id']."' ORDER BY name ASC",$db));
		$res_sous_cat=mysql_query("SELECT * FROM 1two_annuaire_cat WHERE inside='".$_GET['id']."' ORDER BY name ASC",$db);
		echo "<p>Sous-catégorie de <b>$list_cat[0]</b></p>";
		if (mysql_num_rows($res_sous_cat)!=0)
			{
			$nbcat=mysql_num_rows($res_sous_cat);
			echo "<table class='table table-hover table-bordered table-striped table-condensed'><tbody>";
			for ($i=0; $i<$nbcat; $i=$i+1)
				{
				$list_sous_cat=mysql_fetch_row($res_sous_cat);
				echo "<tr>";
				echo "<td><a href='?menu=gestion&id=$list_sous_cat[3]'>$list_sous_cat[0]</a></td>";
				echo "<td>";
				echo "<div class='btn-toolbar'><div class='btn-group'>";
				echo "<a class='btn' href='?menu=gestion&id=$list_sous_cat[3]&action=edit'><i class='icon-pencil'></i></a>";
				echo "<a class='btn' href='?menu=gestion&id=$list_sous_cat[3]&action=supp'><i class='icon-trash'></i></a>";
				echo "</div></div>";
				echo "</td>";
				echo "</tr>";
				}
			echo "</tbody></table>";
			}
		else echo "<div class='alert alert-info'><button type='button' class='close' data-dismiss='alert'>×</button>Pas de sous-catégories.</a></div>";
			
		$inside=$list_cat[3];
		echo "<p>Ajouter une catégorie dans la catégorie <b>$list_cat[0]</b></p>";
		}
	echo "<div class='hero-unit'><form method='post' action='' class='form-horizontal'><input type='hidden' name='inside' value='$inside'>";
	echo "<div class='control-group'>";
	echo "<label class='control-label' for='inputTitre'>Titre</label>";
	echo "<div class='controls'><input name='name' type='text' id='inputTitre' placeholder='Titre' class='input-xxlarge'></div>";
	echo "</div>";
	echo "<div class='control-group'>";
	echo "<label class='control-label' for='inputDesc'>Description</label>";
	echo "<div class='controls'><textarea name='description' id='inputDesc' placeholder=\"Champs non requis. Sauf si vous décidez d'utiliser ce champs dans votre programme (moi je ne l'utilise pas).\" rows='8' class='input-xxlarge'></textarea></div>";
	echo "</div>";
	echo "<div class='control-group'>";
	echo "<div class='controls'><input type='submit' class='btn btn-info' name='SubmitCategorie' value='Ajouter'></div>";
	echo "</div>";
	echo "</form></div>";
	echo "<hr></hr>";
	
	
	
	
	
	
	
	
	if ($_GET['action']=="suppsite")
		{
		if ($_GET['confsuppsite']=="oui")
			{
			$result_delete_site=mysql_query("DELETE FROM 1two_annuaire_sites WHERE compteur='".$_GET['site']."'",$db);
			echo "<div class='alert alert-success'><button type='button' class='close' data-dismiss='alert'>×</button>Le site a été supprimé.</a></div>";
			}
		else
			{
			echo "<div class='alert'><button type='button' class='close' data-dismiss='alert'>×</button>Etes-vous sûr de vouloir supprimer ce site ? <a href='?menu=gestion&id=".$_GET['id']."&site=".$_GET['site']."&action=suppsite&confsuppsite=oui&page=".$_GET['page']."#suppsite'>oui</a> <a href='?menu=gestion&id=".$_GET['id']."&confsuppsite=non&page=".$_GET['page']."#suppsite'>non</a></div>";
			}
		}
	if (($_POST['SubmitEditSite']=="Valider") and ($_POST['editowner']!="") and ($_POST['editemail']!="") and ($_POST['edittitlesite']!="") and ($_POST['editurlsite']!="") and ($_POST['editurlsite']!="http://") and ($_POST['editdescriptionsite']!=""))
		{
		$res_modif_site=mysql_query("UPDATE 1two_annuaire_sites SET category='".$_POST['category']."', title='".$_POST['edittitlesite']."', url='".$_POST['editurlsite']."', description='".$_POST['editdescriptionsite']."', owner='".$_POST['editowner']."', mail='".$_POST['editemail']."' WHERE compteur='".$_GET['site']."'",$db);
		echo "<div class='alert alert-success'><button type='button' class='close' data-dismiss='alert'>×</button>Le site a été modifié.</div>"; 
		$_GET['action']="";
		}
	if ($_GET['action']=="editsite")
		{
		$list_edit_sites=mysql_fetch_row(mysql_query("SELECT * FROM 1two_annuaire_sites WHERE compteur='".$_GET['site']."'",$db));
		echo "<div class='hero-unit'><p>Edition du site <b>$list_edit_sites[2]</b> (tous les champs sont obligatoires)</p>";
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
												else echo "<option value='$CatNum'"; if ($list_edit_sites[6]==$CatNum) echo " selected"; echo ">$CatName</option>";
												if ($f==0) echo "</optgroup>";
												}
											}
										
										echo "</select>";
		echo "</div>";
		echo "</div>";
		echo "<div class='control-group'>";
		echo "<label class='control-label' for='inputName'>Votre nom</label>";
		echo "<div class='controls'><input name='editowner' type='text' id='inputName' maxlength='20' value=\"$list_edit_sites[8]\"></div>";
		echo "</div>";
		echo "<div class='control-group'>";
		echo "<label class='control-label' for='inputEmail'>Adresse email</label>";
		echo "<div class='controls'><input name='editemail' type='text' id='inputEmail' maxlength='100' value='$list_edit_sites[5]' class='input-xxlarge'></div>";
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
	//Fin edition de sites 
	//Liste des sites
	if ($_GET['id']=="0")
		{
		echo "<p>Liste des sites à la racine</p>";
		$categorie=0;
		}
	else
		{
		echo "<p>Liste des sites dans la catégorie <b>$list_cat[0]</b></p>";
		$categorie=$list_cat[3];
		}
	$res_liste_sites=mysql_query("SELECT compteur, title, url, description, owner, mail, date_ins, hour_ins FROM 1two_annuaire_sites WHERE valid='1' and category='".$_GET['id']."' ORDER BY date_ins, hour_ins ASC",$db);
	if (mysql_num_rows($res_liste_sites)!=0)
		{
		$nbrsites=mysql_num_rows($res_liste_sites);
		$nbpage=ceil($nbrsites/10);
		if ($_GET['page']=="") $_GET['page']=1;
		echo "<table class='table table-hover table-bordered table-striped table-condensed'><tbody>";
		for ($i=0; $i<$nbrsites; $i=$i+1)
			{
			$list_sites=mysql_fetch_row($res_liste_sites);
			if ( ($i>=10*$_GET['page']-10) and ($i<10*$_GET['page']) )
				{
				echo "<tr>";
				echo "<td>";
				echo "<a href='$list_sites[2]' target='_blank'>$list_sites[1]</a> - <span class='muted'>Ajouté le ".wiki_aff_date_fr($list_sites[6])." à $list_sites[7]</span>";
				echo "<div class='btn-toolbar pull-right'><div class='btn-group'>";
				echo "<a class='btn' href='?menu=gestion&id=".$_GET['id']."&site=$list_sites[0]&action=editsite&page=".$_GET['page']."'><i class='icon-pencil'></i></a>";
				echo "<a class='btn' href='?menu=gestion&id=".$_GET['id']."&site=$list_sites[0]&action=suppsite&page=".$_GET['page']."'><i class='icon-trash'></i></a>";
				echo "</div></div>";
				echo "<br />".nl2br($list_sites[3]);
				echo "</td>";
				echo "</tr>";
				}
			}
		echo "<tbody></table>";
		
		echo "<p><em>Allez à la page :</em></p>";
						
						if ($nbpage>1)
							{
							echo "<p><div class='pagination pagination-centered'><ul>";
							$prev=$_GET['page']-1; if ($_GET['page']!=1)
															{
															$consURL="<a href='?menu=gestion&id=".$_GET['id']."&page=$prev'>&laquo;</a>";
															echo "<li>".$consURL."</li>";
															}
							
							if ($_GET['page']>=10) { echo "<li><a href='?menu=gestion&id=".$_GET['id']."&page=1'>1</a></li><li><a href='?menu=gestion&id=".$_GET['id']."&page=2'>2</a></li><li><span>...</span></li>"; }
							
							for ($j=$_GET['page']-3; $j<=$_GET['page']+3; $j++)
								{
								if (($j>=1) and ($j<=$nbpage))
									{
									if ($j==$_GET['page']) echo "<li class='active'><span>$j</span></li>";
									else
										{
										$consURL="<a href='?menu=gestion&id=".$_GET['id']."&page=$j'>$j</a> ";
										echo "<li>".$consURL."</li>";
										}
									}
								}
							
							$avderpage=$nbpage-1;	
							if ($_GET['page']<=$nbpage-9) { echo "<li><span>...</span></li><li><a href='?menu=gestion&id=".$_GET['id']."&page=$avderpage'>$avderpage</a></li><li><a href='?menu=gestion&id=".$_GET['id']."&page=$nbpage'>$nbpage</a></li>"; }
									
							$next=$_GET['page']+1; if ($_GET['page']!=$nbpage) echo "<li><a href='?menu=gestion&id=".$_GET['id']."&page=$next'>&raquo;</a></li>";
							echo "</ul></div></p>";
							}
							
		}
	else echo "<div class='alert alert-info'><button type='button' class='close' data-dismiss='alert'>×</button>Pas de site dans la catégorie <b>$list_cat[0]</b>.</div>";
	}
?>
