<?php 
	$node = menu_get_object(); 
	@$nid = $node->nid;
	//if ($node){
	//	krumo($node);
	//}

	// load taxonomy tree for currency
	$currency_taxonomy = taxonomy_vocabulary_machine_name_load('currency');
	$currency_taxonomy_tree = taxonomy_get_tree($currency_taxonomy->vid,0);
	//echo "<pre style='height: 500px; overflow-y: scroll'>".print_r($currency_taxonomy_tree,1)."</pre>";
	// get all term ids
	$currency_tids = array();
	foreach($currency_taxonomy_tree as $term) {
		$currency_tids[] = $term->tid;
	}
	// load all terms
	$currency_terms = taxonomy_term_load_multiple($currency_tids);
	
	// add terms to Drupal.settings
	// access in JS via Drupal.settings.taxonomy.currency
	drupal_add_js(array('taxonomy' => array('currency' => $currency_terms)), 'setting');
	//echo "<pre style='height: 500px; overflow-y: scroll'>".print_r($node,1)."</pre>";
	if ($node){
		$exchRate = field_get_items('node',$node,'field_exchange_rate_to_usd');
		if (isset($exchRate)){
			drupal_add_js(array('node' => array('values' => array('field_exchange_rate_to_usd'=>$node->field_exchange_rate_to_usd[LANGUAGE_NONE][0]['value']))),'setting');
		}
	} else {
			drupal_add_js(array('node' => array('values' => array('field_exchange_rate_to_usd'=>0))),'setting');
	}
?>
	<?php //print $messages; ?>
	<div id="project-forms-container" class="form-container container-fluid">
		<div class="row">
			<div class="col-sm-12"><?php print drupal_render($form['title']); ?></div>
		</div>
		<div class="row">
			<div class="col-sm-12"><?php print drupal_render($form['field_location']); ?></div>
		</div>
		<div class="row">
			<div class="col-sm-6"><?php print drupal_render($form['field_population']); ?></div>
		</div>
		<div class="row">
			<div class="col-sm-12"><?php print drupal_render($form['body']); ?></div>
		</div>
		<div class="row">
			<div class="col-sm-6"><?php print drupal_render($form['field_author']); ?></div>
		</div>
		<div class="row">
			<div class="col-sm-6"><?php print drupal_render($form['field_discount_rate']); ?></div>
		</div>
		<div class="row">
			<div class="col-sm-6"><?php print drupal_render($form['field_ci_cost']); ?></div>
		</div>
		<div class="row">
			<div class="col-sm-6"><?php print drupal_render($form['field_land_cost']); ?></div>
		</div>
		<div class="row">
			<div class="col-sm-6"><?php print drupal_render($form['field_currency']); ?></div>
			<div class="col-sm-6"><?php print drupal_render($form['field_exchange_rate_to_usd']); ?>
			</div>
		</div>
		<div id="project-forms-buttons" class="row"><?php print drupal_render_children($form); ?></div>
	</div>


