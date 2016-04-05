<?php

namespace Drupal\error_log_jira\Controller;

use Drupal\Core\Field\Plugin\Field\FieldType\StringItem;
use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Logger\RfcLogLevel;
use Drupal\Core\StringTranslation\TranslatableMarkup;

class AddForm extends FormBase {

  function getFormID() {
    return 'error_log_jira_list';
  }

  public function buildForm(array $form, FormStateInterface $form_state) {

    // Form for the key for the jira project.
    $form['key'] = array(
      '#type'          => 'textfield',
      '#title'         => t('jira Project KEY'),
//      '#default_value' => variable_get('error_log_jira_key', ''),
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
      '#title'         => t('Number of items to be checked.'),
      '#options'       => $error_log_jira_options,
      '#description'   => t('Select how many values do you want<br> to be
                             checked on every cron run.'),
//      '#default_value' => variable_get('error_log_jira_number_select', '0'),
    );

    // Checkboxes form.
    $form['jira_severity_levels'] = array(
      '#type'          => 'checkboxes',
      '#title'         => t('Type of log messages'),
      '#options'       => RfcLogLevel::getLevels(),
      '#required'      => TRUE,
    );

    // Submit form for the "Save" button.
    $form['submit'] = array(
      '#type'  => 'submit',
      '#value' => t('Save'),
    );

    return $form;
  }

  public function validateForm(array &$form, FormStateInterface $form_state) {
    /*
     * Nothing to validate on this form
     */
  }

  public function submitForm(array &$form, FormStateInterface $form_state) {
    $jira_key = $form_state['values']['key'];
    $jira_number = $form_state['values']['number_select'];
    $jira_severity_levels = $form_state['values']['jira_severity_levels'];
    drupal_set_message(t('Your settings has been saved'));
    $form_state['redirect'] = 'error_log_jira';
    return;
  }
}
