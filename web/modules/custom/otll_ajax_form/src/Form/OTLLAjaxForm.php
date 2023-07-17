<?php

namespace Drupal\otll_ajax_form\Form;

use Drupal\Core\Ajax\AjaxResponse;
use Drupal\Core\Ajax\MessageCommand;
use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;

/**
 * @class OTLLForm
 *  Form to generate one time login link.
 */
class OTLLAjaxForm extends FormBase 
{
  /**
   * {@inheritdoc}
   */
	public function getFormId() {
    return 'otll_ajax_form';
  }

	/**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state) {
    $form['user_name'] = [
      '#type' => 'textfield',
      '#title' => $this->t('User name:'),
      '#required' => TRUE,
      '#description' => $this->t('Enter user name to generate one time login link.'),
    ];

    $form['submit'] = [
      '#type' => 'submit',
      '#value' => $this->t('Generate'),
      '#ajax' => [
        'callback' => '::ajaxHandler'
      ]
    ];

    return $form;
  }

	/**
   * @method ajaxHandler
   *   Handles the AJAX request.
   */
  public function ajaxHandler(array &$form,  FormStateInterface $form_state) {
    // Fetching user name from the form data.
    $username = $form_state->getValue('user_name');
    // Fetching user object.
    $user = user_load_by_name($username);
    $response = new AjaxResponse();
    if ($user) {
      $url = user_pass_reset_url($user);
      $response->addCommand(new MessageCommand($this->t('one time login link for the given username is: <br> @url', 
        ['@url' => $url])));
    }

    return $response;
  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state)
  {
    // Nothing to do here since handling form submission via AJAX.
  }
}