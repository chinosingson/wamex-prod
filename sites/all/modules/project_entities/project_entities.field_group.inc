<?php
/**
 * @file
 * project_entities.field_group.inc
 */

/**
 * Implements hook_field_group_info().
 */
function project_entities_field_group_info() {
  $export = array();

  $field_group = new stdClass();
  $field_group->disabled = FALSE; /* Edit this to true to make a default field_group disabled initially */
  $field_group->api_version = 1;
  $field_group->identifier = 'group_currency|node|project|form';
  $field_group->group_name = 'group_currency';
  $field_group->entity_type = 'node';
  $field_group->bundle = 'project';
  $field_group->mode = 'form';
  $field_group->parent_name = '';
  $field_group->data = array(
    'label' => 'Currency',
    'weight' => '5',
    'children' => array(
      0 => 'field_project_currency_name',
      1 => 'field_project_currency_code',
      2 => 'field_project_exchange_rate',
    ),
    'format_type' => 'fieldset',
    'format_settings' => array(
      'formatter' => 'collapsible',
      'instance_settings' => array(
        'description' => '',
        'classes' => 'group-currency field-group-fieldset',
        'required_fields' => 1,
      ),
    ),
  );
  $export['group_currency|node|project|form'] = $field_group;

  $field_group = new stdClass();
  $field_group->disabled = FALSE; /* Edit this to true to make a default field_group disabled initially */
  $field_group->api_version = 1;
  $field_group->identifier = 'group_reticulation|node|project|form';
  $field_group->group_name = 'group_reticulation';
  $field_group->entity_type = 'node';
  $field_group->bundle = 'project';
  $field_group->mode = 'form';
  $field_group->parent_name = '';
  $field_group->data = array(
    'label' => 'Reticulation',
    'weight' => '4',
    'children' => array(
      0 => 'field_reticulation_discount_rate',
      1 => 'field_reticulation_o_m',
      2 => 'field_reticulation_design_horz',
    ),
    'format_type' => 'fieldset',
    'format_settings' => array(
      'formatter' => 'collapsible',
      'instance_settings' => array(
        'description' => '',
        'classes' => 'group-reticulation field-group-fieldset',
        'required_fields' => 1,
      ),
    ),
  );
  $export['group_reticulation|node|project|form'] = $field_group;

  $field_group = new stdClass();
  $field_group->disabled = FALSE; /* Edit this to true to make a default field_group disabled initially */
  $field_group->api_version = 1;
  $field_group->identifier = 'group_treatment|node|project|form';
  $field_group->group_name = 'group_treatment';
  $field_group->entity_type = 'node';
  $field_group->bundle = 'project';
  $field_group->mode = 'form';
  $field_group->parent_name = '';
  $field_group->data = array(
    'label' => 'Treatment',
    'weight' => '3',
    'children' => array(
      0 => 'field_treatment_discount_rate',
      1 => 'field_treatment_o_m',
      2 => 'field_treatment_design_horizon',
    ),
    'format_type' => 'fieldset',
    'format_settings' => array(
      'formatter' => 'collapsible',
      'instance_settings' => array(
        'description' => '',
        'classes' => 'group-treatment field-group-fieldset',
        'required_fields' => 1,
      ),
    ),
  );
  $export['group_treatment|node|project|form'] = $field_group;

  return $export;
}
