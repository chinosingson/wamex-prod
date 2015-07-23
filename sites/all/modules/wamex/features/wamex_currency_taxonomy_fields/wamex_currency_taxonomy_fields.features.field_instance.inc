<?php
/**
 * @file
 * wamex_currency_taxonomy_fields.features.field_instance.inc
 */

/**
 * Implements hook_field_default_field_instances().
 */
function wamex_currency_taxonomy_fields_field_default_field_instances() {
  $field_instances = array();

  // Exported field_instance: 'taxonomy_term-currency-field_currency_code'
  $field_instances['taxonomy_term-currency-field_currency_code'] = array(
    'bundle' => 'currency',
    'default_value' => NULL,
    'deleted' => 0,
    'description' => '',
    'display' => array(
      'default' => array(
        'label' => 'above',
        'module' => 'text',
        'settings' => array(),
        'type' => 'text_default',
        'weight' => 1,
      ),
    ),
    'entity_type' => 'taxonomy_term',
    'field_name' => 'field_currency_code',
    'label' => 'Currency Code',
    'required' => 0,
    'settings' => array(
      'text_processing' => 0,
      'user_register_form' => FALSE,
    ),
    'widget' => array(
      'active' => 1,
      'module' => 'text',
      'settings' => array(
        'size' => 20,
      ),
      'type' => 'text_textfield',
      'weight' => 2,
    ),
  );

  // Exported field_instance: 'taxonomy_term-currency-field_exchange_rate'
  $field_instances['taxonomy_term-currency-field_exchange_rate'] = array(
    'bundle' => 'currency',
    'default_value' => NULL,
    'deleted' => 0,
    'description' => '',
    'display' => array(
      'default' => array(
        'label' => 'above',
        'module' => 'number',
        'settings' => array(
          'decimal_separator' => '.',
          'prefix_suffix' => TRUE,
          'scale' => 2,
          'thousand_separator' => ' ',
        ),
        'type' => 'number_decimal',
        'weight' => 0,
      ),
    ),
    'entity_type' => 'taxonomy_term',
    'field_name' => 'field_exchange_rate',
    'label' => 'Exchange Rate',
    'required' => 0,
    'settings' => array(
      'max' => '',
      'min' => 0,
      'prefix' => '',
      'suffix' => '',
      'user_register_form' => FALSE,
    ),
    'widget' => array(
      'active' => 0,
      'module' => 'number',
      'settings' => array(),
      'type' => 'number',
      'weight' => 1,
    ),
  );

  // Translatables
  // Included for use with string extractors like potx.
  t('Currency Code');
  t('Exchange Rate');

  return $field_instances;
}
