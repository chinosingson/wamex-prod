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


function wamex_form_alter(&$form, &$form_state, $form_id) {
	if ($form_id == 'project_node_form'){
		$form['title']['#title'] = t('Project Name');
		$form['body'][LANGUAGE_NONE][0]['#title'] = t('Description');
		$form['body'][LANGUAGE_NONE][0]['#format'] = 'plain_text';
		$form['body'][LANGUAGE_NONE][0]['#rows'] = 5;
		
		hide($form['body'][LANGUAGE_NONE][0]['summary']);
	}
	
	if($form_id == 'loading_node_form'){
		$form['body'][LANGUAGE_NONE][0]['#title'] = t('Description');
		$form['body'][LANGUAGE_NONE][0]['#rows'] = 5;
		hide($form['body'][LANGUAGE_NONE][0]['summary']);
	
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

	if($element['#id'] == 'edit-field-exchange-rate-to-usd-und-0-value'){
		//$output .= "[".$element ['#id']."]";
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