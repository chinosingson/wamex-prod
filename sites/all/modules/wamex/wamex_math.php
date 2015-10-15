<?php

	//define('DRUPAL_ROOT', 'c:\xampp\htdocs\wamex');


	//require_once DRUPAL_ROOT . '/includes/bootstrap.inc';
	//drupal_bootstrap(DRUPAL_BOOTSTRAP_FULL);


// Input #1:
// Weighted average of all loadings

global $debug;
$debug = FALSE;

/*$arrayAverageLoad = array(
	'ADWF' => 150,
	'COD' => 50,
	'BOD5' => 40 ,
	'N' => 10,
	'P' => 2, 
	'TSS' => 140
	);

$arrayStandards = array(
	'name' => "Malaysia",
	'COD' => 102,
	'BOD5' => 50,
	'N' => -1,
	'P' => -1,
	'TSS' => 100,
	); */

if ($debug){
	echo "Loading: ";
	print_r ($arrayAverageLoad);
	echo "<br />";
	echo "Standards: ";
	print_r ($arrayStandards);
	echo "<br />";
	echo "<br />";
}


// Get the list of tech options for the specified loading
//$arrayTech = wamex_select_tech($arrayAverageLoad,$arrayStandards);

if ($debug){ 
	echo "Applicable Tech:<br/>" ;
	//print_r($arrayTech);
}

// END


function wamex_get_all_tech(){

	/*$arrayTechnology[0] = array(
		'id' => 1,
		'name' => "Slow Rate Treatment",
		'pCOD' => 0.95,
		'aCOD' => 1,
		'pBOD5' => 0.97,
		'aBOD5' => 1,
		'pN' => 0.85,
		'aN' => 1,
		'pP' => 0.90,
		'aP' => 1, 
		'pTSS' => 0.95,
		'aTSS' => 1 
		);
	$arrayTechnology[1] = array(
		'id' => 2,
		'name' => "Rapid Infiltration",
		'pCOD' => 0.95,
		'aCOD' => 1,
		'pBOD5' => 0.97,
		'aBOD5' => 1,
		'pN' => 0.85,
		'aN' => 1,
		'pP' => 0.90,
		'aP' => 1, 
		'pTSS' => 0.95,
		'aTSS' => 1 
		);
	$arrayTechnology[2] = array(
		'id' => 3,
		'name' => "Perfect Tank",
		'pCOD' => 0.59,
		'aCOD' => NULL,
		'pBOD5' => 0.97,
		'aBOD5' => 1,
		'pN' => 0.85,
		'aN' => 1,
		'pP' => 0.90,
		'aP' => 1, 
		'pTSS' => 0.95,
		'aTSS' => 1 
		);*/

  $select = db_select('wamex_technology', 'wt'); //->extend('Tablesort');
  $results = $select->fields('wt', array('tid', 'name','cod', 'max_bod', 'max_n_p', 'max_n_a', 'max_p_a', 'max_tss_p', 'max_tss_a'))
							//->orderByHeader($header)
						 ->execute();
						 
  $rows = array();
	$arrayTechnology = array();
   //$destination = drupal_get_destination();
  foreach ($results as $val) {
		$arrayTechnology[] = array(
			'id'=>$val->tid,
			'name'=>$val->name,
			'pCOD'=>$val->cod, 
			'aCOD'=>NULL,
			'pBOD5'=>$val->max_bod, 
			'aBOD5'=>NULL,
			'pN'=>$val->max_n_p, 
			'aN'=>$val->max_n_a, 
			'pP'=>NULL,
			'aP'=>$val->max_p_a, 
			'pTSS'=>$val->max_tss_p, 
			'aTSS'=>$val->max_tss_a, 
		);
	}
						 
	//print '<pre>'.print_r($rows,1).'</pre>';
	//print '<pre>'.print_r($arrayTechnology,1).'</pre>';
	return $arrayTechnology;

}



function wamex_select_tech($loading,$target){

	//global $debug;
	$debug = FALSE;
	$arrayPossibleTech = array();
	// Load technology table as array from DB
	$arrayAllTech = wamex_get_all_tech();

	$ctr = 0;
	foreach ($arrayAllTech as $tech) {

		// Let's assume this tech does not pass the standard
		$flag = FALSE;
		if ($debug) echo "Processing: [".$tech["id"] ."] " . $tech["name"] . "<br/><br/>"; 

		// Test for COD
		if ($debug) echo "Testing for COD... ";
		if (wamex_test($loading["COD"],$tech["pCOD"],$target["COD"],$tech["aCOD"])){
			if ($debug) echo "passed COD test <br/>";
			
			if ($debug) echo "Testing for BOD5... ";
			// If good, test for BOD5
			if (wamex_test($loading["BOD5"],$tech["pBOD5"],$target["BOD5"],$tech["pBOD5"])){
				if ($debug) echo "passed BOD5 test <br/>";
				
				if ($debug) echo "Testing for N... ";	
				// If good, test for N
				if (wamex_test($loading["N"],$tech["pN"],$target["N"],$tech["aN"])){
					if ($debug) echo "passed N test <br/>";
					
					if ($debug) echo "Testing for P... ";
					// If good, test for P
					if (wamex_test($loading["P"],$tech["pP"],$target["P"],$tech["aP"])){
						if ($debug) echo "passed P test <br/>";
						
						if ($debug) echo "Testing for TSS... ";
						// If good, test for TSS
						if (wamex_test($loading["TSS"],$tech["pTSS"],$target["TSS"],$tech["aTSS"])){
							if ($debug) echo "passed TSS test <br/>";
							// Okay, this tech passes all tests	
							if ($debug) echo $tech["name"] . " has passed ALL TESTS! <br/><br/>";
							$flag = TRUE;

						}	
					}	
				}	
			}
			

		}

		// Add to list of techs if this tech passes the test
		if ($flag == TRUE) {
			$arrayPossibleTech[] = $tech["id"];
		}
	}
	
	//if (count($arrayPossibleTech) > 0){
		return $arrayPossibleTech;
	//} else {
		//return $arrayPossibleTech[] = 'No technologies suitable for selected standard and sources.';
	//}
}


function wamex_test($source,$coefficient,$output,$limit=0){
	
	//global $debug;
	$debug = FALSE;
	if (is_null($coefficient)) {
		$coefficient = -1;
	}
	
	if($output >= 0){

		// Calculate effluent residue after applying tech
		if ($coefficient >= 0){
			$residue = $source - ($source*$coefficient);
		} else {
			$residue = -1;
		}

		if($debug) {
			echo "param: SRC:$source, COEFF:$coefficient, OUTPUT:$output, LIMIT:$limit <br/>";
		}

		// If calculate residue is less than max limit, set residue to the tech limit
		if ($residue < $limit) $residue = $limit;

		if ($debug){ 
				echo "[influent: $source / effluent: $residue / target: $output] ";
			}

		//if residue is less than the effluent target, it passes the test
		if ($residue <= $output){
			return TRUE;
		}else{

			if ($debug) echo "Failed test...<br><br>";
			return FALSE;
		} 

	}else{

		if ($debug) echo "Test skipped. Not applicable... ";
		return TRUE;

	}
}

