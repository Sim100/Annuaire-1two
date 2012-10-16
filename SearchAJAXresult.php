<?php
include ('_connexion.php');
include ('fonc-url.php');
if(isset($_GET['q'])) {
    $q = htmlentities($_GET['q']);
     
    try {
        $bdd = new PDO('mysql:host='.host.';dbname='.bdd.'', ''.user.'', ''.pass.'');
    } catch(Exception $e) {
        exit('Impossible to connect database');
    }
	$requete = "SELECT title, url, compteur FROM 1two_annuaire_sites WHERE (title LIKE '%".$q."%' or url LIKE '%".$q."%') and valid=1 ORDER BY title ASC LIMIT 0, 30";
    $resultat = $bdd->query($requete) or die(print_r($bdd->errorInfo()));
    while($donnees = $resultat->fetch(PDO::FETCH_ASSOC)) {
		echo utf8_encode($donnees['title']).""."\n";
    }
}
?>