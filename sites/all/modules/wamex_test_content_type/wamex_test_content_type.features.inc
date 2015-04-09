<?php
/**
 * @file
 * wamex_test_content_type.features.inc
 */

/**
 * Implements hook_node_info().
 */
function wamex_test_content_type_node_info() {
  $items = array(
    'test' => array(
      'name' => t('Test'),
      'base' => 'node_content',
      'description' => '',
      'has_title' => '1',
      'title_label' => t('Title'),
      'help' => '',
    ),
  );
  drupal_alter('node_info', $items);
  return $items;
}
