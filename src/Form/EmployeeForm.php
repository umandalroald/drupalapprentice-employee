<?php

/**
 * @file
 * Contains \Drupal\employee\Form\EmployeeForm.
 */

namespace Drupal\employee\Form;

use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Component\Utility\UrlHelper;
use Symfony\Component\HttpFoundation\RedirectResponse;

/**
 * Employee form.
 */
class EmployeeForm extends FormBase {
    /**
     * {@inheritdoc}
     */
    public function getFormId() {
        return 'employee_form';
    }
  
    /**
     * {@inheritdoc}
     */
    public function buildForm(array $form, FormStateInterface $form_state) {

      $form['firstname'] = array(
          '#type' => 'textfield',
          '#title' => t('First Name'),
          '#required' => TRUE,
        );

        $form['lastname'] = array(
          '#type' => 'textfield',
          '#title' => t('Last Name'),
        );
        $form['age'] = array(
          '#type' => 'textfield',
          '#title' => t('Age'),
        );

        $form['submit'] = array(
          '#type' => 'submit',
          '#value' => t('Submit'),
        );
        return $form;
    }
  
    /**
     * {@inheritdoc}
     */
    // public function validateForm(array &$form, FormStateInterface $form_state) {
    // // Validate Age int.
    //     if (!is_int($form_state->getValue('age'))) {
    //       $form_state->setErrorByName('age', $this->t("Age must be int"));
    //     }
    // }
  
    /**
     * {@inheritdoc}
     */
    public function submitForm(array &$form, FormStateInterface $form_state) {
      $field = $form_state->getValues();

      $employee_information = array(
        'uid' => 0,
        'firstname' => $field['firstname'],
        'lastname' => $field['lastname'],
        'age' => $field['age']
      );

      $query = \Drupal::database();
      $query ->insert('employee')
          ->fields($employee_information)
          ->execute();

      drupal_set_message('New employee is successfully created ' . $field['firstname'] . ' ' . $field['lastname']);

      $response = new RedirectResponse("/employee");
      $response->send();
    }
  }