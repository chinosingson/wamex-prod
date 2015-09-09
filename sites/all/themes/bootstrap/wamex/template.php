<?php

/**
 * @file
 * template.php
 */
drupal_add_js(drupal_get_path('theme', 'wamex') .'/script.js');

 
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

function wamex_preprocess_views_view(&$variables) {
	$view = $variables['view'];
	//if (
	if($view->name == 'list_of_projects'){
		$variables['messages'] = theme('status_messages');
		//krumo($variables['messages']);
	}
}



function wamex_form_alter(&$form, &$form_state, $form_id) {
	switch($form_id){
		case 'project_node_form':
		case 'project_node_form_ajax':
			$form['actions']['submit']['#submit'][] = 'wamex_project_submit_handler';
			$form['title']['#title'] = t('Project Name');
			$form['body'][LANGUAGE_NONE][0]['#title'] = t('Description');
			$form['body'][LANGUAGE_NONE][0]['#format'] = 'plain_text';
			$form['body'][LANGUAGE_NONE][0]['#rows'] = 5;
			
			hide($form['body'][LANGUAGE_NONE][0]['summary']);
			//echo '<pre>'.print_r($form,1).'</pre>';
			break;
		case 'loading_node_form':
			$form['actions']['submit']['#submit'][] = 'wamex_loading_submit_handler';
			if (isset($form['field_loading_project'])) { 
				drupal_set_title('Create Loading - '.$form['field_loading_project']['und']['#options'][1]);
			}
			$form['body'][LANGUAGE_NONE][0]['#title'] = t('Description');
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

function wamex_loading_submit_handler($form, &$form_state) {
  if ($form_state['node']->nid) {
  
    
    //popup_element(t(''), t("Your project has been submitted"));
	
	//drupal_set_message(t('1'.$form_state['redirect']));

	$form_state['redirect'] = 'node/'.$form_state['node']->field_loading_project[LANGUAGE_NONE][0]['target_id'];
	//drupal_set_message(t('2.'.print_r($form_state['redirect'])));
	
					$path =  array(
						t('thank-you'),
						array(
							'query' => array(
							'destination' => t('node'),
							),
						),
					);
	
	//$form_state['redirect'] = $path;
  }
}

function wamex_project_submit_handler($form, &$form_state) {
  if ($form_state['node']->nid) {
  
    
    //popup_element(t(''), t("Your project has been submitted"));
	
	//drupal_set_message(t($form_state['redirect']));

	//$form_state['redirect'] = 'node/'.$form_state['node']->field_loading_project[LANGUAGE_NONE][0]['target_id'];
	$form_state['redirect'] = 'dashboard';
	//drupal_set_message(t('3.'.print_r($form_state['redirect'])));
	
					$path =  array(
						t('thank-you'),
						array(
							'query' => array(
							'destination' => t('dashboard'),
							),
						),
					);
	
	//$form_state['redirect'] = $path;
  }
}