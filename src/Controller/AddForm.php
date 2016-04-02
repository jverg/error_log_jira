<?php

namespace Drupal\error_log_jira\Controller;

use Drupal\Core\Form\FormInterface;
use Drupal\Core\Form\FormStateInterface;

class AddForm implements FormInterface {

  function getFormID() {
    return 'error_log_jira_add';
  }

  function buildForm(array $form, FormStateInterface $form_state) {
    $form['name'] = array(
      '#type' => 'textfield',
      '#title' => t('Name'),
    );
    $form['message'] = array(
      '#type' => 'textarea',
      '#title' => t('Message'),
    );
    $form['actions'] = array(
      '#type' => 'actions'
    );
    $form['actions']['submit'] = array(
      '#type' => 'submit',
      '#value' => t('Add'),
    );
    return $form;
  }

  function validateForm(array &$form, FormStateInterface $form_state) {
    /*
     * Nothing to validate on this form
     */
  }

  function submitForm(array &$form, FormStateInterface $form_state) {
    $name = $form_state['values']['name'];
    $message = $form_state['values']['message'];
    BdContactStorage::add(check_plain($name), check_plain($message));
    watchdog('bd_contact', 'BD Contact message from %name has been submitted.', array('%name' => $name));
    drupal_set_message(t('Your message has been submitted'));
    $form_state['redirect'] = 'admin/content/bd_contact';
    return;
  }
}
