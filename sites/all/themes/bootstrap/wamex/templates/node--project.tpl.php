<?php
$node = menu_get_object(); 
if ($node):
	//print "<pre style='display: block; height: 500px; overflow-y: scroll'>".print_r($node,1)."</pre>";
	//krumo($node);
	//$nid = field_get_items('node',$node,'nid');
	$nid = $node->nid;
	$field_body = field_get_items('node',$node,'body');
	$field_author = field_get_items('node',$node,'field_author');
	$field_location = field_get_items('node',$node,'field_location');
	$field_population = field_get_items('node',$node,'field_population');
	$field_ci_cost = field_get_items('node',$node,'field_ci_cost');
	$field_discount_rate = field_get_items('node',$node,'field_discount_rate');
	//$field_currency = field_has_data('field_currency'); //['und'][0]['taxonomy_term']->name;
	$field_currency = field_get_items('node',$node,'field_currency');
	$field_exchange_rate_to_usd = field_get_items('node',$node,'field_exchange_rate_to_usd');

	//print "<pre style='display: block; height: 500px; overflow-y: scroll'>".print_r($field_currency,1)."</pre>";
	if (isset($nid)){
		drupal_add_js(array('node' => array('values' => array('nid'=>$node->nid))),'setting');
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
					<div class="col-sm-8 project-info-value well well-sm"><?php print (isset($field_body) ? $field_body[0]['value'] : "-");  ?></div>
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
					<div class="col-sm-12"><h3 class="project-section-title">Effluent Standards</h3></div>
				</div>
				<div class="row" id="effluent-standard-name">
					<div class="col-sm-6">
						<?php 
							$project_form = drupal_get_form('wamex_project_form');
							$project_form['field_effluent_standard']['#prefix'] = '';
							$project_form['field_effluent_standard']['#suffix'] = '';
							$project_form['field_effluent_standard']['#attributes']['id'] = 'project-effluent-standard';
							$project_form['field_effluent_standard']['#title'] = t('Select a Standard');
							print drupal_render($project_form['field_effluent_standard']);
						?>
					</div>
				</div>
				<div class="row" id="effluent-standard-values">
					<div class="col-sm-2 project-effluent-attribute" id="project-effluent-cod"><label>COD</label><span class="well well-sm effluent-value">&nbsp;</span></div>
					<div class="col-sm-2 project-effluent-attribute" id="project-effluent-bod5"><label>BOD5</label><span class="well well-sm effluent-value">&nbsp;</span></div>
					<div class="col-sm-2 project-effluent-attribute" id="project-effluent-totn"><label>TotN</label><span class="well well-sm effluent-value">&nbsp;</span></div>
					<div class="col-sm-2 project-effluent-attribute" id="project-effluent-totp"><label>TotP</label><span class="well well-sm effluent-value">&nbsp;</span></div>
					<div class="col-sm-2 project-effluent-attribute" id="project-effluent-tss"><label>TSS</label><span class="well well-sm effluent-value">&nbsp;</span></div>
					<div class="col-sm-2"></div>
				</div>
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
			<button class="btn btn-primary btn-add-loading" id="add-loading-<?php print $node->nid; ?>"><span class="glyphicon glyphicon-plus"></span>&nbsp;Add Loading</button>
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