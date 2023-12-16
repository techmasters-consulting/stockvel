<?php
/**
 * @file
 * Contains \Drupal\judiciary_postpone_deadline\Controller\PropertyController.
 */
namespace Drupal\daniel_dateforward\Controller;


use Drupal\Core\Controller\ControllerBase;
use Symfony\Component\HttpFoundation\Request;

/**
 * An example controller.
 */
class DateForwardingController extends ControllerBase {

  /**
   * Returns a render-able array for a test page.
   */
  public function viewDateForwardingHistory(Request $request, string $pv_id=null): array
  {
    $getPvIdFromQuery = $request->query->get('pvid');
    $pv_id = $getPvIdFromQuery;
    //load pv

    //get cause number, pvid, payer and physical and function organisation
    //set them in the header.

    return [

      'viewHeader' => [
        '#type' => 'view',
        '#name' => 'pv_header_details',
        '#display_id' => 'block_1',
        '#arguments' => [$pv_id],
        '#embed' => TRUE,
      ],

      'formHead' => [
        '#markup' => t('Use the form below to postpone a deadline '),
      ],
      'form' => \Drupal::formBuilder()->getForm('Drupal\judiciary_postpone_deadline\Form\PropertyForm'),
      'header' => [
        '#prefix' => '<h2>',
        '#suffix' => '</h2>',
        '#markup' => t('Postponement History for  PV'. $pv_id ),
      ],
      //TODO: PV ENTITY SHOULD BE LINKED
      'view' => [
        '#type' => 'view',
        '#title' => 'view',
        '#name' => 'deadline_postponement_history',
        '#display_id' => 'block_1',
        '#arguments' => [$pv_id],
        '#embed' => TRUE,
      ],




    ];

  }

}
