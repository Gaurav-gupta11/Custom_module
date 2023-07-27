<?php

namespace Drupal\custom_block_module\Plugin\Block;

use Drupal\Core\Block\BlockBase;
use Drupal\Core\Session\AccountInterface;

/**
 * Provides a 'Custom Welcome' block.
 * 
 * @Block(
 * 	id = "custom_welcome_block",
 * 	admin_label = @Translation("Custom Welcome Block"),
 * 	category = @Translation("Custom")
 * )
 */
class CustomWelcomeBlock extends BlockBase {

	/**
	 * {@inheritDoc}
	 */
	public function build() {
		$user = \Drupal::currentUser();
		$roles = $user->getRoles();
		$welcome_message = $this->t('Welcome @roles', ['@roles' => implode(', ', $roles)]);
		return [
      '#markup' => $welcome_message,
    ];
	}
}
