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
