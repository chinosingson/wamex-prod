<?php 
	$node = menu_get_object(); 
	@$nid = $node->nid;
	if (!$nid) {
		$nid = arg(3);
		//drupal_add_js(array('node' => array('values' => array('nid'=>$node->nid))),'setting');
		$form['field_loading_project'][LANGUAGE_NONE]['#value'] = $nid;
		//$form['field_loading_project'][LANGUAGE_NONE][0]['target_id']['#value'] = $nid;
	}
	
	//if ($title) { 
	//echo "";
	//drupal_set_title ('123');
	//print "title: ".$title;
	//} 

?><?php //print_r($variables); //['title']; ?>
	<div id="project-forms-container" class="form-container container-fluid"><?php //print $nid; ?>
		<div class="row">
			<div class="col-sm-12"><?php print drupal_render($form['title']); ?></div>
		</div>
		<div class="row">
			<div class="col-sm-12"><?php print drupal_render($form['body']); ?></div>
		</div>
		<div class="row">
			<div class="col-sm-6" id="loading-project-container"><?php print drupal_render($form['field_loading_project']); ?></div>
			<div class="col-sm-6"><?php 
				//print_r($form['field_loading_project'][LANGUAGE_NONE][0]);
				//echo "<pre style='height: 500px; overflow-y: scroll'>".print_r($form['field_loading_project'][LANGUAGE_NONE],1)."</pre>";
				?>
			</div>
		</div>
		<div id="project-forms-buttons" class="row"><?php print drupal_render_children($form); ?></div>
	</div>


