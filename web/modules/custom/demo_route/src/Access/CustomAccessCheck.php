<?php

namespace Drupal\demo_route\Access;

use Drupal\Core\Access\AccessResult;
use Drupal\Core\Routing\Access\AccessInterface;
use Drupal\Core\Session\AccountInterface;
use Symfony\Component\Routing\Route;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class MyCustomAccessCheck
 * @package Drupal\mymodule\Access
 */
class CustomAccessCheck implements AccessInterface
{
  /**
   * @return string
   */
  public function appliesTo()
  {
    return '_mycustom_access_check';
  }

  /**
   * @param Route $route
   * @param Request $request
   * @param AccountInterface $account
   * @return AccessResult|\Drupal\Core\Access\AccessResultAllowed
   */
  public function access(Route $route, Request $request, AccountInterface $account) {
    // Get the roles assigned to the account
    $roles = $account->getRoles();
  
    // Check if the account has the 'content_editor' or 'administrator' role
    if (in_array('content_editor', $roles) || in_array('administrator', $roles)) {
      return AccessResult::allowed();
    } else {
      return AccessResult::forbidden();
    }
  }
  
  
}
?>