<h1>Experiment 1 - Preliminary Data Analysis </h1>
<?php

/*
 * Data Analysis Tool for TRIPESET 1.0 - Experiment 1
 * (C) 2017, Università degli Studi della Campania "Luigi Vanvitelli"
 * http://www.unicampania.it
 *
 * Powered by Giovanni dr. Federico
 * dev@giovannifederico.net
 * http://www.giovannifederico.net
*/

require_once("mysql.class.php");
$MySQL = new MySQL;
$Db = $MySQL->Connessione();

/* Impostazioni dello script */
$NumberOfSubjects = 28;									// Indica il numero di soggetti che compone il database
$ControllaCorrettezza = TRUE;							// Imposta un filtro sulle sole risposte corrette
$PartiDalSoggettoNumero = 1;								// Imposta il soggetto di partenza a partire dal quale fare l'analisi globale dei dati
$InformazioniRichiesteAlDb = "AVG(RT), STDDEV(RT)";		// Indica quali dati richiedere al Database nelle SELECT --> Media e Deviazione Standard
$PrecisioneDecimale = 3;									// Indica la precisione decimale richiesta
/* Fine Impostazioni */


if($ControllaCorrettezza) $CheckCorrettezza = " AND CORRETTEZZA = 1";
else $CheckCorrettezza = "";

// Estraggo il numero di trial per condizione
$CountQuery1 = "SELECT COUNT(*) AS QUANTITY FROM experiment1 WHERE (SOGGETTO >= " . $PartiDalSoggettoNumero . " AND SOGGETTO <= " . $NumberOfSubjects . " AND S1 = 'coherent_near_near' AND S2 = 'yes_tool')";
$CountQuery2 = "SELECT COUNT(*) AS QUANTITY FROM experiment1 WHERE (SOGGETTO >= " . $PartiDalSoggettoNumero . " AND SOGGETTO <= " . $NumberOfSubjects . " AND S1 = 'coherent_near_near' AND S2 = 'yes_object')";
$CountQuery3 = "SELECT COUNT(*) AS QUANTITY FROM experiment1 WHERE (SOGGETTO >= " . $PartiDalSoggettoNumero . " AND SOGGETTO <= " . $NumberOfSubjects . " AND S1 = 'coherent_near_near' AND S2 = 'no_tool')";
$CountQuery4 = "SELECT COUNT(*) AS QUANTITY FROM experiment1 WHERE (SOGGETTO >= " . $PartiDalSoggettoNumero . " AND SOGGETTO <= " . $NumberOfSubjects . " AND S1 = 'coherent_near_near' AND S2 = 'no_object')";
$CountQuery5 = "SELECT COUNT(*) AS QUANTITY FROM experiment1 WHERE (SOGGETTO >= " . $PartiDalSoggettoNumero . " AND SOGGETTO <= " . $NumberOfSubjects . " AND S1 = 'not_coherent_near_near' AND S2 = 'yes_tool')";
$CountQuery6 = "SELECT COUNT(*) AS QUANTITY FROM experiment1 WHERE (SOGGETTO >= " . $PartiDalSoggettoNumero . " AND SOGGETTO <= " . $NumberOfSubjects . " AND S1 = 'not_coherent_near_near' AND S2 = 'yes_object')";
$CountQuery7 = "SELECT COUNT(*) AS QUANTITY FROM experiment1 WHERE (SOGGETTO >= " . $PartiDalSoggettoNumero . " AND SOGGETTO <= " . $NumberOfSubjects . " AND S1 = 'not_coherent_near_near' AND S2 = 'no_tool')";
$CountQuery8 = "SELECT COUNT(*) AS QUANTITY FROM experiment1 WHERE (SOGGETTO >= " . $PartiDalSoggettoNumero . " AND SOGGETTO <= " . $NumberOfSubjects . " AND S1 = 'not_coherent_near_near' AND S2 = 'no_object')";
$CountExecute1 = mysqli_query($Db, $CountQuery1) or die(mysqli_error($Db));
$CountExecute2 = mysqli_query($Db, $CountQuery2) or die(mysqli_error($Db));
$CountExecute3 = mysqli_query($Db, $CountQuery3) or die(mysqli_error($Db));
$CountExecute4 = mysqli_query($Db, $CountQuery4) or die(mysqli_error($Db));
$CountExecute5 = mysqli_query($Db, $CountQuery5) or die(mysqli_error($Db));
$CountExecute6 = mysqli_query($Db, $CountQuery6) or die(mysqli_error($Db));
$CountExecute7 = mysqli_query($Db, $CountQuery7) or die(mysqli_error($Db));
$CountExecute8 = mysqli_query($Db, $CountQuery8) or die(mysqli_error($Db));
$NumberOfTrials['C_YT'] = mysqli_fetch_array($CountExecute1);
$NumberOfTrials['C_YO'] = mysqli_fetch_array($CountExecute2);
$NumberOfTrials['C_NT'] = mysqli_fetch_array($CountExecute3);
$NumberOfTrials['C_NO'] = mysqli_fetch_array($CountExecute4);
$NumberOfTrials['NC_YT'] = mysqli_fetch_array($CountExecute5);
$NumberOfTrials['NC_YO'] = mysqli_fetch_array($CountExecute6);
$NumberOfTrials['NC_NT'] = mysqli_fetch_array($CountExecute7);
$NumberOfTrials['NC_NO'] = mysqli_fetch_array($CountExecute8);

sleep(0.5);

// Estraggo Informazioni Globali per tutte le condizioni:
$GlobalQuery1 = "SELECT " . $InformazioniRichiesteAlDb . " FROM experiment1 WHERE (SOGGETTO >= " . $PartiDalSoggettoNumero . " AND SOGGETTO <= " . $NumberOfSubjects . " AND S1 = 'coherent_near_near' AND S2 = 'yes_tool'" . $CheckCorrettezza . ")";
$GlobalQuery2 = "SELECT " . $InformazioniRichiesteAlDb . " FROM experiment1 WHERE (SOGGETTO >= " . $PartiDalSoggettoNumero . " AND SOGGETTO <= " . $NumberOfSubjects . " AND S1 = 'coherent_near_near' AND S2 = 'yes_object'" . $CheckCorrettezza. ")";
$GlobalQuery3 = "SELECT " . $InformazioniRichiesteAlDb . " FROM experiment1 WHERE (SOGGETTO >= " . $PartiDalSoggettoNumero . " AND SOGGETTO <= " . $NumberOfSubjects . " AND S1 = 'coherent_near_near' AND S2 = 'no_tool' " . $CheckCorrettezza. ")";
$GlobalQuery4 = "SELECT " . $InformazioniRichiesteAlDb . " FROM experiment1 WHERE (SOGGETTO >= " . $PartiDalSoggettoNumero . " AND SOGGETTO <= " . $NumberOfSubjects . " AND S1 = 'coherent_near_near' AND S2 = 'no_object'" . $CheckCorrettezza. ")";
$GlobalQuery5 = "SELECT " . $InformazioniRichiesteAlDb . " FROM experiment1 WHERE (SOGGETTO >= " . $PartiDalSoggettoNumero . " AND SOGGETTO <= " . $NumberOfSubjects . " AND S1 = 'not_coherent_near_near' AND S2 = 'yes_tool'" . $CheckCorrettezza. ")";
$GlobalQuery6 = "SELECT " . $InformazioniRichiesteAlDb . " FROM experiment1 WHERE (SOGGETTO >= " . $PartiDalSoggettoNumero . " AND SOGGETTO <= " . $NumberOfSubjects . " AND S1 = 'not_coherent_near_near' AND S2 = 'yes_object'" . $CheckCorrettezza. ")";
$GlobalQuery7 = "SELECT " . $InformazioniRichiesteAlDb . " FROM experiment1 WHERE (SOGGETTO >= " . $PartiDalSoggettoNumero . " AND SOGGETTO <= " . $NumberOfSubjects . " AND S1 = 'not_coherent_near_near' AND S2 = 'no_tool'" . $CheckCorrettezza. ")";
$GlobalQuery8 = "SELECT " . $InformazioniRichiesteAlDb . " FROM experiment1 WHERE (SOGGETTO >= " . $PartiDalSoggettoNumero . " AND SOGGETTO <= " . $NumberOfSubjects . " AND S1 = 'not_coherent_near_near' AND S2 = 'no_object'" . $CheckCorrettezza. ")";
$GlobalExecute1 = mysqli_query($Db, $GlobalQuery1) or die(mysqli_error($Db));
$GlobalExecute2 = mysqli_query($Db, $GlobalQuery2) or die(mysqli_error($Db));
$GlobalExecute3 = mysqli_query($Db, $GlobalQuery3) or die(mysqli_error($Db));
$GlobalExecute4 = mysqli_query($Db, $GlobalQuery4) or die(mysqli_error($Db));
$GlobalExecute5 = mysqli_query($Db, $GlobalQuery5) or die(mysqli_error($Db));
$GlobalExecute6 = mysqli_query($Db, $GlobalQuery6) or die(mysqli_error($Db));
$GlobalExecute7 = mysqli_query($Db, $GlobalQuery7) or die(mysqli_error($Db));
$GlobalExecute8 = mysqli_query($Db, $GlobalQuery8) or die(mysqli_error($Db));
$GlobalData['C_YT'] = mysqli_fetch_array($GlobalExecute1);
$GlobalData['C_YO'] = mysqli_fetch_array($GlobalExecute2);
$GlobalData['C_NT'] = mysqli_fetch_array($GlobalExecute3);
$GlobalData['C_NO'] = mysqli_fetch_array($GlobalExecute4);
$GlobalData['NC_YT'] = mysqli_fetch_array($GlobalExecute5);
$GlobalData['NC_YO'] = mysqli_fetch_array($GlobalExecute6);
$GlobalData['NC_NT'] = mysqli_fetch_array($GlobalExecute7);
$GlobalData['NC_NO'] = mysqli_fetch_array($GlobalExecute8);

sleep(0.5);


// Estraggo Informazioni Aggregate per SI e NO:
$AggregatedQuery1 = "SELECT " . $InformazioniRichiesteAlDb . " FROM experiment1 WHERE (SOGGETTO >= " . $PartiDalSoggettoNumero . " AND SOGGETTO <= " . $NumberOfSubjects . " AND S1 = 'coherent_near_near' AND S2 LIKE 'yes_%' " . $CheckCorrettezza . ")";
$AggregatedQuery2 = "SELECT " . $InformazioniRichiesteAlDb . " FROM experiment1 WHERE (SOGGETTO >= " . $PartiDalSoggettoNumero . " AND SOGGETTO <= " . $NumberOfSubjects . " AND S1 = 'coherent_near_near' AND S2 LIKE 'no_%' " . $CheckCorrettezza. ")";
$AggregatedQuery3 = "SELECT " . $InformazioniRichiesteAlDb . " FROM experiment1 WHERE (SOGGETTO >= " . $PartiDalSoggettoNumero . " AND SOGGETTO <= " . $NumberOfSubjects . " AND S1 = 'not_coherent_near_near' AND S2 LIKE 'yes_%' " . $CheckCorrettezza. ")";
$AggregatedQuery4 = "SELECT " . $InformazioniRichiesteAlDb . " FROM experiment1 WHERE (SOGGETTO >= " . $PartiDalSoggettoNumero . " AND SOGGETTO <= " . $NumberOfSubjects . " AND S1 = 'not_coherent_near_near' AND S2 LIKE 'no_%' " . $CheckCorrettezza. ")";
$AggregatedExecute1 = mysqli_query($Db, $AggregatedQuery1) or die(mysqli_error($Db));
$AggregatedExecute2 = mysqli_query($Db, $AggregatedQuery2) or die(mysqli_error($Db));
$AggregatedExecute3 = mysqli_query($Db, $AggregatedQuery3) or die(mysqli_error($Db));
$AggregatedExecute4 = mysqli_query($Db, $AggregatedQuery4) or die(mysqli_error($Db));
$AggregatedData['C_YES'] = mysqli_fetch_array($AggregatedExecute1);
$AggregatedData['C_NO'] = mysqli_fetch_array($AggregatedExecute2);
$AggregatedData['NC_YES'] = mysqli_fetch_array($AggregatedExecute3);
$AggregatedData['NC_NO'] = mysqli_fetch_array($AggregatedExecute4);

sleep(0.5);


// Estraggo Informazioni Aggregate per Coherent e Not Coherent:
$AggregatedCQuery1 = "SELECT " . $InformazioniRichiesteAlDb . " FROM experiment1 WHERE (SOGGETTO >= " . $PartiDalSoggettoNumero . " AND SOGGETTO <= " . $NumberOfSubjects . " AND S1 = 'coherent_near_near' " . $CheckCorrettezza . ")";
$AggregatedCQuery2 = "SELECT " . $InformazioniRichiesteAlDb . " FROM experiment1 WHERE (SOGGETTO >= " . $PartiDalSoggettoNumero . " AND SOGGETTO <= " . $NumberOfSubjects . " AND S1 = 'not_coherent_near_near' " . $CheckCorrettezza. ")";
$AggregatedCExecute1 = mysqli_query($Db, $AggregatedCQuery1) or die(mysqli_error($Db));
$AggregatedCExecute2 = mysqli_query($Db, $AggregatedCQuery2) or die(mysqli_error($Db));
$AggregatedCData['C'] = mysqli_fetch_array($AggregatedCExecute1);
$AggregatedCData['NC'] = mysqli_fetch_array($AggregatedCExecute2);

sleep(0.5);

// Estraggo Informazioni per Singolo Soggetto:
for ( $i = $PartiDalSoggettoNumero; $i <= $NumberOfSubjects; $i++) {
	$Query1 = "SELECT " . $InformazioniRichiesteAlDb . " FROM experiment1 WHERE (S1 = 'coherent_near_near' AND S2 = 'yes_tool' AND SOGGETTO = " . $i . $CheckCorrettezza. ")";
	$Query2 = "SELECT " . $InformazioniRichiesteAlDb . " FROM experiment1 WHERE (S1 = 'coherent_near_near' AND S2 = 'yes_object' AND SOGGETTO = " . $i . $CheckCorrettezza. ")";
	$Query3 = "SELECT " . $InformazioniRichiesteAlDb . " FROM experiment1 WHERE (S1 = 'coherent_near_near' AND S2 = 'no_tool' AND SOGGETTO = " . $i . $CheckCorrettezza. ")";
	$Query4 = "SELECT " . $InformazioniRichiesteAlDb . " FROM experiment1 WHERE (S1 = 'coherent_near_near' AND S2 = 'no_object' AND SOGGETTO = " . $i . $CheckCorrettezza. ")";
	$Query5 = "SELECT " . $InformazioniRichiesteAlDb . " FROM experiment1 WHERE (S1 = 'not_coherent_near_near' AND S2 = 'yes_tool' AND SOGGETTO = " . $i . $CheckCorrettezza. ")";
	$Query6 = "SELECT " . $InformazioniRichiesteAlDb . " FROM experiment1 WHERE (S1 = 'not_coherent_near_near' AND S2 = 'yes_object' AND SOGGETTO = " . $i . $CheckCorrettezza. ")";
	$Query7 = "SELECT " . $InformazioniRichiesteAlDb . " FROM experiment1 WHERE (S1 = 'not_coherent_near_near' AND S2 = 'no_tool' AND SOGGETTO = " . $i . $CheckCorrettezza. ")";
	$Query8 = "SELECT " . $InformazioniRichiesteAlDb . " FROM experiment1 WHERE (S1 = 'not_coherent_near_near' AND S2 = 'no_object' AND SOGGETTO = " . $i . $CheckCorrettezza. ")";
	$Execute1 = mysqli_query($Db, $Query1) or die(mysqli_error($Db));
	$Execute2 = mysqli_query($Db, $Query2) or die(mysqli_error($Db));
	$Execute3 = mysqli_query($Db, $Query3) or die(mysqli_error($Db));
	$Execute4 = mysqli_query($Db, $Query4) or die(mysqli_error($Db));
	$Execute5 = mysqli_query($Db, $Query5) or die(mysqli_error($Db));
	$Execute6 = mysqli_query($Db, $Query6) or die(mysqli_error($Db));
	$Execute7 = mysqli_query($Db, $Query7) or die(mysqli_error($Db));
	$Execute8 = mysqli_query($Db, $Query8) or die(mysqli_error($Db));
	$Data[$i]['C_YT'] = mysqli_fetch_array($Execute1);
	$Data[$i]['C_YO'] = mysqli_fetch_array($Execute2);
	$Data[$i]['C_NT'] = mysqli_fetch_array($Execute3);
	$Data[$i]['C_NO'] = mysqli_fetch_array($Execute4);
	$Data[$i]['NC_YT'] = mysqli_fetch_array($Execute5);
	$Data[$i]['NC_YO'] = mysqli_fetch_array($Execute6);
	$Data[$i]['NC_NT'] = mysqli_fetch_array($Execute7);
	$Data[$i]['NC_NO'] = mysqli_fetch_array($Execute8);
}

sleep(0.5);

// Estraggo Gli Errori Globali:
$GlobalErrorQuery1 = "SELECT COUNT(*) AS ERRORS FROM experiment1 WHERE (SOGGETTO >= " . $PartiDalSoggettoNumero . " AND SOGGETTO <= " . $NumberOfSubjects . " AND S1 = 'coherent_near_near' AND S2 = 'yes_tool' AND CORRETTEZZA = 0)";
$GlobalErrorQuery2 = "SELECT COUNT(*) AS ERRORS FROM experiment1 WHERE (SOGGETTO >= " . $PartiDalSoggettoNumero . " AND SOGGETTO <= " . $NumberOfSubjects . " AND S1 = 'coherent_near_near' AND S2 = 'yes_object' AND CORRETTEZZA = 0)";
$GlobalErrorQuery3 = "SELECT COUNT(*) AS ERRORS FROM experiment1 WHERE (SOGGETTO >= " . $PartiDalSoggettoNumero . " AND SOGGETTO <= " . $NumberOfSubjects . " AND S1 = 'coherent_near_near' AND S2 = 'no_tool' AND CORRETTEZZA = 0)";
$GlobalErrorQuery4 = "SELECT COUNT(*) AS ERRORS FROM experiment1 WHERE (SOGGETTO >= " . $PartiDalSoggettoNumero . " AND SOGGETTO <= " . $NumberOfSubjects . " AND S1 = 'coherent_near_near' AND S2 = 'no_object' AND CORRETTEZZA = 0)";
$GlobalErrorQuery5 = "SELECT COUNT(*) AS ERRORS FROM experiment1 WHERE (SOGGETTO >= " . $PartiDalSoggettoNumero . " AND SOGGETTO <= " . $NumberOfSubjects . " AND S1 = 'not_coherent_near_near' AND S2 = 'yes_tool' AND CORRETTEZZA = 0)";
$GlobalErrorQuery6 = "SELECT COUNT(*) AS ERRORS FROM experiment1 WHERE (SOGGETTO >= " . $PartiDalSoggettoNumero . " AND SOGGETTO <= " . $NumberOfSubjects . " AND S1 = 'not_coherent_near_near' AND S2 = 'yes_object' AND CORRETTEZZA = 0)";
$GlobalErrorQuery7 = "SELECT COUNT(*) AS ERRORS FROM experiment1 WHERE (SOGGETTO >= " . $PartiDalSoggettoNumero . " AND SOGGETTO <= " . $NumberOfSubjects . " AND S1 = 'not_coherent_near_near' AND S2 = 'no_tool' AND CORRETTEZZA = 0)";
$GlobalErrorQuery8 = "SELECT COUNT(*) AS ERRORS FROM experiment1 WHERE (SOGGETTO >= " . $PartiDalSoggettoNumero . " AND SOGGETTO <= " . $NumberOfSubjects . " AND S1 = 'not_coherent_near_near' AND S2 = 'no_object' AND CORRETTEZZA = 0)";
$GlobalErrorExecute1 = mysqli_query($Db, $GlobalErrorQuery1) or die(mysqli_error($Db));
$GlobalErrorExecute2 = mysqli_query($Db, $GlobalErrorQuery2) or die(mysqli_error($Db));
$GlobalErrorExecute3 = mysqli_query($Db, $GlobalErrorQuery3) or die(mysqli_error($Db));
$GlobalErrorExecute4 = mysqli_query($Db, $GlobalErrorQuery4) or die(mysqli_error($Db));
$GlobalErrorExecute5 = mysqli_query($Db, $GlobalErrorQuery5) or die(mysqli_error($Db));
$GlobalErrorExecute6 = mysqli_query($Db, $GlobalErrorQuery6) or die(mysqli_error($Db));
$GlobalErrorExecute7 = mysqli_query($Db, $GlobalErrorQuery7) or die(mysqli_error($Db));
$GlobalErrorExecute8 = mysqli_query($Db, $GlobalErrorQuery8) or die(mysqli_error($Db));
$GlobalData['C_YT']['EXTRA'] = mysqli_fetch_array($GlobalErrorExecute1);
$GlobalData['C_YO']['EXTRA'] = mysqli_fetch_array($GlobalErrorExecute2);
$GlobalData['C_NT']['EXTRA'] = mysqli_fetch_array($GlobalErrorExecute3);
$GlobalData['C_NO']['EXTRA'] = mysqli_fetch_array($GlobalErrorExecute4);
$GlobalData['NC_YT']['EXTRA'] = mysqli_fetch_array($GlobalErrorExecute5);
$GlobalData['NC_YO']['EXTRA'] = mysqli_fetch_array($GlobalErrorExecute6);
$GlobalData['NC_NT']['EXTRA'] = mysqli_fetch_array($GlobalErrorExecute7);
$GlobalData['NC_NO']['EXTRA'] = mysqli_fetch_array($GlobalErrorExecute8);

sleep(0.5);

// Estraggo Gli Errori commessi dai Soggetti per ogni condizione:
for ( $i = $PartiDalSoggettoNumero; $i <= $NumberOfSubjects; $i++) {
	$ErrorQuery1 = "SELECT COUNT(*) AS ERRORS FROM experiment1 WHERE (S1 = 'coherent_near_near' AND S2 = 'yes_tool' AND SOGGETTO = " . $i . " AND CORRETTEZZA = 0)";
	$ErrorQuery2 = "SELECT COUNT(*) AS ERRORS FROM experiment1 WHERE (S1 = 'coherent_near_near' AND S2 = 'yes_object' AND SOGGETTO = " . $i . " AND CORRETTEZZA = 0)";
	$ErrorQuery3 = "SELECT COUNT(*) AS ERRORS FROM experiment1 WHERE (S1 = 'coherent_near_near' AND S2 = 'no_tool' AND SOGGETTO = " . $i . " AND CORRETTEZZA = 0)";
	$ErrorQuery4 = "SELECT COUNT(*) AS ERRORS FROM experiment1 WHERE (S1 = 'coherent_near_near' AND S2 = 'no_object' AND SOGGETTO = " . $i . " AND CORRETTEZZA = 0)";
	$ErrorQuery5 = "SELECT COUNT(*) AS ERRORS FROM experiment1 WHERE (S1 = 'not_coherent_near_near' AND S2 = 'yes_tool' AND SOGGETTO = " . $i . " AND CORRETTEZZA = 0)";
	$ErrorQuery6 = "SELECT COUNT(*) AS ERRORS FROM experiment1 WHERE (S1 = 'not_coherent_near_near' AND S2 = 'yes_object' AND SOGGETTO = " . $i . " AND CORRETTEZZA = 0)";
	$ErrorQuery7 = "SELECT COUNT(*) AS ERRORS FROM experiment1 WHERE (S1 = 'not_coherent_near_near' AND S2 = 'no_tool' AND SOGGETTO = " . $i . " AND CORRETTEZZA = 0)";
	$ErrorQuery8 = "SELECT COUNT(*) AS ERRORS FROM experiment1 WHERE (S1 = 'not_coherent_near_near' AND S2 = 'no_object' AND SOGGETTO = " . $i . " AND CORRETTEZZA = 0)";
	$ErrorExecute1 = mysqli_query($Db, $ErrorQuery1) or die(mysqli_error($Db));
	$ErrorExecute2 = mysqli_query($Db, $ErrorQuery2) or die(mysqli_error($Db));
	$ErrorExecute3 = mysqli_query($Db, $ErrorQuery3) or die(mysqli_error($Db));
	$ErrorExecute4 = mysqli_query($Db, $ErrorQuery4) or die(mysqli_error($Db));
	$ErrorExecute5 = mysqli_query($Db, $ErrorQuery5) or die(mysqli_error($Db));
	$ErrorExecute6 = mysqli_query($Db, $ErrorQuery6) or die(mysqli_error($Db));
	$ErrorExecute7 = mysqli_query($Db, $ErrorQuery7) or die(mysqli_error($Db));
	$ErrorExecute8 = mysqli_query($Db, $ErrorQuery8) or die(mysqli_error($Db));
	$Data[$i]['C_YT']['EXTRA'] = mysqli_fetch_array($ErrorExecute1);
	$Data[$i]['C_YO']['EXTRA']  = mysqli_fetch_array($ErrorExecute2);
	$Data[$i]['C_NT']['EXTRA']  = mysqli_fetch_array($ErrorExecute3);
	$Data[$i]['C_NO']['EXTRA']  = mysqli_fetch_array($ErrorExecute4);
	$Data[$i]['NC_YT']['EXTRA']  = mysqli_fetch_array($ErrorExecute5);
	$Data[$i]['NC_YO']['EXTRA']  = mysqli_fetch_array($ErrorExecute6);
	$Data[$i]['NC_NT']['EXTRA']  = mysqli_fetch_array($ErrorExecute7);
	$Data[$i]['NC_NO']['EXTRA']  = mysqli_fetch_array($ErrorExecute8);
}

sleep(0.5);

// Calcolo l'IES per ogni Coondizione
$IES['C_YT'] = $GlobalData['C_YT']['AVG(RT)'] / ( 1 - ($GlobalData['C_YT']['EXTRA']['ERRORS']/$NumberOfTrials['C_YT']['QUANTITY']) );
$IES['C_YO'] = $GlobalData['C_YO']['AVG(RT)'] / ( 1 - ($GlobalData['C_YO']['EXTRA']['ERRORS']/$NumberOfTrials['C_YO']['QUANTITY']) );
$IES['C_NT'] = $GlobalData['C_NT']['AVG(RT)'] / ( 1 - ($GlobalData['C_NT']['EXTRA']['ERRORS']/$NumberOfTrials['C_NT']['QUANTITY']) );
$IES['C_NO'] = $GlobalData['C_NO']['AVG(RT)'] / ( 1 - ($GlobalData['C_NO']['EXTRA']['ERRORS']/$NumberOfTrials['C_NO']['QUANTITY']) );
$IES['NC_YT'] = $GlobalData['NC_YT']['AVG(RT)'] / ( 1 - ($GlobalData['NC_YT']['EXTRA']['ERRORS']/$NumberOfTrials['NC_YT']['QUANTITY']) );
$IES['NC_YO'] = $GlobalData['NC_YO']['AVG(RT)'] / ( 1 - ($GlobalData['NC_YO']['EXTRA']['ERRORS']/$NumberOfTrials['NC_YO']['QUANTITY']) );
$IES['NC_NT'] = $GlobalData['NC_NT']['AVG(RT)'] / ( 1 - ($GlobalData['NC_NT']['EXTRA']['ERRORS']/$NumberOfTrials['NC_NT']['QUANTITY']) );
$IES['NC_NO'] = $GlobalData['NC_NO']['AVG(RT)'] / ( 1 - ($GlobalData['NC_NO']['EXTRA']['ERRORS']/$NumberOfTrials['NC_NO']['QUANTITY']) );

$IES['C_YES'] = $AggregatedData['C_YES']['AVG(RT)'] / (1 - (($GlobalData['C_YT']['EXTRA']['ERRORS'] + $GlobalData['C_YO']['EXTRA']['ERRORS'])/($NumberOfTrials['C_YT']['QUANTITY']+$NumberOfTrials['C_YO']['QUANTITY']) ));
$IES['C_NO'] = $AggregatedData['C_NO']['AVG(RT)'] / (1 - (($GlobalData['C_NT']['EXTRA']['ERRORS'] + $GlobalData['C_NO']['EXTRA']['ERRORS'])/($NumberOfTrials['C_NT']['QUANTITY']+$NumberOfTrials['C_NO']['QUANTITY']) ));
$IES['NC_YES'] = $AggregatedData['NC_YES']['AVG(RT)'] / (1 - (($GlobalData['NC_YT']['EXTRA']['ERRORS'] + $GlobalData['NC_YO']['EXTRA']['ERRORS'])/($NumberOfTrials['NC_YT']['QUANTITY']+$NumberOfTrials['NC_YO']['QUANTITY']) ));
$IES['NC_NO'] = $AggregatedData['NC_NO']['AVG(RT)'] / (1 - (($GlobalData['NC_NT']['EXTRA']['ERRORS'] + $GlobalData['NC_NO']['EXTRA']['ERRORS'])/($NumberOfTrials['NC_NT']['QUANTITY']+$NumberOfTrials['NC_NO']['QUANTITY']) ));

$TE_Y = $GlobalData['C_YT']['EXTRA']['ERRORS'] + $GlobalData['C_YO']['EXTRA']['ERRORS'] + $GlobalData['C_NT']['EXTRA']['ERRORS'] + $GlobalData['C_NO']['EXTRA']['ERRORS'];
$TS_Y = $NumberOfTrials['C_YT']['QUANTITY']+ $NumberOfTrials['C_YO']['QUANTITY'] + $NumberOfTrials['C_NT']['QUANTITY'] + $NumberOfTrials['C_NO']['QUANTITY'];
$TE_N = $GlobalData['NC_YT']['EXTRA']['ERRORS'] + $GlobalData['NC_YO']['EXTRA']['ERRORS'] + $GlobalData['NC_NT']['EXTRA']['ERRORS'] + $GlobalData['NC_NO']['EXTRA']['ERRORS'];
$TS_N = $NumberOfTrials['NC_YT']['QUANTITY'] + $NumberOfTrials['NC_YO']['QUANTITY'] + $NumberOfTrials['NC_NT']['QUANTITY'] + $NumberOfTrials['NC_NO']['QUANTITY'];

$IES['C'] = $AggregatedCData['C']['AVG(RT)'] / ( 1 - ($TE_Y/$TS_Y) );
$IES['NC'] = $AggregatedCData['NC']['AVG(RT)'] / ( 1 - ($TE_N/$TS_N) );

// Debug:
echo "<pre>";

	//print_r($GlobalData);
	//print_r($Data);
echo "</pre>";
?>

<h2>Global Means and Standard Deviations for all conditions</h2>

<table border="1" cellspacing="2" cellpadding="2">
  <tbody>
    <tr>
      <td bgcolor="#A2FF80"><strong>Coherent * Yes Tool (ms)</strong></td>
      <td bgcolor="#A2FF80"><strong>Coherent * Yes Object (ms)</strong></td>
      <td bgcolor="#A2FF80"><strong>Coherent * No Tool (ms)</strong></td>
      <td bgcolor="#A2FF80"><strong>Coherent * No Object (ms)</strong></td>
      <td bgcolor="#FF9798"><strong>Not Coherent * Yes Tool (ms)</strong></td>
      <td bgcolor="#FF9798"><strong>Not Coherent * Yes Object (ms)</strong></td>
      <td bgcolor="#FF9798"><strong>Not Coherent * No Tool (ms)</strong></td>
      <td bgcolor="#FF9798"><strong>Not Coherent * No Object (ms)</strong></td>
    </tr>
    <tr>
      <td bgcolor="#D5FFDA">M = <?php echo round($GlobalData['C_YT']['AVG(RT)'], $PrecisioneDecimale); ?> (SD = <?php echo round($GlobalData['C_YT']['STDDEV(RT)'], $PrecisioneDecimale); ?>)</td>
      <td bgcolor="#D5FFDA">M = <?php echo round($GlobalData['C_YO']['AVG(RT)'], $PrecisioneDecimale); ?> (SD = <?php echo round($GlobalData['C_YO']['STDDEV(RT)'], $PrecisioneDecimale); ?>)</td>
      <td bgcolor="#D5FFDA">M = <?php echo round($GlobalData['C_NT']['AVG(RT)'], $PrecisioneDecimale); ?> (SD = <?php echo round($GlobalData['C_NT']['STDDEV(RT)'], $PrecisioneDecimale); ?>)</td>
      <td bgcolor="#D5FFDA">M = <?php echo round($GlobalData['C_NO']['AVG(RT)'], $PrecisioneDecimale); ?> (SD = <?php echo round($GlobalData['C_NO']['STDDEV(RT)'], $PrecisioneDecimale); ?>)</td>
      <td bgcolor="#FFEFEF">M = <?php echo round($GlobalData['NC_YT']['AVG(RT)'], $PrecisioneDecimale); ?> (SD = <?php echo round($GlobalData['NC_YT']['STDDEV(RT)'], $PrecisioneDecimale); ?>)</td>
      <td bgcolor="#FFEFEF">M = <?php echo round($GlobalData['NC_YO']['AVG(RT)'], $PrecisioneDecimale); ?> (SD = <?php echo round($GlobalData['NC_YO']['STDDEV(RT)'], $PrecisioneDecimale); ?>)</td>
      <td bgcolor="#FFEFEF">M = <?php echo round($GlobalData['NC_NT']['AVG(RT)'], $PrecisioneDecimale); ?> (SD = <?php echo round($GlobalData['NC_NT']['STDDEV(RT)'], $PrecisioneDecimale); ?>)</td>
      <td bgcolor="#FFEFEF">M = <?php echo round($GlobalData['NC_NO']['AVG(RT)'], $PrecisioneDecimale); ?> (SD = <?php echo round($GlobalData['NC_NO']['STDDEV(RT)'], $PrecisioneDecimale); ?>)</td>
    </tr>
  </tbody>
</table>

<h2>Global Means and Standard Deviations for YES and NO aggregrated</h2>

<table border="1" cellspacing="2" cellpadding="2">
  <tbody>
    <tr>
      <td bgcolor="#A2FF80"><strong>Coherent * Yes (ms)</strong></td>
      <td bgcolor="#A2FF80"><strong>Coherent * No (ms)</strong></td>
      <td bgcolor="#FF9798"><strong>Not Coherent * Yes (ms)</strong></td>
      <td bgcolor="#FF9798"><strong>Not Coherent * No (ms)</strong></td>
    </tr>
    <tr>
      <td bgcolor="#D5FFDA">M = <?php echo round($AggregatedData['C_YES']['AVG(RT)'], $PrecisioneDecimale); ?> (SD = <?php echo round($AggregatedData['C_YES']['STDDEV(RT)'], $PrecisioneDecimale); ?>)</td>
      <td bgcolor="#D5FFDA">M = <?php echo round($AggregatedData['C_NO']['AVG(RT)'], $PrecisioneDecimale); ?> (SD = <?php echo round($AggregatedData['C_NO']['STDDEV(RT)'], $PrecisioneDecimale); ?>)</td>
      <td bgcolor="#FFEFEF">M = <?php echo round($AggregatedData['NC_YES']['AVG(RT)'], $PrecisioneDecimale); ?> (SD = <?php echo round($AggregatedData['NC_YES']['STDDEV(RT)'], $PrecisioneDecimale); ?>)</td>
      <td bgcolor="#FFEFEF">M = <?php echo round($AggregatedData['NC_NO']['AVG(RT)'], $PrecisioneDecimale); ?> (SD = <?php echo round($AggregatedData['NC_NO']['STDDEV(RT)'], $PrecisioneDecimale); ?>)</td>

    </tr>
  </tbody>
</table>

<h2>Global Means and Standard Deviations for Coherent and Not Coherent aggregated</h2>

<table border="1" cellspacing="2" cellpadding="2">
  <tbody>
    <tr>
      <td bgcolor="#A2FF80"><strong>Coherent (ms)</strong></td>
      <td bgcolor="#FF9798"><strong>Not Coherent (ms)</strong></td>
    </tr>
    <tr>
      <td bgcolor="#D5FFDA">M = <?php echo round($AggregatedCData['C']['AVG(RT)'], $PrecisioneDecimale); ?> (SD = <?php echo round($AggregatedCData['C']['STDDEV(RT)'], $PrecisioneDecimale); ?>)</td>
      <td bgcolor="#FFEFEF">M = <?php echo round($AggregatedCData['NC']['AVG(RT)'], $PrecisioneDecimale); ?> (SD = <?php echo round($AggregatedCData['NC']['STDDEV(RT)'], $PrecisioneDecimale); ?>)</td>

    </tr>
  </tbody>
</table>

<h2>Means and Standard Deviations per Subjects</h2>

<table border="1" cellspacing="2" cellpadding="2">
  <tbody>
    <tr>
      <td bgcolor="#ebebeb"><strong>Soggetto</strong></td>
      <td bgcolor="#A2FF80"><strong>Coherent * Yes Tool (ms)</strong></td>
      <td bgcolor="#A2FF80"><strong>Coherent * Yes Object (ms)</strong></td>
      <td bgcolor="#A2FF80"><strong>Coherent * No Tool (ms)</strong></td>
      <td bgcolor="#A2FF80"><strong>Coherent * No Object (ms)</strong></td>
      <td bgcolor="#FF9798"><strong>Not Coherent * Yes Tool (ms)</strong></td>
      <td bgcolor="#FF9798"><strong>Not Coherent * Yes Object (ms)</strong></td>
      <td bgcolor="#FF9798"><strong>Not Coherent * No Tool (ms)</strong></td>
      <td bgcolor="#FF9798"><strong>Not Coherent * No Object (ms)</strong></td>
    </tr>
    <?php for ($s = $PartiDalSoggettoNumero; $s <= $NumberOfSubjects; $s++) { ?>
    <tr>
      <td bgcolor="#ebebeb"><?php echo $s; ?></td>
      <td bgcolor="#D5FFDA">M = <?php echo round($Data[$s]['C_YT']['AVG(RT)'], $PrecisioneDecimale); ?> (SD = <?php echo round($Data[$s]['C_YT']['STDDEV(RT)'], $PrecisioneDecimale); ?>)</td>
      <td bgcolor="#D5FFDA">M = <?php echo round($Data[$s]['C_YO']['AVG(RT)'], $PrecisioneDecimale); ?> (SD = <?php echo round($Data[$s]['C_YO']['STDDEV(RT)'], $PrecisioneDecimale); ?>)</td>
      <td bgcolor="#D5FFDA">M = <?php echo round($Data[$s]['C_NT']['AVG(RT)'], $PrecisioneDecimale); ?> (SD = <?php echo round($Data[$s]['C_NT']['STDDEV(RT)'], $PrecisioneDecimale); ?>)</td>
      <td bgcolor="#D5FFDA">M = <?php echo round($Data[$s]['C_NO']['AVG(RT)'], $PrecisioneDecimale); ?> (SD = <?php echo round($Data[$s]['C_NO']['STDDEV(RT)'], $PrecisioneDecimale); ?>)</td>
      <td bgcolor="#FFEFEF">M = <?php echo round($Data[$s]['NC_YT']['AVG(RT)'], $PrecisioneDecimale); ?> (SD = <?php echo round($Data[$s]['NC_YT']['STDDEV(RT)'], $PrecisioneDecimale); ?>)</td>
      <td bgcolor="#FFEFEF">M = <?php echo round($Data[$s]['NC_YO']['AVG(RT)'], $PrecisioneDecimale); ?> (SD = <?php echo round($Data[$s]['NC_YO']['STDDEV(RT)'], $PrecisioneDecimale); ?>)</td>
      <td bgcolor="#FFEFEF">M = <?php echo round($Data[$s]['NC_NT']['AVG(RT)'], $PrecisioneDecimale); ?> (SD = <?php echo round($Data[$s]['NC_NT']['STDDEV(RT)'], $PrecisioneDecimale); ?>)</td>
      <td bgcolor="#FFEFEF">M = <?php echo round($Data[$s]['NC_NO']['AVG(RT)'], $PrecisioneDecimale); ?> (SD = <?php echo round($Data[$s]['NC_NO']['STDDEV(RT)'], $PrecisioneDecimale); ?>)</td>
    </tr>
    <?php } ?>
  </tbody>
</table>

<br><hr>

<h2>Inverse Efficiency Score for All Conditions</h2>

<table border="1" cellspacing="2" cellpadding="2">
  <tbody>
    <tr>
      <td bgcolor="#A2FF80"><strong>Coherent * Yes Tool (ms)</strong></td>
      <td bgcolor="#A2FF80"><strong>Coherent * Yes Object (ms)</strong></td>
      <td bgcolor="#A2FF80"><strong>Coherent * No Tool (ms)</strong></td>
      <td bgcolor="#A2FF80"><strong>Coherent * No Object (ms)</strong></td>
      <td bgcolor="#FF9798"><strong>Not Coherent * Yes Tool (ms)</strong></td>
      <td bgcolor="#FF9798"><strong>Not Coherent * Yes Object (ms)</strong></td>
      <td bgcolor="#FF9798"><strong>Not Coherent * No Tool (ms)</strong></td>
      <td bgcolor="#FF9798"><strong>Not Coherent * No Object (ms)</strong></td>
    </tr>
    <tr>
      <td bgcolor="#D5FFDA"><?php echo round($IES['C_YT'], $PrecisioneDecimale); ; ?></td>
      <td bgcolor="#D5FFDA"><?php echo round($IES['C_YO'], $PrecisioneDecimale); ; ?></td>
      <td bgcolor="#D5FFDA"><?php echo round($IES['C_NT'], $PrecisioneDecimale); ; ?></td>
      <td bgcolor="#D5FFDA"><?php echo round($IES['C_NO'], $PrecisioneDecimale); ; ?></td>
      <td bgcolor="#FFEFEF"><?php echo round($IES['NC_YT'], $PrecisioneDecimale); ; ?></td>
      <td bgcolor="#FFEFEF"><?php echo round($IES['NC_YO'], $PrecisioneDecimale); ; ?></td>
      <td bgcolor="#FFEFEF"><?php echo round($IES['NC_NT'], $PrecisioneDecimale); ; ?></td>
      <td bgcolor="#FFEFEF"><?php echo round($IES['NC_NO'], $PrecisioneDecimale); ; ?></td>
    </tr>
  </tbody>
</table>

<h2>Inverse Efficiency Score for YES and NO aggregrated</h2>

<table border="1" cellspacing="2" cellpadding="2">
  <tbody>
    <tr>
      <td bgcolor="#A2FF80"><strong>Coherent * Yes (ms)</strong></td>
      <td bgcolor="#A2FF80"><strong>Coherent * No (ms)</strong></td>
      <td bgcolor="#FF9798"><strong>Not Coherent * Yes (ms)</strong></td>
      <td bgcolor="#FF9798"><strong>Not Coherent * No (ms)</strong></td>
    </tr>
    <tr>
      <td bgcolor="#D5FFDA"><?php echo round($IES['C_YES'], $PrecisioneDecimale); ; ?></td>
      <td bgcolor="#D5FFDA"><?php echo round($IES['C_NO'], $PrecisioneDecimale); ; ?></td>
      <td bgcolor="#FFEFEF"><?php echo round($IES['NC_YES'], $PrecisioneDecimale); ; ?></td>
      <td bgcolor="#FFEFEF"><?php echo round($IES['NC_NO'], $PrecisioneDecimale); ; ?></td>
    </tr>
  </tbody>
</table>

<h2>Inverse Efficiency Score for Coherent and Not Coherent aggregrated</h2>

<table border="1" cellspacing="2" cellpadding="2">
  <tbody>
    <tr>
      <td bgcolor="#A2FF80"><strong>Coherent (ms)</strong></td>
      <td bgcolor="#FF9798"><strong>Not Coherent (ms)</strong></td>
    </tr>
    <tr>
      <td bgcolor="#D5FFDA"><?php echo round($IES['C'], $PrecisioneDecimale); ?></td>
      <td bgcolor="#FFEFEF"><?php echo round($IES['NC'], $PrecisioneDecimale); ?></td>
    </tr>
  </tbody>
</table>

<h2>Inverse Efficiency Score per Subjects</h2>

<table border="1" cellspacing="2" cellpadding="2">
  <tbody>
    <tr>
      <td bgcolor="#ebebeb"><strong>Soggetto</strong></td>
      <td bgcolor="#A2FF80"><strong>Coherent * Yes Tool (ms)</strong></td>
      <td bgcolor="#A2FF80"><strong>Coherent * Yes Object (ms)</strong></td>
      <td bgcolor="#A2FF80"><strong>Coherent * No Tool (ms)</strong></td>
      <td bgcolor="#A2FF80"><strong>Coherent * No Object (ms)</strong></td>
      <td bgcolor="#FF9798"><strong>Not Coherent * Yes Tool (ms)</strong></td>
      <td bgcolor="#FF9798"><strong>Not Coherent * Yes Object (ms)</strong></td>
      <td bgcolor="#FF9798"><strong>Not Coherent * No Tool (ms)</strong></td>
      <td bgcolor="#FF9798"><strong>Not Coherent * No Object (ms)</strong></td>
    </tr>
    <?php for ($s = $PartiDalSoggettoNumero; $s <= $NumberOfSubjects; $s++) {
		$TotalErrors = 	$Data[$s]['C_YT']['EXTRA']['ERRORS'] +
						$Data[$s]['C_YO']['EXTRA']['ERRORS'] +
						$Data[$s]['C_NT']['EXTRA']['ERRORS'] +
						$Data[$s]['C_NO']['EXTRA']['ERRORS'] +
						$Data[$s]['NC_YT']['EXTRA']['ERRORS'] +
						$Data[$s]['NC_YO']['EXTRA']['ERRORS'] +
						$Data[$s]['NC_NT']['EXTRA']['ERRORS'] +
						$Data[$s]['NC_NO']['EXTRA']['ERRORS'];

		$IES_SUBJ['C_YT'] = 		round($Data[$s]['C_YT']['AVG(RT)'] / ( 1 - ($Data[$s]['C_YT']['EXTRA']['ERRORS']/10) ), $PrecisioneDecimale);
		$IES_SUBJ['C_YO'] = 		round($Data[$s]['C_YO']['AVG(RT)'] / ( 1 - ($Data[$s]['C_YO']['EXTRA']['ERRORS']/10) ), $PrecisioneDecimale);
		$IES_SUBJ['C_NT'] = 		round($Data[$s]['C_NT']['AVG(RT)'] / ( 1 - ($Data[$s]['C_NT']['EXTRA']['ERRORS']/10) ), $PrecisioneDecimale);
		$IES_SUBJ['C_NO'] = 		round($Data[$s]['C_NO']['AVG(RT)'] / ( 1 - ($Data[$s]['C_NO']['EXTRA']['ERRORS']/10) ), $PrecisioneDecimale);
		$IES_SUBJ['NC_YT'] = 	round($Data[$s]['NC_YT']['AVG(RT)'] / ( 1 - ($Data[$s]['NC_YT']['EXTRA']['ERRORS']/10) ), $PrecisioneDecimale);
		$IES_SUBJ['NC_YO'] = 	round($Data[$s]['NC_YO']['AVG(RT)'] / ( 1 - ($Data[$s]['NC_YO']['EXTRA']['ERRORS']/10) ), $PrecisioneDecimale);
		$IES_SUBJ['NC_NT'] = 	round($Data[$s]['NC_NT']['AVG(RT)'] / ( 1 - ($Data[$s]['NC_NT']['EXTRA']['ERRORS']/10) ), $PrecisioneDecimale);
		$IES_SUBJ['NC_NO'] = 	round($Data[$s]['NC_NO']['AVG(RT)'] / ( 1 - ($Data[$s]['NC_NO']['EXTRA']['ERRORS']/10) ), $PrecisioneDecimale);

	?>
    <tr>
      <td bgcolor="#ebebeb"><?php echo $s; ?></td>
      <td bgcolor="#D5FFDA"><?php echo $IES_SUBJ['C_YT']; ?></td>
      <td bgcolor="#D5FFDA"><?php echo $IES_SUBJ['C_YO']; ?></td>
      <td bgcolor="#D5FFDA"><?php echo $IES_SUBJ['C_NT']; ?></td>
      <td bgcolor="#D5FFDA"><?php echo $IES_SUBJ['C_NO']; ?></td>
      <td bgcolor="#FFEFEF"><?php echo $IES_SUBJ['NC_YT']; ?></td>
      <td bgcolor="#FFEFEF"><?php echo $IES_SUBJ['NC_YO']; ?></td>
      <td bgcolor="#FFEFEF"><?php echo $IES_SUBJ['NC_NT']; ?></td>
      <td bgcolor="#FFEFEF"><?php echo $IES_SUBJ['NC_NO']; ?></td>
    </tr>
    <?php } ?>
  </tbody>
</table>

<br><hr>

<h2>Global errors for All Conditions</h2>

<table border="1" cellspacing="2" cellpadding="2">
  <tbody>
    <tr>
      <td bgcolor="#A2FF80"><strong>Coherent * Yes Tool</strong></td>
      <td bgcolor="#A2FF80"><strong>Coherent * Yes Object</strong></td>
      <td bgcolor="#A2FF80"><strong>Coherent * No Tool</strong></td>
      <td bgcolor="#A2FF80"><strong>Coherent * No Object</strong></td>
      <td bgcolor="#FF9798"><strong>Not Coherent * Yes Tool</strong></td>
      <td bgcolor="#FF9798"><strong>Not Coherent * Yes Object</strong></td>
      <td bgcolor="#FF9798"><strong>Not Coherent * No Tool</strong></td>
      <td bgcolor="#FF9798"><strong>Not Coherent * No Object</strong></td>
    </tr>
    <tr>
      <td bgcolor="#D5FFDA"><?php echo $GlobalData['C_YT']['EXTRA']['ERRORS']; ?></td>
      <td bgcolor="#D5FFDA"><?php echo $GlobalData['C_YO']['EXTRA']['ERRORS']; ?></td>
      <td bgcolor="#D5FFDA"><?php echo $GlobalData['C_NT']['EXTRA']['ERRORS']; ?></td>
      <td bgcolor="#D5FFDA"><?php echo $GlobalData['C_NO']['EXTRA']['ERRORS']; ?></td>
      <td bgcolor="#FFEFEF"><?php echo $GlobalData['NC_YT']['EXTRA']['ERRORS']; ?></td>
      <td bgcolor="#FFEFEF"><?php echo $GlobalData['NC_YO']['EXTRA']['ERRORS']; ?></td>
      <td bgcolor="#FFEFEF"><?php echo $GlobalData['NC_NT']['EXTRA']['ERRORS']; ?></td>
      <td bgcolor="#FFEFEF"><?php echo $GlobalData['NC_NO']['EXTRA']['ERRORS']; ?></td>
    </tr>
  </tbody>
</table>

<h2>Global errors for YES and NO aggregated</h2>

<table border="1" cellspacing="2" cellpadding="2">
  <tbody>
    <tr>
      <td bgcolor="#A2FF80"><strong>Coherent * Yes</strong></td>
      <td bgcolor="#A2FF80"><strong>Coherent * No</strong></td>
      <td bgcolor="#FF9798"><strong>Not Coherent * Yes</strong></td>
      <td bgcolor="#FF9798"><strong>Not Coherent * No</strong></td>
    </tr>
    <tr>
      <td bgcolor="#D5FFDA"><?php echo $GlobalData['C_YT']['EXTRA']['ERRORS'] + $GlobalData['C_YO']['EXTRA']['ERRORS']; ?></td>
      <td bgcolor="#D5FFDA"><?php echo $GlobalData['C_NT']['EXTRA']['ERRORS'] + $GlobalData['C_NO']['EXTRA']['ERRORS']; ?></td>
      <td bgcolor="#FFEFEF"><?php echo $GlobalData['NC_YT']['EXTRA']['ERRORS'] + $GlobalData['NC_YO']['EXTRA']['ERRORS']; ?></td>
      <td bgcolor="#FFEFEF"><?php echo $GlobalData['NC_NT']['EXTRA']['ERRORS'] + $GlobalData['NC_NO']['EXTRA']['ERRORS']; ?></td>
    </tr>
  </tbody>
</table>

<h2>Global errors for Coherent and Not Coherent aggregated</h2>

<table border="1" cellspacing="2" cellpadding="2">
  <tbody>
    <tr>
      <td bgcolor="#A2FF80"><strong>Coherent</strong></td>
      <td bgcolor="#FF9798"><strong>Not Coherent</strong></td>
    </tr>
    <tr>
      <td bgcolor="#D5FFDA"><?php echo $GlobalData['C_YT']['EXTRA']['ERRORS'] + $GlobalData['C_YO']['EXTRA']['ERRORS'] + $GlobalData['C_NT']['EXTRA']['ERRORS'] + $GlobalData['C_NO']['EXTRA']['ERRORS']; ?></td>
      <td bgcolor="#FFEFEF"><?php echo $GlobalData['NC_YT']['EXTRA']['ERRORS'] + $GlobalData['NC_YO']['EXTRA']['ERRORS'] + $GlobalData['NC_NT']['EXTRA']['ERRORS'] + $GlobalData['NC_NO']['EXTRA']['ERRORS']; ?></td>
    </tr>
  </tbody>
</table>

<h2>Subjects Errors for All Conditions</h2>

<table border="1" cellspacing="2" cellpadding="2">
  <tbody>
    <tr>
      <td bgcolor="#ebebeb"><strong>Soggetto</strong></td>
      <td bgcolor="#A2FF80"><strong>Coherent * Yes Tool</strong></td>
      <td bgcolor="#A2FF80"><strong>Coherent * Yes Object</strong></td>
      <td bgcolor="#A2FF80"><strong>Coherent * No Tool</strong></td>
      <td bgcolor="#A2FF80"><strong>Coherent * No Object</strong></td>
      <td bgcolor="#FF9798"><strong>Not Coherent * Yes Tool</strong></td>
      <td bgcolor="#FF9798"><strong>Not Coherent * Yes Object</strong></td>
      <td bgcolor="#FF9798"><strong>Not Coherent * No Tool</strong></td>
      <td bgcolor="#FF9798"><strong>Not Coherent * No Object</strong></td>
      <td bgcolor="#FF0002"><strong style="color: #FFFFFF">Total Errors</strong></td>
    </tr>
    <?php for ($s = $PartiDalSoggettoNumero; $s <= $NumberOfSubjects; $s++) {
		$TotalErrors = 	$Data[$s]['C_YT']['EXTRA']['ERRORS'] +
						$Data[$s]['C_YO']['EXTRA']['ERRORS'] +
						$Data[$s]['C_NT']['EXTRA']['ERRORS'] +
						$Data[$s]['C_NO']['EXTRA']['ERRORS'] +
						$Data[$s]['NC_YT']['EXTRA']['ERRORS'] +
						$Data[$s]['NC_YO']['EXTRA']['ERRORS'] +
						$Data[$s]['NC_NT']['EXTRA']['ERRORS'] +
						$Data[$s]['NC_NO']['EXTRA']['ERRORS'];
	?>
    <tr>
      <td bgcolor="#ebebeb"><?php echo $s; ?></td>
      <td bgcolor="#D5FFDA"><?php echo $Data[$s]['C_YT']['EXTRA']['ERRORS']; ?>/10 (<?php echo $Data[$s]['C_YT']['EXTRA']['ERRORS']/10; ?>)</td>
      <td bgcolor="#D5FFDA"><?php echo $Data[$s]['C_YO']['EXTRA']['ERRORS']; ?>/10 (<?php echo $Data[$s]['C_YO']['EXTRA']['ERRORS']/10; ?>)</td>
      <td bgcolor="#D5FFDA"><?php echo $Data[$s]['C_NT']['EXTRA']['ERRORS']; ?>/10 (<?php echo $Data[$s]['C_NT']['EXTRA']['ERRORS']/10; ?>)</td>
      <td bgcolor="#D5FFDA"><?php echo $Data[$s]['C_NO']['EXTRA']['ERRORS']; ?>/10 (<?php echo $Data[$s]['C_NO']['EXTRA']['ERRORS']/10; ?>)</td>
      <td bgcolor="#FFEFEF"><?php echo $Data[$s]['NC_YT']['EXTRA']['ERRORS']; ?>/10 (<?php echo $Data[$s]['NC_YT']['EXTRA']['ERRORS']/10; ?>)</td>
      <td bgcolor="#FFEFEF"><?php echo $Data[$s]['NC_YO']['EXTRA']['ERRORS']; ?>/10 (<?php echo $Data[$s]['NC_YO']['EXTRA']['ERRORS']/10; ?>)</td>
      <td bgcolor="#FFEFEF"><?php echo $Data[$s]['NC_NT']['EXTRA']['ERRORS']; ?>/10 (<?php echo $Data[$s]['NC_NT']['EXTRA']['ERRORS']/10; ?>)</td>
      <td bgcolor="#FFEFEF"><?php echo $Data[$s]['NC_NO']['EXTRA']['ERRORS']; ?>/10 (<?php echo $Data[$s]['NC_NO']['EXTRA']['ERRORS']/10; ?>)</td>
      <td bgcolor="#FFEFEF" style="color: #FF0004"><strong><?php echo $TotalErrors; ?>/80 (<?php echo $TotalErrors/80; ?>)</strong></td>
    </tr>
    <?php } ?>
  </tbody>
</table>

<h2>Subjects Errors for YES and NO aggregated</h2>

<table border="1" cellspacing="2" cellpadding="2">
  <tbody>
    <tr>
      <td bgcolor="#ebebeb"><strong>Soggetto</strong></td>
      <td bgcolor="#A2FF80"><strong>Coherent * Yes</strong></td>
      <td bgcolor="#A2FF80"><strong>Coherent * No</strong></td>
      <td bgcolor="#FF9798"><strong>Not Coherent * Yes</strong></td>
      <td bgcolor="#FF9798"><strong>Not Coherent * No</strong></td>
      <td bgcolor="#FF0002"><strong style="color: #FFFFFF">Total Errors</strong></td>
    </tr>
    <?php for ($s = $PartiDalSoggettoNumero; $s <= $NumberOfSubjects; $s++) {
		$TotalErrors = 	$Data[$s]['C_YT']['EXTRA']['ERRORS'] +
						$Data[$s]['C_YO']['EXTRA']['ERRORS'] +
						$Data[$s]['C_NT']['EXTRA']['ERRORS'] +
						$Data[$s]['C_NO']['EXTRA']['ERRORS'] +
						$Data[$s]['NC_YT']['EXTRA']['ERRORS'] +
						$Data[$s]['NC_YO']['EXTRA']['ERRORS'] +
						$Data[$s]['NC_NT']['EXTRA']['ERRORS'] +
						$Data[$s]['NC_NO']['EXTRA']['ERRORS'];
	?>
    <tr>
      <td bgcolor="#ebebeb"><?php echo $s; ?></td>
      <td bgcolor="#D5FFDA"><?php echo $Data[$s]['C_YT']['EXTRA']['ERRORS'] + $Data[$s]['C_YO']['EXTRA']['ERRORS']; ?></td>
      <td bgcolor="#D5FFDA"><?php echo $Data[$s]['C_NT']['EXTRA']['ERRORS'] + $Data[$s]['C_NO']['EXTRA']['ERRORS']; ?></td>
      <td bgcolor="#FFEFEF"><?php echo $Data[$s]['NC_YT']['EXTRA']['ERRORS'] + $Data[$s]['NC_YO']['EXTRA']['ERRORS']; ?></td>
      <td bgcolor="#FFEFEF"><?php echo $Data[$s]['NC_NT']['EXTRA']['ERRORS'] + $Data[$s]['NC_NO']['EXTRA']['ERRORS']; ?></td>
      <td bgcolor="#FFEFEF" style="color: #FF0004"><strong><?php echo $TotalErrors; ?></strong></td>
    </tr>
    <?php } ?>
  </tbody>
</table>
