<?php
/**
 * @file
 * wamex_views_dashboard.features.user_permission.inc
 */

/**
 * Implements hook_user_default_permissions().
 */
function wamex_views_dashboard_user_default_permissions() {
  $permissions = array();

  // Exported permission: 'administer views'.
  $permissions['administer views'] = array(
    'name' => 'administer views',
    'roles' => array(
      'administrator' => 'administrator',
    ),
    'module' => 'views',
  );

  return $permissions;
}
