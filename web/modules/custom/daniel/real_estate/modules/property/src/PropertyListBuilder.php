<?php

namespace Drupal\real_estate_property;

use Drupal\Core\Entity\EntityInterface;
use Drupal\Core\Entity\EntityListBuilder;
use Drupal\Core\Link;

/**
 * Defines a class to build a listing of Property entities.
 *
 * @ingroup real_estate_property
 */
class PropertyListBuilder extends EntityListBuilder {

  /**
   * {@inheritdoc}
   */
  public function buildHeader() {
    $header['id'] = $this->t('Property ID');
    $header['title'] = $this->t('Title');
    return $header + parent::buildHeader();
  }

  /**
   * {@inheritdoc}
   */
  public function buildRow(EntityInterface $entity) {
    /** @var \Drupal\real_estate_property\Entity\Property $entity */
    $row['id'] = $entity->id();
    $row['title'] = Link::createFromRoute(
      $entity->label(),
      'entity.real_estate_property.edit_form',
      ['real_estate_property' => $entity->id()]
    );
    return $row + parent::buildRow($entity);
  }

}
