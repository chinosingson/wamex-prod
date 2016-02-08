<?php

// uncomment these to test wamex_math
//	define('DRUPAL_ROOT', 'c:\xampp\htdocs\wamex');
//	require_once DRUPAL_ROOT . '/includes/bootstrap.inc';
//	drupal_bootstrap(DRUPAL_BOOTSTRAP_FULL);


// Input #1:
// Weighted average of all loadings

global $debug;
$debug = variable_get('wamex_tech_debug');


// for testing. set $debug = TRUE to see results
/*if ($debug){
	//Loadings: 150.0|750.0|350.0|60.0|15.0|400.0
	$arrayAverageLoad = array(
		'ADWF' => 150.0,
		'COD' => 750.0,
		'BOD5' => 350.0,
		'N' => 60.0,
		'P' => 15.0, 
		'TSS' => 400.0
		);

	//Standards: 250.00|100.00|null|null|140.00
	$arrayStandards = array(
		'name' => "Indian",
		'COD' => 250,
		'BOD5' => 100,
		'N' => -1,
		'P' => -1,
		'TSS' => 140,
		); 


	$flt_popeq = 562500.00;

	// Get the list of tech options for the specified loading
	$arrayTech = wamex_select_tech($arrayAverageLoad,$arrayStandards,$flt_popeq);
	echo "Loading: ";
	print_r ($arrayAverageLoad);
	echo "<br />";
	echo "Standards: ";
	print_r ($arrayStandards);
	echo "<br />";
	echo "Popeq: ".$flt_popeq; 
	echo "<br />";
	echo "Applicable Tech:".count($arrayTech)."<br/>" ;
	echo "<pre>".print_r($arrayTech,1)."</pre>";
	
}*/


// END


function wamex_get_all_tech($popeqV){ // scenario on/off

	global $debug;
	// sql select
  $select = db_select('wamex_technology', 'wt'); //->extend('Tablesort');
	// sql select fields
	$fields = array('tid', 'name','cod', 'max_bod', 'max_n_p', 'max_n_a', 'max_p_p', 'max_p_a', 'max_tss_p', 'max_tss_a');

	if ($popeqV < 1) $popeqV = 1; // (?)
		
	if ($debug) echo "<b>Selecting technologies based on Population Equivalent ".number_format($popeqV,2).".</b><br/>";
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
	if ($debug) echo "<pre>";
	for ($x = 0; $x < $numThresholds; $x++){
		//$capex_field = 'capex_'.$capex_thresholds[$x]['alias'];
		if ($popeqV >= $capex_thresholds[$x]['value']){
			//echo $popeqV." > [".$x."]".$capex_thresholds[$x]['value']."<br/>";
			if ($popeqV >= 1200000){
				$threshold = $capex_thresholds[$x]['value'];
				if ($debug) echo "<tt>Minimum Threshold: ".$popeqV." < [".($x)."]".number_format($threshold)."</tt><br/>";
			} /*else {
				$threshold = $capex_thresholds[$x-1]['value'];
				echo "-".$popeqV." < [".($x)."]".$threshold."<br/>";
				// do nothing;
			}*/
			//break;
		} else {
			$threshold = $capex_thresholds[$x-1]['value'];
			if ($debug) print "<tt>Minimum Threshold: ".number_format($threshold)."</tt><br/>";
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
			'pP'=>$val->max_p_p,
			'aP'=>$val->max_p_a, 
			'pTSS'=>$val->max_tss_p, 
			'aTSS'=>$val->max_tss_a, 
		);
	}
	
	if($debug){
		//print '<pre>'.print_r($rows,1).'</pre>';
		//print '<pre>'.print_r($arrayTechnology,1).'</pre>';
		print "<tt>CapEx is non-zero for ".count($arrayTechnology)." technologies.</tt><br/>";
		
		// display list of technology names here
		// ...
		$t = 1;
		foreach ($arrayTechnology as $tech){
			echo "<tt>$t [".$tech['id']."] ".$tech['name']."</tt><br/>";
			$t++;
		}
		echo "<br/>";
		echo "</pre>";

	}
	return $arrayTechnology;

}



function wamex_select_tech($loading,$target,$popeq){

	global $debug;
	//$debug = FALSE;
	$arrayPossibleTech = array();
	// Load technology table as array from DB
	$arrayAllTech = wamex_get_all_tech($popeq);
	
	if($debug) echo "<b>Selecting technologies based on average loading and standards.</b><br/>";
	if($debug) echo "<pre>";

	$ctr = 0;
	foreach ($arrayAllTech as $tech) {

	
		// Let's assume this tech does not pass the standard
		$flag = FALSE;
		if ($debug) {
			echo "<tt><b><u>" . $tech["name"] . "</u></b> [".$tech["id"] ."]</tt><br/>";
			echo "<tt><b>Param | Efficiency | Loading | Standard | Residue | Status | Action</b></tt><br/>";
		}
		
		//if ($debug) echo "tech: ".print_r($tech,1) . "<br/><br/>";

		// Test for COD
		if ($debug) echo "<tt>COD&nbsp;&nbsp;&nbsp;|&nbsp;</tt>";
		$test_cod = wamex_test($loading["COD"],$tech["pCOD"],$target["COD"],$tech["aCOD"]);
		if ($test_cod!="FAIL"){
			if ($debug) echo str_replace("_","&nbsp","<tt> ".str_pad($test_cod,6,"_",STR_PAD_BOTH)." | ".str_pad(($test_cod=="PASS"?"Next":"Skip"),6,"_",STR_PAD_BOTH)."</tt><br/>");
			
			if ($debug) echo "<tt>BOD5&nbsp;&nbsp;|&nbsp;</tt>";
			// If good, test for BOD5
			$test_bod5 = wamex_test($loading["BOD5"],$tech["pBOD5"],$target["BOD5"],$tech["pBOD5"]);
			if ($test_bod5!="FAIL"){
				if ($debug) echo str_replace("_","&nbsp","<tt> ".str_pad($test_bod5,6,"_",STR_PAD_BOTH)." | ".str_pad(($test_bod5=="PASS"?"Next":"Skip"),6,"_",STR_PAD_BOTH)."</tt><br/>");

				if ($debug) echo "<tt>N&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;|&nbsp;</tt>";	
				// If good, test for N
				$test_n = wamex_test($loading["N"],$tech["pN"],$target["N"],$tech["aN"]);
				if ($test_n!="FAIL"){
						if ($debug) echo str_replace("_","&nbsp","<tt> ".str_pad($test_n,6,"_",STR_PAD_BOTH)." | ".str_pad(($test_n=="PASS"?"Next":"Skip"),6,"_",STR_PAD_BOTH)."</tt><br/>");
					
					if ($debug) echo "<tt>P&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;|&nbsp;</tt>";
					// If good, test for P
					$test_p = wamex_test($loading["P"],$tech["pP"],$target["P"],$tech["aP"]);
					if ($test_p!="FAIL"){
						if ($debug) echo str_replace("_","&nbsp","<tt> ".str_pad($test_p,6,"_",STR_PAD_BOTH)." | ".str_pad(($test_p=="PASS"?"Next":"Skip"),6,"_",STR_PAD_BOTH)."</tt><br/>");
						
						if ($debug) echo "<tt>TSS&nbsp;&nbsp;&nbsp;|&nbsp;</tt>";
						// If good, test for TSS
						$test_tss = wamex_test($loading["TSS"],$tech["pTSS"],$target["TSS"],$tech["aTSS"]);
						if ($test_tss!="FAIL"){
							if ($debug) echo str_replace("_","&nbsp","<tt> ".str_pad($test_tss,6,"_",STR_PAD_BOTH)." | ".str_pad(($test_tss=="PASS"?"Next":"Skip"),6,"_",STR_PAD_BOTH)."</tt><br/>");
							// Okay, this tech passes all tests	
							if ($debug) echo "<tt><b>FINAL | PASS</b></tt><br/><br/>";
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
		if ($debug) echo "<b>".count($arrayPossibleTech)." technologies pass tests.</b><br/>";
		if ($debug) echo "</pre>";
		return $arrayPossibleTech;
	//} else {
		//return $arrayPossibleTech[] = 'No technologies suitable for selected standard and sources.';
	//}
}


function wamex_test($source,$coefficient,$output,$limit=0){
	
	global $debug;
	//$debug = FALSE;
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
			//echo "param: SRC:$source, COEFF:$coefficient, OUTPUT:$output, RESIDUE:$residue, LIMIT:$limit <br/>";
			//echo "<tt>Efficiency: $coefficient | Loading: $source | Standard: $output | Residue: $residue | </tt>";
			$debug_str = "<tt>".str_pad($coefficient,10,"_",STR_PAD_LEFT)." | ".str_pad($source,7,"_",STR_PAD_LEFT)." | ".str_pad($output,8,"_",STR_PAD_LEFT)." | ".str_pad($residue,7,"_",STR_PAD_LEFT)." |</tt>";
			$debug_str = str_replace("_","&nbsp;",$debug_str);
			echo $debug_str;
		}

		// If calculate residue is less than max limit, set residue to the tech limit
		if ($residue < $limit) $residue = $limit;

		/*if ($debug){ 
				echo "[influent: $source / effluent: $residue / target: $output] ";
			}*/

		//if residue is less than the effluent target, it passes the test
		if ($residue <= $output){ // || $output == "null"){
			return "PASS";
		}else{

			if ($debug) {
				//echo "<tt>Status: FAIL | Action: Quit</tt><br/><br/>";
				$debug_str = "<tt> ".str_pad("FAIL",6,"_",STR_PAD_BOTH)." | ".str_pad("Quit",6,"_",STR_PAD_BOTH)."</tt><br/><br/>";
				$debug_str = str_replace("_","&nbsp;",$debug_str);
				echo $debug_str;
			}
			return "FAIL";
		} 

	}else{

		if ($debug) {
			//echo "<tt>Efficiency: $coefficient | Loading: $source | Standard: N/A | Residue: N/A | </tt>";
			$debug_str =  "<tt>".str_pad($coefficient,10,"_",STR_PAD_LEFT)." | ".str_pad($source,7,"_",STR_PAD_LEFT)." | ".str_pad($output,8,"_",STR_PAD_LEFT)." | ".str_pad("N/A",7,"_",STR_PAD_LEFT)." |</tt>";
			$debug_str = str_replace("_","&nbsp;",$debug_str);
			echo $debug_str;
			//echo "<tt>N/A | Action: Skip | </tt>";
		}
		return "N/A";

	}
}

