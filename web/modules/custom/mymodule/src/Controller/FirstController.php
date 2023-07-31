<?php

/**
 * @file
 * Generates markup to be displayed. Functionality in this 
 * Controller is wired to Drupal in mymodule.routing.yml.
 */

namespace Drupal\mymodule\Controller;

use Drupal\Core\Controller\ControllerBase;
use Symfony\Component\HttpFoundation\Response;

class FirstController extends ControllerBase {

	public function simpleContent() {
		return [
			'#type' => 'markup',
			'#markup' => ('Hello Drupal world.
						Time flies like an arrow.'),
		];
	}

	public function helloPage($name) {
    $output = 'Hello ' . $name;
    return new Response($output);
}	
}
?>