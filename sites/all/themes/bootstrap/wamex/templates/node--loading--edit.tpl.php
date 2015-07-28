<?php 
	$node = menu_get_object(); 
	@$nid = $node->nid;

?>
	<div id="project-forms-container" class="form-container container-fluid">
		<div class="row">
			<div class="col-sm-12"><?php print drupal_render($form['title']); ?></div>
		</div>
		<div class="row">
			<div class="col-sm-12"><?php print drupal_render($form['body']); ?></div>
		</div>
		<div id="project-forms-buttons" class="row"><?php print drupal_render_children($form); ?></div>
	</div>


