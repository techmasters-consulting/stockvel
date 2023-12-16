<?php
/**
 * @file
 * Contains \Drupal\judiciary_postpone_deadline\Controller\PropertyController.
 */
namespace Drupal\daniel_property\Controller;


use Drupal\Core\Controller\ControllerBase;
use Symfony\Component\HttpFoundation\Request;

/**
 * An example controller.
 */
class PropertyController extends ControllerBase {

  /**
   * Returns a render-able array for a test page.
   */
  public function viewPropertyDossier(Request $request, string $property_id=null): array
  {
    $getPropertyIdFromQuery = $request->query->get('pid');
    $property_id = $getPropertyIdFromQuery;
    //load pv

    //get cause number, pvid, payer and physical and function organisation
    //set them in the header.

    return [

      'viewHeader' => [
        '#type' => 'view',
        '#name' => 'p_header_details',
        '#display_id' => 'block_1',
        '#arguments' => [$property_id],
        '#embed' => TRUE,
      ],

      'formHead' => [
        '#markup' => t('Use the form below to add a new property '),
      ],
      'form' => \Drupal::formBuilder()->getForm('Drupal\daniel_property\Form\PropertyForm'),
      'header' => [
        '#prefix' => '<h2>',
        '#suffix' => '</h2>',
        '#markup' => t('Audit History for  Property'. $property_id ),
      ],
      //TODO: PV ENTITY SHOULD BE LINKED
      'view' => [
        '#type' => 'view',
        '#title' => 'view',
        '#name' => 'deadline_postponement_history',
        '#display_id' => 'block_1',
        '#arguments' => [$property_id],
        '#embed' => TRUE,
      ],




    ];

  }

}
