<?php

namespace Drupal\real_estate_agency;

use Drupal\Core\Entity\EntityInterface;
use Drupal\Core\Entity\EntityListBuilder;
use Drupal\Core\Link;

/**
 * Defines a class to build a listing of Agency entities.
 *
 * @ingroup real_estate_agency
 */
class AgencyListBuilder extends EntityListBuilder {

  /**
   * {@inheritdoc}
   */
  public function buildHeader() {
    $header['id'] = $this->t('Agency ID');
    $header['name'] = $this->t('Name');
    return $header + parent::buildHeader();
  }

  /**
   * {@inheritdoc}
   */
  public function buildRow(EntityInterface $entity) {
    /** @var \Drupal\real_estate_agency\Entity\Agency $entity */
    $row['id'] = $entity->id();
    $row['name'] = Link::createFromRoute(
      $entity->label(),
      'entity.real_estate_agency.edit_form',
      ['real_estate_agency' => $entity->id()]
    );
    return $row + parent::buildRow($entity);
  }

}
