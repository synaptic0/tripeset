<?php
/*
 * Data Analysis Tool for TRIPESET 1.0 - Experiment 2
 * (C) 2017, Università degli Studi della Campania "Luigi Vanvitelli"
 * http://www.unicampania.it
 *
 * Powered by Giovanni dr. Federico
 * dev@giovannifederico.net
 * http://www.giovannifederico.net
*/

ini_set('display_errors', 'On');
error_reporting(E_ALL);
require_once("mysql.class.php");
$MySQL = new MySQL;
$Db = $MySQL->Connessione();

/* Impostazioni dello script */
$NumberOfSubjects = 4;															// Indica il numero di soggetti che compone il database
$ControllaCorrettezza = TRUE;													// Imposta un filtro sulle sole risposte corrette
$PartiDalSoggettoNumero = 1;													// Imposta il soggetto di partenza a partire dal quale fare l'analisi globale dei dati
$InformazioniRichiesteAlDb = "AVG(RT) as mRT, STDDEV(RT) as sdRT";				// Indica quali dati richiedere al Database nelle SELECT --> Media e Deviazione Standard
$TabellaDb = "experiment2";														// Indica la tabella entro cui sono contenuti i dati
$PrecisioneDecimale = 5;														// Indica la precisione decimale richiesta
$TrialXCond = 18;																// Specificare il numero di trial per singola condizione (S1 * S2) -> 9 se tutte le cond. 18 se yes\no accorpati
$S1_Types = array('near_near', 'near_far', 'far_near', 'far_far');				// Array contenente le distinte condizioni di S1
$S2_Types = array('yes_tool', "yes_object", "no_tool", "no_object" );												// Array contenente le distinte condizioni di S2

if($ControllaCorrettezza) $CheckCorrettezza = " AND CORRETTEZZA = 1";
else $CheckCorrettezza = "";

// Estraggo i dati per singolo soggetto e li inserisco nell'Array $Data;
for ($s = 1; $s <= $NumberOfSubjects; $s++) {
	foreach($S1_Types as $S1) {
		foreach($S2_Types as $S2) {
			$i = $s - 1;
			$Query_RT = "SELECT " . $InformazioniRichiesteAlDb . " FROM " . $TabellaDb . " WHERE S1 = '$S1' AND S2 LIKE '$S2' AND SOGGETTO = $s" . $CheckCorrettezza;
			$Query_ERRORS = "SELECT COUNT(id) AS errors FROM " . $TabellaDb . " WHERE S1 = '$S1' AND S2 LIKE '$S2' AND SOGGETTO = $s AND CORRETTEZZA = 0";
			$Result_RT = mysqli_query($Db, $Query_RT);
			$Result_ERRORS = mysqli_query($Db, $Query_ERRORS);
			$RT = mysqli_fetch_array($Result_RT, MYSQLI_ASSOC);
			$ERR = mysqli_fetch_array($Result_ERRORS, MYSQLI_ASSOC);
			$Data[$i][$S1][$S2] = $RT;
			$Data[$i][$S1][$S2]["errors"] = $ERR['errors'];
			$Data[$i][$S1][$S2]["errors_perc"] = 1 - (1 - ($ERR['errors']/$TrialXCond) );
			$Data[$i][$S1][$S2]["accuracy"] = (1 - ($ERR['errors']/$TrialXCond) );
			$Data[$i][$S1][$S2]["IES"] = $RT['mRT']/ (1 - ($ERR['errors']/$TrialXCond) );
		}
	}
}

// Stampo il titolo della pagina HTML generata:
function PrintTitle() {
	echo "<h1>Experiment 2 - Preliminary Data Analysis </h1><hr>";
}

// Stampo Summary
function Summary() {
	global $NumberOfSubjects, $PrecisioneDecimale, $TrialXCond, $S1_Types, $S2_Types;

	echo "<h3>The contents of this page are confidential and intended solely for the recipient.<br>";
	echo "Reproduction of, or forwarding to anyone not directly sent this page (link) is strictly forbidden.</h3>";
	echo "<hr><br>";
	echo "All data managed by this script are related to the folowing setup:";
	echo "<ul>";
	echo "<li><strong>Sample size (N)</strong>: " . $NumberOfSubjects . "</li>";
	echo "<li><strong>S1 conditions</strong>: " . implode(", ", $S1_Types) . "</li>";
	echo "<li><strong>S2 conditions</strong>: " . implode(", ", $S2_Types) . "</li>";
	echo "<li><strong>Number of trials for each S1 * S2</strong>: " . $TrialXCond . "</li>";
	echo "<li><strong>Float precision (number of decimals)</strong>: " . $PrecisioneDecimale . "</li>";
	echo "</ul>";
}

// Funzione per la stampa dei dati, si passi come argomento il dato richiesto:
function PrintData($Title, $InfoRequested, $ShowMean = FALSE, $ShowTotal = FALSE) {
	echo 	"<h2>". $Title . "</h2>";
	echo 	"<table border='1' cellspacing='2' cellpadding='2'>";
	echo 	"<tr>";
	echo 	"<th>Soggetto</th>";

	global $S1_Types, $S2_Types, $NumberOfSubjects, $Data, $PrecisioneDecimale;

	foreach($S1_Types as $S1) {
		foreach($S2_Types as $S2) {
			echo "<th>" . $S1 . " * " . $S2 .  "</th>";
		}
	}
	echo 	"</tr>";

	$Mean = array();
	for ($s = 0; $s < $NumberOfSubjects; $s++) {
		echo "<tr>";
		echo "<td>" . ($s + 1) . "</td>";
		foreach($S1_Types as $S1) {
			foreach($S2_Types as $S2) {
				echo "<td>" . round($Data[$s][$S1][$S2][$InfoRequested], $PrecisioneDecimale) . "</td>";
				if (isset($Mean[$S1][$S2])) {
					$Mean[$S1][$S2] = $Mean[$S1][$S2] + round($Data[$s][$S1][$S2][$InfoRequested], $PrecisioneDecimale);
				} else {
					$Mean[$S1][$S2] = round($Data[$s][$S1][$S2][$InfoRequested], $PrecisioneDecimale);
				}
			}
		}
		echo "</tr>";
	}

	if ($ShowMean) {
		echo "<th>Global:</th>";
		foreach($S1_Types as $S1) {
			foreach($S2_Types as $S2) {
				echo "<td>" . round( ($Mean[$S1][$S2] / $NumberOfSubjects), $PrecisioneDecimale) . "</td>";
				}
			}
		echo "</tr>";
	}

	if ($ShowTotal) {
		echo "<th>Global:</th>";
		foreach($S1_Types as $S1) {
			foreach($S2_Types as $S2) {
				echo "<td>" . round($Mean[$S1][$S2], $PrecisioneDecimale) . "</td>";
				}
			}
		echo "</tr>";
	}

	echo 	"</table>";

}

// Separatore
function Separatore() {
	echo "<br><hr>";
}
?>

<?php
PrintTitle();

Summary();
Separatore();

PrintData("Global means (ms)", "mRT", true);
PrintData("Standard deviations (ms)", "sdRT", true);
Separatore();

PrintData("Inverse Efficiency Score (ms)", "IES", true);
Separatore();

PrintData("Accuracy (% of correct responses)", "accuracy", true);
PrintData("Number of errors", "errors", false, true);
PrintData("Errors percentage", "errors_perc", true);
Separatore();
?>
