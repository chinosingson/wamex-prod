<?php
/**
 * @file
 * project_entities.features.uuid_term.inc
 */

/**
 * Implements hook_uuid_features_default_terms().
 */
function project_entities_uuid_features_default_terms() {
  $terms = array();

  $terms[] = array(
    'name' => 'US Dollar',
    'description' => '',
    'format' => 'filtered_html',
    'weight' => 0,
    'uuid' => '603695c3-c3d0-4d65-997f-41e8fa69dbf3',
    'vocabulary_machine_name' => 'currency',
    'field_exchange_rate' => array(
      'und' => array(
        0 => array(
          'value' => 1,
        ),
      ),
    ),
    'field_currency_code' => array(
      'und' => array(
        0 => array(
          'value' => 'USD',
          'format' => NULL,
          'safe_value' => 'USD',
        ),
      ),
    ),
  );
  $terms[] = array(
    'name' => 'Philippine Peso',
    'description' => '',
    'format' => 'filtered_html',
    'weight' => 0,
    'uuid' => '627f2bf2-fbf6-469d-8611-7ca3283e6d54',
    'vocabulary_machine_name' => 'currency',
    'field_exchange_rate' => array(
      'und' => array(
        0 => array(
          'value' => 44.22,
        ),
      ),
    ),
    'field_currency_code' => array(
      'und' => array(
        0 => array(
          'value' => 'PHP',
          'format' => NULL,
          'safe_value' => 'PHP',
        ),
      ),
    ),
  );
  return $terms;
}
