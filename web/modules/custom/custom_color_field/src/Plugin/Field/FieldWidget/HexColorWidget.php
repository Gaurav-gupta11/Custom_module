<?php

namespace Drupal\custom_color_field\Plugin\Field\FieldWidget;

use Drupal\Core\Field\FieldItemListInterface;
use Drupal\Core\Field\WidgetBase;
use Drupal\Core\Form\FormStateInterface;

/**
 * Plugin implementation of the 'hex_color_widget' widget.
 *
 * @FieldWidget(
 *   id = "hex_color_widget",
 *   module = "custom_color_field",
 *   label = @Translation("Hex Code RGB"),
 *   field_types = {
 *     "custom_color_field"
 *   }
 * )
 */
class HexColorWidget extends WidgetBase {

  /**
   * {@inheritdoc}
   */
  public function formElement(FieldItemListInterface $items, $delta, array $element, array &$form, FormStateInterface $form_state) {
    $value = isset($items[$delta]->color) ? $items[$delta]->color : '';
    $element += [
      '#type' => 'textfield',
      '#default_value' => $value,
      '#size' => 7,
      '#maxlength' => 7,
      '#element_validate' => [
        [static::class, 'validate'],
      ],
    ];
    return ['color' => $element];
  }

  /**
   * Validate the color text field.
   */
  public static function validate($element, FormStateInterface $form_state) {
    $value = $element['#value'];
    if (strlen($value) == 0) {
      $form_state->setValueForElement($element, '');
      return;
    }
    if (!preg_match('/^#([a-f0-9]{6})$/iD', strtolower($value))) {
      $form_state->setError($element, ("Color must be a 6-digit hexadecimal value, suitable for CSS."));
    }
  }

}
