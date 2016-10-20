	<?php
	//$node = menu_get_object();

	global $debug;
	$user_debug = $debug;
	global $user;
	if($user->uid!=0){
		$user_fields = user_load($user->uid);
		$user_scenarios = (isset($user_fields->field_user_scenarios[LANGUAGE_NONE]) ? $user_fields->field_user_scenarios[LANGUAGE_NONE][0]['value'] : FALSE);
	} else {
		$user_fields = null;
		$user_scenarios = FALSE;
	}

	if ($node):
	$nid = $node->nid;
	//print "<pre style='display: block; '>".$user_scenarios."</pre>";
	//print "<pre style='display: block; '>".$user_debug."</pre>";
	//print "<pre style='display: block; height: 500px; overflow-y: scroll'>".print_r($node,1)."</pre>";
	//$nid = field_get_items('node',$node,'nid');
	//$nid = $node->nid;

  // NODE VALUES
	$field_body = field_get_items('node',$node,'body');
	//print "<pre style='display: block; height: 500px; overflow-y: scroll'>".print_r($field_body,1)."</pre>";
	$field_author = field_get_items('node',$node,'field_author');
	$field_location = field_get_items('node',$node,'field_location');
	$field_population = field_get_items('node',$node,'field_population');
	$field_ci_cost = field_get_items('node',$node,'field_ci_cost');
	$field_discount_rate = field_get_items('node',$node,'field_discount_rate');
	//$field_om_pct_treatment = field_get_items('node',$node,'field_om_pct_treatment');
	//$field_design_horizon_treatment = field_get_items('node',$node,'field_design_horizon_treatment');
	$field_currency = field_get_items('node',$node,'field_currency');
	$field_exchange_rate_to_usd = field_get_items('node',$node,'field_exchange_rate_to_usd');
	$field_effluent_standard = field_get_items('node',$node,'field_effluent_standard');
	$field_effluent_cod = field_get_items('node',$node,'field_loading_cod');
	$field_effluent_bod5 = field_get_items('node',$node,'field_loading_bod5');
	$field_effluent_totn = field_get_items('node',$node,'field_loading_totn');
	$field_effluent_totp = field_get_items('node',$node,'field_loading_totp');
	$field_effluent_tss = field_get_items('node',$node,'field_loading_tss');
	$field_land_cost = field_get_items('node',$node,'field_land_cost');
  $field_land_area = field_get_items('node',$node,'field_land_area');
  $field_population_density = field_get_items('node',$node,'field_population_density');
  $field_sewerage_type = field_get_items('node',$node,'field_sewerage_type');
  $field_pipe_length = field_get_items('node',$node,'field_pipe_length');
  $field_terrain_type = field_get_items('node',$node,'field_terrain_type');
  $field_technology_data = field_get_items('node',$node,'field_technology_data');

  // PERMISSIONS
	$addLoadingPerm = user_access('add loading custom');
	$editProjectPerm = user_access('edit project custom');
	$addScenarioPerm = user_access('add scenario custom');
	//

	$term_currency = taxonomy_term_load($field_currency[0]['tid']);
	$currency_code = $term_currency->field_currency_code[LANGUAGE_NONE][0]['value'];

	if (isset($nid)){

    //drupal_add_css(libraries_get_path('leaflet') . '/leaflet.css', array('type'=>'file','group'=>CSS_DEFAULT));
    //drupal_add_css(libraries_get_path('leaflet.geosearch') . '/src/css/l.geosearch.css', array('type'=>'file','group'=>CSS_DEFAULT));
    //drupal_add_js(libraries_get_path('leaflet') . '/leaflet.js');
    //drupal_add_js(libraries_get_path('leaflet.geosearch') . '/src/js/l.control.geosearch.js');
    //drupal_add_js(libraries_get_path('leaflet.geosearch') . '/src/js/l.geosearch.provider.openstreetmap.js');
    //drupal_add_js(libraries_get_path('leaflet.geosearch') . '/src/js/l.geosearch.provider.google.js');
    //drupal_add_js(base_path(). drupal_get_path('theme', 'wamex'). '/js/loc-map.js');
		// set some node values to the jQuery extension
		drupal_add_js(array('node' => array('values' => array('nid'=>$node->nid))),'setting');
		drupal_add_js(array('node' => array('values' => array('title'=>$node->title))),'setting');
		drupal_add_js(array('node' => array('values' => array('body'=>$field_body[0]['value']))),'setting');
		drupal_add_js(array('node' => array('values' => array('field_author'=>$field_author[0]['value']))),'setting');
		drupal_add_js(array('node' => array('values' => array('field_location'=>$field_location[0]['value']))),'setting');
		drupal_add_js(array('node' => array('values' => array('field_population'=>$field_population[0]['value']))),'setting');
		drupal_add_js(array('node' => array('values' => array('field_ci_cost'=>$field_ci_cost[0]['value']))),'setting');
		drupal_add_js(array('node' => array('values' => array('field_currency'=>$field_currency[0]['tid']))),'setting');
		drupal_add_js(array('node' => array('values' => array('field_currency_name'=>$field_currency[0]['taxonomy_term']->name))),'setting');
		drupal_add_js(array('node' => array('values' => array('field_currency_code'=>$currency_code))), 'setting');
		drupal_add_js(array('node' => array('values' => array('field_exchange_rate'=>$field_exchange_rate_to_usd[0]['value']))),'setting');
		drupal_add_js(array('node' => array('values' => array('field_discount_rate'=>$field_discount_rate[0]['value']))),'setting');
		//drupal_add_js(array('node' => array('values' => array('field_om_pct_treatment'=>$field_om_pct_treatment[0]['value']))),'setting');
		//drupal_add_js(array('node' => array('values' => array('field_design_horizon_treatment'=>$field_design_horizon_treatment[0]['value']))),'setting');
		drupal_add_js(array('node' => array('values' => array('field_land_cost'=>$field_land_cost[0]['value']))),'setting');
		drupal_add_js(array('node' => array('values' => array('field_effluent_standard'=>$field_effluent_standard[0]['tid']))),'setting');
		drupal_add_js(array('node' => array('values' => array('field_effluent_standard_name'=>$field_effluent_standard[0]['taxonomy_term']->name))),'setting');
		drupal_add_js(array('node' => array('values' => array('field_cod'=>$field_effluent_cod[0]['value']))),'setting');
		drupal_add_js(array('node' => array('values' => array('field_bod5'=>$field_effluent_bod5[0]['value']))),'setting');
		drupal_add_js(array('node' => array('values' => array('field_totn'=>$field_effluent_totn[0]['value']))),'setting');
		drupal_add_js(array('node' => array('values' => array('field_totp'=>$field_effluent_totp[0]['value']))),'setting');
		drupal_add_js(array('node' => array('values' => array('field_tss'=>$field_effluent_tss[0]['value']))),'setting');

		drupal_add_js(array('node' => array('values' => array('field_land_cost'=>$field_land_cost[0]['value']))),'setting');
		drupal_add_js(array('node' => array('values' => array('field_land_area'=>$field_land_area[0]['value']))),'setting');
		drupal_add_js(array('node' => array('values' => array('field_population_density'=>$field_population_density[0]['value']))),'setting');
		drupal_add_js(array('node' => array('values' => array('field_sewerage_type'=>$field_sewerage_type[0]['value']))),'setting');
		drupal_add_js(array('node' => array('values' => array('field_pipe_length'=>$field_pipe_length[0]['value']))),'setting');

    $techData = json_decode($field_technology_data[0]['value'],TRUE);

		drupal_add_js(array('node' => array('values' => array('technologies'=>$techData['table']))),'setting');

    //print "<pre style='display: block; '>".print_r($techData['args'],1)."</pre>";
	}
//}


$view_loading = views_get_view('loading');
$view_loading->set_display('block');

$view_scenario = views_get_view('scenario');
$view_scenario->set_display('block');

?>
<div id="project-page-<?php print $nid; ?>" class="panel-group" role="tablist" aria-multiselectable="false">
	<div id="project-info-container" class="container-fluid panel panel-default">
		<div id="project-information" class="col-sm-12 col-md-12 col-lg-12 panel-heading" role="tab" id="heading-project-info">
			<div class="row" id="project-info-title-container">
				<div class="col-sm-12">
					<h3 class="project-section-title panel-title" id="project-info-title"><a href="#collapse-project-info" name="project-info" role="button" data-toggle="collapse" aria-expanded="true" aria-controls="collapse-project-info"><span id="toggle-project-info" class="heading-arrow glyphicon glyphicon-chevron-up"></span>Project Information</a></h3>
				<?php if ($editProjectPerm): ?><a href="<?php print base_path(); ?>project/edit/<?php print $node->nid; ?>" class="btn btn-primary btn-sm pull-right" id="edit-project-<?php print $nid; ?>"><span class="glyphicon glyphicon-pencil"></span>&nbsp;Edit</a><?php endif; ?>
				</div>
			</div>
		</div>
		<div class="panel-collapse collapse in" id="collapse-project-info" role="tabpanel" aria-labelledby="heading-project-info">
			<table class="table">
				<tbody>
					<tr>
						<td class="project-info-label col-sm-5 col-md-5 col-lg-5"><label>Project Name</label></td>
						<td class="project-info-value col-sm-7 col-md-7 col-lg-7"><?php print $title; ?></td>
					</tr>
					<tr>
						<td class="project-info-label col-sm-5 col-md-5 col-lg-5"><label>Author</label></td>
						<td class="project-info-value col-sm-7 col-md-7 col-lg-7"><?php print (isset($field_author) ? $field_author[0]['value'] : "-"); ?></td>
					</tr>
					<tr>
						<td class="project-info-label col-sm-5 col-md-5 col-lg-5"><label>Location</label></td>
						<td class="project-info-value col-sm-7 col-md-7 col-lg-7" id="project-location"><?php print (isset($field_location) ? $field_location[0]['value']: "-"); ?></td>
					</tr>
					<!--tr>
						<td class="project-info-value col-sm-12 col-md-12 col-lg-12" colspan="2" id="map-container"><div id="project-location-name"></div><div id="map-canvas"></div></td>
					</tr-->
					<tr>
						<td class="project-info-label col-sm-5 col-md-5 col-lg-5"><label>Population</label></td>
						<td class="project-info-value col-sm-7 col-md-7 col-lg-7"><?php print (isset($field_population) ? number_format($field_population[0]['value']): "-"); ?>
						<span class="hidden" id="td-field-population"><?php print (isset($field_population) ? $field_population[0]['value']: "-"); ?></span>
						</td>

					</tr>
					<tr>
						<td class="project-info-label col-sm-5 col-md-5 col-lg-5"><label>Description</label></td>
						<td class="project-info-value col-sm-7 col-md-7 col-lg-7"><?php print (isset($field_body) ? $field_body[0]['value'] : "-");  ?></td>
					</tr>
				</tbody>
			</table>
		</div>
	</div>

	<div id="financial-info-container" class="container-fluid panel panel-default">
		<div id="financial-information" class="col-sm-12 col-md-12 col-lg-12 panel-heading" role="tab" id="heading-financial-info">
			<div class="row" id="financial-info-title-container">
				<div class="col-sm-12">
					<h3 class="project-section-title panel-title" id="financial-info-title"><a href="#collapse-financial-info" name="financial-info" role="button" data-toggle="collapse" aria-expanded="true" aria-controls="collapse-financial-info"><span id="toggle-financial-info" class="heading-arrow glyphicon glyphicon-chevron-up"></span>Financial Information</a></h3>
				<?php if ($editProjectPerm): ?><a href="<?php print base_path(); ?>project/edit/<?php print $node->nid; ?>" class="btn btn-primary btn-sm pull-right" id="edit-project-<?php print $nid; ?>"><span class="glyphicon glyphicon-pencil"></span>&nbsp;Edit</a><?php endif; ?>
				</div>
			</div>
		</div>
		<div class="panel-collapse collapse in" id="collapse-financial-info" role="tabpanel" aria-labelledby="heading-financial-info">
			<table class="table" id="financial-info-table">
        <tbody>
        <tr>
          <td class="project-info-label col-sm-5 col-md-5 col-lg-5"><label>Currency</label></td>
          <td class="project-info-value col-sm-7 col-md-7 col-lg-7"><?php print (isset($field_currency[0]['taxonomy_term']->name) ? $field_currency[0]['taxonomy_term']->name : "-"); ?>&nbsp;</td>
        </tr>
        <tr>
          <td class="project-info-label col-sm-5 col-md-5 col-lg-5"><label>Exchange Rate</label></td>
          <td class="project-info-value col-sm-7 col-md-7 col-lg-7"><?php print (isset($field_exchange_rate_to_usd) ? $field_exchange_rate_to_usd[0]['value']: "-"); ?></td>
        </tr>
        <tr>
          <td class="project-info-label col-sm-5 col-md-5 col-lg-5"><label>Discount Rate</label></td>
          <td class="project-info-value col-sm-7 col-md-7 col-lg-7"><?php print (isset($field_discount_rate) ? $field_discount_rate[0]['value']: "-"); ?></td>
        </tr>
        <!--tr>
          <td class="project-info-label col-sm-5 col-md-5 col-lg-5"><label>O&amp;M  % of CI Cost</label></td>
          <td class="project-info-value col-sm-7 col-md-7 col-lg-7"><?php //print (isset($field_om_pct_treatment) ? $field_om_pct_treatment[0]['value']: "-"); ?></td>
        </tr-->
        <!--tr>
          <td class="project-info-label col-sm-5 col-md-5 col-lg-5"><label>Design Horizon</label></td>
          <td class="project-info-value col-sm-7 col-md-7 col-lg-7"><?php //print (isset($field_design_horizon_treatment) ? $field_design_horizon_treatment[0]['value']: "-"); ?></td>
        </tr-->
        <!--tr>
          <td class="project-info-label col-sm-5 col-md-5 col-lg-5"><label>Capital Investment Cost</label></td>
          <td class="project-info-value col-sm-7 col-md-7 col-lg-7"><?php //print (isset($field_ci_cost) ? number_format($field_ci_cost[0]['value']): "-"); ?>
          <span class="hidden" id="td-field-ci-cost"><?php //print (isset($field_ci_cost) ? $field_ci_cost[0]['value']: "-"); ?></span>
          </td>
        </tr-->
        <tr>
          <td class="project-info-label col-sm-5 col-md-5 col-lg-5"><label>Land Cost <span class="label-unit">(<?php print $currency_code." "?>per sq m)</span></label></td>
          <td class="project-info-value col-sm-7 col-md-7 col-lg-7"><?php print (isset($field_land_cost) ? $field_land_cost[0]['value']: "-"); ?></td>
        </tr>
        </tbody>
			</table>
		</div>
	</div>
  <?php $view_loading->set_arguments(array($nid)); $view_loading->pre_execute(); $view_loading->execute();  ?>
	<div id="loading-list-container" class="container-fluid panel panel-default">
		<div id="heading-loading-list" class="panel-heading" role="tab">
			<div id="loading-title-container">
				<h3 class="project-section-title panel-title" id="loading-list-title"><a href="#collapse-loading-list" name="loading-list" role="button" data-toggle="collapse" aria-expanded="true"><span id="toggle-loading-list" class="heading-arrow glyphicon glyphicon-chevron-up"></span>Wastewater Characterisation</a></h3>
				<?php if ($addLoadingPerm):?><button class="btn btn-primary btn-sm btn-add-loading pull-right" id="add-loading-<?php print $nid; ?>"><span class="glyphicon glyphicon-plus"></span>&nbsp;Add</button><?php endif; ?>
				<button class="btn btn-xs btn-default section-help" id="loading-help">?</button>
			</div>
		</div>
		<div id="collapse-loading-list" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="heading-loading-list">
			<div class="panel-body">
				<div class="table-responsive" id="loading-form-container"></div>
				<div id="loading-view-container">
					<div id="loading-list-container"><?php print $view_loading->render(); ?></div>
				</div>
				<div id="loading-actions-container"></div>
			</div>
		</div>
	</div>

	<div id="standards-container" class="container-fluid panel panel-default">
		<div id="heading-standards" class="panel-heading" role="tab">
			<div id="standards-title-container">
				<h3 id="standards-title" class="project-section-title panel-title"><a href="#collapse-standards" name="standards" role="button" data-toggle="collapse"  aria-expanded="true" aria-controls="collapse-standards"><span id="toggle-standards" class="heading-arrow glyphicon glyphicon-chevron-up"></span>Effluent Standards</a></h3>
				<button class="btn btn-xs btn-default section-help" id="standards-help">?</button>
				<div id="effluent-standards-messages"></div>
			</div>
		</div>
		<div id="collapse-standards" class="row table-responsive panel-collapse collapse in" role="tabpanel" aria-labelledby="heading-standards">
			<div class="panel-body">
				<?php
					$effl_output = "";
					$effl_form = drupal_get_form('wamex_project_effl_form',$nid);
					$effl_form['field_effluent_standard']['#title'] = t('Standard');
					$effl_form['actions']['submit']['#attributes']['class'][] = 'btn-sm';
          $effl_form['actions']['submit']['#attributes']['data-toggle'][] = 'tooltip';
          $effl_form['actions']['submit']['#attributes']['data-placement'][] = 'auto';
          //$effl_form['actions']['submit']['#attributes']['title'][] = '_';
					$effl_header = array(
						//array('data' => t('Standard'), 'class'=>array('tech-attributes','tech-attributes-header','tech-name','col-name')) ,
						array('data' => $effl_form['field_effluent_standard']['#title'], 'class'=>array('col-md-3','tech-attributes','tech-attributes-header','tech-name','col-name')) ,
						array('data' => $effl_form['field_cod']['#title'], 'class'=>array('col-md-1','tech-attributes','tech-attributes-cod','tech-cod','col-cod')),
						array('data' => $effl_form['field_bod5']['#title'], 'class'=>array('col-md-1','tech-attributes','tech-attributes-bod5','tech-bod5','col-bod5')),
						array('data' => $effl_form['field_totn']['#title'], 'class'=>array('col-md-1','tech-attributes','tech-attributes-totn','tech-totn','col-totn')),
						array('data' => $effl_form['field_totp']['#title'], 'class'=>array('col-md-1','tech-attributes','tech-attributes-totp','tech-totp','col-totp')),
						array('data' => $effl_form['field_tss']['#title'], 'class'=>array('col-md-1','tech-attributes','tech-attributes-totp','tech-tss','col-tss')),
						array('data' => t('&nbsp;'),'class'=>array('col-md-1','col-volc')),
						//array('data' => t('&nbsp;')),
						//array('data' => t('&nbsp;')),
					);
					$effl_rows = array();
					$effl_form['field_effluent_standard']['#title'] = null;
					$effl_form['field_cod']['#title'] = null;
					$effl_form['field_bod5']['#title'] = null;
					$effl_form['field_totn']['#title'] = null;
					$effl_form['field_totp']['#title'] = null;
					$effl_form['field_tss']['#title'] = null;
					$effl_rows[0]['data'] = array(
						array('data'=>$effl_form['field_effluent_standard']),
						array('data'=>$effl_form['field_cod'], 'class'=>array('tech-attributes','tech-cod','col-cod')),
						array('data'=>$effl_form['field_bod5'], 'class'=>array('tech-attributes','tech-bod5','col-bod5')),
						array('data'=>$effl_form['field_totn'], 'class'=>array('tech-attributes','tech-totn','col-totn')),
						array('data'=>$effl_form['field_totp'], 'class'=>array('tech-attributes','tech-totp','col-totp')),
						array('data'=>$effl_form['field_tss'], 'class'=>array('tech-attributes','tech-tss','col-tss')),
						array('data' => ($editProjectPerm ? $effl_form['actions']['submit'] : t(''))),
						//array('data' => t('&nbsp;')),
						//array('data' => t('&nbsp;')),
					);
					$effl_rows[0]['id'] = 'effluent-standard-values';
					$effl_output .= theme('table', array('header' => $effl_header, 'rows' =>$effl_rows, 'attributes'=>array('id'=>'table-effl-standards')));
					$effl_output .= drupal_render($effl_form['form_build_id']);
					$effl_output .= drupal_render($effl_form['form_id']);
					$effl_output .= drupal_render($effl_form['form_token']);
					$variables['element'] = $effl_form;
					$variables['element']['#children'] = $effl_output;
					print theme_form($variables);
				?>
			</div>
		</div>
	</div>

	<div id="popeq-container" class="container-fluid panel panel-default">
		<div id="heading-popeq" class="panel-heading" role="tab">
			<div id="popeq-title-container">
				<h3 id="popeq-title" class="project-section-title panel-title" ><a href="#collapse-popeq" name="populationEquivalent" role="button" data-toggle="collapse" aria-expanded="true" aria-controls="collapse-popeq"><span id="toggle-popeq" class="heading-arrow glyphicon glyphicon-chevron-up"></span>Population Equivalent</a></h3>
				<button class="btn btn-xs btn-default section-help" id="popeq-help">?</button>
			</div>
		</div>
		<div id="collapse-popeq" class="row table-responsive panel-collapse collapse in" role="tabpanel" aria-labelledby="heading-popeq">
			<div class="panel-body">
				<?php
					$popeq_output = "";
					$popeq_form = drupal_get_form('wamex_project_popeq_form',$nid);
					$popeq_rows[0] = array(
						array('data' => t(''),'class'=>array('col-md-3','popeq-row-header', 'popeq-row-param')),
						array('data' => $popeq_form['popeq_parameter']['COD'], 'class'=>array('col-md-1','popeq-parameter','popeq-parameter-cod','popeq-cod','col-cod')),
						array('data' => $popeq_form['popeq_parameter']['BOD5'], 'class'=>array('col-md-1','popeq-parameter','popeq-parameter-bod5','popeq-bod5','col-bod5')),
						array('data' => $popeq_form['popeq_parameter']['TotN'], 'class'=>array('col-md-1','popeq-parameter','popeq-parameter-totn','popeq-totn','col-totn')),
						array('data' => $popeq_form['popeq_parameter']['TotP'], 'class'=>array('col-md-1','popeq-parameter','popeq-parameter-totp','popeq-totp','col-totp')),
						array('data' => $popeq_form['popeq_parameter']['TSS'], 'class'=>array('col-md-1','popeq-parameter','popeq-parameter-tss','popeq-tss','col-tss')),
						array('data' => $popeq_form['popeq_parameter']['Vol/C'], 'class'=>array('col-md-1','popeq-parameter','popeq-parameter-volc','popeq-volc','col-volc')),
					);
					$popeq_rows[1]['data'] = array(
						array('data' => t('<label id="popeq-label-pol">Person Load Equivalent</label> (POL, <span class="label-unit">gm/capita/day</span>)'),'class'=>array('popeq-row-header', 'popeq-row-pol')),
						array('data' => $popeq_form['popeq_pol']['pol-cod'], 'class'=>array('popeq-pol','popeq-pol-cod','popeq-cod','col-cod')),
						array('data' => $popeq_form['popeq_pol']['pol-bod5'], 'class'=>array('popeq-pol','popeq-pol-bod5','popeq-bod5','col-bod5')),
						array('data' => $popeq_form['popeq_pol']['pol-totn'], 'class'=>array('popeq-pol','popeq-pol-totn','popeq-totn','col-totn')),
						array('data' => $popeq_form['popeq_pol']['pol-totp'], 'class'=>array('popeq-pol','popeq-pol-totp','popeq-totp','col-totp')),
						array('data' => $popeq_form['popeq_pol']['pol-tss'], 'class'=>array('popeq-pol','popeq-pol-tss','popeq-tss','col-tss')),
						array('data' => $popeq_form['popeq_pol']['pol-volc'], 'class'=>array('popeq-pol','popeq-pol-volc','popeq-volc','col-volc')),
					);
					$popeq_rows[2]['data'] = array(
						array('data' => t('<label>Population Equivalent</label> (PE, <span class="label-unit">persons/day)'),'class'=>array('popeq-row-header','popeq-row-pe')),
						array('data' => '', 'class'=>array('popeq-pe','popeq-pe-cod', 'popeq-cod', 'col-cod')),
						array('data' => '', 'class'=>array('popeq-pe','popeq-pe-bod5', 'popeq-bod5', 'col-bod5')),
						array('data' => '', 'class'=>array('popeq-pe','popeq-pe-totn', 'popeq-totn', 'col-totn')),
						array('data' => '', 'class'=>array('popeq-pe','popeq-pe-totp', 'popeq-totp', 'col-totp')),
						array('data' => '', 'class'=>array('popeq-pe','popeq-pe-tss', 'popeq-tss', 'col-tss')),
						array('data' => '', 'class'=>array('popeq-pe','popeq-pe-volc', 'popeq-volc', 'col-volc')),
					);
					$popeq_rows[3]['data'] = array(
						array('data' => t('<label>Total Population Equivalent</label>'),'class'=>array('popeq-row-header','popeq-row-totpe')),
						array('data' => '', 'class'=>array('popeq-totpe','popeq-totpe-cod', 'popeq-cod', 'col-cod')),
						array('data' => '', 'class'=>array('popeq-totpe','popeq-totpe-bod5', 'popeq-bod5', 'col-bod5')),
						array('data' => '', 'class'=>array('popeq-totpe','popeq-totpe-totn', 'popeq-totn', 'col-totn')),
						array('data' => '', 'class'=>array('popeq-totpe','popeq-totpe-totp', 'popeq-totp', 'col-totp')),
						array('data' => '', 'class'=>array('popeq-totpe','popeq-totpe-tss', 'popeq-tss', 'col-tss')),
						array('data' => '', 'class'=>array('popeq-totpe','popeq-totpe-volc', 'popeq-volc', 'col-volc')),
					);
					$popeq_rows[4]['data'] = array(
						array('data' => t('<label>Total Effluent Flow</label> (<span class="label-unit">m&sup3;/day</span>)'),'class'=>array('popeq-row-header','popeq-row-totflow')),
						array('data' => '', 'class'=>array('popeq-totflow')),
					);
					$popeq_output .= theme('table', array('rows' =>$popeq_rows, 'attributes'=>array('id'=>'table-popeq')));
					//$popeq_output .= drupal_render($popeq_form['popeq_parameter']);
					$popeq_output .= drupal_render($popeq_form['form_build_id']);
					$popeq_output .= drupal_render($popeq_form['form_id']);
					$popeq_output .= drupal_render($popeq_form['form_token']);
					$variables['element'] = $popeq_form;
					$variables['element']['#children'] = $popeq_output;
					print theme_form($variables);
				?>
			</div>
		</div>
	</div>

	<div id="scenario-container" class="container-fluid panel panel-default">
		<div id="heading-scenario" class="panel-heading" role="tab">
			<div id="scenario-title-container">
				<h3 id="scenario-title" class="project-section-title panel-title"><a href="#collapse-scenario" name="scenario-list" role="button" data-toggle="collapse" aria-expanded="true" aria-controls="collapse-scenario"><span id="toggle-scenario" class="heading-arrow glyphicon glyphicon-chevron-up"></span>Scenarios</a></h3>
				<button class="btn btn-xs btn-default section-help" id="scenario-help">?</button>
				<?php if ($addScenarioPerm):?><button class="btn btn-primary btn-sm btn-add-scenario pull-right" id="add-scenario-<?php print $nid; ?>" data-toggle="tooltip" data-placement="auto"><span class="glyphicon glyphicon-plus"></span>&nbsp;Add</button><?php endif; ?>
				<div class="form-group pull-right" id="scenario-toggle-container">
					<div id="user-scenarios-toggle-hidden"><?php //print ($user_scenarios ? "ON" : "OFF");?></div>
					<div class="col-sm-offset-2 col-sm-10 hidden">
						<div class="checkbox">
							<label for="user-scenarios-toggle">
								<input type="checkbox" disabled="disabled" id="user-scenarios-toggle" name="user-scenarios" value="<?php //print $user_scenarios; ?>"><?php //print ($user_scenarios ? "ON" : "OFF");?>
							</label>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div id="collapse-scenario" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="heading-scenario">
			<div class="panel-body">
				<div class="table-responsive" id="scenario-form-container"></div>
				<div id="scenario-view-container">
					<div id="scenario-list-container"><?php $view_scenario->set_arguments(array($nid)); $view_scenario->pre_execute(); $view_scenario->execute(); print $view_scenario->render(); ?></div>
				</div>
				<div id="scenario-actions-container"></div>
			</div>
		</div>
	</div>

	<div id="loading-tech-container" class="container-fluid panel panel-default">
		<div id="heading-tech" class="panel-heading" role="tab">
			<div id="tech-title-container">
				<h3 id="loading-tech-title" class="project-section-title panel-title" ><a href="#collapse-tech" name="technologies" role="button" data-toggle="collapse" aria-expanded="true" aria-controls="collapse-tech"><span id="toggle-tech" class="heading-arrow glyphicon glyphicon-chevron-up"></span>Suitable Technologies</a></h3>
				<button class="btn btn-xs btn-default section-help" id="tech-help">?</button>
				<!--a href="<?php print base_path() ?>wamex-ajax-tech/nojs" class="btn btn-primary btn-sm btn-ajax-tech pull-right use-ajax" id="make-ajax-<?php print $nid; ?>"><span class="glyphicon glyphicon-asterisk"></span>&nbsp;AJAX!</a-->
				<!--button class="btn btn-primary btn-sm btn-make-json pull-right" id="make-json-<?php print $nid; ?>"><span class="glyphicon glyphicon-floppy-save"></span>&nbsp;Make JSON</button-->
				<button class="btn btn-primary btn-sm btn-show-tech pull-right" id="show-tech-<?php print $nid; ?>"><span class="glyphicon glyphicon-chevron-right"></span>&nbsp;Update</button>
				<div id="loading-popeq-selected-param"></div>
			</div>
		</div>
		<div id="collapse-tech" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="heading-tech">
      <div id="loading-ajax-tech-list"></div>
			<div id="loading-tech-list"><?php print wamex_display_tech(json_decode($field_technology_data[0]['value'],TRUE),TRUE); ?></div>
		</div>
	</div>

	<div id="loading-retic-container" class="container-fluid panel panel-default">
		<div id="heading-retic" class="panel-heading" role="tab">
			<div id="retic-title-container">
				<h3 id="loading-retic-title" class="project-section-title panel-title" ><a href="#collapse-retic" name="reticulation" role="button" data-toggle="collapse" aria-expanded="true" aria-controls="collapse-retic"><span id="toggle-retic" class="heading-arrow glyphicon glyphicon-chevron-up"></span>Collection and Conveyance</a></h3>
				<button class="btn btn-xs btn-default section-help" id="retic-help">?</button>
        <div id="retic-messages"></div>
				<!--button class="btn btn-primary btn-sm btn-show-retic pull-right" id="show-retic-<?php //print $nid; ?>"><span class="glyphicon glyphicon-pencil"></span>&nbsp;Edit</button-->
			</div>
		</div>
		<div id="collapse-retic" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="heading-retic">
			<div id="loading-retic-list">
				<?php
          //echo $field_sewerage_type[0]['value'];
          //echo "<br/>";
          //echo $field_pipe_length[0]['value'];

					$retic_output = "";
					$retic_form = drupal_get_form('wamex_project_retic_form',$nid);
					//$retic_form['actions']['submit']['#attributes']['class'][] = 'btn-sm';
          $retic_form['field_land_area']['#title'] = null;
          $retic_form['field_land_area']['#value'] = $field_land_area[0]['value'];
          $retic_form['field_land_area']['#attributes']['title'] = "Land Area";
          //$retic_form['field_population_density']['#title'] = null;
          //$retic_form['field_population_density']['#value'] = $field_population_density[0]['value'];
          $retic_form['field_sewerage_type']['#title'] = null;
          //$retic_form['field_sewerage_type']['#value'] = $field_sewerage_type[0]['value'];
          $retic_form['field_sewerage_type']['#value'] = t('Conventional');
          $retic_form['field_sewerage_type']['#attributes']['disabled'] = 'disabled';
          $retic_form['field_pipe_length']['#title'] = null;
          $retic_form['field_pipe_length']['#value'] = $field_pipe_length[0]['value'];
          $retic_form['field_pipe_length']['#attributes']['title'] = "Pipe Length";
          $retic_form['field_terrain_type']['#title'] = null;
          $retic_form['field_terrain_type']['#value'] = $field_terrain_type[0]['value'];
          $retic_form['field_terrain_type']['#attributes']['title'] = "Type of Terrain";
          $retic_form['actions']['submit']['#attributes']['class'][] = 'btn-sm';
          $retic_header = array();
					$retic_rows = array();

          $retic_rows[]['data'] = array(
						array('data'=>t('<label id="retic-label-sewerage-type">Type of Sewerage</label>'), 'class'=>array('retic-row-header')),
            array('data'=>$retic_form['field_sewerage_type'], 'colspan'=>2),
          );

          $retic_rows[]['data'] = array(
						array('data'=>t('<label>Cost of Sewerage</label> (<span class="label-unit">'.$currency_code.'</span>)'), 'class'=>array('retic-row-header')),
            array('data'=>'', 'id'=>array('retic-cost')),
          );

          $retic_rows[]['data'] = array(
						array('data'=>t('<label>Cost of Sewerage Per Capita</label> (<span class="label-unit">'.$currency_code.'</span>)'), 'class'=>array('retic-row-header')),
            array('data'=>'', 'id'=>array('retic-cost-per-capita'), 'colspan'=>'2' ),
          );

					$retic_rows[]['data'] = array(
						array('data'=>t('<label id="retic-label-land-area">Land Area</label> (<span class="label-unit">m<sup>2</sup></span>)'), 'class'=>array('retic-row-header','col-sm-5')),
						array('data'=>$retic_form['field_land_area'],'colspan'=>2),
          );

          /*$retic_rows[]['data'] = array(
						array('data'=>t('<label>Population Density</label> (<span class="label-unit">persons per m<sup>2</sup></span>)'), 'class'=>array('retic-row-header')),
						array('data'=>$retic_form['field_population_density'],'colspan'=>2),
					);*/

          $retic_rows[]['data'] = array(
						array('data'=>t('<label id="retic-label-pipe-length">Pipe Length</label> (<span class="label-unit">m</span>)'), 'class'=>array('retic-row-header')),
            array('data'=>$retic_form['field_pipe_length'], 'colspan'=>2),
            //array('#attributes'=>array('title'=>'Pipe Length')),
          );

          $retic_rows[]['data'] = array(
						array('data'=>t('<label id="retic-label-terrain-type">Type of Terrain</label>'), 'class'=>array('retic-row-header')),
            array('data'=>$retic_form['field_terrain_type']),
            array('data' => ($editProjectPerm ? $retic_form['actions']['submit'] : t('asdfasd'))),
          );

          /* $retic_rows[]['data'] = array(
						array('data'=>t('<label>Number of Pumps</label>'), 'class'=>array('retic-row-header')),
            array('data'=>'<div class="retic-pump-count-header col-sm-4">6L/s/day</div><div id="retic-pump-count-6" class="well well-sm col-sm-7"></div>', 'id'=>'num-pumps-6L'),
            array('data'=>'<div class="retic-pump-count-header col-sm-4">12L/s/day</div><div id="retic-pump-count-12" class="well well-sm col-sm-7"></div>', 'id'=>'num-pumps-12L'),
          ); */

          $retic_rows[]['data'] = array(
						array('data'=>t('<label>Cost of Pumps</label> (<span class="label-unit">'.$currency_code.'</span>)'), 'class'=>array('retic-row-header')),
            array('data'=>'', 'id'=>array('pump-cost'), 'colspan'=>'2' ),
          );

          $retic_rows[]['data'] = array(
						array('data'=>t('<label>Cost of Pumps Per Capita</label> (<span class="label-unit">'.$currency_code.'</span>)'), 'class'=>array('retic-row-header')),
            array('data'=>'', 'id'=>array('pump-cost-per-capita'), 'colspan'=>'2' ),
          );

					$retic_output .= theme('table', array('header' => null, 'rows' =>$retic_rows, 'attributes'=>array('id'=>'table-retic-values', 'class'=>'table')));
					$retic_output .= drupal_render($retic_form['form_build_id']);
					$retic_output .= drupal_render($retic_form['form_id']);
					$retic_output .= drupal_render($retic_form['form_token']);
					$variables['element'] = $retic_form;
					$variables['element']['#children'] = $retic_output;
					print theme_form($variables);
				?>

      </div>
		</div>
	</div>

	<hr/>
</div>
<?php else: ?>
<div>No node information.</div>
<?php endif; ?>