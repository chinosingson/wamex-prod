<?php
// Input #1:
// Weighted average of all loadings

$arrayAverageLoad = array(
	'ADWF' => 150,
	'COD' => 750,
	'BOD5' => 350 ,
	'N' => 60,
	'P' => 15, 
	'TSS' => 200
	);

$arrayStandards = array(
	'name' => "Malaysia",
	'COD' => 102,
	'BOD5' => 50,
	'N' => -1,
	'P' => -1,
	'TSS' => 100,
	); 


echo $arrayAverageLoad["BOD5"];

$arrayTech = wamex_select_tech($arrayAverageLoad,$arrayStandards);


function wamex_select_tech($loading,$target){

	// Load technology table as array
	$arrayTechnology[0] = array(
		'id' => 1,
		'name' => "Slow Rate Treatment",
		'COD' => 0.95,
		'BOD5' => 0.97 ,
		'N' => 0.85,
		'P' => 0.90, 
		'TSS' => 0.95 
		);
	$arrayTechnology[1] = array(
		'id' => 2,
		'name' => "Rapid Infiltration",
		'COD' => 0.90,
		'BOD5' => 0.95 ,
		'N' => 0.70,
		'P' => 0.60, 
		'TSS' => 0.95 
		);
		
	$arrayTechnology[2] = array(
		'id'=>3,
		'COD' => x,
		//'BOD5_max' => value,
		
	);


	foreach ($arrayTechnology as $tech) {

		if (wamex_test($loading["COD"],$tech["COD"],$target["COD"]) &&
		{
			$arrayPossibleTech[] = $tech["id"];
		}

		
		echo "<br />";

	}


 return $arrayPossibleTech;
}


function wamex_test($source,$coefficient,$output,$limit){

	$residue = $source*$coefficient;
	if ($residue <= $limit) $residue = $limit;
	if ($residue <= $output) return TRUE;

}
