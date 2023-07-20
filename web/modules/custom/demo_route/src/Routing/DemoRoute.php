<?php

namespace Drupal\demo_route\Routing;

use Drupal\Core\Routing\RouteSubscriberBase;
use Symfony\Component\Routing\RouteCollection;

/**
 * Listens to the dynamic route events.
 */
class DemoRoute extends RouteSubscriberBase {

  /**
   * {@inheritdoc}
   */
  protected function alterRoutes(RouteCollection $collection) {
    // Remove editor role access for 'mymodule.admin_editor_route'.
    if ($route = $collection->get('demo_route.route')) {
      $route->setRequirement('_role', 'administrator');
    }
  }

}

?>