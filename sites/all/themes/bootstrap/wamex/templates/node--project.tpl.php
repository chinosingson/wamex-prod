<?php

if ($node){
	//echo "<pre style='display: none; height: 500px; overflow-y: scroll'>".print_r($node,1)."</pre>";
	//krumo($node);
	//$nid = field_get_items('node',$node,'nid');
	$nid = $node->nid;
	if (isset($nid)){
		drupal_add_js(array('node' => array('values' => array('nid'=>$node->nid))),'setting');
	}
}

$field_author = field_get_items('node',$node,'field_author');
$field_location = field_get_items('node',$node,'field_location');
$field_population = field_get_items('node',$node,'field_population');
$field_ci_cost = field_get_items('node',$node,'field_ci_cost');
$field_discount_rate = field_get_items('node',$node,'field_discount_rate');
$field_currency = field_get_items('node',$node,'field_currency');
$field_exchange_rate_to_usd = field_get_items('node',$node,'field_exchange_rate_to_usd');


//krumo($field_currency);

$view_loading = views_get_view('loading');
$view_loading->set_display('block');


?>

<div id="project-page-<?php print $node->nid; ?>">
	<div class="container-fluid">
		<div class="row">
			<div class="col-sm-12"><h3 class="project-section-title">Project Information</h3></div>
		</div>
		<div class="row">
			<div class="col-sm-2 project-info"><h4>Author</h4><?php print (isset($field_author) ? print_r($field_author[0]['value'],1) : "wala"); ?></div>
			<div class="col-sm-2 project-info"><h4>Location</h4><?php print (isset($field_location) ? print_r($field_location[0]['value'],1): "wala"); ?></div>
			<div class="col-sm-8 project-info"><h4>Description</h4><?php print $node->body['und'][0]['value']; ?></div>
		</div>
		<div class="row">
			<div class="col-sm-2 project-info"><h4>Population</h4><?php print (isset($field_population) ? print_r($field_population[0]['value'],1): "wala"); ?></div>
			<div class="col-sm-2 project-info"><h4>CI Cost</h4><?php print (isset($field_ci_cost) ? print_r($field_ci_cost[0]['value'],1): "wala"); ?></div>
			<div class="col-sm-2 project-info"><h4>Discount Rate</h4><?php print (isset($field_discount_rate) ? print_r($field_discount_rate[0]['value'],1): "wala"); ?></div>
			<div class="col-sm-2 project-info"><h4>Currency</h4><?php print (isset($field_currency) ? print_r($field_currency[0]['taxonomy_term']->name,1): "wala"); ?></div>
			<div class="col-sm-2 project-info"><h4>Exchange Rate</h4><?php print (isset($field_exchange_rate_to_usd) ? print_r($field_exchange_rate_to_usd[0]['value'],1): "wala"); ?></div>
		</div>
	</div>
	<hr/>
	<div class="container-fluid">
		<div class="row">
			<div class="col-sm-12"><h3 class="project-section-title">Loading/WW Characterisation</h3></div>
		</div>
		<div class="row">
			<div class="col-sm-12" id="loading-list-container">
				<?php $view_loading->set_arguments(array($nid)); $view_loading->pre_execute(); $view_loading->execute();
				print $view_loading->render(); ?>
			</div>
		</div>
		<div class="row">
			<div class="col-sm-12">
				<a class="btn btn-default" href="add/loading<?php print "/".$nid; ?>" id="add-loading">Add Loading</a>
				<a class="btn btn-default disabled" id="refresh-loading-list">Reload List</a>
			</div>
		</div>
		<div class="row">
			<div class="col-sm-12" id="loading-form-container">
				<?php 
/* 				
module_load_include('inc', 'node', 'node.pages');

$form = node_add('loading');
$output = drupal_render($form);
	print $output; */
				?>
			</div>
		</div>
	</div>
	<hr/>
	<div class="container-fluid">
		<div class="row">
			<div class="col-sm-12"><h3 class="project-section-title">Suitable Technologies</h3></div>
		</div>
		<div class="row">
			<div class="col-sm-12">technologies</div>
		</div>
	</div>
	<hr/>
</div>