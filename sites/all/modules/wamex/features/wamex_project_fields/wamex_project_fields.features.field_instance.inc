<?php
/**
 * @file
 * wamex_project_fields.features.field_instance.inc
 */

/**
 * Implements hook_field_default_field_instances().
 */
function wamex_project_fields_field_default_field_instances() {
  $field_instances = array();

  // Exported field_instance: 'node-project-field_currency'
  $field_instances['node-project-field_currency'] = array(
    'bundle' => 'project',
    'default_value' => array(
      0 => array(
        'tid' => 2,
      ),
    ),
    'deleted' => 0,
    'description' => '',
    'display' => array(
      'default' => array(
        'label' => 'above',
        'module' => 'taxonomy',
        'settings' => array(),
        'type' => 'taxonomy_term_reference_link',
        'weight' => 8,
      ),
      'teaser' => array(
        'label' => 'above',
        'settings' => array(),
        'type' => 'hidden',
        'weight' => 0,
      ),
    ),
    'entity_type' => 'node',
    'field_name' => 'field_currency',
    'label' => 'Currency',
    'required' => 0,
    'settings' => array(
      'user_register_form' => FALSE,
    ),
    'widget' => array(
      'active' => 1,
      'module' => 'options',
      'settings' => array(),
      'type' => 'options_select',
      'weight' => 4,
    ),
  );

  // Translatables
  // Included for use with string extractors like potx.
  t('Currency');

  return $field_instances;
}
