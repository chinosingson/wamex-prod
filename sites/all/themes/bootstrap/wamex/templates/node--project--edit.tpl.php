<?php 
	$node = menu_get_object(); 
	@$nid = $node->nid;

	//echo "<pre style='height: 500px; overflow-y: scroll'>".print_r($form['body'],1)."</pre>";

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


