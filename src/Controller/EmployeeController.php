<?php

/**
 * @file
 * Contains \Drupal\employee\Controller\EmployeeController.
 */
namespace Drupal\employee\Controller;
use Drupal\Core\Controller\ControllerBase;
use Drupal\Core\Link;
use Drupal\Core\Url;

/**
 * Class EmployeeController.
 * 
 * @package Drupal\employee\Controller
 */
class EmployeeController extends ControllerBase {
    /**
     * Welcome.
     * 
     * @return string
     *   Return Hello string.
     */
    public function employee() {
        $employee = [];
        // Query employee from table employee.
        $query = \Drupal::database()->select('employee', 'f')
          ->fields('f', ['pid', 'firstname', 'lastname', 'age']);
        $results = $query->execute();
    
        $options = array(
          'attributes' => ['class' => ['link']],
          'absolute'   => TRUE,
        );

        foreach($results->fetchAll() as $item) {
          $employee[] = array(
            'firstname' => $item->firstname,
            'lastname' => $item->lastname,
            'age' => $item->age,
            // 'pid' => Link::fromTextAndUrl(t('Edit'), Url::fromUri('internal:/employee-form/manage/' . $item->pid, $options))->toString()
          );
        }

        // $employee = [
        //     [
        //         'firstname' => 'Roald',
        //         'lastname' => 'Umandal',
        //         'age' => 26
        //     ],
        //     [
        //         'firstname' => 'Prince',
        //         'lastname' => 'Cervo',
        //         'age' => 16
        //     ],
        //     [
        //         'firsname' => 'Jiliane',
        //         'lastname' => 'Cervo',
        //         'age' => 7
        //     ]
        // ];
        // $employee = array();
        return [
            '#theme' => 'employee_template',
            '#header' => ['First Name', 'Last Name', 'Age'],
            // '#header' => ['First Name', 'Last Name', 'Age', 'Operation'],
            '#rows' => $employee
        ];
    }
}