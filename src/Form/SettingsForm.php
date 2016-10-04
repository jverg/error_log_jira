<?php

/**
 * @file
 * Contains Drupal\error_log_jira\Form\SettingsForm.
 */
namespace Drupal\error_log_jira\Form;

use Drupal\Core\Form\ConfigFormBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Logger\RfcLogLevel;

/**
 * Class SettingsForm
 * @package Drupal\error_log_jira\Form
 */
class SettingsForm extends ConfigFormBase {

  protected function getEditableConfigNames() {
    return [
      'error_log_jira.settings',
    ];
  }

  /**
   * {@inheritdoc}
   */
  public function getFormId()
  {
    return 'settings_form';
  }

  public function buildForm(array $form, FormStateInterface $form_state) {

    $config = $this->config('error_log_jira.settings');

    // Form for the key for the jira project.
    $form['key'] = array(
      '#type'          => 'textfield',
      '#title'         => $this->t('jira Project KEY'),
      '#default_value' => $config->get('error_log_jira_key'),
      '#description'   => t('Enter the KEY of your jira project.<br>
                           (NOT THE TITLE).'),
      '#required'      => TRUE,
      '#size'          => 10,
    );

    // The select form.
    $error_log_jira_options = array(
      '0'  => 'No Values',
      '1'  => '1',
      '6'  => '6',
      '10' => '10',
      '25' => '25',
    );

    $form['number_select'] = array(
      '#type'          => 'select',
      '#title'         => $this->t('Number of items to be checked.'),
      '#options'       => $error_log_jira_options,
      '#description'   => t('Select how many values do you want<br> to be
                             checked on every cron run.'),
      '#default_value' => $config->get('error_log_jira_number_select'),
    );

    // Checkboxes form.
    $form['jira_severity_levels'] = array(
      '#type'          => 'checkboxes',
      '#title'         => $this->t('Type of log messages'),
      '#options'       => RfcLogLevel::getLevels(),
      '#default_value' => $config->get('error_log_jira_severity_levels'),
      '#required'      => TRUE,
    );

    return parent::buildForm($form, $form_state);
  }

  public function validateForm(array &$form, FormStateInterface $form_state) {
    /*
     * Nothing to validate on this form
     */
  }

  public function submitForm(array &$form, FormStateInterface $form_state) {
    parent::submitForm($form, $form_state);

    $this->config('error_log_jira.settings')
      ->set('error_log_jira_key', $form_state->getValue('key'))
      ->set('error_log_jira_number_select', $form_state->getValue('number_select'))
      ->set('error_log_jira_severity_levels', $form_state->getValue('jira_severity_levels'))
      ->save();

  }
}
