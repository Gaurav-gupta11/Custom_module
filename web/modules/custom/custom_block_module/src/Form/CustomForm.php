<?php


namespace Drupal\custom_block_module\Form;

use Drupal\Core\Form\ConfigFormBase;
use Drupal\Core\Form\FormStateInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Drupal\Core\Routing\RouteMatchInterface;

/**
 * Implements a custom form.
 */
class CustomForm extends ConfigFormBase {

  /**
   * The current route match.
   *
   * @var \Drupal\Core\Routing\RouteMatchInterface
   */
  protected $routeMatch;

  /**
   * CustomForm constructor.
   *
   * @param \Drupal\Core\Routing\RouteMatchInterface $route_match
   *   The current route match.
   */
  public function __construct(RouteMatchInterface $route_match) {
    $this->routeMatch = $route_match;
  }

  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container) {
    return new static(
      $container->get('current_route_match')
    );
  }
  /**
   * {@inheritdoc}
   */
  public function getFormId() {
    return 'custom_module_block_form';
  }

  public function getEditableConfigNames(){
    return [
			'custom_block_module.settings',
		];
  }
  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state) {
    $num_groups = $form_state->get('num_groups') ?? 1;

    $form['groups'] = [
      '#type' => 'fieldset',
      '#title' => $this->t('Groups'),
      '#prefix' => '<div id="groups-wrapper">',
      '#suffix' => '</div>',
    ];
    $form['#tree'] = TRUE;

    for ($i = 0; $i < $num_groups; $i++) {
      $form['groups'][$i]['group_name'] = [
        '#type' => 'textfield',
        '#title' => $this->t('Name of the group'),
      ];

      $form['groups'][$i]['habitations_label'] = [
        '#type' => 'textfield',
        '#title' => $this->t('Name of the 1st label'),
      ];

      $form['groups'][$i]['habitations_value'] = [
        '#type' => 'textfield',
        '#title' => $this->t('Name of the 1st value of 1st label'),
      ];

      $form['groups'][$i]['people_label'] = [
        '#type' => 'textfield',
        '#title' => $this->t('Name of the 2nd label'),
      ];

      $form['groups'][$i]['people_value'] = [
        '#type' => 'textfield',
        '#title' => $this->t('Name of the 2nd value of 2nd label'),
      ];
    }

    $form['actions']['remove_group'] = [
      '#type' => 'submit',
      '#value' => $this->t('Remove'),
      '#submit' => ['::removeCallback'],
      '#ajax' => [
        'callback' => '::addMoreCallback',
        'wrapper' => 'groups-wrapper',
      ],
    ];

    $form['actions']['add_group'] = [
      '#type' => 'submit',
      '#value' => $this->t('Add more'),
      '#submit' => ['::addMore'],
      '#ajax' => [
        'callback' => '::addMoreCallback',
        'wrapper' => 'groups-wrapper',
      ],
    ];

    return parent::buildForm($form, $form_state);
  }

/**
 * {@inheritdoc}
 */
public function submitForm(array &$form, FormStateInterface $form_state) {
  // Retrieve the configuration name dynamically based on some condition.
  $config_name = 'custom_block_module.settings'; // Replace this with your dynamic configuration name.

  // Retrieve the configuration.
  $config = $this->config($config_name);

  // Get the number of groups from the form state.
  $num_groups = $form_state->get('num_groups') ?? 1;

  // Loop through each group and set the configuration settings.
  for ($i = 0; $i < $num_groups; $i++) {
    $group_name = $form_state->getValue(['groups', $i, 'group_name']);
    $habitations_label = $form_state->getValue(['groups', $i, 'habitations_label']);
    $habitations_value = $form_state->getValue(['groups', $i, 'habitations_value']);
    $people_label = $form_state->getValue(['groups', $i, 'people_label']);
    $people_value = $form_state->getValue(['groups', $i, 'people_value']);

    // Set the configuration values for each group.
    $config->set('group_' . $i . '_name', $group_name)
      ->set('group_' . $i . '_habitations_label', $habitations_label)
      ->set('group_' . $i . '_habitations_value', $habitations_value)
      ->set('group_' . $i . '_people_label', $people_label)
      ->set('group_' . $i . '_people_value', $people_value);
  }

  // Set the number of groups in the configuration.
  $config->set('num_groups', $num_groups);

  // Save the configuration.
  $config->save();

  parent::submitForm($form, $form_state);
}

  /**
   * Ajax callback for adding more group fields.
   */
  public function addMore(array &$form, FormStateInterface $form_state) {
    $num_groups = $form_state->get('num_groups') ?? 1;
    $form_state->set('num_groups', $num_groups + 1);
    $form_state->setRebuild();
  }

  /**
   * Ajax callback for removing group fields.
   */
  public function removeCallback(array &$form, FormStateInterface $form_state) {
    $num_groups = $form_state->get('num_groups') ?? 1;
    $form_state->set('num_groups', $num_groups - 1);
    $form_state->setRebuild();
  }

  /**
   * Ajax callback for rebuilding the form.
   */
  public function addMoreCallback(array &$form, FormStateInterface $form_state) {
    return $form['groups'];
  }

}
