<?php
/**
 * @file
 * wamex_views_loading.views_default.inc
 */

/**
 * Implements hook_views_default_views().
 */
function wamex_views_loading_views_default_views() {
  $export = array();

  $view = new view();
  $view->name = 'loading';
  $view->description = '';
  $view->tag = 'default';
  $view->base_table = 'node';
  $view->human_name = 'Loading';
  $view->core = 7;
  $view->api_version = '3.0';
  $view->disabled = FALSE; /* Edit this to true to make a default view disabled initially */

  /* Display: Master */
  $handler = $view->new_display('default', 'Master', 'default');
  $handler->display->display_options['title'] = 'Loading Available';
  $handler->display->display_options['use_more_always'] = FALSE;
  $handler->display->display_options['access']['type'] = 'perm';
  $handler->display->display_options['cache']['type'] = 'none';
  $handler->display->display_options['query']['type'] = 'views_query';
  $handler->display->display_options['exposed_form']['type'] = 'basic';
  $handler->display->display_options['pager']['type'] = 'some';
  $handler->display->display_options['pager']['options']['items_per_page'] = '5';
  $handler->display->display_options['style_plugin'] = 'table';
  /* Field: Content: Title */
  $handler->display->display_options['fields']['title']['id'] = 'title';
  $handler->display->display_options['fields']['title']['table'] = 'node';
  $handler->display->display_options['fields']['title']['field'] = 'title';
  $handler->display->display_options['fields']['title']['alter']['word_boundary'] = FALSE;
  $handler->display->display_options['fields']['title']['alter']['ellipsis'] = FALSE;
  /* Field: Content: Edit link */
  $handler->display->display_options['fields']['edit_node']['id'] = 'edit_node';
  $handler->display->display_options['fields']['edit_node']['table'] = 'views_entity_node';
  $handler->display->display_options['fields']['edit_node']['field'] = 'edit_node';
  $handler->display->display_options['fields']['edit_node']['text'] = 'edit';
  /* Sort criterion: Content: Post date */
  $handler->display->display_options['sorts']['created']['id'] = 'created';
  $handler->display->display_options['sorts']['created']['table'] = 'node';
  $handler->display->display_options['sorts']['created']['field'] = 'created';
  $handler->display->display_options['sorts']['created']['order'] = 'DESC';
  /* Contextual filter: Content: Project (field_loading_project) */
  $handler->display->display_options['arguments']['field_loading_project_target_id']['id'] = 'field_loading_project_target_id';
  $handler->display->display_options['arguments']['field_loading_project_target_id']['table'] = 'field_data_field_loading_project';
  $handler->display->display_options['arguments']['field_loading_project_target_id']['field'] = 'field_loading_project_target_id';
  $handler->display->display_options['arguments']['field_loading_project_target_id']['default_action'] = 'default';
  $handler->display->display_options['arguments']['field_loading_project_target_id']['default_argument_type'] = 'node';
  $handler->display->display_options['arguments']['field_loading_project_target_id']['summary']['number_of_records'] = '0';
  $handler->display->display_options['arguments']['field_loading_project_target_id']['summary']['format'] = 'default_summary';
  $handler->display->display_options['arguments']['field_loading_project_target_id']['summary_options']['items_per_page'] = '25';
  /* Filter criterion: Content: Published */
  $handler->display->display_options['filters']['status']['id'] = 'status';
  $handler->display->display_options['filters']['status']['table'] = 'node';
  $handler->display->display_options['filters']['status']['field'] = 'status';
  $handler->display->display_options['filters']['status']['value'] = 1;
  $handler->display->display_options['filters']['status']['group'] = 1;
  $handler->display->display_options['filters']['status']['expose']['operator'] = FALSE;
  /* Filter criterion: Content: Type */
  $handler->display->display_options['filters']['type']['id'] = 'type';
  $handler->display->display_options['filters']['type']['table'] = 'node';
  $handler->display->display_options['filters']['type']['field'] = 'type';
  $handler->display->display_options['filters']['type']['value'] = array(
    'loading' => 'loading',
  );

  /* Display: Block */
  $handler = $view->new_display('block', 'Block', 'block');
  $export['loading'] = $view;

  return $export;
}
