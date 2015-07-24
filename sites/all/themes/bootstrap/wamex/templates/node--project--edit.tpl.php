<?php 
	$node = menu_get_object(); 
	@$nid = $node->nid;

	$currency_taxonomy = taxonomy_vocabulary_machine_name_load('currency');
	$currency_taxonomy_tree = taxonomy_get_tree($currency_taxonomy->vid,0);
	//echo "<pre style='height: 500px; overflow-y: scroll'>".print_r($currency_taxonomy_tree,1)."</pre>";
	
	$currency_tids = array();
	foreach($currency_taxonomy_tree as $term) {
		//echo print_r($term,1)."<br/>";
		$currency_tids[] = $term->tid;
	}
	
	$currency_terms = taxonomy_term_load_multiple($currency_tids);
	//$currency_terms_json = drupal_json_encode($currency_terms);
	//echo "<pre style='height: 500px; overflow-y: scroll'>".$currency_taxonomy_tree_json."</pre>";
	
	//drupal_add_js('','inline');
	drupal_add_js(array('taxonomy' => array('currency' => $currency_terms)), 'setting');
?>

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
			<div class="col-sm-6"><?php print drupal_render($form['field_currency']); ?></div>
			<div class="col-sm-6"><?php print drupal_render($form['field_exchange_rate_to_usd']); ?></div>
		</div>
		<div id="project-forms-buttons" class="row"><?php print drupal_render_children($form); ?></div>
	</div>


