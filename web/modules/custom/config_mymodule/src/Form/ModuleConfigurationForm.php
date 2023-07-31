<?php

namespace Drupal\config_mymodule\Form;

use Drupal\Core\Form\ConfigFormBase;
use Drupal\Core\Form\FormStateInterface;

/**
 * Form for taking user information
 */
class ModuleConfigurationForm extends ConfigFormBase {
	/**
	 * {@inheritDoc}
	 */
	public function getFormId() {
		return 'config_mymodule_admin_settings';
	}

	/**
	 * {@inheritDoc}
	 */
	public function getEditableConfigNames() {
		return [
			'config_mymodule.admin_settings',
		];
	}

	/**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state) {
    $config = $this->config('config_mymodule.admin_settings');

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
		];

		$form['email'] = [
			'#type' => 'email',
			'#title' => $this->t('Email ID'),
			'#default_value' => $config->get('email'),
      '#required' => TRUE,
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
		return parent::buildForm($form, $form_state);
	}

	/**
   * {@inheritdoc}
   */
  public function validateForm(array &$form, FormStateInterface $form_state) {
    $email = $form_state->getValue('email');
    $phoneNumber = $form_state->getValue('phone_number');

    // Validate phone number.
    if (!is_numeric($phoneNumber) || strlen($phoneNumber) != 10) {
      $form_state->setErrorByName('phone_number', $this->t('Phone number should be a 10-digit number.'));
    }

    // Validate email.
    if (!\Drupal::service('email.validator')->isValid($email)) {
      $form_state->setErrorByName('email', $this->t('Invalid email format.'));
    }
    elseif (!preg_match('/@(yahoo|gmail|outlook)\.com$/', $email)) {
      $form_state->setErrorByName('email', $this->t('Email address should be from Yahoo, Gmail, or Outlook.'));
    }
  }

	/**
   * {@inheritdoc}
   */
	public function submitForm(array &$form, FormStateInterface $form_state) {
    $submitted_name = $form_state->getValue('full_name');
    $this->messenger()->addMessage($this->t("Congrats @user Your Form submitted Successfully", ['@user' => $submitted_name]));
  }


}