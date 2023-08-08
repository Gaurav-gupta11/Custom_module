<?php 

namespace Drupal\custom_color_field\Plugin\Field\FieldType;

use Drupal\Core\Field\FieldItemBase;
use Drupal\Core\Field\FieldStorageDefinitionInterface;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\TypedData\DataDefinition;

/**
 * Defines the 'custom_color_field' field type.
 *
 * @FieldType(
 *   id = "custom_color_field",
 *   label = @Translation("Custom color field"),
 *   category = @Translation("Custom"),
 * )
 */
final class ColorField extends FieldItemBase {
  
    /**
     * {@inheritdoc}
     */

     public static function schema(FieldStorageDefinitionInterface $field_definition) {
      return [
          'columns' => [
              'color' => [
                  'type' => 'varchar',
                  'length' => $field_definition->getSetting("length"),
              ],
          ],
      ];
  }

  /**
   * {@inheritdoc}
   */
  public static function defaultStorageSettings() {
      return [
          'length' => 255,
      ] + parent::defaultStorageSettings();
  }

  /**
   * {@inheritdoc}
   */
  public function storageSettingsForm(array &$form, FormStateInterface $form_state, $has_data) {
      $element = [];

      $element['length'] = [
          '#type' => 'number',
          '#title' => ("Length of your text"),
          '#required' => TRUE,
          '#default_value' => $this->getSetting("length"),
      ];
      return $element;
  }

  

  /**
   * {@inheritdoc}
   */
  public static function propertyDefinitions(FieldStorageDefinitionInterface $field_definition) {
      $properties['color'] = DataDefinition::create('string')->setLabel(("Name"));

      return $properties;
  }
}