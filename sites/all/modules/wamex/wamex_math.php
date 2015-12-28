<?php

	//define('DRUPAL_ROOT', 'c:\xampp\htdocs\wamex');


	//require_once DRUPAL_ROOT . '/includes/bootstrap.inc';
	//drupal_bootstrap(DRUPAL_BOOTSTRAP_FULL);


// Input #1:
// Weighted average of all loadings

global $debug;
$debug = FALSE;

$arrayAverageLoad = array(
	'ADWF' => 62.5,
	'COD' => 55,
	'BOD5' => 65 ,
	'N' => 29,
	'P' => 46.5, 
	'TSS' => 65
	);
	//62.5|55.0|65.0|29.0|46.5|65.0

$arrayStandards = array(
	'name' => "Malaysia",
	'COD' => 102,
	'BOD5' => 50,
	'N' => -1,
	'P' => -1,
	'TSS' => 100,
	); 
	// 102.00|50.00|null|null|100.00


$flt_popeq = 2.3875;


if ($debug){
	echo "Loading: ";
	print_r ($arrayAverageLoad);
	echo "<br />";
	echo "Standards: ";
	print_r ($arrayStandards);
	echo "<br />";
	echo "Popeq: ".$flt_popeq; 
	echo "<br />";
}

// Get the list of tech options for the specified loading
//$arrayTech = wamex_select_tech($arrayAverageLoad,$arrayStandards,$flt_popeq);

//if ($debug){ 
//	echo "Applicable Tech:<br/>" ;
//	print_r($arrayTech);
//}

// END


function wamex_get_all_tech($popeqV){

	// sql select
  $select = db_select('wamex_technology', 'wt'); //->extend('Tablesort');
	// sql select fields
	$fields = array('tid', 'name','cod', 'max_bod', 'max_n_p', 'max_n_a', 'max_p_a', 'max_tss_p', 'max_tss_a');

	if ($popeqV < 1) $popeqV = 1; // (?)
	$capex_thresholds = array(
		array('value'=>1,'alias'=> '1'),
		array('value'=>10,'alias' => '10'),
		array('value'=>200,'alias' => '200'),
		array('value'=>2000,'alias' => '2k'),
		//array('value'=>2000,'alias' => '2kb'),
		array('value'=>20000,'alias' => '20k'),
		//array('value'=>20000,'alias' => '20kb'),
		array('value'=>200000,'alias' => '200k'),
		//array('value'=>200000,'alias' => '200kb'),
		array('value'=>600000,'alias' => '600k'),
		//array('value'=>600000,'alias' => '600kb'),
		array('value'=>1200000,'alias' => '1200k'),
		//array('value'=>1200000,'alias' => '1200kb'),
	);
	
	// get techs with applicable capex
	$capex_field = array();
	$numThresholds = count($capex_thresholds);
	//foreach ($capex_thresholds as $cet){
	for ($x = 0; $x < $numThresholds; $x++){
		//$capex_field = 'capex_'.$capex_thresholds[$x]['alias'];
		if ($popeqV >= $capex_thresholds[$x]['value']){
			//echo $popeqV." > [".$x."]".$capex_thresholds[$x]['value']."<br/>";
			if ($popeqV >= 1200000){
				$threshold = $capex_thresholds[$x]['value'];
				//echo "-".$popeqV." < [".($x)."]".$threshold."<br/>";
			} /*else {
				$threshold = $capex_thresholds[$x-1]['value'];
				echo "-".$popeqV." < [".($x)."]".$threshold."<br/>";
				// do nothing;
			}*/
			//break;
		} else {
			$threshold = $capex_thresholds[$x-1]['value'];
			//echo "--".$popeqV." < [".($x-1)."]".$threshold."<br/>";
			break;
		}
	}
	//echo "X:".$x."<br/>";
	//echo "Th:".$threshold."<br/>";
	if ($threshold >= 2000){
		$capex_field['a'] = 'capex_'.$capex_thresholds[$x-1]['alias'].'a';
		$capex_field['b'] = 'capex_'.$capex_thresholds[$x-1]['alias'].'b';
		$fields[] = $capex_field['a'];
		$fields[] = $capex_field['b'];
		$capex_condition = db_or()->isNotNull($capex_field['a'])->isNotNull($capex_field['b']);
	} else {
		$capex_field['a'] = 'capex_'.$capex_thresholds[$x-1]['alias'];
		$fields[] = $capex_field['a'];
		$capex_condition = db_or()->isNotNull($capex_field['a']);
		//$capex_field['b'] = NULL;
	}
	
	//$fields[] = $capex_field['a'];
	//if ($capex_field['b']) $fields[] = $capex_field['b'];
	//echo print_r($fields,1)."<br/>";
  $query = $select->fields('wt', $fields)
						->condition($capex_condition);
							//->orderByHeader($header)
							//->condition($capex_field, '0', '<>')
							//->isNotNull($capex_field);
	

	//echo $query->__toString();
	//echo "<br/>";
	$results = $query->execute();
						 
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



function wamex_select_tech($loading,$target,$popeq){

	//global $debug;
	$debug = FALSE;
	$arrayPossibleTech = array();
	// Load technology table as array from DB
	$arrayAllTech = wamex_get_all_tech($popeq);

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

