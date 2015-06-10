<?php
/**
 * @file
 * loading.features.inc
 */

/**
 * Implements hook_ctools_plugin_api().
 */
function loading_ctools_plugin_api($module = NULL, $api = NULL) {
  if ($module == "strongarm" && $api == "strongarm") {
    return array("version" => "1");
  }
}

/**
 * Implements hook_node_info().
 */
function loading_node_info() {
  $items = array(
    'loading' => array(
      'name' => t('Loading'),
      'base' => 'node_content',
      'description' => t('Define a loading within a project'),
      'has_title' => '1',
      'title_label' => t('Loading name'),
      'help' => '',
    ),
  );
  drupal_alter('node_info', $items);
  return $items;
}
