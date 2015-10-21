	<?php
$node = menu_get_object(); 
if ($node):
	//print "<pre style='display: block; height: 500px; overflow-y: scroll'>".print_r($node,1)."</pre>";
	//$nid = field_get_items('node',$node,'nid');
	$nid = $node->nid;
	$field_body = field_get_items('node',$node,'body');
	$field_author = field_get_items('node',$node,'field_author');
	$field_location = field_get_items('node',$node,'field_location');
	$field_population = field_get_items('node',$node,'field_population');
	$field_ci_cost = field_get_items('node',$node,'field_ci_cost');
	$field_discount_rate = field_get_items('node',$node,'field_discount_rate');
	$field_currency = field_get_items('node',$node,'field_currency');
	$field_exchange_rate_to_usd = field_get_items('node',$node,'field_exchange_rate_to_usd');
	$field_effluent_standard = field_get_items('node',$node,'field_effluent_standard');
	$field_effluent_cod = field_get_items('node',$node,'field_loading_cod');
	$field_effluent_bod5 = field_get_items('node',$node,'field_loading_bod5');
	$field_effluent_totn = field_get_items('node',$node,'field_loading_totn');
	$field_effluent_totp = field_get_items('node',$node,'field_loading_totp');
	$field_effluent_tss = field_get_items('node',$node,'field_loading_tss');
	$addLoadingPerm = user_access('add loading custom');
	$editProjectPerm = user_access('edit project custom');
	//
	//print $editPerm;
	if (isset($nid)){
		// set some node values to the jQuery extension
		drupal_add_js(array('node' => array('values' => array('nid'=>$node->nid))),'setting');
		drupal_add_js(array('node' => array('values' => array('field_currency'=>$field_currency[0]['tid']))),'setting');
		drupal_add_js(array('node' => array('values' => array('field_exchange_rate'=>$field_exchange_rate_to_usd[0]['value']))),'setting');
		drupal_add_js(array('node' => array('values' => array('field_effluent_standard'=>$field_effluent_standard[0]['tid']))),'setting');
		drupal_add_js(array('node' => array('values' => array('field_cod'=>$field_effluent_cod[0]['value']))),'setting');
		drupal_add_js(array('node' => array('values' => array('field_bod5'=>$field_effluent_bod5[0]['value']))),'setting');
		drupal_add_js(array('node' => array('values' => array('field_totn'=>$field_effluent_totn[0]['value']))),'setting');
		drupal_add_js(array('node' => array('values' => array('field_totp'=>$field_effluent_totp[0]['value']))),'setting');
		drupal_add_js(array('node' => array('values' => array('field_tss'=>$field_effluent_tss[0]['value']))),'setting');
	}
//}


$view_loading = views_get_view('loading');
$view_loading->set_display('block');

?>
<div id="project-page-<?php print $node->nid; ?>">
	<div class="container-fluid">
		<div class="row">
			<div id="project-information" class="col-sm-5 col-md-5 col-lg-5">
				<div class="row">
					<div class="col-sm-12"><h3 class="project-section-title">Project Information</h3></div>
				</div>
				<div class="row">
					<div class="col-sm-4 project-info-label"><h4>Project Name</h4></div>
					<div class="col-sm-8 project-info-value"><?php print $title; ?></div>
				</div>
				<div class="row">
					<div class="col-sm-4 project-info-label"><h4>Author</h4></div>
					<div class="col-sm-8 project-info-value"><?php print (isset($field_author) ? $field_author[0]['value'] : "-"); ?></div>
				</div>
				<div class="row">
					<div class="col-sm-4 project-info-label"><h4>Location</h4></div>
					<div class="col-sm-8 project-info-value"><?php print (isset($field_location) ? $field_location[0]['value']: "-"); ?></div>
				</div>
				<div class="row">
					<div class="col-sm-4 project-info-label"><h4>Description</h4></div>
					<div class="col-sm-8 project-info-value"><?php print (isset($field_body) ? $field_body[0]['value'] : "-");  ?></div>
				</div>
				<div class="row">
					<div class="col-sm-4 project-info-label"><h4>Population</h4></div>
					<div class="col-sm-8 project-info-value"><?php print (isset($field_population) ? $field_population[0]['value']: "-"); ?></div>
				</div>
				<div class="row">
					<div class="col-sm-4 project-info-label"><h4>CI Cost</h4></div>
					<div class="col-sm-8 project-info-value"><?php print (isset($field_ci_cost) ? $field_ci_cost[0]['value']: "-"); ?></div>
				</div>
				<div class="row">
					<div class="col-sm-4 project-info-label"><h4>Discount Rate</h4></div>
					<div class="col-sm-8 project-info-value"><?php print (isset($field_discount_rate) ? $field_discount_rate[0]['value']: "-"); ?></div>
				</div>
				<div class="row">
					<div class="col-sm-4 project-info-label"><h4>Currency</h4></div>
					<div class="col-sm-8 project-info-value"><?php print (isset($field_currency) ? $node->field_currency['und'][0]['taxonomy_term']->name : "-"); ?></div>
				</div>
				<div class="row">
					<div class="col-sm-4 project-info-label"><h4>Exchange Rate</h4></div>
					<div class="col-sm-8 project-info-value"><?php print (isset($field_exchange_rate_to_usd) ? $field_exchange_rate_to_usd[0]['value']: "-"); ?></div>
				</div>
			</div>
			<div id="project-information" class="col-sm-5 col-md-5 col-lg-5 col-md-offset-1 col-lg-offset-1">
				<div class="row">
					<div class="col-sm-12">
						<h3 class="project-section-title">Effluent Standards</h3>
						<div id="effluent-standards-messages"></div>
					</div>
				</div>
						<?php 
							$effl_form = drupal_get_form('wamex_project_effl_form',$nid);
							//echo '<pre>'.print_r($effl_form['actions']['submit'],1).'</pre>';
							//print render($effl_form['submit']);
							$effl_form_markup = '<div class="row" id="effluent-standard-name">';
							$effl_form_markup .= drupal_render($effl_form['field_effluent_standard']);
							$effl_form_markup .= '</div>';
							$effl_form_markup .= '<div class="row" id="effluent-standard-values">';
							$effl_form_markup .= drupal_render($effl_form['field_cod']);
							$effl_form_markup .= drupal_render($effl_form['field_bod5']);
							$effl_form_markup .= drupal_render($effl_form['field_totn']);
							$effl_form_markup .= drupal_render($effl_form['field_totp']);
							$effl_form_markup .= drupal_render($effl_form['field_tss']);
							$effl_form_markup .= '</div>';
							$effl_form_markup .= '<div class="row" id="effluent-standard-actions"><br/>';
							if($editProjectPerm){
								$effl_form_markup .= drupal_render($effl_form['actions']['submit']);
							}
							$effl_form_markup .= '</div>';
							$effl_form_markup .= drupal_render($effl_form['form_build_id']);
							$effl_form_markup .= drupal_render($effl_form['form_id']);
							$effl_form_markup .= drupal_render($effl_form['form_token']);
							$variables['element'] = $effl_form;
							$variables['element']['#children'] = $effl_form_markup;
							print theme_form($variables);
						?>
				</div>
				<!--div class="row" id="effluent-standard-values">
					<div class="col-sm-2 project-effluent-attribute" id="project-effluent-cod"><label>COD</label><span class="well well-sm effluent-value">&nbsp;</span></div>
					<div class="col-sm-2 project-effluent-attribute" id="project-effluent-bod5"><label>BOD5</label><span class="well well-sm effluent-value">&nbsp;</span></div>
					<div class="col-sm-2 project-effluent-attribute" id="project-effluent-totn"><label>TotN</label><span class="well well-sm effluent-value">&nbsp;</span></div>
					<div class="col-sm-2 project-effluent-attribute" id="project-effluent-totp"><label>TotP</label><span class="well well-sm effluent-value">&nbsp;</span></div>
					<div class="col-sm-2 project-effluent-attribute" id="project-effluent-tss"><label>TSS</label><span class="well well-sm effluent-value">&nbsp;</span></div>
					<div class="col-sm-2"></div>
				</div-->
				
			</div>
		</div>

	</div>
	<hr/>
	<div class="container-fluid">
		<div class="row">
			<div class="col-sm-12"><h3 class="project-section-title" id="loading-list-title">Loading/WW Characterisation</h3></div>
		</div>
		<div class="row" id="loading-view-container">
			<div class="col-sm-12" id="loading-list-container"><?php $view_loading->set_arguments(array($nid)); $view_loading->pre_execute(); $view_loading->execute(); print $view_loading->render(); ?></div>
		</div>
		<div class="row" id="loading-actions-container">
			<?php if ($addLoadingPerm):?><button class="btn btn-primary btn-add-loading" id="add-loading-<?php print $node->nid; ?>"><span class="glyphicon glyphicon-plus"></span>&nbsp;Add Loading</button><?php endif; ?>
			<!--button class="btn btn-default hidden" id="cancel-loading" >Cancel</button-->
		</div>
		<div class="row" id="loading-form-container"></div>
	</div>
	<hr/>
	<div class="container-fluid" id="loading-tech-container">
		<div class="row">
			<div class="col-sm-12"><h3 class="project-section-title" id="loading-tech-title">Suitable Technologies</h3>
				<button class="btn btn-primary btn-show-tech" id="show-tech-<?php print $node->nid; ?>"><span class="glyphicon glyphicon-chevron-right"></span>&nbsp;Show Results</button>
			</div>
		</div>
		<div class="row">
			<div class="col-sm-12" id="loading-tech-list"></div>
		</div>
	</div>
	<hr/>
</div>
<?php else: ?>
<div>No node information.</div>
<?php endif; ?>