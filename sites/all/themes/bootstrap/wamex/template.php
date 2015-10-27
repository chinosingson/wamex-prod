<?php

/**
 * @file
 * template.php
 */

 
function wamex_theme($variables) {
	
	return array(
		'project_node_form' => array(
			'arguments' => array('form' => NULL),
			'render element' => 'form',
			'path' => drupal_get_path('theme','wamex').'/templates',
			'template' => 'node--project--edit'),
		'loading_node_form' => array(
			'arguments' => array('form' => NULL),
			'render element' => 'form',
			'path' => drupal_get_path('theme','wamex').'/templates',
			'template' => 'node--loading--edit'),
	);
}

function wamex_preprocess_html(&$variables){
	$node = menu_get_object();
	$arg = arg();
	if ($arg[0] == 'dashboard' || $arg[0] == 'project' || (@is_object($node) && ($node->type == 'project' || $node->type == 'loading'))){
		drupal_add_js(drupal_get_path('theme', 'wamex') .'/script.js');
		drupal_add_css(drupal_get_path('module','wamex').'/js/formvalidation/css/formValidation.min.css',array('type'=>'file','group'=>CSS_THEME));
		//drupal_add_css(drupal_get_path('module','wamex').'/js/x-editable/css/bootstrap-editable.css',array('type'=>'file','group'=>CSS_THEME));
		//drupal_add_css(drupal_get_path('module','wamex').'/formvalidation/js/framework/bootstrap-select.min.css',array('type'=>'file','group'=>CSS_THEME));
	} /*else {
		
		drupal_set_message(print_r($variables),'error');
	}*/
}

function wamex_preprocess_views_view(&$variables) {
	$view = $variables['view'];
	//if (
	if($view->name == 'list_of_projects'){
		$variables['messages'] = theme('status_messages');
		//krumo($variables['messages']);
	}
}

function wamex_link($variables) {
	$output = '';
	/*$args = func_get_args();
	if ($variables['text'] == 'Edit' && $args[0]['options']['query']['destination'] == 'dashboard'){
		$output  .= "<pre>".print_r($args,1)."</pre>";
		$variables['options']['attributes']['class'][] = 'dashboard-edit-link';
		$variables['options']['attributes']['id'][] = 'dashboard-edit-link-';
		$output  .= print_r($variables['options']['attributes'],1);
	}*/
	$output .= '<a href="' . check_plain(url($variables ['path'], $variables ['options'])) . '"' . drupal_attributes($variables ['options']['attributes']) . '>' . ($variables ['options']['html'] ? $variables ['text'] : check_plain($variables ['text'])) . '</a>';
  return $output;
}

function wamex_form_alter(&$form, &$form_state, $form_id) {
	switch($form_id){
		case 'project_node_form':
		case 'wamex_project_form':
			$form['title']['#title'] = t('Project Name');
			$form['body'][LANGUAGE_NONE][0]['#format'] = 'plain_text';
			$form['body'][LANGUAGE_NONE][0]['#rows'] = 5;
			
			hide($form['body'][LANGUAGE_NONE][0]['summary']);
			//echo '<pre>'.print_r($form,1).'</pre>';
			break;
		case 'loading_node_form':
		case 'wamex_loading_form':
			//$form['actions']['submit']['#submit'][] = 'wamex_loading_submit_handler';
			if (isset($form['field_loading_project'])) { 
				drupal_set_title('Create Loading - '.$form['field_loading_project']['und']['#options'][1]);
			}
			$form['body'][LANGUAGE_NONE][0]['#rows'] = 5;
			hide($form['body'][LANGUAGE_NONE][0]['summary']);
			break;
	
	}
	
	return $form;
}


function wamex_form_element($variables) {
	$element = &$variables ['element'];

  // This function is invoked as theme wrapper, but the rendered form element
  // may not necessarily have been processed by form_builder().
  $element += array(
    '#title_display' => 'before',
  );

  // Add element #id for #type 'item'.
  if (isset($element ['#markup']) && !empty($element ['#id'])) {
    $attributes ['id'] = $element ['#id'];
  }
  // Add element's #type and #name as class to aid with JS/CSS selectors.
  $attributes ['class'] = array('form-item');
  if (!empty($element ['#type'])) {
    $attributes ['class'][] = 'form-type-' . strtr($element ['#type'], '_', '-');
  }
  if (!empty($element ['#name'])) {
    $attributes ['class'][] = 'form-item-' . strtr($element ['#name'], array(' ' => '-', '_' => '-', '[' => '-', ']' => ''));
  }
  // Add a class for disabled elements to facilitate cross-browser styling.
  if (!empty($element ['#attributes']['disabled'])) {
    $attributes ['class'][] = 'form-disabled';
  }
  $output = '<div' . drupal_attributes($attributes) . '>' . "\n";

  // If #title is not set, we don't display any label or required marker.
  if (!isset($element ['#title'])) {
    $element ['#title_display'] = 'none';
  }
  $prefix = isset($element ['#field_prefix']) ? '<span class="field-prefix">' . $element ['#field_prefix'] . '</span> ' : '';
  $suffix = isset($element ['#field_suffix']) ? ' <span class="field-suffix">' . $element ['#field_suffix'] . '</span>' : '';

	// theme the exchange rate field
	if($element['#id'] == 'edit-field-exchange-rate-to-usd-und-0-value'){
		// add a 'Refresh' button
		$suffix = '<a class="btn btn-primary" id="reset-exchange-rate" title="Reset exchange rate to default value">Refresh</a>';
	}

  switch ($element ['#title_display']) {
    case 'before':
    case 'invisible':
      $output .= ' ' . theme('form_element_label', $variables);
      $output .= ' ' . $prefix . $element ['#children'] . $suffix . "\n";
      break;

    case 'after':
      $output .= ' ' . $prefix . $element ['#children'] . $suffix;
      $output .= ' ' . theme('form_element_label', $variables) . "\n";
      break;

    case 'none':
    case 'attribute':
      // Output no label and no required marker, only the children.
      $output .= ' ' . $prefix . $element ['#children'] . $suffix . "\n";
      break;
  }

  if (!empty($element ['#description'])) {
    $output .= '<div class="description">' . $element ['#description'] . "</div>\n";
  }

  $output .= "</div>\n";
	return $output;
}

