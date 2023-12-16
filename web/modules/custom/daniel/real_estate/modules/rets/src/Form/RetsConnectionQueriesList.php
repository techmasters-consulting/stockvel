<?php

namespace Drupal\real_estate_rets\Form;

use Drupal\Core\Entity\EntityForm;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Render\Element;
use Drupal\Core\Url;

/**
 * Builds the query set customize form.
 */
class RetsConnectionQueriesList extends EntityForm {

  /**
   * The entity being used by this form.
   *
   * @var \Drupal\real_estate_rets\RetsConnectionInterface
   */
  protected $entity;

  /**
   * {@inheritdoc}
   */
  public function form(array $form, FormStateInterface $form_state) {

    $this->entity = $this->getEntity();

    $form = parent::form($form, $form_state);
    $form['queries'] = [
      '#tree' => TRUE,
      '#weight' => -20,
    ];

    $form['queries'] = [
      '#type' => 'table',
      '#header' => [
        $this->t('Name'),
        $this->t('Weight'),
        $this->t('Operations'),
      ],
      '#empty' => $this->t('No queries available. <a href=":link">Add a query</a>', [':link' => $this->url('entity.real_estate_rets_connection.add_query_form', ['real_estate_rets_connection' => $this->entity->id()])]),
      '#attributes' => ['id' => 'queries'],
      '#tabledrag' => [
        [
          'action' => 'order',
          'relationship' => 'sibling',
          'group' => 'query-weight',
        ],
      ],
    ];

    foreach ($this->entity->getQueries() as $query) {
      $id = $query->id();

      $form['queries'][$id]['#attributes']['class'][] = 'draggable';
      $form['queries'][$id]['name'] = [
        '#type' => 'item',
        '#title' => $query->label(),
      ];
      unset($form['queries'][$id]['name']['#access_callback']);
      $form['queries'][$id]['#weight'] = $query->weight();
      $form['queries'][$id]['weight'] = [
        '#type' => 'weight',
        '#title' => $this->t('Weight for @title', ['@title' => $query->label()]),
        '#title_display' => 'invisible',
        '#default_value' => $query->weight(),
        '#attributes' => ['class' => ['query-weight']],
      ];

      $links['edit'] = [
        'title' => $this->t('Edit'),
        'url' => Url::fromRoute('entity.real_estate_rets_connection.edit_query_form', [
          'real_estate_rets_connection' => $this->entity->id(),
          'connection_query' => $query->id(),
        ]),
      ];
      $links['delete'] = [
        'title' => $this->t('Delete'),
        'url' => Url::fromRoute('entity.real_estate_rets_connection.delete_query_form', [
          'real_estate_rets_connection' => $this->entity->id(),
          'connection_query' => $query->id(),
        ]),
      ];

      $form['queries'][$id]['operations'] = [
        '#type' => 'operations',
        '#links' => $links,
      ];
    }
    return $form;
  }

  /**
   * {@inheritdoc}
   */
  protected function actions(array $form, FormStateInterface $form_state) {
    // Only includes a Save action for the entity, no direct Delete button.
    return [
      'submit' => [
        '#type' => 'submit',
        '#value' => $this->t('Save'),
        '#access' => (bool) Element::getVisibleChildren($form['queries']),
        '#submit' => ['::submitForm', '::save'],
      ],
    ];
  }

  /**
   * {@inheritdoc}
   */
  public function save(array $form, FormStateInterface $form_state) {
    foreach ($this->entity->getQueries() as $query) {

      $weight = 1;
      /** @var \Drupal\real_estate_rets\RetsConnectionInterface $this->entity */
      $this->entity->setQueryWeight($query->id(), $weight);
    }
    $this->entity->save();
    $this->messenger()->addStatus($this->t('The query set has been updated.'));
  }

}
