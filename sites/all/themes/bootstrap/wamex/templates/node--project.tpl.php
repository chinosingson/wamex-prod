	<?php
$node = menu_get_object(); 
$nid = $node->nid;
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
<div id="project-page-<?php print $nid; ?>" class="panel-group" role="tablist" aria-multiselectable="false">
	<div id="project-info-container" class="container-fluid panel panel-default">
		<div id="project-information" class="col-sm-12 col-md-12 col-lg-12 panel-heading" role="tab" id="heading-project-info">
			<div class="row" id="project-info-title-container">
				<div class="col-sm-12">
					<h3 class="project-section-title panel-title" id="project-info-title"><a href="#" role="button" data-toggle="collapse" data-target="#collapse-project-info" aria-expanded="true" aria-controls="collapse-project-info"><span id="toggle-project-info" class="heading-arrow glyphicon glyphicon-chevron-up"></span>Project Information</a></h3>
				<?php if ($editProjectPerm): ?><a href="<?php print base_path(); ?>project/edit/<?php print $node->nid; ?>" class="btn btn-primary btn-sm pull-right" id="edit-project-<?php print $nid; ?>"><span class="glyphicon glyphicon-pencil"></span>&nbsp;Edit</a><?php endif; ?>
				</div>
			</div>
		</div>
		<div class="panel-collapse collapse in" id="collapse-project-info" role="tabpanel" aria-labelledby="heading-project-info">
			<table class="table panel-body">
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
						<td class="project-info-value col-sm-7 col-md-7 col-lg-7"><?php print (isset($field_location) ? $field_location[0]['value']: "-"); ?></td>
					</tr>
					<tr>
						<td class="project-info-label col-sm-5 col-md-5 col-lg-5"><label>Population</label></td>
						<td class="project-info-value col-sm-7 col-md-7 col-lg-7"><?php print (isset($field_population) ? $field_population[0]['value']: "-"); ?></td>
					</tr>
					<tr>
						<td class="project-info-label col-sm-5 col-md-5 col-lg-5"><label>Description</label></td>
						<td class="project-info-value col-sm-7 col-md-7 col-lg-7"><?php print (isset($field_body) ? $field_body[0]['value'] : "-");  ?></td>
					</tr>
					<tr>
						<td class="project-info-label col-sm-5 col-md-5 col-lg-5"><label>Currency</label></td>
						<td class="project-info-value col-sm-7 col-md-7 col-lg-7"><?php print (isset($field_currency) ? $node->field_currency['und'][0]['taxonomy_term']->name : "-"); ?></td>
					</tr>
					<tr>
						<td class="project-info-label col-sm-5 col-md-5 col-lg-5"><label>Exchange Rate</label></td>
						<td class="project-info-value col-sm-7 col-md-7 col-lg-7"><?php print (isset($field_exchange_rate_to_usd) ? $field_exchange_rate_to_usd[0]['value']: "-"); ?></td>
					</tr>
					<tr>
						<td class="project-info-label col-sm-5 col-md-5 col-lg-5"><label>Discount Rate</label></td>
						<td class="project-info-value col-sm-7 col-md-7 col-lg-7"><?php print (isset($field_discount_rate) ? $field_discount_rate[0]['value']: "-"); ?></td>
					</tr>
					<tr>
						<td class="project-info-label col-sm-5 col-md-5 col-lg-5"><label>Capital Investment Cost</label></td>
						<td class="project-info-value col-sm-7 col-md-7 col-lg-7"><?php print (isset($field_ci_cost) ? $field_ci_cost[0]['value']: "-"); ?></td>
					</tr>
				</tbody>
			</table>
		</div>
	</div>

	<div id="loading-list-container" class="container-fluid panel panel-default">
		<div  id="heading-loading-list" class="panel-heading" role="tab">
			<div id="loading-title-container">
				<h3 class="project-section-title panel-title" id="loading-list-title"><a href="#" role="button" data-toggle="collapse" data-target="#collapse-loading-list" aria-expanded="true" aria-controls="collapse-loading-list"><span id="toggle-loading-list" class="heading-arrow glyphicon glyphicon-chevron-up"></span>Wastewater Characterisation</a></h3>
				<?php if ($addLoadingPerm):?><button class="btn btn-primary btn-sm btn-add-loading pull-right" id="add-loading-<?php print $nid; ?>"><span class="glyphicon glyphicon-plus"></span>&nbsp;Add</button><?php endif; ?>
			</div>
		</div>
		<div id="collapse-loading-list" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="heading-loading-list">
			<div class="panel-body">
				<a name="loading-list"></a>
				<div class="table-responsive" id="loading-form-container"></div>
				<div id="loading-view-container">
					<div id="loading-list-container"><?php $view_loading->set_arguments(array($nid)); $view_loading->pre_execute(); $view_loading->execute(); print $view_loading->render(); ?></div>
				</div>
				<div id="loading-actions-container"></div>
			</div>
		</div>
	</div>

	<div id="standards-container" class="container-fluid panel panel-default">
		<div id="heading-standards" class="panel-heading" role="tab">
			<div id="standards-title-container">
				<h3 id="standards-title" class="project-section-title panel-title"><a href="#collapse-standards" role="button" data-toggle="collapse"  aria-expanded="true" aria-controls="collapse-standards"><span id="toggle-standards" class="heading-arrow glyphicon glyphicon-chevron-up"></span>Effluent Standards</a></h3>
				<button class="btn btn-xs btn-default pull-right" id="standards-help">?</button>
				<div id="standards-messages"></div>
			</div>
		</div>
		<div id="collapse-standards" class="row table-responsive panel-collapse collapse in" role="tabpanel" aria-labelledby="heading-standards">
			<div class="panel-body">
				<?php 
					$effl_output = "";
					$effl_form = drupal_get_form('wamex_project_effl_form',$nid);
					$effl_form['field_effluent_standard']['#title'] = t('Standard');
					$effl_form['actions']['submit']['#attributes']['class'][] = 'btn-sm';
					$effl_header = array(
						//array('data' => t('Standard'), 'class'=>array('tech-attributes','tech-attributes-header','tech-name','col-name')) ,
						array('data' => $effl_form['field_effluent_standard']['#title'], 'class'=>array('col-sm-5','tech-attributes','tech-attributes-header','tech-name','col-name')) ,
						array('data' => $effl_form['field_cod']['#title'], 'class'=>array('col-sm-1','tech-attributes','tech-attributes-cod','tech-cod','col-cod')),
						array('data' => $effl_form['field_bod5']['#title'], 'class'=>array('col-sm-1','tech-attributes','tech-attributes-bod5','tech-bod5','col-bod5')),
						array('data' => $effl_form['field_totn']['#title'], 'class'=>array('col-sm-1','tech-attributes','tech-attributes-totn','tech-totn','col-totn')),
						array('data' => $effl_form['field_totp']['#title'], 'class'=>array('col-sm-1','tech-attributes','tech-attributes-totp','tech-totp','col-totp')),
						array('data' => $effl_form['field_tss']['#title'], 'class'=>array('col-sm-1','tech-attributes','tech-attributes-totp','tech-tss','col-tss')),
						array('data' => t('&nbsp;')),
						array('data' => t('&nbsp;')),
						array('data' => t('&nbsp;')),
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
						array('data' => ($editProjectPerm ? $effl_form['actions']['submit'] : t('wala'))),
						array('data' => t('&nbsp;')),
						array('data' => t('&nbsp;')),
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

	<div id="loading-tech-container" class="container-fluid panel panel-default">
		<div id="heading-tech" class="panel-heading" role="tab">
			<div id="tech-title-container">
				<h3 id="loading-tech-title" class="project-section-title panel-title" ><a href="#" role="button" data-toggle="collapse" data-target="#collapse-tech" aria-expanded="true" aria-controls="collapse-tech"><span id="toggle-tech" class="heading-arrow glyphicon glyphicon-chevron-up"></span>Suitable Technologies</a></h3>
				<button class="btn btn-primary btn-sm btn-show-tech pull-right" id="show-tech-<?php print $nid; ?>"><span class="glyphicon glyphicon-chevron-right"></span>&nbsp;Show</button>
			</div>
		</div>
		<div id="collapse-tech" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="heading-tech">
			<div id="loading-tech-list"></div>
		</div>
	</div>
	<hr/>
</div>
<?php else: ?>
<div>No node information.</div>
<?php endif; ?>