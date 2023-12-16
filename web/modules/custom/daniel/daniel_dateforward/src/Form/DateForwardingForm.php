<?php
/**
 * @file
 * Contains \Drupal\judiciary_postpone_deadline\Form\PropertyForm.
 */
namespace Drupal\judiciary_postpone_deadline\Form;

use Drupal\Core\Entity\EntityStorageException;
use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\node\Entity\Node;
class DateForwardingForm extends FormBase {
  /**
   * {@inheritdoc}
   */

   public function getFormId() {
    return 'new_deadline_form';
}
public function buildForm(array $form, FormStateInterface $form_state, string $pv_id=Null): array
{
  $getPvIdFromQuery = $this->getRequest()->query->get('pvid');
  if(!$getPvIdFromQuery){
    $pv_id = '00000';
    \Drupal::messenger()->addMessage(t("PV Not FOUND!"), 'error');

  }else {
    $pv_id = $getPvIdFromQuery;
  }

 //get current date
  $loadCurrentDateFromPvId = $this->getCurrentDateFromPvId($pv_id);
  if(!$loadCurrentDateFromPvId){
    $current_due_date= date("Y-m-d");
    \Drupal::messenger()->addMessage(t("Current Date was not set, defaulted to today!"), 'warning');

  }else {
    $current_due_date = $loadCurrentDateFromPvId;
  }


  $form['payment_voucher_id'] = array (
    '#type' => 'textfield',
    '#title' => t('Payment Voucher ID:'),
    '#required' => TRUE,
    '#default_value' => $pv_id,
    '#disabled' => TRUE,
  );
  $form['current_deadline'] = array (
      '#type' => 'date',
      '#title' => t('Current Deadline:'),
      '#required' => TRUE,
      '#default_value' => $current_due_date,
    );
  $form['new_deadline'] = array (
    '#type' => 'date',
    '#title' => t('Enter New Deadline:'),
    '#required' => TRUE,
  );
  $form['reason'] = array (
    '#type' => 'text_format',
    '#title' => t('Reason for Postponement:'),
    '#required' => TRUE,
    '#default_value' => t('Reason for Postponement:'),
    '#format' => 'full_html',
    '#base_type' => 'textarea',
  );
  $form['actions']['#type'] = 'actions';
  $form['actions']['submit'] = array(
      '#type' => 'submit',
      '#value' => $this->t('PostPone'),
      '#button_type' => 'primary',
    );
    return $form;
  }

  public function validateForm(array &$form, FormStateInterface $form_state): void
  {
     //date must be in the future
    $date_now = date("Y-m-d");
    $new_deadline = $form_state->getValue('new_deadline');

    if($date_now > $new_deadline) {
      $form_state->setErrorByName('new_deadline', $this->t('Date must be in the future'));
    }
  }

  /**
   * @throws EntityStorageException
   */
  public  function submitForm(array &$form, FormStateInterface $form_state): void
  {
    //TODO: EXTRACT AS A METHOD (PV ENTITY CHECK)
    //load the pv and update the deadline with new value
    //update the PV entity

    $pv_id = $form_state->getValues()['payment_voucher_id'];
    try{
      $pv_entity = $this->getPvFromId($pv_id);

      if ($pv_entity) {
        $pv_entity->set('field_overdue_date', $form_state->getValues()['new_deadline']);
        $pv_entity->save();
      }
    }catch(\Exception $exception){
      \Drupal::messenger()->addMessage(t($exception));
    }


    //create new postponement history
    //TODO: FOR THE FIRST TIME IF TYPE DOES NOT EXIST CREATE IT
    //TODO: LOP THROUGH THE FILEDS IF THEY DO NOT EXIST CREATE
    //TODO: EXTRACT AS A METHOD (Postpone histoy creation)
    $postpone_deadline_history = Node::create(['type' => 'postponement_of_deadline']);
    $postpone_deadline_history->set('title', 'Deadline for PV ' . $form_state->getValue('payment_voucher_id'));
    $postpone_deadline_history->set('field_current_pv_deadline', $form_state->getValue('current_deadline'));
    $postpone_deadline_history->set('field_new_pv_deadline',$form_state->getValue('new_deadline') );
    $postpone_deadline_history->set('field_pv_id', $form_state->getValue('payment_voucher_id'));
    $postpone_deadline_history->set('field_reason_deadline_postpone',$form_state->getValue('reason')->value );

    $postpone_deadline_history->save();
    \Drupal::logger('Judiciary Postpone Deadline')->info('Deadline Postponed! from ' .
      $form_state->getValue('current_deadline').   ' to ' . $form_state->getValue('new_deadline') );
    \Drupal::messenger()->addMessage(t("Deadline Postponed!"));

  }

  /**
   * @param mixed $pv_id
   * @return mixed|null
   * @throws \Drupal\Component\Plugin\Exception\InvalidPluginDefinitionException
   * @throws \Drupal\Component\Plugin\Exception\PluginNotFoundException
   */
  public function getCurrentDateFromPvId(string $pv_id)
  {
    try{
      $pv_entity = $this->getPvFromId($pv_id);
      $current_due_date = null;
      if ($pv_entity) {
        $current_due_date = $pv_entity->get('field_overdue_date')->getValue()[0]['value'];
      }
    }catch(\Exception $exception){
      \Drupal::messenger()->addMessage(t($exception));
    }
    //load the pv and get the current date

    return $current_due_date;
  }
//TODO: just another single responsibility concept
//TODO: THE FUNCTION BELOW SHOULD BE REFACTORED IN TO A SERVICE IN PV_MODULE getPvFromId(string $pv_id)
  /**
   * @param mixed $pv_id
   * @return \Drupal\Core\Entity\EntityInterface|null
   * @throws \Drupal\Component\Plugin\Exception\InvalidPluginDefinitionException
   * @throws \Drupal\Component\Plugin\Exception\PluginNotFoundException
   */
  public function getPvFromId(string $pv_id): ?\Drupal\Core\Entity\EntityInterface
  {

    return \Drupal::entityTypeManager()->getStorage('jud_payment_voucher')->load($pv_id);

  }
}

