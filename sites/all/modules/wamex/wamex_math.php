<?php

// uncomment these to test wamex_math
//	define('DRUPAL_ROOT', 'c:\xampp\htdocs\wamex');
//	require_once DRUPAL_ROOT . '/includes/bootstrap.inc';
//	drupal_bootstrap(DRUPAL_BOOTSTRAP_FULL);


// Input #1:
// Weighted average of all loadings

global $debug;
global $user;
if($user->uid!=0){
	$user_fields = user_load($user->uid);
	$debug = (isset($user_fields->field_user_tech_debug[LANGUAGE_NONE]) ? $user_fields->field_user_tech_debug[LANGUAGE_NONE][0]['value'] : FALSE);
} else {
	$user_fields = null;
	$debug = FALSE;
}
//$debug = variable_get('wamex_tech_debug');
//$debug = (isset($user_fields->field_user_tech_debug[LANGUAGE_NONE]) ? $user_fields->field_user_tech_debug[LANGUAGE_NONE][0]['value'] : FALSE);
//$user_debug = var

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


function wamex_get_all_tech($popeqV,$scenarioV){ // scenario on/off

	global $debug;
	// sql select
  $select = db_select('wamex_technology', 'wt'); //->extend('Tablesort');
	// sql select fields
	$fields = array('tid', 'name','cod', 'max_bod', 'max_n_p', 'max_n_a', 'max_p_p', 'max_p_a', 'max_tss_p', 'max_tss_a','req_land','req_chem','req_energy','om','shock','flows','toxic','sludge');
	//if ($scenarioV != "") {
		//$scenario_fields = array('req_land','req_chem','req_energy','om','shock','flows','toxic','sludge');
		//$fields = array_merge($fields,$scenario_fields);
		//if ($debug) {
			//echo $popeqV;
			//echo print_r($fields,1)."<br/>";
			//echo print_r($scenario_fields,1)."<br/>";
		//}
	//}
	
	//$popeq_query_elements = wamex_get_popeq_threshold($popeqV);
	//$fields[] = $capex_query_elements['capex_fields'];
	//$fields = array_merge($fields, $popeq_fields);
	//if ($capex_field['b']) $fields[] = $capex_field['b'];
	//echo print_r($popeq_query_elements['popeq_fields'],1)."<br/>";
	if ($debug) echo "<pre>";
	$popeq_threshold = wamex_popeq_threshold($popeqV);
	$popeq_query_elements = wamex_popeq_query_elements($popeq_threshold['threshold'],$popeq_threshold['shortcut']);
	$popeq_fields = $popeq_query_elements['popeq_fields'];
	$popeq_condition = $popeq_query_elements['popeq_condition'];
	
  //$query = $select->fields('wt', $fields)
  $query = $select->fields('wt') // , $fields)
						->condition($popeq_condition);
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
		//if($debug) echo print_r($val,1)."<br/>";
		 $ary_tech_values = array(
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
			'req_land'=>$val->req_land,
			'req_chem'=>$val->req_chem,
			'req_energy'=>$val->req_energy,
			'om'=>$val->om,
			'shock'=>$val->shock,
			'flows'=>$val->flows,
			'toxic'=>$val->toxic,
			'sludge'=>$val->sludge,
		);
		
		if($popeqV > 0) {
			foreach($popeq_fields as $fieldname){
				$ary_tech_values[$fieldname] = $val->{$fieldname};
			}
		}
		
		$arrayTechnology[] = $val;
	}
	
	if($debug){
		//print '<pre>'.print_r($rows,1).'</pre>';
		//print '<pre>'.print_r($arrayTechnology,1).'</pre>';
		//print $popeqV."<br/>";
		//echo "<b>Selecting Technologies based on Population Equivalent</b><br/><pre>";
		print "Population Equivalent: ".number_format($popeqV,2)."<br/>";
		print "CapEx is non-zero for ".count($arrayTechnology)." technologies.<br/>";
		
		// display list of technology names here
		// ...
		$t = 1;
		echo "<b>Tech| Name</b><br/>";
		foreach ($arrayTechnology as $tech){
			echo str_replace("_","&nbsp;",str_pad($tech->tid,4,"_",STR_PAD_BOTH))."|".$tech->name."</tt><br/>";
			$t++;
		}
		echo "<br/>";
		echo "</pre>";

	}
	return $arrayTechnology;

}


function wamex_popeq_threshold($popeqV) {
	global $debug;
	if ($popeqV < 1) $popeqV = 1; // (?)
		
	if ($debug) {
		echo "<b>Selecting technologies based on Population Equivalent (".number_format($popeqV,2).")</b><br/>";
	}
	$popeq_thresholds = array(
		array('value'=>1,'shortcut'=> '1'),
		array('value'=>10,'shortcut' => '10'),
		array('value'=>200,'shortcut' => '200'),
		array('value'=>2000,'shortcut' => '2k'),
		//array('value'=>2000,'shortcut' => '2kb'),
		array('value'=>20000,'shortcut' => '20k'),
		//array('value'=>20000,'shortcut' => '20kb'),
		array('value'=>200000,'shortcut' => '200k'),
		//array('value'=>200000,'shortcut' => '200kb'),
		array('value'=>600000,'shortcut' => '600k'),
		//array('value'=>600000,'shortcut' => '600kb'),
		array('value'=>1200000,'shortcut' => '1200k'),
		//array('value'=>1200000,'shortcut' => '1200kb'),
	);
	
	// get techs with applicable capex
	$numThresholds = count($popeq_thresholds);
	//foreach ($capex_thresholds as $cet){
	//if ($debug) echo "<pre>";
	/*for ($x = 0; $x < $numThresholds; $x++){
		//$capex_field = 'capex_'.$capex_thresholds[$x]['shortcut'];
		if ($popeqV >= $popeq_thresholds[$x]['value']){
			//echo $popeqV." > [".$x."]".$capex_thresholds[$x]['value']."<br/>";
			if ($popeqV >= 1200000){
				$threshold = $popeq_thresholds[$x]['value'];
				$shortcut = $popeq_thresholds[$x]['shortcut'];
				if ($debug) echo "<tt>1 Minimum Threshold: ".$popeqV." < [".($x)."]".number_format($threshold)."</tt><br/>";
			}
			//else {
				//$threshold = $capex_thresholds[$x-1]['value'];
				//echo "-".$popeqV." < [".($x)."]".$threshold."<br/>";
				// do nothing;
			//}
			//break;
		} else {
			//echo "current: ".print_r(current($popeq_thresholds),1)."<br/>";
			$threshold = $popeq_thresholds[$x-1]['value'];
			$shortcut = $popeq_thresholds[$x-1]['shortcut'];
			if ($debug) print "<tt>2 Minimum Threshold: ".number_format($threshold)."</tt><br/>";
			break;
		}
	}*/
	
	
	/*while (list($th,$val) = each($popeq_thresholds)){
		echo print_r($th,1)."<br/>";
		echo print_r($val,1)."<br/>";
	}*/

	foreach ($popeq_thresholds as $key => $a_th){
		if ($popeqV >= $a_th['value']) {
			//if ($debug) echo "[".$key."] ".$a_th['value']."<br/>";
			//if ($popeqV >= 1200000);
		} 
		else {
			//if ($debug) echo "[".$key."] ".$a_th['value']."<br/>";
			break;
		}
	}
	
	if ($popeqV >= 1200000) {
		$popeq_threshold_index = $key;
		if($debug) {
			//echo "key: k:".$key."<br/>";
			echo "<tt>Minimum Threshold: ".$popeqV." < [".($x)."]".number_format($popeq_thresholds[$popeq_threshold_index]['value'])."</tt><br/>";
		}
	} else {
		$popeq_threshold_index = $key-1;
		if($debug) {
			//echo "key: k:".($key-1)."<br/>";
			echo "<tt>Minimum Threshold: ".number_format($popeq_thresholds[$popeq_threshold_index]['value'])."</tt><br/>";
		}
	}
	
	$threshold = $popeq_thresholds[$popeq_threshold_index]['value'];
	$shortcut = $popeq_thresholds[$popeq_threshold_index]['shortcut'];
	//if ($debug) echo "</pre>";

	//echo "X:".$x."<br/>";
	//if($debug) echo "wamex_math: Th:".$threshold."<br/>";
	return array('threshold'=>$threshold, 'shortcut'=>$shortcut);
}

function wamex_popeq_query_elements($threshold, $shortcut){
	
	$capex_field = array();
	$popeq_fields = array();
	if ($threshold >= 2000){
		$capex_field['a'] = 'capex_'.$shortcut.'a';
		$capex_field['b'] = 'capex_'.$shortcut.'b';
		$popeq_fields[] = $capex_field['a'];
		$popeq_fields[] = $capex_field['b'];
		$popeq_fields[] = 'opex_'.$shortcut.'a';
		$popeq_fields[] = 'opex_'.$shortcut.'b';
		$popeq_condition = db_or()->isNotNull($capex_field['a'])->isNotNull($capex_field['b']);
	} else {
		$capex_field['a'] = 'capex_'.$shortcut;
		$popeq_fields[] = $capex_field['a'];
		$popeq_fields[] = 'opex_'.$shortcut;
		$popeq_condition = db_or()->isNotNull($capex_field['a']);
		//$capex_field['b'] = NULL;
	}
	
	return array('popeq_fields'=>array(), 'popeq_condition'=>$popeq_condition); //,'threshold'=>$threshold,'shortcut'=>$shortcut);
	
}



// function wamex_scenario_filter($tids = array(tid), array(parameters)) {
// return array( scenario scores ) // applicable/enabled parameters, sorted by score descending
//}

function wamex_scenario_score($tech,$scenarioV) {
	global $debug;
	
	//if ($debug) echo "wamex_scenario_score tech = <br/>".print_r($tech,1)."<br/>";
	
	$ary_scenario = explode("|",$scenarioV);
	$scenario_sum = array_sum($ary_scenario);
	$weights = array(
		'req_land'=>$ary_scenario[0]/$scenario_sum,
		'req_chem'=>$ary_scenario[1]/$scenario_sum,
		'req_energy'=>$ary_scenario[2]/$scenario_sum,
		'om'=>$ary_scenario[3]/$scenario_sum,
		'shock'=>$ary_scenario[4]/$scenario_sum,
		'flows'=>$ary_scenario[5]/$scenario_sum,
		'toxic'=>$ary_scenario[6]/$scenario_sum,
		'sludge'=>$ary_scenario[7]/$scenario_sum,
	);
	
	//score logic/math goes here
	$score = (double) $tech['req_land']*$weights['req_land']+
		$tech['req_chem']*$weights['req_chem']+
		$tech['req_energy']*$weights['req_energy']+
		$tech['om']*$weights['om']+
		$tech['shock']*$weights['shock']+
		$tech['flows']*$weights['flows']+
		$tech['toxic']*$weights['toxic']+
		$tech['sludge']*$weights['sludge'];
	
	
	if ($debug){
		//echo $scenarioV."<br/>";
		//echo print_r($tech,1)."<br/>";
		//echo "scenario_sum: ".$scenario_sum."<br/>";
		//echo "weights: ".implode("|",$weights)."<br/>";
		echo str_replace("_","&nbsp;",str_pad($tech['tid'],4,"_",STR_PAD_BOTH))."|";
		echo str_pad(number_format($tech['req_land']*$weights['req_land'],6),8,"_",STR_PAD_BOTH)."|";
		echo number_format($tech['req_chem']*$weights['req_chem'],6)."|";
		echo number_format($tech['req_energy']*$weights['req_energy'],6)."|";
		echo number_format($tech['om']*$weights['om'],6)."|";
		echo number_format($tech['shock']*$weights['shock'],6)."|";
		echo number_format($tech['flows']*$weights['flows'],6)."|";
		echo number_format($tech['toxic']*$weights['toxic'],6)."|";
		echo number_format($tech['sludge']*$weights['sludge'],6)."|";
		echo "<b>".number_format($score,6)."</b><br/>";
		//echo $tech['name']."<br/>";
	}
	return $score;
}

function wamex_capex($popeq,$capex_a,$capex_b) {
	$capex = $capex_a*($popeq/1000)+$capex_b;
	return $capex;
}

function wamex_opex($popeq,$opex_a,$opex_b) {
	$opex = $opex_a*($popeq/1000)+$opex_b;
	return $opex;
}


function wamex_land_req($popeq,$land_values) {
	if ($popeq < 200){
		$land_req = 0;
	} elseif ($popeq < 1000){
		// land_200
		$land_req = $land_values[0];
	} elseif ($popeq > 1000){
		//$land_req = "PE = ".$popeq."<br/>LAND = ".$land_values[1];
		// land_1k
		$land_req = $popeq*$land_values[1];
	}
	return $land_req;
}

function wamex_select_tech($loading,$target,$popeq,$scenario){

	global $debug;
	//$debug = FALSE;
	$arrayPossibleTech = array();
	// Load technology table as array from DB
	$arrayAllTech = wamex_get_all_tech($popeq,$scenario);
	
	if($debug) echo "<b>Selecting technologies based on Average Loading and Standards.</b><br/>";
	if($debug) echo "<pre style='height: 400px; overflow-y: scroll; '>";

	$ctr = 0;
	foreach ($arrayAllTech as $tech) {
		$tech = (array)$tech;
	
		// Let's assume this tech does not pass the standard
		$flag = FALSE;
		if ($debug) {
			echo "<tt><b><u>" . $tech["name"] . "</u></b> [".$tech["tid"] ."]</tt><br/>";
			echo "<tt><b>Param | Efficiency | Loading | Standard | Residue | Status | Action</b></tt><br/>";
		}
		
		//if ($debug) echo "tech: ".print_r($tech,1) . "<br/><br/>";

		// Test for COD
		if ($debug) echo "<tt>COD&nbsp;&nbsp;&nbsp;|&nbsp;</tt>";
		$test_cod = wamex_test($loading["COD"],$tech["cod"],$target["COD"],$tech["cod"]);
		if ($test_cod!="FAIL"){
			if ($debug) echo str_replace("_","&nbsp","<tt> ".str_pad($test_cod,6,"_",STR_PAD_BOTH)." | ".str_pad(($test_cod=="PASS"?"Next":"Skip"),6,"_",STR_PAD_BOTH)."</tt><br/>");
			
			if ($debug) echo "<tt>BOD5&nbsp;&nbsp;|&nbsp;</tt>";
			// If good, test for BOD5
			$test_bod5 = wamex_test($loading["BOD5"],$tech["max_bod"],$target["BOD5"],$tech["max_bod"]);
			if ($test_bod5!="FAIL"){
				if ($debug) echo str_replace("_","&nbsp","<tt> ".str_pad($test_bod5,6,"_",STR_PAD_BOTH)." | ".str_pad(($test_bod5=="PASS"?"Next":"Skip"),6,"_",STR_PAD_BOTH)."</tt><br/>");

				if ($debug) echo "<tt>N&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;|&nbsp;</tt>";	
				// If good, test for N
				$test_n = wamex_test($loading["N"],$tech["max_n_p"],$target["N"],$tech["max_n_a"]);
				if ($test_n!="FAIL"){
						if ($debug) echo str_replace("_","&nbsp","<tt> ".str_pad($test_n,6,"_",STR_PAD_BOTH)." | ".str_pad(($test_n=="PASS"?"Next":"Skip"),6,"_",STR_PAD_BOTH)."</tt><br/>");
					
					if ($debug) echo "<tt>P&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;|&nbsp;</tt>";
					// If good, test for P
					$test_p = wamex_test($loading["P"],$tech["max_p_p"],$target["P"],$tech["max_p_a"]);
					if ($test_p!="FAIL"){
						if ($debug) echo str_replace("_","&nbsp","<tt> ".str_pad($test_p,6,"_",STR_PAD_BOTH)." | ".str_pad(($test_p=="PASS"?"Next":"Skip"),6,"_",STR_PAD_BOTH)."</tt><br/>");
						
						if ($debug) echo "<tt>TSS&nbsp;&nbsp;&nbsp;|&nbsp;</tt>";
						// If good, test for TSS
						$test_tss = wamex_test($loading["TSS"],$tech["max_tss_p"],$target["TSS"],$tech["max_tss_a"]);
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
			$arrayPossibleTech[] = $tech;
		}
	}
	
	//if (count($arrayPossibleTech) > 0){
		// if ($debug) echo "<b>".count($arrayPossibleTech)." technologies pass tests.</b><br/>";
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

