<?php

/**
 * @file
 * Generates routes for admin and editor. Functionality in this 
 * Controller is wired to Drupal in demo_route.routing.yml.
 */

namespace Drupal\demo_route\Controller;

use Drupal\Core\Controller\ControllerBase;
use Symfony\Component\HttpFoundation\Response;

class RouteController extends ControllerBase {

	public function simpleContent() {
		return [
			'#type' => 'markup',
			'#markup' => ('Hello Drupal world.
						Time flies like an arrow.'),
		];
	}
}
?>