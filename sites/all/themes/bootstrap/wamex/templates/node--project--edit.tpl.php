<?php 
	$node = menu_get_object(); 
	@$nid = $node->nid;

	//echo "<pre style='height: 500px; overflow-y: scroll'>".print_r($form['field_author'],1)."</pre>";

?>

	<div id="project-forms-container" class="form-container container-fluid">
		<?php print drupal_render($form['title']); ?>
		<?php print drupal_render($form['field_location']); ?>
		<?php print drupal_render($form['field_population']); ?>
		<?php print drupal_render($form['body']); ?>
		<?php print drupal_render($form['field_author']); ?>
		<?php print drupal_render($form['field_discount_rate']); ?>
		<?php print drupal_render($form['field_ci_cost']); ?>
		<?php print drupal_render($form['field_currency']); ?>
		<?php print drupal_render($form['field_exchange_rate_to_usd']); ?>
		<div id="project-forms-buttons" class="row"><?php print drupal_render_children($form); ?></div>
	</div>


