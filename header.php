<div class="row">
<div class="span12">
	<div class="row">
		<div class="span2"><a href="http://www.1two.org"><img src='design/logo-1two.png' alt='Annuaire 1two, annuaire de liens et annuaire généraliste gratuit des meilleurs sites web avec liens en dur' title='Annuaire 1two, annuaire de liens et annuaire généraliste gratuit des meilleurs sites web avec liens en dur' /></a></div>
		<div class="span10"><div class='header_top_banner'>
					
										<?PHP
										if ( (strpos($titlepage, 'XXX-Adulte') === false) and (strpos($titlepage, 'Poker / Casino') === false ) )
											{
											?>
											<span class="visible-desktop">
											<script type="text/javascript"><!--
											google_ad_client = "pub-8396385936154281";
											/* 728x90, date de création 20/08/09 */
											google_ad_slot = "8604521337";
											google_ad_width = 728;
											google_ad_height = 90;
											//-->
											</script>
											<script type="text/javascript"
											src="http://pagead2.googlesyndication.com/pagead/show_ads.js">
											</script>
											</span>
											
											<span class="visible-tablet">
											<script type="text/javascript"><!--
											google_ad_client = "pub-8396385936154281";
											/* 468x60, date de création 25/08/09 */
											google_ad_slot = "1440800833";
											google_ad_width = 468;
											google_ad_height = 60;
											//-->
											</script>
											<script type="text/javascript"
											src="http://pagead2.googlesyndication.com/pagead/show_ads.js">
											</script>
											</span>
											<?PHP
											}
										?>
					
					<strong>Annuaire 1two.org</strong>, annuaire gratuit et référencement de site internet
		</div></div>
	</div>
</div>
</div>

<div class="navbar">
<div class="navbar-inner">
<div class="container">
  <a class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
	<span class="icon-bar"></span>
	<span class="icon-bar"></span>
	<span class="icon-bar"></span>
  </a>
  <div class="nav-collapse collapse">
	<ul class="nav">
			<li<?PHP if ($choixmenu=="") echo " class='active'"; ?>><a href="http://www.1two.org" rel="tooltip" title="Accueil de l'annuaire 1two">Accueil</a></li>
			<li<?PHP if ($choixmenu=="proposerunsite") echo " class='active'"; ?>><a href="/soumettre-un-site-0.html" rel="tooltip" title="Proposer un site dans l'annuaire 1two (soumis à validation)">Proposer un site</a></li>
			<li<?PHP if ($choixmenu=="moncompte") echo " class='active'"; ?>><a href="/mon_compte" rel="tooltip" title="Accéder à mon compte personnel">Mon compte</a></li>
			<li class="divider-vertical"></li>
			<li>
					<form class="navbar-search pull-left" action='rechercher.php'>
						<script type="text/javascript">
							$(document).ready(function() {
								$('#SearchField').autocomplete('SearchAJAXresult.php');
							});
						</script>
					<input id='SearchField' type="text" name="search" class="search-query" placeholder="Rechercher">
					</form>
			</li>
	</ul>
	
	<ul class="nav pull-right">
			<li class="divider-vertical"></li>
			
			<?PHP
			$ButtonLogin="<li><a href='#myLogin' role='button' data-toggle='modal'>Connexion</a></li>";
			
			if ($_GET['session']=="logout") echo $ButtonLogin;
			else
				{
				if ( ($_SESSION["username"]!="") and ($_SESSION["password"]!="") )
					{
					$query="SELECT password FROM 1two_annuaire_sites WHERE url='".$_SESSION["username"]."' or url='".$_SESSION["username"]."/'";
					$res_connection=@mysql_query($query,$db);
					if (mysql_num_rows($res_connection)!=0)
						{
						$list_connection=mysql_fetch_row($res_connection);
						if ( $list_connection[0]==md5($_SESSION["password"]) )
							{					
							$list_name=mysql_fetch_row(mysql_query("SELECT * FROM 1two_annuaire_sites WHERE url='".$_SESSION["username"]."' or url='".$_SESSION["username"]."/'",$db));
							
							
							
							echo "<li class='dropdown'>";
							echo "<a href='#' class='dropdown-toggle' data-toggle='dropdown'>";
									echo "$list_name[8]";
							echo "<b class='caret'></b>";
							echo "</a>";
							echo "<ul class='dropdown-menu'>";
									echo "<li><a href='/mon_compte'>Mon compte</a></li>";
									echo "<li><a href='/index.php?session=logout'>Déconnection</a></li>";
							echo "</ul>";
							echo "</li>";
							}
						else { echo $ButtonLogin; }
						}
					else { echo $ButtonLogin; }
					}
				else { echo $ButtonLogin; }
				}
			?>
			
			
	</ul>
  </div><!--/.nav-collapse -->
</div>
</div>
</div>


 
<div class="modal hide fade" id="myLogin" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
<form class="form-horizontal" method='post' action=''>
<div class="modal-header">
<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
<h3 id="myModalLabel">Connexion Membre 1two</h3>
</div>
<div class="modal-body">
<p>
	
<div class="control-group">
<label class="control-label" for="inputUrl">Votre site web (sans le / à la fin) :</label>
<div class="controls">
<input type="text" name='username' id="inputUrl" value="http://">
</div>
</div>
<div class="control-group">
<label class="control-label" for="inputPassword">Mot de passe :</label>
<div class="controls">
<input type="password" name='password' id="inputPassword" placeholder="Mot de passe">
</div>
</div>
<div class="control-group">
<div class="controls">
<label class="checkbox">
<input type="checkbox" name='keepupdated' value='1'> connexion automatique
</label>
</div>
</div>
<a href='/forgot-password.php'>Mot de passe oublié ?</a>
</p>
</div>
<div class="modal-footer">
<input type='submit' class="btn btn-primary" name='membersaccess' value='Connexion' />
</form>
</div>
</div>