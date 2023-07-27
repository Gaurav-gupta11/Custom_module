<?php
namespace Drupal\custom_block_module\Plugin\Block;

use Drupal\Core\Block\BlockBase;

/**
 * Provides a custom block with the form data.
 *
 * @Block(
 *   id = "custom_form_block",
 *   admin_label = @Translation("Custom Form Block"),
 * )
 */
class CustomFormBlock extends BlockBase {

  /**
   * {@inheritdoc}
   */
  public function build() {
    // Retrieve the configuration name dynamically based on some condition.
    $config_name = 'custom_block_module.settings'; // Replace this with your dynamic configuration name.

    // Load the configuration data.
    $config = \Drupal::config($config_name);
    $content = [];

    // Get the number of groups from the configuration data.
    $num_groups = $config->get('num_groups') ?? 1;
    // Loop through each group and add it to the $content array.
    for ($i = 0; $i < $num_groups; $i++) {
      $group = [
        'group_name' => $config->get('group_' . $i . '_name'),
        'habitations_label' => $config->get('group_' . $i . '_habitations_label'),
        'habitations_value' => $config->get('group_' . $i . '_habitations_value'),
        'people_label' => $config->get('group_' . $i . '_people_label'),
        'people_value' => $config->get('group_' . $i . '_people_value'),
      ];
      $content[] = $group;
    }

    return [
      '#theme' => 'custom_form_data_block',
      '#content' => $content,
    ];
  }
}
?>