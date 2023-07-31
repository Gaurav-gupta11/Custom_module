<?php

namespace Drupal\config_mymodule\Form;

use Drupal\Core\Form\ConfigFormBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Ajax\AjaxResponse;
use Drupal\Core\Ajax\HtmlCommand;

/**
 * Form for taking user information
 */
class AjaxCustomForm extends ConfigFormBase {
	/**
	 * {@inheritDoc}
	 */
	public function getFormId() {
		return 'config_mymodule_ajax_customform';
	}

	/**
	 * {@inheritDoc}
	 */
	public function getEditableConfigNames() {
		return [
			'config_mymodule.ajax_customform',
		];
	}

	/**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state) {
    $config = $this->config('config_mymodule.ajax_customform');

		$form['element'] = [
			'#type' => 'markup',
			'#markup' => "<div class='success'></div>",
		];

    $form['full_name'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Full Name'),
      '#default_value' => $config->get('full_name'),
      '#required' => TRUE,
    ];

		$form['phone_number'] = [
			'#type' => 'tel',
			'#title' => $this->t('Phone Number'),
			'#default_value' => $config->get('phone_number'),
      '#required' => TRUE,
			'#suffix' => '<div class = "error" id = "phone_number"></div>'
		];

		$form['email'] = [
			'#type' => 'email',
			'#title' => $this->t('Email ID'),
			'#default_value' => $config->get('email'),
      '#required' => TRUE,
			'#suffix' => '<div class = "error" id = "email"></div>'
		];

		$form['gender'] = [
			'#type' => 'radios',
			'#title' => $this->t('Gender'),
			'#options' => [
        'male' => $this->t('Male'),
        'female' => $this->t('Female'),
        'other' => $this->t('Other'),
      ],
			'#default_value' => $config->get('gender'),
      '#required' => TRUE,
		];

		$form['submit'] = [
      '#type' => 'submit',
      '#value' => $this->t("I know the risks, Clear Cache!"),
			'#ajax' => [
						'callback' => '::validateAjax',
			],
		];

		$form['#attatched']['library'][] = 'config_mymodule/config_mymodule_css';
		return $form;
	}

	/**
   * Validates user input values and throws error.
   */ 
  public function validateAjax(array &$form, FormStateInterface $form_state) {
		$ajax_response = new AjaxResponse();
    
    $email = $form_state->getValue('email');
    $phoneNumber = $form_state->getValue('phone_number');

		$valid = TRUE;
    // Validate phone number.
    if (!is_numeric($phoneNumber) || strlen($phoneNumber) != 10) {
      $ajax_response->addCommand(new HtmlCommand('#phone_number', 
        $this->t('It should be a 10 digit number')));
      $valid = FALSE;
    }

    // Validate email.
    if (!\Drupal::service('email.validator')->isValid($email)) {
			$ajax_response->addCommand(new HtmlCommand('#email', $this->t('Invalid email format.')));
    }
    elseif (!preg_match('/@(yahoo|gmail|outlook)\.com$/', $email)) {
      $ajax_response->addCommand(new HtmlCommand('#email', $this->t('Email address should be from Yahoo, Gmail, or Outlook.')));
    }
		if ($valid) {
		$ajax_response->addCommand(new HtmlCommand('.success', 'Form submitted successfully'));
		}
		return $ajax_response;
  }

	/**
   * {@inheritdoc}
   */
	public function submitForm(array &$form, FormStateInterface $form_state) {
			//Nothing to write
  }


}