<?PHP
function fonc_url($path)
	{
	$urlpath=strtolower($path);
	$urlpath=str_replace( " & ", " ", $urlpath);
	$urlpath=str_replace( ", ", " ", $urlpath);
	$urlpath=str_replace( " / ", " ", $urlpath);
	$urlpath=str_replace( "(", "", $urlpath);
	$urlpath=str_replace( ")", "", $urlpath);
	$urlpath=str_replace( "'", " ", $urlpath);
	$urlpath=str_replace( "–", " ", $urlpath);
	$urlpath=str_replace( "’", "-", $urlpath);
	$urlpath=str_replace( "/", " ", $urlpath);
	$urlpath=str_replace( "%20", " ", $urlpath);
	$urlpath=str_replace( "", "oe", $urlpath);
	$urlpath=str_replace( "", "oe", $urlpath);
	$urlpath=str_replace( ".", "", $urlpath);
	$urlpath=str_replace( " : ", " ", $urlpath);
	$urlpath=str_replace( ": ", " ", $urlpath);
	$urlpath=str_replace( "|", "", $urlpath);
	$urlpath=str_replace( "%", "", $urlpath);
	$urlpath=str_replace( " - ", "-", $urlpath);
	$urlpath=str_replace( " ", "-", $urlpath);
	$urlpath=strtr($urlpath,"אבגהעףפצטיךכחלםמןשתûüָֹÊְֲִַֻ־ֿװײÛÜ", "aaaaooooeeeeciiiiuuuueeeeaaaciioouu");
	return $urlpath;
	}
	
function wiki_aff_date_fr($text)
	{
	$datenews=explode("-",$text);
	$yearnews=$datenews[0];
	$monthnews=$datenews[1];
	$daynews=$datenews[2];
	if ($monthnews=="01") $monthnews="Janvier"; if ($monthnews=="02") $monthnews="Fיvrier"; if ($monthnews=="03") $monthnews="Mars";
	if ($monthnews=="04") $monthnews="Avril"; if ($monthnews=="05") $monthnews="Mai"; if ($monthnews=="06") $monthnews="Juin";
	if ($monthnews=="07") $monthnews="Juillet"; if ($monthnews=="08") $monthnews="Août"; if ($monthnews=="09") $monthnews="Septembre";
	if ($monthnews=="10") $monthnews="Octobre"; if ($monthnews=="11") $monthnews="Novembre"; if ($monthnews=="12") $monthnews="Dיcembre";
	
	$affdate="$daynews $monthnews $yearnews";
	
	return $affdate;
	}
?>