<?php
namespace Drupal\custom_color_field\Plugin\Field\FieldFormatter;

use Drupal\Core\Field\FieldItemListInterface;
use Drupal\Core\Field\FormatterBase;

/**
 * Plugin implementation of the 'text' formatter.
 *
 * @FieldFormatter(
 *   id = "custom_field_text",
 *   label = @Translation("Text"),
 *   field_types = {"custom_color_field"},
 * )
 */
 class ColorFormatter extends FormatterBase {

  /**
   * {@inheritdoc}
   */
  public function viewElements(FieldItemListInterface $items, $langcode): array {
    $element = [];
    foreach ($items as $delta => $item) {
      $element[$delta] = [
        '#markup' => $item->color,
      ];
    }
    return $element;
  }

}